<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

   // Category.php
public function getResearchesAttribute()
{
    return \App\Models\Research::whereJsonContains('category_ids', $this->id)->get();
}

}
