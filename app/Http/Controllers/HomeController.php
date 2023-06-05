<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class HomeController extends Controller {
    public function home(Request $request): RedirectResponse {
        // if session user exist redirect to /todolist
        if ($request->session()->exists('user'))
            return redirect('/todolist');

        // default return to /login
        return redirect('/login');
    }
}
