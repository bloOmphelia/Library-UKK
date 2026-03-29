<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Traits\Filterable;

class Category extends Model
{
    use HasFactory, Filterable, SoftDeletes;

    protected $fillable = [
        'name',
    ];

    public function books ()
    {
        return $this->hasMany(Book::class);
    }
}
