<?php

namespace App\Http\Controllers;

use App\Models\Firma;
use Illuminate\Http\Request;

class FirmaController extends Controller
{
    public function index()
    {
        $query = Firma::query();

        if (request('cauta')) {
            $query->where(function($q) {
                $q->where('nume', 'like', '%' . request('cauta') . '%')
                ->orWhere('cui', 'like', '%' . request('cauta') . '%')
                ->orWhere('email', 'like', '%' . request('cauta') . '%')
                ->orWhere('telefon', 'like', '%' . request('cauta') . '%');
            });
        }

        $firme = $query->orderBy('nume')->get();
        return view('firme.index', compact('firme'));
    }

    public function create()
    {
        return view('firme.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nume'    => 'required|string|max:255',
            'cui'     => 'required|string|unique:firme',
            'adresa'  => 'nullable|string',
            'telefon' => 'nullable|string',
            'email'   => 'nullable|email',
        ]);

        Firma::create([
            'nume'    => $request->nume,
            'cui'     => $request->cui,
            'adresa'  => $request->adresa,
            'telefon' => $request->telefon,
            'email'   => $request->email,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('firme.index')->with('success', 'Firma adaugata cu succes!');
    }

    public function show(string $id)
    {
        $firma = Firma::findOrFail($id);
        $query = $firma->documente();

        if (request('cauta')) {
            $query->where(function($q) {
                $q->where('numar_document', 'like', '%' . request('cauta') . '%')
                  ->orWhere('tip', 'like', '%' . request('cauta') . '%')
                  ->orWhere('observatii', 'like', '%' . request('cauta') . '%');
            });
        }

        if (request('tip')) {
            $query->where('tip', request('tip'));
        }

        $sortBy = request('sort', 'data_document');
        $sortDir = request('dir', 'desc');

        $coloanePemise = ['tip', 'numar_document', 'data_document', 'created_at'];
        if (!in_array($sortBy, $coloanePemise)) {
            $sortBy = 'data_document';
        }

        $documente = $query->orderBy($sortBy, $sortDir)->get();

        return view('firme.show', compact('firma', 'documente', 'sortBy', 'sortDir'));
    }

    public function edit(string $id)
    {
        $firma = Firma::findOrFail($id);
        return view('firme.edit', compact('firma'));
    }

    public function update(Request $request, string $id)
    {
        $firma = Firma::findOrFail($id);

        $request->validate([
            'nume'    => 'required|string|max:255',
            'cui'     => 'required|string|unique:firme,cui,' . $id,
            'adresa'  => 'nullable|string',
            'telefon' => 'nullable|string',
            'email'   => 'nullable|email',
        ]);

        $firma->update($request->all());

        return redirect()->route('firme.index')->with('success', 'Firma actualizata!');
    }

    public function destroy(string $id)
    {
        $firma = Firma::findOrFail($id);
        $firma->delete();

        return redirect()->route('firme.index')->with('success', 'Firma stearsa!');
    }
}