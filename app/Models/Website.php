<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Website extends Model
{
    protected $fillable = [
        'client_id',
        'url',
        'is_down',
        'last_checked_at',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}

