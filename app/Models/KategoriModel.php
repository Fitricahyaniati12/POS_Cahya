<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\barang;

class KategoriModel extends Model
{
    use HasFactory;
    protected $table = 'm_kategori';
    protected $primaryKey = 'kategori_id';
    
    protected $fillable = ['nama_kategori', 'deskripsi'];

    public function barang(): HasMany
    {
        return $this->hasMany(BarangModel::class, 'barang_id', 'barang_id');
    }

}