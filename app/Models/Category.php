<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class Category extends Model
{
    use SoftDeletes;

    protected $table = 'categories';

    protected $primaryKey = 'id';

    protected $fillable = [
        'title',
        'description',
    ];

    /**
     * Get paginated list of categories with optional sorting and search.
     *
     * @param string|null $sort Sorting option.
     * @param string|null $search Search term.
     * @return LengthAwarePaginator<Category>
     */
    public static function getCategory($sort = null, $search = null): LengthAwarePaginator
    {
        $query = Category::withTrashed()->select("id", "title", "description", "deleted_at");

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
            case 'sort_delete':
                $query->orderBy('deleted_at', 'desc');
                break;
            default:
                $query->orderBy('id', 'asc');
        }

        return $query->paginate(7);
    }

    /**
     * Get category by ID.
     *
     * @param int $id
     * @return Category|null
     */
    public static function getById(int $id): ?object
    {
        return Category::find($id);
    }

    /**
     * Store a new category.
     *
     * @param array<string, mixed> $data
     * @return void
     */
    public static function store(array $data): void
    {
        Category::create([
            'title' => $data['title'],
            'description' => $data['description'],
        ]);
    }

    /**
     * Delete category by ID.
     *
     * @param int $id
     * @return void
     */
    public static function deleteById(int $id): void
    {
        Category::findOrFail($id)->delete();
    }
}
