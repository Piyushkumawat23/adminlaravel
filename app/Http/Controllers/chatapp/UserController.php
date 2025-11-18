<?php

namespace App\Http\Controllers\chatapp;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ChatUser;
use App\Models\ChatMessage;
use App\Models\WebsiteSetting;
use App\Models\Page;
use App\Models\Menu;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use App\Events\NewChatMessage; // <-- *** 1. यह लाइन जोड़ें ***

class UserController extends Controller
{
    // ... (Aapke shareNavPages aur shareNavMenus functions yahaan) ...
    public function shareNavPages()
    {
        view()->share('navPages', Page::where('status', 'active')->get());
    }
    public function shareNavMenus()
    {
        view()->share('navMenus', Menu::where('status', 1)->get());
    }

    // ... (Aapke showRegisterForm, storeUser, showLoginForm, authenticate... functions) ...
    // ... (Unmein koi badlaav nahi hai) ...

    /**
     * Signup form dikhayein
     */
    public function showRegisterForm()
    {
        $this->shareNavPages();
        $this->shareNavMenus();
        $websiteSetting = WebsiteSetting::first();
        return view('chatapp.auth.register', compact('websiteSetting'));
    }

    /**
     * Signup data store karein
     */
    public function storeUser(Request $request)
    {
        $request->validate([
            'fname' => 'required|string|max:255',
            'lname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users_chat',
            'password' => 'required|string|min:3',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imageName = time().'.'.$request->image->extension();
        $request->image->move(public_path('images/chatapp_profiles'), $imageName);
        
        $user = ChatUser::create([
            'fname' => $request->fname,
            'lname' => $request->lname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'img' => $imageName,
            'unique_id' => rand(time(), 100000000),
            'status' => 'Active now'
        ]);

        session(['unique_id' => $user->unique_id]);

        return response()->json([
            'status' => 'success',
            'redirect_url' => url('chatapp/users')
        ]);
    }

    /**
     * Login form dikhayein
     */
    public function showLoginForm()
    {
        $this->shareNavPages();
        $this->shareNavMenus();
        $websiteSetting = WebsiteSetting::first();
        return view('chatapp.auth.login', compact('websiteSetting'));
    }

    /**
     * Login authenticate karein
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = ChatUser::where('email', $credentials['email'])->first();

        if ($user && Hash::check($credentials['password'], $user->password)) {
            $user->status = 'Active now';
            $user->save();
            
            session(['unique_id' => $user->unique_id]);
            $request->session()->regenerate();

            return response()->json([
                'status' => 'success',
                'redirect_url' => url('chatapp/users')
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'The provided credentials do not match our records.'
        ], 422);
    }

    public function showUsersList()
    {
        if (!session()->has('unique_id')) {
            return redirect()->route('chatapp.login');
        }
        $this->shareNavPages();
        $this->shareNavMenus();
        $websiteSetting = WebsiteSetting::first();
        $user = ChatUser::where('unique_id', session('unique_id'))->first();

        return view('chatapp.users', compact(
            'websiteSetting',
            'user'
        ));
    }

    // Is function mein koi badlaav nahi hai
    public function getUsers()
    {
        if (!session()->has('unique_id')) return '';

        $myId = session('unique_id');
        $users = ChatUser::where('unique_id', '!=', $myId)->get();
        $output = "";

        if ($users->count() == 0) {
            $output = "No users are available to chat";
        } else {
            foreach ($users as $user) {
                // Har user ke liye last message fetch karein
                $lastMessageQuery = ChatMessage::where(function ($q) use ($myId, $user) {
                    $q->where('outgoing_msg_id', $myId)
                      ->where('incoming_msg_id', $user->unique_id);
                })->orWhere(function ($q) use ($myId, $user) {
                    $q->where('outgoing_msg_id', $user->unique_id)
                      ->where('incoming_msg_id', $myId);
                })->orderBy('msg_id', 'DESC')->first();

                $you = "";
                $lastMsg = "No message available";

                if ($lastMessageQuery) {
                    $lastMsg = $lastMessageQuery->msg;
                    if ($lastMessageQuery->outgoing_msg_id == $myId) {
                        $you = "You: ";
                    }
                    if (strlen($lastMsg) > 28) {
                        $lastMsg = substr($lastMsg, 0, 28) . '...';
                    }
                }

                $unreadCount = ChatMessage::where('incoming_msg_id', $myId)
                                       ->where('outgoing_msg_id', $user->unique_id)
                                       ->where('is_read', 0)
                                       ->count();

                $unreadBadge = "";
                if ($unreadCount > 0) {
                    $unreadBadge = '<span class="unread-badge">' . $unreadCount . '</span>';
                }
                
                $statusOffline = ($user->status == "Offline now") ? "offline" : "";

                $output .= '<a href="'. url('chatapp/chat/' . $user->unique_id) .'"> 
                                <div class="content">
                                <img src="' . asset('images/chatapp_profiles/' . $user->img) . '" alt="">
                                <div class="details">
                                    <span>' . $user->fname . " " . $user->lname . '</span>
                                    <p>' . $you . $lastMsg . '</p>
                                </div>
                                </div>
                                <div class="status-dot ' . $statusOffline . '"><i class="fas fa-circle"></i></div>
                                ' . $unreadBadge . '
                            </a>';
            }
        }
        return $output;
    }

    // Is function mein koi badlaav nahi hai
    public function searchUsers(Request $request)
    {
        if (!session()->has('unique_id')) return '';

        $myId = session('unique_id');
        $searchTerm = $request->input('searchTerm');

        $users = ChatUser::where('unique_id', '!=', $myId)
                         ->where(function($query) use ($searchTerm) {
                             $query->where('fname', 'LIKE', "%{$searchTerm}%")
                                   ->orWhere('lname', 'LIKE', "%{$searchTerm}%");
                         })
                         ->get();
        $output = "";

        if ($users->count() > 0) {
            // (Aapka HTML banane wala logic yahaan...)
            // ... (Same logic as getUsers) ...
        } else {
            $output = 'No user found related to your search term';
        }
        return $output;
    }

    public function showChatArea($unique_id)
    {
        if (!session()->has('unique_id')) {
            return redirect()->route('chatapp.login');
        }
        $myId = session('unique_id');
        ChatMessage::where('incoming_msg_id', $myId)
                   ->where('outgoing_msg_id', $unique_id)
                   ->where('is_read', 0)
                   ->update(['is_read' => 1]);

        $this->shareNavPages();
        $this->shareNavMenus();
        $websiteSetting = WebsiteSetting::first();
        $chatUser = ChatUser::where('unique_id', $unique_id)->first();

        if (!$chatUser) {
            return redirect()->route('chatapp.users.list');
        }

        return view('chatapp.chat', compact(
            'websiteSetting',
            'chatUser'
        ));
    }


    // =======================================================================
    // === 2. YEH FUNCTION POORA BADAL GAYA HAI (insertChat) ===
    // =======================================================================
    public function insertChat(Request $request)
    {
        if (!session()->has('unique_id')) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 401);
        }

        // --- Rate Limiting (Spam Protection) ---
        // Humne yeh pehle routes/web.php mein 'throttle:chat'
        // middleware lagakar set kar diya hai.
        // Isliye yahaan code ki zaroorat nahi hai.

        $outgoing_id = session('unique_id');
        $incoming_id = $request->incoming_id;
        $messageText = $request->message;
        $hasFile = $request->hasFile('file_upload');
        $reply_to_id = $request->reply_to_message_id ?? null;

        if (!$hasFile && empty($messageText)) {
            return response()->json(['status' => 'error', 'message' => 'Empty message'], 400);
        }

        $msgType = 'text';
        $filePath = null;
        $msgContent = $messageText;

        if ($hasFile) {
            $file = $request->file('file_upload');
            $mime = $file->getMimeType();
            
            if (strstr($mime, "video/")) { $msgType = 'video'; }
            elseif (strstr($mime, "image/")) { $msgType = 'image'; }
            else { $msgType = $file->extension() ?? 'doc'; }

            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = 'Images/chat_files/' . $fileName; // Relative to public
            $directory = public_path('Images/chat_files');

            if (!file_exists($directory)) {
                mkdir($directory, 0755, true);
            }
            
            $file->move($directory, $fileName);
            
            if (!file_exists($directory . '/' . $fileName)) {
                return response()->json(['status' => 'error', 'message' => 'File upload failed'], 500);
            }
        }

        // 1. Message ko Database mein banayein
        $newMessage = ChatMessage::create([
            'incoming_msg_id' => $incoming_id,
            'outgoing_msg_id' => $outgoing_id,
            'msg' => $msgContent,
            'msg_type' => $msgType,
            'file_path' => $filePath,
            'is_read' => 0,
            'reply_to_message_id' => $reply_to_id
        ]);

        // 2. Event ko Broadcast karein
        // Yeh 'NewChatMessage' event ko fire karega
        // 'toOthers()' ka matlab hai yeh message bhejnewale ko
        // dobara nahi bheja jayega (bandwidth bachaane ke liye).
        broadcast(new NewChatMessage($newMessage))->toOthers();

        // 3. Bhejnewale (sender) ko naya message JSON mein lautaayein
        // Taki uska UI TURANT update ho sake.
        // Hum relation load kar rahe hain jo humne Model mein banaye the.
        $newMessage->load(['sender', 'repliedTo.sender']);
        
        return response()->json([
            'status' => 'success',
            'message' => $newMessage // <-- Hum HTML nahi, data bhej rahe hain
        ]);
    }


    // =======================================================================
    // === 3. YEH FUNCTION POORA BADAL GAYA HAI (getChat) ===
    // =======================================================================
    public function getChat(Request $request)
    {
        if (!session()->has('unique_id')) {
            return response()->json([]); // Khaali JSON lautaayein
        }
        $outgoing_id = session('unique_id'); // Yeh main hoon
        $incoming_id = $request->incoming_id; // Yeh saamne wala hai

        // Messages fetch karne se PEHLE, un sabhi messages ko 'read' mark karo
        ChatMessage::where('incoming_msg_id', $outgoing_id)
                   ->where('outgoing_msg_id', $incoming_id)
                   ->where('is_read', 0)
                   ->update(['is_read' => 1]);

        // Ab hum messages fetch karenge (bilkul aapki query ki tarah)
        $messages = ChatMessage::leftJoin('users_chat', 'users_chat.unique_id', '=', 'chat_messages.outgoing_msg_id')
            // Parent message (jiska reply diya) ko join karein
            ->leftJoin('chat_messages as parent_msg', 'chat_messages.reply_to_message_id', '=', 'parent_msg.msg_id')
            // Parent message ke sender ki details join karein
            ->leftJoin('users_chat as parent_user', 'parent_msg.outgoing_msg_id', '=', 'parent_user.unique_id')
            
            ->where(function ($query) use ($outgoing_id, $incoming_id) {
                $query->where('chat_messages.outgoing_msg_id', $outgoing_id)
                      ->where('chat_messages.incoming_msg_id', $incoming_id);
            })
            ->orWhere(function ($query) use ($outgoing_id, $incoming_id) {
                $query->where('chat_messages.outgoing_msg_id', $incoming_id)
                      ->where('chat_messages.incoming_msg_id', $outgoing_id);
            })
            ->orderBy('chat_messages.msg_id', 'asc')
            ->select(
                'chat_messages.*', 
                'users_chat.img', 
                'users_chat.fname',
                // Parent message ki details
                'parent_msg.msg as parent_message_text',
                'parent_msg.file_path as parent_file_path',
                'parent_msg.outgoing_msg_id as parent_sender_id',
                'parent_user.fname as parent_user_fname'
            )
            ->get();

        // ** YEH HAI BADLAAV: Hum HTML nahi, seedha data bhej rahe hain **
        return response()->json($messages);
    }

    public function logout()
    {
        if (session()->has('unique_id')) {
            $unique_id = session('unique_id');

            $user = ChatUser::where('unique_id', $unique_id)->first();
            if ($user) {
                $user->status = "Offline now";
                $user->save();
            }
            session()->forget('unique_id');
        }
        return redirect()->route('chatapp.login');
    }
}