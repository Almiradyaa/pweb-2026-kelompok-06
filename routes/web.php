<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::view('/preview-daftar-email', 'auth.register-email');
Route::view('/preview-daftar-sandi', 'auth.register-password');
Route::view('/preview-otp', 'auth.verify-otp');
Route::view('/preview-daftar-profil', 'auth.register-profile');
Route::view('/preview-login', 'auth.login');
Route::view('/preview-landing', 'landing');
Route::view('/preview-katalog', 'catalog');

Route::get('/preview-antre', function () {
    return view('pinjam-detail', ['status' => 'antre']);
});

Route::get('/preview-dipinjam', function () {
    return view('pinjam-detail', ['status' => 'dipinjam']);
});

Route::get('/preview-detail-buku', function () {
    return view('detail-buku');
});

Route::get('/preview-detail-antre/{slug?}', function (?string $slug = 'beautiful-boy') {
    $books = [
        'beautiful-boy' => [
            'title' => 'Beautiful Boy',
            'author' => 'David Sheff',
            'categories' => ['Non-Fiksi'],
            'is_new' => true,
            'cover' => 'images/book-4.png',
            'release_year' => '2008',
            'stock' => 0,
            'synopsis' => 'kisah nyata karya David Sheff tentang perjuangan berat seorang ayah menghadapi kecanduan metamfetamin yang menghancurkan hidup putranya yang cerdas, Nic. Melalui siklus rehabilitasi dan kekambuhan yang terus berulang, David berusaha memahami ilmu di balik kecanduan sambil menjaga kewarasannya dan tetap mencintai sang anak tanpa terjebak dalam perilaku yang merusak. Kisah ini menyoroti dampak emosional kecanduan terhadap keluarga serta keteguhan harapan di tengah ketidakberdayaan orang tua untuk menyelamatkan anaknya sendiri.',
            'available_again' => '01-01-2027',
            'return_date' => '06-01-2027',
            'queue_action' => '#antre-submit',
        ],
        'sense-and-sensibility' => [
            'title' => 'Sense and Sensibility',
            'author' => 'Jane Austen',
            'categories' => ['Fiksi'],
            'is_new' => true,
            'cover' => 'images/book-3.png',
            'release_year' => '1811',
            'stock' => 0,
            'synopsis' => 'Setelah kehilangan harta warisan, keluarga Dashwood pindah ke Barton Cottage. Elinor menghadapi cinta yang rumit dengan Edward Ferrars, sementara Marianne patah hati karena ditinggalkan John Willoughby. Setelah melewati berbagai konflik dan kekecewaan, Elinor menikahi Edward, sedangkan Marianne menikahi Kolonel Brandon.',
            'available_again' => '01-01-2027',
            'return_date' => '06-01-2027',
            'queue_action' => '#antre-submit',
        ],
    ];

    $selectedBook = $books[$slug] ?? $books['beautiful-boy'];

    $similarBooks = [
        [
            'title' => 'Persuasion',
            'author' => 'Jane Austen',
            'categories' => ['Fiksi'],
            'is_new' => true,
            'cover' => 'images/book-5.png',
            'stock' => 4,
            'url' => url('/preview-detail-antre/sense-and-sensibility'),
        ],
        [
            'title' => 'North and South',
            'author' => 'Elizabeth Gaskell',
            'categories' => ['Fiksi'],
            'is_new' => true,
            'cover' => 'images/book-9.png',
            'stock' => 2,
            'url' => url('/preview-detail-antre/beautiful-boy'),
        ],
        [
            'title' => 'Marie Antoinette',
            'author' => 'Antonia Fraser',
            'categories' => ['Non-Fiksi'],
            'is_new' => true,
            'cover' => 'images/book-8.png',
            'stock' => 3,
            'url' => url('/preview-detail-antre/sense-and-sensibility'),
        ],
    ];

    return view('detail-buku', [
        'book' => $selectedBook,
        'similarBooks' => $similarBooks,
    ]);
});