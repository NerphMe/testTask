<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exchange extends Model
{
    use HasFactory;

    protected $table = 'exchange';

    protected $fillable = [
        'baseCurrency',
        'quoteCurrency',
        'user_id',
        'rate',
        'baseCurrencyAmount',
        'quoteCurrencyAmount',
    ];

    public $timestamps = true;

    public function users()
    {
        return $this->hasOne(User::class,'id','user_id');
    }
}
