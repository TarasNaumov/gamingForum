<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class Forum extends Model
{
    use SoftDeletes;

    protected $table = 'forums';

    protected $primaryKey = 'id';

    protected $fillable = [
        'subcategory_id',
        'title',
    ];

    /**
     * Get forum by ID.
     *
     * @param int $id
     * @return Forum|null
     */
    public static function getById(int $id): ?object
    {
        return Forum::where('id', $id)->firstOrFail();
    }

    /**
     * Store a new forum entry.
     *
     * @param array<string, mixed> $data
     * @return void
     */
    public static function store(array $data): void
    {
        Forum::create([
            'title' => $data['title'],
            'subcategory_id' => $data['subcategory_id']
        ]);
    }

    /**
     * Get paginated forums list with optional search and sorting.
     *
     * @param string|null $search
     * @param string|null $sort
     * @return LengthAwarePaginator<Forum>
     */
    public static function getForums($search, $sort): LengthAwarePaginator
    {
        $query = Forum::withTrashed()->select("id", "subcategory_id", "title", "deleted_at");

        if (!empty($search)) {
            $query->where('title', 'like', '%' . $search . '%');
        }

        switch ($sort) {
            case 'sort_id':
                $query->orderBy('id', 'asc');
                break;
            case 'sort_title':
                $query->orderBy('title', 'asc');
                break;
            case 'sort_subcategory':
                $query->orderBy('subcategory_id', 'asc');
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
     * Search forums with optional title and subcategory filter.
     *
     * @param Builder $query
     * @param int $id
     * @param Request $request
     * @return LengthAwarePaginator<Forum>
     */
    public static function search($query, int $id, Request $request): LengthAwarePaginator
    {
        if ($request->filled('search')) {
            $search = '%' . $request->search . '%';
            $query->where('title', 'like', $search);
        }

        if ($id !== 0) {
            $query->where('subcategory_id', $id);
        }

        return $query->paginate(14);
    }
}
