<?php

namespace App\Http\Controllers;

use App\Models\Notificare;
use Illuminate\Http\Request;

class NotificareController extends Controller
{
    public function index()
    {
        $notificari = Notificare::orderBy('created_at', 'desc')->get();
        Notificare::where('citita', false)->update(['citita' => true]);
        return view('notificari.index', compact('notificari'));
    }

    public function destroy(string $id)
    {
        Notificare::findOrFail($id)->delete();
        return back()->with('success', 'Notificare stearsa!');
    }

    public function stergeToate()
    {
        Notificare::truncate();
        return back()->with('success', 'Toate notificarile au fost sterse!');
    }
}