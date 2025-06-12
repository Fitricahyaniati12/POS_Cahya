<?php

namespace App\Models;

use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Middleware\Authorize;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Tymon\JWTAuth\Contracts\JWTSubject;

class UserModel extends  Authenticatable implements JWTSubject
{

    public function getJWTIdentifier()
    {
        return $this->getkey();
    }

    public function getJWTCustomClaims()
    {
        return[];
    }
    use HasFactory, Timestamp;

    protected $table = 'm_user'; // Mendefinisikan nama tabel yang digunakan oleh model ini
    protected $primaryKey = 'user_id'; // Mendefinisikan primary key dari tabel yang digunakan

     protected $fillable = ['level_id', 'username', 'nama', 'password', 'created_at', 'updated_at', 'image'];

    protected $hidden   = ['password'];

    protected $casts    = ['password' => 'hashed'];

    public function level(): BelongsTo
    {
        return $this->belongsTo(LevelModel::class, 'level_id', 'level_id');
    }
    /**
     * Mendapatkan nama role dari user
     */
    public function getRoleName(): string
    {
        return $this->level ? $this->level->level_nama : 'Tidak ada level';
        //return $this->level->level_nama;
    }

    /**
     * Cek apakah user memiliki role tertentu
     */
    public function hasRole($role): bool
    {
        return $this->level && $this->level->level_kode === $role;
    }
    public function getRole()
    {
        return $this->level ? $this->level->level_kode : null;
    }

    protected function image(): Attribute
    {
         return Attribute::make(
        get: fn ($image) => $image ? url('/' . $image) : null,
    );
    // return Attribute::make(
    // get: fn ($image) => url('/storage/posts/' . $image),
    // );
    }

    public function getProfilePictureUrl()
    {
        return $this->image
            ? asset($this->image) // karena langsung di public/
            : asset('adminlte/dist/img/avatar.png');

            //: asset('adminlte/dist/img/user2-160x160');
    }
}
