<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_id',
        'rating',
        'comment'
    ];

    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id');
    }
}
