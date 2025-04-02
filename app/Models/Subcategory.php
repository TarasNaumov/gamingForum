<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

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

    public static function store($data): void
    {
        Subcategory::create([
            'title' => $data['title'],
            'description' => $data['description'],
            'category_id' => $data['category_id']
        ]);
    }
}
