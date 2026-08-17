<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Firma;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Lista toti utilizatorii
    public function index()
    {
        $users = User::where('role', 'user')->with('firme')->get();
        return view('users.index', compact('users'));
    }

    // Formularul de creare utilizator
    public function create()
    {
        $firme = Firma::all();
        return view('users.create', compact('firme'));
    }

    // Salveaza utilizatorul nou
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'firme'    => 'nullable|array',
            'firme.*'  => 'exists:firme,id',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'user',
        ]);

        if ($request->firme) {
            $user->firme()->attach($request->firme);
        }

        return redirect()->route('users.index')->with('success', 'Utilizator creat cu succes!');
    }

    // Editeaza utilizatorul
    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        $firme = Firma::all();
        $firmeAsociate = $user->firme->pluck('id')->toArray();
        return view('users.edit', compact('user', 'firme', 'firmeAsociate'));
    }

    // Salveaza modificarile
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|min:6|confirmed',
            'firme'    => 'nullable|array',
            'firme.*'  => 'exists:firme,id',
        ]);

        $user->update([
            'name'  => $request->name,
            'email' => $request->email,
        ]);

        if ($request->password) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        $user->firme()->sync($request->firme ?? []);

        return redirect()->route('users.index')->with('success', 'Utilizator actualizat!');
    }

    // Sterge utilizatorul
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->firme()->detach();
        $user->delete();

        return redirect()->route('users.index')->with('success', 'Utilizator sters!');
    }
}