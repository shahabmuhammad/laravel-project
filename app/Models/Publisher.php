<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Publisher extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'website',
        'address',
    ];

    public function researches()
    {
        return $this->hasMany(Research::class);
    }
}
