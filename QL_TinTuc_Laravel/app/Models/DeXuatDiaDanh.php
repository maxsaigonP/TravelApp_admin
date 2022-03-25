<?php

namespace App\Models;

use App\Models\TinhThanh;
use App\Models\User;
use App\Models\HinhAnh;
use App\Models\BaiVietChiaSe;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DeXuatDiaDanh extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $fillable = [
        'tenDiaDanh',
        'moTa',
        'kinhDo',
        'viDo',
        'tinh_thanh_id',
        'user_id',
        'hinhAnh',
        'trangThai',
    ];

    public function tinhthanh()
    {
        return $this->belongsTo(TinhThanh::class, 'tinh_thanh_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function hinhanh()
    {
        return $this->belongsTo(HinhAnh::class, 'id', 'idDiaDanh');
    }

    public function hinhanhs()
    {
        return $this->hasMany(HinhAnh::class, 'idDiaDanh', 'id');
    }

    public function shares()
    {
        return $this->hasMany(BaiVietChiaSe::class, 'idDiaDanh');
    }
}
