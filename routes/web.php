<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

if (app()->isLocal()) {
    Route::get('/test', function () {
        $my_img = imagecreate(200, 200);
        $background = imagecolorallocate($my_img, 0, 0, 255);
        $text_colour = imagecolorallocate($my_img, 255, 255, 0);
        $line_colour = imagecolorallocate($my_img, 128, 255, 0);
        imagestring($my_img, 4, 30, 100, 'test image', $text_colour);
        imagesetthickness($my_img, 5);
        imageline($my_img, 30, 120, 165, 120, $line_colour);

        ob_start();
        imagepng($my_img);
        $data = ob_get_contents();
        ob_end_clean();

        $data = base64_encode($data);
        $data = "data:image/png;base64,{$data}";

        imagedestroy($my_img);

        $vars = get_defined_vars();

        return view('test', compact(array_keys(get_defined_vars())));
    });
}

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
