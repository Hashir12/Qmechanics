<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\UserRole;
class User extends Authenticatable
{
    use HasFactory, Notifiable, softDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id'
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

    public static function createUser(array $data)
    {
        $roleId = UserRole::where('id', $data['role'])->first()->id;

        if (!$roleId) {
            throw new \Exception("Role not found.");
        }

        return self::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role_id' => $roleId,
        ]);
    }

    public static function updateUser(array $data, int $id) {
        $user = self::findOrFail($id);
        $user->name = $data['name'];
        $user->role_id = $data['role'];
        $user->save();
    }


    public function role()
    {
        return $this->belongsTo(UserRole::class, 'role_id');
    }
}
