<?php

namespace App\Http\Controllers;

use App\Coursmonnaie;
use App\Crypto;
use App\Portefeuille;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Spend;

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
    public function index()
    {
        $currentUser = Auth::user();
        $allusers = User::all();
        $spends = Spend::all();
        $cryptos = Crypto::all();
        $coursmonnaies = Coursmonnaie::all();
        $portefeuille = Portefeuille::find($currentUser->id);

        //dd($spends);

        if($currentUser->role == 'admin'){
            return view('admin.home', compact('currentUser', 'cryptos', 'allusers','spends', 'coursmonnaies', 'allUser'));
        }else{
            return view('client.home', compact('currentUser','spends','portefeuille', 'cryptos', 'coursmonnaies'));
        }
        
    }
}
