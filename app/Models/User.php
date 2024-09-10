<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\UserRole;
class User extends Authenticatable
{
    use HasFactory, Notifiable, softDeletes;

    private static $parent_id;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'parent_id',
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

    public static function setAuthId($id) {
        self::$parent_id = $id;
        return new self;
    }

    public function createUser(array $data)
    {
        try {
            $role = UserRole::where('id', $data['role'])->first();

            if (!$role) {
                throw new Exception("Role not found.");
            }

            $newUser = self::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role_id' => $role->id,
                'parent_id' => self::$parent_id
            ]);

            if (!$newUser) {
                throw new Exception("Failed to create user.");
            }
            return ['status' => 'success', 'message' => 'User created successfully.', 'user' => $newUser];
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public static function updateUser(array $data, int $id) {
        try {
            $user = self::find($id);
            if (!$user) {
                throw new Exception("User not found.");
            }

            $user->name = $data['name'];
            $user->role_id = $data['role'];
            $user->save();
            return ['status' => 'success', 'message' => 'User updated successfully.'];
        } catch(Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }

    }

    public function role()
    {
        return $this->belongsTo(UserRole::class, 'role_id');
    }
}
