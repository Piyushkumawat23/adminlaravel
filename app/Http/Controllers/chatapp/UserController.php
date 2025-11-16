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
            'password' => 'required|string|min:3', // Aapne min:3 likha tha, min:6 recommended hai
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // 💡 Zaroori Check: Kya 'public/images/chatapp_profiles' folder hai?
        // Agar nahi hai, toh yeh line 500 error degi. Folder banayein.
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
            // **FIX 500 ERROR Yahaan:**
            'redirect_url' => url('chatapp/users') // 'route()' ki jagah 'url()'
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
                // **FIX 500 ERROR Yahaan:**
                'redirect_url' => url('chatapp/users') // 'route()' ki jagah 'url()'
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'The provided credentials do not match our records.'
        ], 422);
    }

    public function showUsersList()
    {
        // 1. Session check karein (Aapke core PHP ki tarah)
        if (!session()->has('unique_id')) {
            // Agar session nahi hai, toh login page par bhej dein
            return redirect()->route('chatapp.login');
        }

        // 2. Layout ke liye data share karein
        $this->shareNavPages(); 
        $this->shareNavMenus();
        $websiteSetting = WebsiteSetting::first();

        // 3. Logged-in user ka data fetch karein (Aapke users.php ki query)
        $user = ChatUser::where('unique_id', session('unique_id'))->first();

        // 4. View ko data ke saath return karein
        return view('chatapp.users', compact(
            'websiteSetting',
            'user' // Logged-in user ka data view ko bhej
        ));
    }

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
                    $you = "You: "; // Agar last message maine bheja tha
                }
                if (strlen($lastMsg) > 28) {
                    $lastMsg = substr($lastMsg, 0, 28) . '...';
                }
            }

            // --- YEH HAI NAYA UNREAD COUNT LOGIC ---
            $unreadCount = ChatMessage::where('incoming_msg_id', $myId)
                                      ->where('outgoing_msg_id', $user->unique_id)
                                      ->where('is_read', 0)
                                      ->count();

            $unreadBadge = "";
            if ($unreadCount > 0) {
                // Ek CSS badge banayein
                $unreadBadge = '<span class="unread-badge">' . $unreadCount . '</span>';
            }
            // --- END COUNT LOGIC ---

            $statusOffline = ($user->status == "Offline now") ? "offline" : "";

            // HTML output mein last message aur badge add karein
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

    /**
     * AJAX: Users search karein (php/search.php ka replacement)
     */
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
        // Same logic jo humne getUsers mein istemal kiya
        foreach ($users as $user) {
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
                if ($lastMessageQuery->outgoing_msg_id == $myId) $you = "You: ";
                if (strlen($lastMsg) > 28) $lastMsg = substr($lastMsg, 0, 28) . '...';
            }

            $unreadCount = ChatMessage::where('incoming_msg_id', $myId)
                                      ->where('outgoing_msg_id', $user->unique_id)
                                      ->where('is_read', 0)
                                      ->count();
            $unreadBadge = $unreadCount > 0 ? '<span class="unread-badge">' . $unreadCount . '</span>' : '';
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

    // --- YEH NAYA CODE ADD KAREIN ---
    // Messages ko 'read' mark karein (is_read = 1)
    $myId = session('unique_id');
    ChatMessage::where('incoming_msg_id', $myId)
               ->where('outgoing_msg_id', $unique_id)
               ->where('is_read', 0)
               ->update(['is_read' => 1]);
    // --- END ---

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

    /**
     * 2. AJAX: Naya message insert karein (insert-chat.php)
     */
   /**
     * 2. AJAX: Naya message insert karein (insert-chat.php)
     */
   public function insertChat(Request $request)
    {
        if (!session()->has('unique_id')) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 401);
        }

        $outgoing_id = session('unique_id');
        $incoming_id = $request->incoming_id;
        $messageText = $request->message; // Yeh caption hai
        $hasFile = $request->hasFile('file_upload'); // Humne pehle hi check kar liya

        // --- YEH AAPKA SAHI LOGIC HAI ---
        // Pehle check karo ki kya message poori tarah khaali hai
        if (!$hasFile && empty($messageText)) {
            // Agar file BHI NAHI HAI aur text BHI NAHI HAI, tab error do
            return response()->json(['status' => 'error', 'message' => 'Empty message'], 400);
        }
        // --- SAHI LOGIC KHATAM ---

        $msgType = 'text'; // Default
        $filePath = null;
        $msgContent = $messageText; // Humesha caption hi save hoga

        if ($hasFile) {
            $file = $request->file('file_upload');
            $mime = $file->getMimeType();
            
            if (strstr($mime, "video/")) {
                $msgType = 'video';
            } elseif (strstr($mime, "image/")) {
                $msgType = 'image';
            } else {
                // *** YEH HAI NAYA BADLAAV ***
                // Ab hum file ka extension save karenge
                $msgType = $file->extension(); // Jaise: 'pdf', 'docx', 'zip'
                if (empty($msgType)) {
                    $msgType = 'doc'; // Agar extension na mile toh fallback
                }
            }

            // Aapka file save karne ka logic (public/Images/chat_files/ mein)
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = 'Images/chat_files/' . $fileName; // Relative to public
            $directory = public_path('Images/chat_files'); // Full path to directory

            if (!file_exists($directory)) {
                mkdir($directory, 0755, true); // Directory banayein agar nahi hai
            }
            
            $file->move($directory, $fileName); // File ko move karein
            
            if (!file_exists($directory . '/' . $fileName)) {
                return response()->json(['status' => 'error', 'message' => 'File upload failed'], 500);
            }
        }

        ChatMessage::create([
            'incoming_msg_id' => $incoming_id,
            'outgoing_msg_id' => $outgoing_id,
            'msg' => $msgContent,
            'msg_type' => $msgType, // Yahaan ab 'pdf', 'zip' etc. save hoga
            'file_path' => $filePath,
            'is_read' => 0
        ]);
        
        return response()->json(['status' => 'success']);
    }

    /**
     * 3. AJAX: Chat history fetch karein (get-chat.php)
     */
    /**
     * 3. AJAX: Chat history fetch karein (get-chat.php)
     */
    public function getChat(Request $request)
    {
        if (!session()->has('unique_id')) {
            return '';
        }
        $outgoing_id = session('unique_id'); // Yeh main hoon
        $incoming_id = $request->incoming_id; // Yeh saamne wala hai
        $output = "";

        // *** YEH HAI NAYA FIX ***
        // Messages fetch karne se PEHLE, un sabhi messages ko 'read' mark karo
        // jo saamne wale ne bheje hain (outgoing_id = $incoming_id)
        // aur mere paas aaye hain (incoming_msg_id = $outgoing_id)
        ChatMessage::where('incoming_msg_id', $outgoing_id)
                   ->where('outgoing_msg_id', $incoming_id)
                   ->where('is_read', 0)
                   ->update(['is_read' => 1]);
        // *** FIX KHATAM ***


        // Ab hum messages fetch karenge
        $messages = ChatMessage::leftJoin('users_chat', 'users_chat.unique_id', '=', 'chat_messages.outgoing_msg_id')
            ->where(function ($query) use ($outgoing_id, $incoming_id) {
                $query->where('outgoing_msg_id', $outgoing_id)
                      ->where('incoming_msg_id', $incoming_id);
            })
            ->orWhere(function ($query) use ($outgoing_id, $incoming_id) {
                $query->where('outgoing_msg_id', $incoming_id)
                      ->where('incoming_msg_id', $outgoing_id);
            })
            ->orderBy('chat_messages.msg_id', 'asc')
            ->select('chat_messages.*', 'users_chat.img')
            ->get();

        if ($messages->count() > 0) {
            foreach ($messages as $row) {
                $messageContent = "";
                $caption = htmlspecialchars($row->msg ?? '');
                $fileUrl = $row->file_path ? asset($row->file_path) : null;
                $captionHtml = !empty($caption) ? '<p>' . $caption . '</p>' : '';

                if ($row->msg_type == 'image' && $fileUrl) {
                    $messageContent = '<div class="message-file"><img src="' . $fileUrl . '" alt="Image"></div>' . $captionHtml;
                
                } elseif ($row->msg_type == 'video' && $fileUrl) {
                    $messageContent = '<div class="message-file"><video controls><source src="' . $fileUrl . '"></video></div>' . $captionHtml;
                
                } elseif ($row->msg_type == 'text') {
                    $messageContent = '<p>' . $caption . '</p>';

                } elseif ($fileUrl) { 
                    // Document logic
                    $fileIcon = 'fas fa-file';
                    $extension = strtolower($row->msg_type);
                    switch ($extension) {
                        case 'pdf': $fileIcon = 'fas fa-file-pdf'; break;
                        case 'doc': case 'docx': $fileIcon = 'fas fa-file-word'; break;
                        case 'xls': case 'xlsx': $fileIcon = 'fas fa-file-excel'; break;
                        case 'ppt': case 'pptx': $fileIcon = 'fas fa-file-powerpoint'; break;
                        case 'zip': case 'rar': $fileIcon = 'fas fa-file-archive'; break;
                        case 'txt': $fileIcon = 'fas fa-file-alt'; break;
                    }
                    $fileType = strtoupper($extension);
                    $docCaption = !empty($caption) ? $caption : 'View ' . $fileType; 
                    $messageContent = '<div class="message-file doc-link"><a href="' . $fileUrl . '" target="_blank"><i class="' . $fileIcon . '"></i> ' . $docCaption . '</a></div>';
                
                } else {
                    $messageContent = '<p>' . $caption . '</p>';
                }

                // HTML generation
                if ($row->outgoing_msg_id == $outgoing_id) {
                    $output .= '<div class="chat outgoing">
                                    <div class="details">' . $messageContent . '</div>
                                </div>';
                } else {
                    $output .= '<div class="chat incoming">
                                    <img src="' . asset('images/chatapp_profiles/' . $row->img) . '" alt="">
                                    <div class="details">' . $messageContent . '</div>
                                </div>';
                }
            }
        } else {
            $output .= '<div class="text">No messages are available. Once you send message they will appear here.</div>';
        }
        return $output;
    }

    public function logout()
    {
        // Check karein ki user logged-in hai
        if (session()->has('unique_id')) {
            $unique_id = session('unique_id');

            // 1. User ka status database mein update karein
            $user = ChatUser::where('unique_id', $unique_id)->first();
            if ($user) {
                $user->status = "Offline now";
                $user->save();
            }

            // 2. Session se 'unique_id' ko remove karein
            session()->forget('unique_id');
        }

        // 3. Login page par wapas bhej dein
        return redirect()->route('chatapp.login');
    }
}