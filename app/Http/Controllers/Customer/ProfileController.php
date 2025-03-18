<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Profiler\Profile;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::guard('customer')->user();
        return view('profile', ['user' => $user]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, String $id)
    {
        // Validasi data yang diterima
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'gender' => 'nullable|string|in:male,female',
            'dob' => 'nullable|date',
            'phone' => 'nullable|numeric',
            'address' => 'nullable|string|max:255',
            'bio' => 'nullable|string'
        ]);

        try {
            // Ambil data customer berdasarkan ID
            $customer = Customer::findOrFail($id);

            // Update data customer dengan data yang sudah divalidasi
            $customer->update($validatedData);

            // Redirect ke halaman profile.index dengan id customer
            return redirect()->route('profile.index', $customer->id)
                ->with('success', 'Profile updated successfully.');
        } catch (\Exception $e) {
            // Jika ada kesalahan, kembali ke halaman sebelumnya dengan error
            return redirect()->back()
                ->withErrors('There was an error updating the profile.')
                ->withInput();
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


    //destroy image
    public function destroyImage(Request $request, $id)
    {
        try {
            $customer = Customer::findOrFail($id);

            //set to null
            $customer->profile_picture = null;
            $customer->save();

            return redirect()->route('profile.index',  $customer->id)
            ->with('success', 'Profile picture deleted successfully.');
        } catch (\Exception $e) {
            //throw $th;
        }
    }
}
