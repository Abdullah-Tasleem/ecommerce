<?php

namespace App\Http\Controllers;

use App\Mail\ContactFormSubmitted;
use App\Models\Contact;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class UserContactController extends Controller
{
    public function index()
    {
        return view('frontend.contact');
    }

    public function store(Request $request)
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please login to send a message.');
        }

        $request->validate([
            'phone' => ['required', 'digits:11'],
            'date' => 'required|date',
            'comment' => 'required|string',
            'cf-turnstile-response' => 'required|string',
        ]);

        $response = Http::asForm()->post('https://challenges.cloudflare.com/turnstile/v0/siteverify', [
            'secret' => env('TURNSTILE_SECRET_KEY'),
            'response' => $request->input('cf-turnstile-response'),
            'remoteip' => $request->ip(),
        ]);

        if (!optional($response->object())->success) {
            return back()->withErrors(['captcha' => 'CAPTCHA verification failed.'])->withInput();
        }

        Contact::create([
            'user_name' => auth()->user()->name,
            'user_email' => auth()->user()->email,
            'phone' => $request->phone,
            'date' => $request->date,
            'comment' => $request->comment,
        ]);
        Mail::to('admin@gmail.com')->send(new ContactFormSubmitted([
            'user_name' => auth()->user()->name,
            'user_email' => auth()->user()->email,
            'phone' => $request->phone,
            'date' => $request->date,
            'comment' => $request->comment,
        ]));

        return back()->with('success', 'Your message has been sent!');
    }
}
