<?php

namespace App\Http\Controllers;

use App\Coursmonnaie;
use App\Crypto;
use App\Portefeuille;
use App\Spend;
use App\User;
use ConsoleTVs\Charts\Facades\Charts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ChartController extends Controller
{

    public function index()
    {

        $currentUser = Auth::user();
        $portefeuille = Portefeuille::find($currentUser->id);
        $cryptos = Crypto::all();
        $valeurId = 1;
        $coursmonnaie = Coursmonnaie::where('crypto_id', '=', $valeurId)->get();

        $dataCrypto = [];
        $date = [];

        for($i = 0; $i < count($coursmonnaie); $i++){
            array_push($dataCrypto, $coursmonnaie[$i]->taux);
        }

        for($j = 0; $j < count($coursmonnaie); $j++){
            array_push($date, $coursmonnaie[$j]->date);
        }


        $cryptoValue = Crypto::find($valeurId);
        $chart = Charts::create('line', 'highcharts')
            ->Title('graphique')
            ->Labels($date)
            ->Values($dataCrypto)
            ->Dimensions(1000,500)
            ->Responsive(false);
        return view('client.chart',compact('chart','cryptoValue','valeurId', 'coursmonnaie', 'currentUser','cryptos', 'portefeuille'));

    }

    public function showCrypto(Crypto $crypto)
    {
        $currentUser = Auth::user();
        $portefeuille = Portefeuille::find($currentUser->id);
        $cryptos = Crypto::all();
        $valeurId = $crypto->id;
        $coursmonnaie = Coursmonnaie::where('crypto_id', '=', $valeurId)->get();

        $dataCrypto = [];
        $date = [];

        for($i = 0; $i < count($coursmonnaie); $i++){
            array_push($dataCrypto, $coursmonnaie[$i]->taux);
        }

        for($j = 0; $j < count($coursmonnaie); $j++){
            array_push($date, $coursmonnaie[$j]->date);
        }


        $cryptoValue = Crypto::find($valeurId);
        $chart = Charts::create('line', 'highcharts')
            ->Title('graphique')
            ->Labels($date)
            ->Values($dataCrypto)
            ->Dimensions(1000,500)
            ->Responsive(false);
        return view('client.chart',compact('chart','cryptoValue','coursmonnaie','valeurId', 'currentUser','cryptos', 'portefeuille'));

    }

    public function buyCrypto(Crypto $crypto)
    {
        $currentUser = Auth::user();
        return view('client.buy',compact('currentUser','crypto'));
    }

    public function confirmBuyCrypto(Request $request, Crypto $crypto)
    {
        $today = Carbon::today();
        $currentUser = Auth::user();
        //$date = new DateTime();
       
        $current_cours = Coursmonnaie::where('crypto_id', '=', $crypto->id)
                ->where('date', '=', $today)->get();

        //dd($current_cours);

        $valeur_euros = $request->quantite * $current_cours[0]->taux;
        dump($valeur_euros);
        //dd($current_cours);

       
        /*
        $request= [
            'crypto_id' => $crypto->id,
            'user_id' => $currentUser->id,
            'date_achat' => $today->format('Y-m-d'),
            'quantité' => $request->quantite,
            'valeur_euros' => $valeur_euros,
            'Coursmonnaie_id' => $crypto->id
        ];*/

        $request->request->add([
            'crypto_id' => $crypto->id,
            'user_id' => $currentUser->id,
            'date_achat' => $today->format('Y-m-d'),
            'valeur_euros' => $valeur_euros,
            'Coursmonnaie_id' => $current_cours[0]->id,
            'quantité' => $request->quantite,
        ]);
        //dd($request);
        request()->validate([
            'crypto_id' => 'required',
            'user_id' => 'required',
            'date_achat' => 'required',
            'quantité' => 'required',
            'valeur_euros' => 'required',
            'Coursmonnaie_id' => 'required',
        ]);
        //dd($request);

        Spend::create($request->all());

        return redirect()->route('listMonnaie')->with('Success','Votre achat a bien été effectué');
    }
    
}
