<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    protected $table = 'quotes';

    protected $fillable = [
        'content',
        'author',
        'created_by',
    ];

    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
