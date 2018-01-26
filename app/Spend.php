<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Spend extends Model
{
    protected $fillable = [
        'crypto_id',
        'user_id',
        'date_achat',
        'quantité',
        'valeur_euros',
        'active',
        'Coursmonnaie_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function crypto()
    {

        return $this->belongsTo(Crypto::class);
    }

    public function Coursmonnaie()
    {
        return $this->belongsTo(Coursmonnaie::class);
    }
    public function getCoursActuel()
    {

        $cours =  DB::table('coursmonnaie')
            ->select('taux')
            ->orderBy('date', 'desc')
            ->where('crypto_id', '=', $this->id)
            ->first();
        return $cours;
    }

}
