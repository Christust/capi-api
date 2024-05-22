<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        return Contact::with(['phones', 'emails', 'addresses'])->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phones' => 'required|array',
            'phones.*' => 'required|string|max:255',
            'emails' => 'required|array',
            'emails.*' => 'required|string|email|max:255',
            'addresses' => 'required|array',
            'addresses.*.address' => 'required|string|max:255',
            'addresses.*.city' => 'required|string|max:255',
            'addresses.*.state' => 'nullable|string|max:255',
            'addresses.*.country' => 'required|string|max:255',
            'addresses.*.postal_code' => 'nullable|string|max:255',
        ]);

        $contact = Contact::create($request->only('name'));

        foreach ($request->phones as $phone) {
            $contact->phones()->create(['phone_number' => $phone]);
        }

        foreach ($request->emails as $email) {
            $contact->emails()->create(['email' => $email]);
        }

        foreach ($request->addresses as $address) {
            $contact->addresses()->create($address);
        }

        return response()->json($contact->load(['phones', 'emails', 'addresses']), 201);
    }

    public function show($id)
    {
        return Contact::with(['phones', 'emails', 'addresses'])->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $contact = Contact::findOrFail($id);
        $contact->update($request->only('name'));

        $contact->phones()->delete();
        foreach ($request->phones as $phone) {
            $contact->phones()->create(['phone_number' => $phone]);
        }

        $contact->emails()->delete();
        foreach ($request->emails as $email) {
            $contact->emails()->create(['email' => $email]);
        }

        $contact->addresses()->delete();
        foreach ($request->addresses as $address) {
            $contact->addresses()->create($address);
        }

        return response()->json($contact->load(['phones', 'emails', 'addresses']), 200);
    }

    public function destroy($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();

        return response()->json(null, 204);
    }
}
