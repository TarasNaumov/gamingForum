<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class Topic extends Model
{
    use softDeletes;
    protected $table = 'topics';
    protected $primaryKey = 'id';
    protected $fillable = [
        'title',
        'description',
        'forum_id',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function forum()
    {
        return $this->belongsTo(Forum::class);
    }

    public function messages() {
        return $this->hasMany(Message::class);
    }
    public static function store(array $data): void
    {
        Topic::create([
            'title' => $data['title'],
            'description' => $data['description'],
            'forum_id' => $data['subcategory_id']
        ]);
    }


    public static function getTopics($search, $sort)
    {
        $query = Topic::withTrashed()->select("id", "forum_id", "title", "description", "user_id", "deleted_at");

        if (!empty($search)) {
            $query->where('title', 'like', '%' . $search . '%')
                ->orWhere('description', 'like', '%' . $search . '%');
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
            case 'sort_forum':
                $query->orderBy('forum_id', 'asc');
                break;
            case 'sort_delete':
                $query->orderBy('deleted_at', 'desc');
                break;
            default:
                $query->orderBy('id', 'asc');
        }

        return $query->paginate(15);
    }
    public static function search($query, $id, Request $request) {
        $query->where('forum_id', $id);

        if ($request->filled('search')) {
            $search = '%' . $request->search . '%';

            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', $search)
                    ->orWhere('description', 'like', $search);
            });
        }

        return $query->paginate(10);

    }

}
