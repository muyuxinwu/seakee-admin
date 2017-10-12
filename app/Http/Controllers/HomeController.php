<?php

namespace App\Http\Controllers;

use App\Interfaces\CommonInterface;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(CommonInterface $common)
    {
    	$image = $common->getBingImage(0,2);
    	dd($image);
        return view('home');
    }
}
