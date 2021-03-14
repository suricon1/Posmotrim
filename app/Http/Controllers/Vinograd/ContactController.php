<?php

namespace App\Http\Controllers\Vinograd;

use App\Models\Vinograd\Contact;
use App\Notifications\ContactMail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

class ContactController extends Controller
{
    public function contactForm()
    {
        return view('vinograd.contact');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'	=>	'required|min:3|max:30',
            'email'	=>	'required|email',
            'message'	=>	'required|string',
            'subject'	=>	[
                'nullable',
                //'size:0',
                Rule::in('')
            ]
        ]);

        $contact = Contact::create([
            'name' => $request->name,
            'email' => $request->email,
            'message' => strip_tags($request->message),
            'date_at' => time(),
            'mark_as_read' => 1
        ]);
        $contact->notify(new ContactMail($contact));

        return redirect()->back()->with('status', 'Мы получили Ваше сообщение.');
    }
}
