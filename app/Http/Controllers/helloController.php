<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class helloController extends Controller
{
    public function index()
    {
        return "Hello, World!";
    }
    public function saluer($name)
    {
        return "Hello, " .$name. "!".' Bienvenue chez laravel.';
    }
}   
