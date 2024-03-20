<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Address;
use Illuminate\Support\Facades\Validator;

class AddressController extends Controller
{
    /**
     * Create a new address.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        // Validasi input dari request
        $validator = Validator::make($request->all(), [
            'street' => 'required',
            'city' => 'required',
            'province' => 'required',
            'country' => 'required',
            'postal_code' => 'required',
        ]);

        // Jika validasi gagal, kembalikan respon error
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        // Buat alamat baru
        $address = Address::create([
            'street' => $request->street,
            'city' => $request->city,
            'province' => $request->province,
            'country' => $request->country,
            'postal_code' => $request->postal_code,
            'user_id' => auth()->user()->id, // Set user_id sesuai dengan user yang sedang login
        ]);

        // Kembalikan respon sukses dengan data alamat yang baru dibuat
        return response()->json(['address' => $address], 201);
    }

    /**
     * Update address information.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Dapatkan alamat yang ingin diupdate
        $address = Address::findOrFail($id);

        // Validasi input dari request
        $validator = Validator::make($request->all(), [
            'street' => 'required',
            'city' => 'required',
            'province' => 'required',
            'country' => 'required',
            'postal_code' => 'required',
        ]);

        // Jika validasi gagal, kembalikan respon error
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        // Update informasi alamat
        $address->update([
            'street' => $request->street,
            'city' => $request->city,
            'province' => $request->province,
            'country' => $request->country,
            'postal_code' => $request->postal_code,
        ]);

        // Kembalikan respon sukses
        return response()->json(['message' => 'Address updated successfully'], 200);
    }

    /**
     * Get address information.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function get($id)
    {
        // Dapatkan alamat berdasarkan ID
        $address = Address::findOrFail($id);

        // Kembalikan data alamat dalam respon
        return response()->json(['address' => $address], 200);
    }

    /**
     * List all addresses.
     *
     * @return \Illuminate\Http\Response
     */
    public function list()
    {
        // Dapatkan semua alamat
        $addresses = Address::all();

        // Kembalikan data alamat dalam respon
        return response()->json(['addresses' => $addresses], 200);
    }

    /**
     * Remove address.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function remove($id)
    {
        // Dapatkan alamat yang ingin dihapus
        $address = Address::findOrFail($id);

        // Hapus alamat
        $address->delete();

        // Kembalikan respon sukses
        return response()->json(['message' => 'Address deleted successfully'], 200);
    }
}
