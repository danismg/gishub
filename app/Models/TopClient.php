<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TopClient extends Model
{
    protected $fillable = [
        'client_id',
    ];

    public function client()
    {
        return $this->belongsTo(client::class);
    }
}
