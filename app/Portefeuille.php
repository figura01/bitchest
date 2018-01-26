<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Portefeuille extends Model

{
    public $table = "portefeuille";

    protected $fillable = [
        'user_id',
        'crypto_id',
        'solde_euros'
    ];
    public function user()
    {
        return $this->hasOne(User::class);
    }
    public function crypto()
    {
        return $this->belongsTo(Crypto::class);
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
