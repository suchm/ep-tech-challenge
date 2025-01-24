<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    protected $fillable = [
        'client_id',
        'date',
        'body',
    ];

    protected $dates = [
        'date',
        'created_at',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
