<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{


    public function home(Request $request)
    {
        $auth = authResource($request);
      
        return Inertia::render('Admin/Home', compact('auth'));
    }
}
