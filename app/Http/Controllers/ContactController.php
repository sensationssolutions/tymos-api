<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormMail;


class ContactController extends Controller
{
    
    public function index()
    {
        $contacts = Contact::orderBy('created_at', 'desc')->get();

        return response()->json([
            'data' => $contacts
        ]);
    }

   
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'phone'   => 'nullable|string|max:20',
            'message' => 'required|string',
        ]);

        $contact = Contact::create([
            ...$validated,
            'status' => false, 
        ]);

         Mail::to('admin@example.com')->send(new ContactFormMail($validated));

        return response()->json([
            'id' => $contact->id,
            'message' => 'Your message has been submitted successfully, will connect with you shortly!',
            'success' => 200
        ]);
    }

   
    public function update(Request $request, $id)
    {
        $contact = Contact::findOrFail($id);

        $validated = $request->validate([
            'status' => 'boolean' 
        ]);

        $contact->update($validated);

        return response()->json([
            'id' => $contact->id,
            'message' => 'Contact status updated.'
        ]);
    }

    
    public function destroy($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();

        return response()->json([
            'id' => $contact->id,
            'message' => 'Contact message deleted.',
            'status' => 200
        ]);
    }
}
