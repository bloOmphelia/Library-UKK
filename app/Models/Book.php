<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Traits\Filterable;

class Book extends Model
{
    use HasFactory, Filterable, SoftDeletes;

    protected $fillable = [
        'cover',
        'title',
        'writer',
        'publisher',
        'description',
        'stock',
        'year',
        'language',
        'category_id',
        'status',
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

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }
}
