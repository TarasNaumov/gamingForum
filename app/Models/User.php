<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class User extends Authenticatable implements HasMedia
{
    use HasFactory, Notifiable, InteractsWithMedia;

    protected $primaryKey = "id";
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'role',
        'name',
        'surname',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public static function getUsers($search, $sort)
    {
        $query = User::select("id", "role", "name", "surname", "email", "status");

        if (!empty($search)) {
            $query->where('title', 'like', '%' . $search . '%')
                ->orWhere('description', 'like', '%' . $search . '%');
        }
        switch ($sort) {
            case 'sort_id':
                $query->orderBy('id', 'asc');
                break;
            case 'sort_name':
                $query->orderBy('name', 'asc');
                break;
            case 'sort_surname':
                $query->orderBy('surname', 'asc');
                break;
            case 'sort_role':
                $query->orderBy('role', 'asc');
                break;
            case 'sort_email':
                $query->orderBy('email', 'desc');
                break;
            default:
                $query->orderBy('id', 'asc');
        }

        return $query->paginate(15);
    }
}
