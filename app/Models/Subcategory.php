<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class Subcategory extends Model
{
    use SoftDeletes;

    protected $table = 'subcategories';
    protected $primaryKey = 'id';

    protected $fillable = [
        'category_id',
        'title',
        'description'
    ];

    /**
     * Store a new subcategory in the database.
     *
     * @param array $data
     * @return void
     */
    public static function store($data): void
    {
        Subcategory::create([
            'title' => $data['title'],
            'description' => $data['description'],
            'category_id' => $data['category_id']
        ]);
    }

    /**
     * Get subcategories with optional search and sorting.
     *
     * @param string|null $sort
     * @param string|null $search
     * @return LengthAwarePaginator
     */
    public static function getSubcategory($sort, $search): LengthAwarePaginator
    {
        $query = Subcategory::withTrashed()->select("id", "category_id", "title", "description", "deleted_at");

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        switch ($sort) {
            case 'sort_id':
                $query->orderBy('id', 'asc');
                break;
            case 'sort_title':
                $query->orderBy('title', 'asc');
                break;
            case 'sort_description':
                $query->orderBy('description', 'asc');
                break;
            case 'sort_category':
                $query->orderBy('category_id', 'asc');
                break;
            case 'sort_delete':
                $query->orderBy('deleted_at', 'desc');
                break;
            default:
                $query->orderBy('id', 'asc');
        }

        return $query->paginate(7);
    }

    /**
     * Search subcategories by title or description and optionally filter by category.
     *
     * @param Builder $query
     * @param int $id
     * @param Request $request
     * @return LengthAwarePaginator
     */
    public static function search($query, $id, Request $request)
    {
        if ($request->filled('search')) {
            $search = '%' . $request->search . '%';
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', $search)
                    ->orWhere('description', 'like', $search);
            });
        }

        if ($id != 0) {
            $query->where('category_id', $id);
        }

        return $query->paginate(6);
    }
}
