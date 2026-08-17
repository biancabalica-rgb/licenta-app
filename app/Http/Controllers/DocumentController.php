<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Firma;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function create(Request $request)
    {
        $firma = Firma::findOrFail($request->firma_id);
        return view('documente.create', compact('firma'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'firma_id'   => 'required|exists:firme,id',
            'tip'        => 'required|string',
            'numar_document' => 'nullable|string|max:255',
            'data_document' => 'nullable|date',
            'fisier'     => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240',
            'observatii' => 'nullable|string',
        ]);

        $fisier = $request->file('fisier');
        $numeFisier = $fisier->getClientOriginalName();
        $caleFisier = $fisier->store('documente', 'public');

        Document::create([
            'firma_id'    => $request->firma_id,
            'user_id'     => auth()->id(),
            'tip'         => $request->tip,
            'numar_document' => $request->numar_document,
            'data_document' => $request->data_document,
            'nume_fisier' => $numeFisier,
            'cale_fisier' => $caleFisier,
            'observatii'  => $request->observatii,
        ]);

        \App\Models\Notificare::create([
            'tip'   => 'document',
            'titlu' => 'Document nou incarcat',
            'mesaj' => auth()->user()->name . ' a incarcat un document de tip ' .
                    $request->tip . ' pentru firma ' .
                    \App\Models\Firma::find($request->firma_id)->nume . '.',
        ]);

        return redirect()->route('firme.show', $request->firma_id)
                         ->with('success', 'Document incarcat cu succes!');
    }

    public function show(string $id)
    {
        $document = Document::findOrFail($id);
        $user = auth()->user();

        // Verifica daca userul are acces la firma documentului
        if ($user->role !== 'admin') {
            $firmeUser = $user->firme->pluck('id')->toArray();
            if (!in_array($document->firma_id, $firmeUser)) {
                abort(403, 'Nu ai acces la acest document.');
            }
        }

        return Storage::disk('public')->download($document->cale_fisier, $document->nume_fisier);
    }

    public function edit(string $id)
    {
        $document = Document::findOrFail($id);
        $user = auth()->user();

        if ($user->role !== 'admin') {
            $firmeUser = $user->firme->pluck('id')->toArray();
            if (!in_array($document->firma_id, $firmeUser)) {
                abort(403, 'Nu ai acces la acest document.');
            }
        }

        $firma = $document->firma;
        return view('documente.edit', compact('document', 'firma'));
    }

public function update(Request $request, string $id)
{
    $document = Document::findOrFail($id);

    $request->validate([
        'tip'            => 'required|string',
        'data_document'  => 'nullable|date',
        'numar_document' => 'nullable|string|max:255',
        'observatii'     => 'nullable|string',
    ]);

    $document->update([
        'tip'            => $request->tip,
        'data_document'  => $request->data_document,
        'numar_document' => $request->numar_document,
        'observatii'     => $request->observatii,
    ]);

    return redirect()->route('firme.show', $document->firma_id)
                     ->with('success', 'Document actualizat cu succes!');
}

    public function destroy(string $id)
    {
        $document = Document::findOrFail($id);
        $user = auth()->user();

        if ($user->role !== 'admin') {
            $firmeUser = $user->firme->pluck('id')->toArray();
            if (!in_array($document->firma_id, $firmeUser)) {
                abort(403, 'Nu ai acces la acest document.');
            }
        }

        Storage::disk('public')->delete($document->cale_fisier);
        $firma_id = $document->firma_id;
        $document->delete();

        return redirect()->route('firme.show', $firma_id)
                        ->with('success', 'Document sters!');
    }
}