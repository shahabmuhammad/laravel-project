<?php
namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Contact; // <-- Ye add karo
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index()
    {
        return view('front.contact'); // ya 'contact', jo blade path hai
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:100',
            'email'   => 'required|email',
            'subject' => 'nullable|string|max:150',
            'message' => 'required|string',
        ]);

        // SAVE TO DATABASE
        Contact::create($validated);

        // SEND EMAIL (optional)
        // Mail::raw(
        //     "New Contact Message:\n\nName: {$request->name}\nEmail: {$request->email}\nMessage: {$request->message}",
        //     function ($msg) use ($request) {
        //         $msg->to('admin@gmail.com')
        //             ->subject('New Contact Form Submission');
        //     }
        // );

        return back()->with('success', 'Your message has been sent!');
    }
}


