<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coursmonnaie extends Model
{
    public $table = "coursmonnaie";
    protected $fillable = [
        'crypto_id',
        'date',
        'taux'
    ];

    public function crypto()
    {
        return $this->belongsTo(Crypto::class);
    }
}
