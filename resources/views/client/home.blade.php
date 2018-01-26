@extends('layouts.app')

@section('content')


  <h1 class="page-header">Dashboard CLIENT</h1>

  <h2 class="sub-header">Detail des achats <span class="solde">Mon solde: <strong>{{$portefeuille->solde_euros}} €</strong></span></h2>
  <div class="table-responsive">
    <table class="table table-striped">
      <thead>
        <tr>
          <th>#</th>
          <th>date d'achat </th>
          <th>Nom de la crypto-monnaie</th>
          <th>Quantité acheté</th>
          <th>Valeur Initiale en Euros</th>
          <th>Valeur actuelle en Euros</th>
          <th>Taux actuel de la monnaie</th>
        </tr>
      </thead>
      <tbody>
      @foreach($spends as $spend)
        <tr>
          <td>#</td>
          <td>{{ $spend->date_achat }}</td>
          <td>{{ $spend->crypto->name}}</td>
          <td>{{ $spend->quantité }}</td>
          <td>{{ $spend->valeur_euros }}€</td>
          <td>{{ $spend->getCoursActuel()->taux * $spend->quantité }}</td>
          <td>{{ $spend->getCoursActuel()->taux}}</td>
        </tr>
      @endforeach
    </table>
  </div>
@endsection
