<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function dashboard()
    {
        $questions = Question::latest()->take(10)->get();
        return view('users.dashboard', compact('questions'));
    }
    
    public function show()
    {
        $user = Auth::user();

        return view('users.profile', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'umur' => ['nullable', 'integer', 'min:0', 'max:120'],
            'alamat' => ['nullable', 'string', 'max:255'],
            'biodata' => ['nullable', 'string', 'max:1000'],
            'password' => ['nullable', 'confirmed', 'min:6'],
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('profile.show')->with('success', 'Profil berhasil diperbarui.');
    }
}

