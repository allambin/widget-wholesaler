<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Database\Factories\PackFactory;

class Pack extends Model
{
    /** @use HasFactory<\Database\Factories\PackFactory> */
    use HasFactory;

    protected $fillable = [
        'quantity',
    ];

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory()
    {
        return PackFactory::new();
    }
}
