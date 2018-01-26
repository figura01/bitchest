<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Crypto extends Model
{
    public $table = "crypto";

    protected $fillable = [
        'name',
        'valeur_init'
    ];

    public function spends()
    {
        return $this->hasOne(Spend::class);

    }
    public function coursmonnaie()
    {
        return $this->hasMany(Coursmonnaie::class);

    }
    public function getCoursActuel()
    {

        $cours = DB::table('coursmonnaie')
            ->select('taux')
            ->orderBy('date', 'desc')
            ->where('crypto_id', '=', $this->id)
            ->first();
        return $cours;
    }
}
