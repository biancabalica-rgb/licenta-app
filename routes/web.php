<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FirmaController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMail;
use App\Http\Controllers\NotificareController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    if (auth()->check() && auth()->user()->role === 'admin') {
        return redirect()->route('firme.index');
    }
    if (auth()->check() && auth()->user()->role === 'user') {
        return redirect()->route('user.dashboard');
    }
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rute pentru documente (admin si user)
    Route::get('/documente/create', [DocumentController::class, 'create'])->name('documente.create');
    Route::post('/documente', [DocumentController::class, 'store'])->name('documente.store');
    Route::get('/documente/{id}', [DocumentController::class, 'show'])->name('documente.show');
    Route::delete('/documente/{id}', [DocumentController::class, 'destroy'])->name('documente.destroy');
    Route::get('/documente/{id}/edit', [DocumentController::class, 'edit'])->name('documente.edit');
Route::put('/documente/{id}', [DocumentController::class, 'update'])->name('documente.update');

    // Rute doar pentru admin
        Route::middleware(\App\Http\Middleware\AdminMiddleware::class)->group(function () {
            Route::resource('firme', FirmaController::class);
            Route::resource('users', UserController::class)->except(['show']);
            Route::get('/notificari', [NotificareController::class, 'index'])->name('notificari.index');
            Route::delete('/notificari/{id}', [NotificareController::class, 'destroy'])->name('notificari.destroy');
            Route::delete('/notificari', [NotificareController::class, 'stergeToate'])->name('notificari.stergeToate');
        });

    // Dashboard utilizator normal
Route::get('/firmele-mele', function () {
    $cauta = request('cauta');
    $tip = request('tip');

    $firme = auth()->user()->firme()->with(['documente' => function($query) use ($cauta, $tip) {
        if ($cauta) {
            $query->where(function($q) use ($cauta) {
                $q->where('numar_document', 'like', '%' . $cauta . '%')
                  ->orWhere('tip', 'like', '%' . $cauta . '%')
                  ->orWhere('observatii', 'like', '%' . $cauta . '%');
            });
        }
        if ($tip) {
            $query->where('tip', $tip);
        }
        $query->orderBy('data_document', 'desc');
    }])->get();

    return view('user.dashboard', compact('firme', 'cauta', 'tip'));
})->name('user.dashboard');
});

    Route::post('/contact', function (\Illuminate\Http\Request $request) {
        $request->validate([
            'nume'    => 'required|string|max:255',
            'email'   => 'required|email',
            'telefon' => 'nullable|string|max:20',
            'mesaj'   => 'required|string',
        ]);

        \App\Models\Notificare::create([
            'tip'   => 'contact',
            'titlu' => 'Cerere noua de servicii de la ' . $request->nume,
            'mesaj' => 'Email: ' . $request->email .
                    ' | Telefon: ' . ($request->telefon ?? '-') .
                    ' | Mesaj: ' . $request->mesaj,
        ]);

        return back()->with('contact_success', 'Mesajul a fost trimis! Te vom contacta in curand.');
    })->name('contact');

require __DIR__.'/auth.php';