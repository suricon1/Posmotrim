<?php

namespace App\Http\Controllers\Admin\Vinograd;

use App\Mail\Admin\ContactReplyMail;
use App\Models\Vinograd\Contact;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Mail;
use View;

class MailsController extends Controller
{
    public function __construct()
    {
        View::share ('messages_open', ' menu-open');
        View::share ('messages_active', ' active');
    }

    public function index()
    {
        return view('admin.vinograd.mail_box.mail_box', [
            'messages' => Contact::with('parent', 'children')
                ->whereNull('parent_id')
                ->orderBy('mark_as_read', 'desc')
                ->orderBy('date_at', 'desc')
                ->paginate(20)
        ]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->mark_as_read = null;
        $contact->save();

        return view('admin.vinograd.mail_box.mail_read', [
            'message' => $contact
        ]);
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'message' =>  'required'
        ]);
        $message = Contact::find($id);
        $reply = Contact::create([
            'parent_id' => $id,
            'message' => $request->message,
            'date_at' => time()
        ]);
        Mail::to($message->email)->queue(new ContactReplyMail($message, $reply));
        return redirect()->route('mails.index');
    }

    public function destroy(Request $request)
    {
        $this->validate($request,
        [
            'check' =>  'required',
            'check.*' =>  'integer|exists:vinograd_contact,id'
        ],
        [
            'check.required' => 'Выберите что удалять',
            'check.*.integer' => 'Не чуди',
            'check.*.exists' => 'Не чуди'
        ]);

        Contact::whereIn('id', $request->check)->delete();
        Contact::whereIn('parent_id', $request->check)->delete();

        return redirect()->route('mails.index');
    }
}
