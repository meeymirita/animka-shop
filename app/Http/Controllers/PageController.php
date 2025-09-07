<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class PageController extends Controller
{
    public function index()
    {
        $data = [
                'index' => 'index',
                '1' => 'Первое меню',
                '2' => 'Второе меню',
                '3' => 'Третье меню',
                '4' => 'Четвертое меню',
                '5' => 'Пятое меню',
        ];
        return Inertia::render('Index', ['data' => $data]);
    }
   public function second()
    {
        return Inertia::render('Second/Index',
            ['second' => 'Second']
        );
    }
}
