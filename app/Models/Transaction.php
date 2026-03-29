<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Traits\Filterable;

class Transaction extends Model
{
    use HasFactory, Filterable, SoftDeletes;

    protected $fillable = [
        'book_id',
        'user_id',
        'borrowed_at',
        'returned_at',
        'due_at',
        'reject_reason',
        'status',
    ];

    protected $casts = [
        'borrowed_at' => 'datetime',
        'returned_at' => 'datetime',
        'due_at'      => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function book()
    {
        return $this->belongsTo(Book::class)->withTrashed();
    }

    public function getStatusLabelAttribute()
    {
        return [
            'pending'  => 'Menunggu',
            'borrowed' => 'Dipinjam',
            'returned' => 'Kembali',
            'late'     => 'Terlambat',
            'rejected' => 'Ditolak',
        ][$this->status] ?? $this->status;
    }
}
