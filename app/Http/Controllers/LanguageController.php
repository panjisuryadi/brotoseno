<?php

namespace App\Http\Controllers;

use Carbon\Carbon;

class LanguageController extends Controller
{
    public function switch($language)
    {
        app()->setLocale($language);

        session()->put('locale', $language);

        setlocale(LC_TIME, $language);

        Carbon::setLocale($language);
         toast(__('Language changed to').' '.strtoupper($language), 'success');
        return redirect()->back();
    }
}
