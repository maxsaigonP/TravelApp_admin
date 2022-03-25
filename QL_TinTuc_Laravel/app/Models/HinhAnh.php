<?php

namespace App\Models;

use App\Models\DiaDanh;
use App\Models\BaiVietChiaSe;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HinhAnh extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'idDiaDanh',
        'idBaiVietChiaSe',
        'idLoai',
        'hinhAnh',
    ];

    public function diadanh()
    {
        return $this->belongsTo(DiaDanh::class, 'idDiaDanh');
    }

    public function baiviet()
    {
        return $this->belongsTo(BaiVietChiaSe::class, 'idBaiVietChiaSe');
    }
}
