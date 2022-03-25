<?php

namespace App\Http\Controllers;

use App\Models\BaiVietChiaSe;
use App\Models\DanhGia;
use App\Models\DeXuatDiaDanh;
use App\Models\DiaDanh;
use App\Models\TinhThanh;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {

        $lstTaiKhoan = User::count();
        $lstDiaDanh = DiaDanh::count();
        $lstTinhThanh = TinhThanh::count();
        $lstBaiViet = BaiVietChiaSe::count();
        $lstDeXuat = DeXuatDiaDanh::count();
        $diaDanh = DiaDanh::withCount(['shares' => function ($query) {
            $query->whereMonth('created_at', Carbon::now()->month);
        }])->orderBy('shares_count', 'desc')->first();
        return view('dashboard', ['lstTaiKhoan' => $lstTaiKhoan, 'lstDiaDanh' => $lstDiaDanh, 'lstTinhThanh' => $lstTinhThanh, 'lstBaiViet' => $lstBaiViet, 'lstDeXuat' => $lstDeXuat, 'diaDanh' => $diaDanh]);
    }

    public function ThongKeChart()
    {
        $output = "";

        $countLike = DanhGia::whereMonth('created_at', Carbon::now()->month)->where('userLike', '=', 1)->count();
        $countUnLike = DanhGia::whereMonth('created_at', Carbon::now()->month)->where('userUnLike', '=', 1)->count();
        $countView = DanhGia::whereMonth('created_at', Carbon::now()->month)->where('userXem', '=', 1)->count();

        $countLikePrev = DanhGia::whereMonth('created_at', Carbon::now()->month - 1)->where('userLike', '=', 1)->count();
        $countUnLikePrev = DanhGia::whereMonth('created_at', Carbon::now()->month - 1)->where('userUnLike', '=', 1)->count();
        $countViewPrev = DanhGia::whereMonth('created_at', Carbon::now()->month - 1)->where('userXem', '=', 1)->count();

        $count12Thang = [];
        b:
        for ($i = 1; $i <= 12; $i++) {
            $Like = DanhGia::whereMonth('created_at', $i)->where('userLike', '=', 1)->count();
            $UnLike = DanhGia::whereMonth('created_at', $i)->where('userUnLike', '=', 1)->count();
            $View = DanhGia::whereMonth('created_at', $i)->where('userXem', '=', 1)->count();
            $count12Thang[$i - 1] = $Like + $UnLike + $View;

            $output .= "<input type='hidden' id='thang' value='" . $count12Thang[$i - 1] . "' />";
        }
        $output .= "<input type='hidden' id='like' value='" . $countLike . "' />" .
            "<input type='hidden' id='unlike' value='" . $countUnLike . "' />" .

            "<input type='hidden' id='view' value='" . $countView . "' />" .
            "<input type='hidden' id='likePrev' value='" . $countLikePrev . "' />" .
            "<input type='hidden' id='unlikePrev' value='" . $countUnLikePrev . "' />" .

            "<input type='hidden' id='viewPrev' value='" . $countViewPrev . "' />";

        return response()->json($output);
    }
}
