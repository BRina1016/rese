<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(){
        return view('index');
    }
    public function show()
    {
        return view('detail', ['id' => '01']);
    }
}
