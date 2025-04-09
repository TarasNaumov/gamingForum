<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Topic extends Model
{
    public static function search($query, $id, Request $request) {
        if ($request->filled('search')) {
            $search = '%' . $request->search . '%';
            $query->where('title', 'like', $search)
                    ->orWhere('description', 'like', $search)
                    ->andWhere('forum_id', $id);;
        }
        return $query->get();
    }
}
