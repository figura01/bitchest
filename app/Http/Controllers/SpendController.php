<?php

namespace App\Http\Controllers;

use App\Coursmonnaie;
use App\Crypto;
use App\Portefeuille;
use App\Spend;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class SpendController extends Controller
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
        ->where('active', '=', 1)->get();        
        $portefeuille = Portefeuille::find($currentUser->id);
        //$portefeuilleCryptos = Portefeuille::find($currentUser->id);
        $cryptos = Crypto::all();
        $coursmonnaies = Coursmonnaie::all();

        return view('client.portefeuille', compact('currentUser','spends','portefeuille', 'cryptos', 'coursmonnaies'));

    }
    public function showHistorique() {
        $currentUser = Auth::user();
        $spends = Spend::where('user_id', '=' , $currentUser->id)->orderBy('date_achat', 'desc')->get();
        $achats = Spend::where('user_id', '=' , $currentUser->id)
        ->where('active', '=', 1)->orderBy('date_achat', 'desc')->get();

        $ventes = Spend::where('user_id', '=' , $currentUser->id)
        ->where('active', '=', 0)->orderBy('date_achat', 'desc')->get();

        $portefeuille = Portefeuille::find($currentUser->id);
        $cryptos = Crypto::all();
        $coursmonnaies = Coursmonnaie::all();
        $status = ['Vendus','En cours'];

        return view('client.historique', compact('currentUser','spends','portefeuille', 'cryptos', 'coursmonnaies', 'status', 'achats', 'ventes'));
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
     * @param  \App\Spend  $spend
     * @return \Illuminate\Http\Response
     */
    public function show(Spend $spend)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Spend  $spend
     * @return \Illuminate\Http\Response
     */
    public function edit(Spend $spend)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Spend  $spend
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Spend $spend)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Spend  $spend
     * @return \Illuminate\Http\Response
     */

    public function displaySpend(Spend $spend)
    {
        $valeur_euros = $spend->valeur_euros;
        
        $portefeuille = Portefeuille::find($spend->user_id);
        $portefeuille->solde_euros += $valeur_euros;
        $portefeuille->save();

        $spend->active = 0;
        $spend->save();

        //Spend::destroy($spend->id);
        return back()->with('successMessage','Votre vente à bien été effectué');
    }
    
    public function destroy(Spend $spend)
    {
        $valeur_euros = $spend->valeur_euros;
        
        $portefeuille = Portefeuille::find($spend->user_id);
        $portefeuille->solde_euros += $valeur_euros;
        $portefeuille->save();


        Spend::destroy($spend->id);
        return redirect()->route('portefeuille')
        ->with('success','Votre vente à bien été effectué');
    }

    public function buyCrypto(Crypto $crypto)
    {
        $currentUser = Auth::user();

        return view('client.buy', compact('currentUser','crypto'));
    }

    public function confirmBuyCrypto(Request $request, Crypto $crypto)
    {
        $today = Carbon::today();
        $currentUser = Auth::user();

        $portefeuille = Portefeuille::find($currentUser->id);



        $current_cours = Coursmonnaie::where('crypto_id', '=', $crypto->id)
                ->where('date', '=', $today)->get();
        
        //$get_current_cours_N1 = $current_cours->id - 1;

        //$current_cours_N1 = Coursmonnaie::where('id', '=', $current_cours_N1);
       


        $valeur_euros = $request->quantite * $current_cours[0]->taux;
        
        if( $portefeuille->solde_euros - $valeur_euros < 0){
            return back()->with('errorMessage','Votre solde \' est pas suffisant pour effectuer cet achat');
        }


        $request->request->add([
            'crypto_id' => $crypto->id,
            'user_id' => $currentUser->id,
            'date_achat' => $today->format('Y-m-d'),
            'valeur_euros' => $valeur_euros,
            'active' => 1,
            'Coursmonnaie_id' => $current_cours[0]->id,
            'quantité' => $request->quantite,
        ]);
    
        request()->validate([
            'crypto_id' => 'required',
            'user_id' => 'required',
            'date_achat' => 'required',
            'quantité' => 'required',
            'valeur_euros' => 'required',
            'Coursmonnaie_id' => 'required',
        ]);
        
        $portefeuille->solde_euros -= $valeur_euros;
        $portefeuille->save();
        
        Spend::create($request->all());

        return redirect()->route('listMonnaie')->with('successMessage','Votre achat a bien été effectué');
    }
}