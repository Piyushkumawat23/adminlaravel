<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WebsiteSetting;  
use Illuminate\Http\Request;
use App\Models\Newsletter;
use Illuminate\Support\Facades\Mail;

class NewsletterController extends Controller
{

    public function __construct()
    {
        $websiteSetting = WebsiteSetting::first();
        view()->share('websiteSetting', $websiteSetting);
    }


    // Show all subscribers
    public function index()
    {
        $subscribers = Newsletter::latest()->paginate(10);
        return view('admin.newsletter.index', compact('subscribers'));
    }

    // Store new subscription
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:newsletters,email',
        ]);

        Newsletter::create([
            'email' => $request->email,
            'status' => 'subscribed'
        ]);

        return redirect()->back()->with('success', 'Subscribed Successfully!');
    }

    // Unsubscribe a user
    public function unsubscribe($id)
    {
        $subscriber = Newsletter::findOrFail($id);
        $subscriber->update(['status' => 'unsubscribed']);

        return redirect()->back()->with('success', 'User Unsubscribed!');
    }



    public function edit($id)
        {
            $subscriber = Newsletter::findOrFail($id);
            return view('admin.newsletter.edit', compact('subscriber'));
        }

        public function update(Request $request, $id)
        {
            $request->validate([
                'email' => 'required|email|unique:newsletters,email,' . $id,
                'status' => 'required|in:subscribed,unsubscribed'
            ]);
        
            $subscriber = Newsletter::findOrFail($id);
            $subscriber->update([
                'email' => $request->email,
                'status' => $request->status
            ]);
        
            return redirect()->route('newsletter.index')->with('success', 'Subscriber updated successfully!');
        }
        




    // Delete a subscriber
    public function destroy($id)
    {
        Newsletter::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Subscriber Deleted!');
    }



    public function showindex()
    {
        $subscribers = Newsletter::latest()->paginate(10);
        return view('admin.newsletter.newsletter', compact('subscribers'));
    }

    public function sendNewsletter(Request $request)
{
    $request->validate([
        'subject' => 'required',
        'message' => 'required'
    ]);

    $subscribers = Newsletter::where('status', 1)->pluck('email'); 

    foreach ($subscribers as $email) {
        Mail::send('emails.newsletter', [
            'subject' => $request->subject,
            'messageContent' => $request->message
        ], function ($message) use ($email, $request) {
            $message->to($email)
                    ->subject($request->subject);
        });
    }

    return redirect()->back()->with('success', 'Newsletter Sent Successfully!');
}

    // https://www.mailmodo.com/email-templates/categories/html-email-templates/
    
}
