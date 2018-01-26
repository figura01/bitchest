<?php

namespace App\Http\Controllers;

use App\Coursmonnaie;
use App\Crypto;
use App\Portefeuille;
use App\Spend;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PortefeuilleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $currentUser = Auth::user();
        $spends = Spend::where('user_id', '=' , $currentUser->id)
        ->where('active', '=', '1')
        ->get();
        
        $portefeuille = Portefeuille::find($currentUser->id);
        //$portefeuilleCryptos = Portefeuille::find($currentUser->id);
        $cryptos = Crypto::all();
        $coursmonnaies = Coursmonnaie::all();

        return view('client.portefeuille', compact('currentUser','spends','portefeuille', 'cryptos', 'coursmonnaies'));

    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Portefeuille  $portefeuille
     * @return \Illuminate\Http\Response
     */
    public function show(Portefeuille $portefeuille)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Portefeuille  $portefeuille
     * @return \Illuminate\Http\Response
     */
    public function edit(Portefeuille $portefeuille)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Portefeuille  $portefeuille
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Portefeuille $portefeuille)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Portefeuille  $portefeuille
     * @return \Illuminate\Http\Response
     */
    public function destroy(Portefeuille $portefeuille)
    {
        //Spend::destroy($spend->id);
        return redirect()->route('portefeuille')
        ->with('success','Votre vente à bien été effectué');
    }
}
