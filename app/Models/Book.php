<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Traits\Filterable;

class Book extends Model
{
    use HasFactory, Filterable;

    protected $fillable = [
        'cover',
        'title',
        'writer',
        'publisher',
        'description',
        'stock',
        'category_id',
    ];

    public function transaction ()
    {
        return $this->hasMany(Transaction::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class)->withDefault([
            'name' => '-'
        ]);
    }
}
