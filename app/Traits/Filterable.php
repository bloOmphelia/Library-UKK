<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait Filterable
{
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

        // 2. Logika Filter Otomatis & Custom
        foreach ($filters as $key => $value) {
            // Lewati jika nilainya kosong atau jika itu keyword 'search' atau 'stock_order'
            if (empty($value) || in_array($key, ['search', 'stock_order', 'page'])) {
                continue;
            }

            if ($key === 'class') {
                // Khusus 'class', gunakan LIKE agar "12" bisa filter "12 RPL", "12 DKV", dll.
                $query->where('class', 'like', $value . '%');
            } else {
                // Filter lainnya (misal: gender, status, dll) tetap menggunakan '='
                $query->where($key, $value);
            }
        }

        return $query;
    }
}