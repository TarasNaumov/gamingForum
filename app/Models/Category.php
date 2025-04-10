<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'categories';

    /**
     * The primary key of the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description'
    ];

    /**
     * Retrieves a category by its ID.
     *
     * @param int $id Category ID.
     * @return object|null
     */
    public static function getById(int $id): ?object
    {
        return Category::find($id);
    }

    /**
     * Stores a new category in the database.
     *
     * @param array $data Associative array containing category data.
     * @return void
     */
    public static function store(array $data): void
    {
        Category::create([
            'title' => $data['title'],
            'description' => $data['description']
        ]);
    }

    /**
     * Deletes a category by its ID.
     *
     * @param int $id Category ID.
     * @return void
     */
    public static function deleteById(int $id): void
    {
        Category::findOrFail($id)->delete();
    }

}

