<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Forum extends Model
{
    use softDeletes;
    protected $table = 'forums';
    protected $primaryKey = 'id';
    protected $fillable = [
        'subcategory_id',
        'title',
    ];

    /**
     * Retrieves a Subcategory by its ID.
     *
     * @param int $id Subcategory ID.
     * @return object|null
     */
    public static function getById(int $id): ?object
    {
        return Forum::where('id', $id)->firstOrFail();
    }

    /**
     * Stores a new forum in the database.
     *
     * @param array $data Associative array containing forum data.
     * @return void
     */
    public static function store(array $data): void
    {
        Forum::create([
            'title' => $data['title'],
            'subcategory_id' => $data['subcategory_id']
        ]);
    }

    public static function search($query, $id, Request $request) {
        if ($request->filled('search')) {
            $search = '%' . $request->search . '%';
            $query->where('title', 'like', $search);
        }

        if ($id != 0) {
            $query->where('subcategory_id', $id);
        }

        return $query->get();
    }
}
