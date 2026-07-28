<?php

// Lang switch controller logic
$locale = request('locale');
$locales = config('app.available_locales', ['en']);

if (in_array($locale, $locales)) {
    session(['locale' => $locale]);
}

return redirect()->back();

