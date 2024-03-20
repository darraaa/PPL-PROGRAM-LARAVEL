<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    /**
     * Create a new contact.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        // Validasi input dari request
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
        ]);

        // Jika validasi gagal, kembalikan respon error
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        // Buat kontak baru
        $contact = Contact::create($request->all());

        // Kembalikan respon sukses dengan data kontak yang baru dibuat
        return response()->json(['contact' => $contact], 201);
    }

    /**
     * Update a contact.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Dapatkan kontak yang ingin diupdate
        $contact = Contact::findOrFail($id);

        // Validasi input dari request
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
        ]);

        // Jika validasi gagal, kembalikan respon error
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        // Update informasi kontak
        $contact->update($request->all());

        // Kembalikan respon sukses
        return response()->json(['message' => 'Contact updated successfully'], 200);
    }

    /**
     * Get a contact.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function get($id)
    {
        // Dapatkan kontak berdasarkan ID
        $contact = Contact::findOrFail($id);

        // Kembalikan data kontak dalam respon
        return response()->json(['contact' => $contact], 200);
    }

    /**
     * Search contacts.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        // Validasi input dari request
        $validator = Validator::make($request->all(), [
            'query' => 'required',
        ]);

        // Jika validasi gagal, kembalikan respon error
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        // Cari kontak berdasarkan query
        $contacts = Contact::where('first_name', 'like', '%' . $request->query . '%')
            ->orWhere('last_name', 'like', '%' . $request->query . '%')
            ->get();

        // Kembalikan data kontak dalam respon
        return response()->json(['contacts' => $contacts], 200);
    }

    /**
     * Remove a contact.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function remove($id)
    {
        // Dapatkan kontak yang ingin dihapus
        $contact = Contact::findOrFail($id);

        // Hapus kontak
        $contact->delete();

        // Kembalikan respon sukses
        return response()->json(['message' => 'Contact deleted successfully'], 200);
    }
}
