<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait Filterable
{
    /**
     * Logic Filter Global
     * $searchableColumns: kolom yang mau dicari (bisa kolom biasa atau relasi)
     */
    public function scopeFilter(Builder $query, array $filters, array $searchableColumns = [])
    {
        // 1. Logika Search (Judul, Penulis, atau Nama User)
        $query->when($filters['search'] ?? null, function ($q, $search) use ($searchableColumns) {
            $q->where(function ($innerQuery) use ($search, $searchableColumns) {
                foreach ($searchableColumns as $column) {
                    if (str_contains($column, '.')) {
                        // Jika mencari di tabel relasi (contoh: 'book.title' atau 'user.name')
                        [$relation, $relColumn] = explode('.', $column);
                        $innerQuery->orWhereHas($relation, function ($relQuery) use ($relColumn, $search) {
                            $relQuery->where($relColumn, 'like', "%$search%");
                        });
                    } else {
                        // Jika mencari di tabel itu sendiri
                        $innerQuery->orWhere($column, 'like', "%$search%");
                    }
                }
            });
        });

        // 2. Logika Filter Otomatis (category_id, status, dll)
        foreach ($filters as $key => $value) {
            if ($key !== 'search' && !empty($value)) {
                $query->where($key, $value);
            }
        }

        return $query;
    }
}