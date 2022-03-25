<?php

namespace App\Http\Controllers;

use App\Models\QuanAn;
use App\Http\Requests\StoreQuanAnRequest;
use App\Http\Requests\UpdateQuanAnRequest;
use App\Models\DiaDanh;
use App\Models\MonAn;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class QuanAnController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected function fixImage(QuanAn $hinhAnh)
    {
        if (Storage::disk('public')->exists($hinhAnh->hinhAnh)) {
            $hinhAnh->hinhAnh = $hinhAnh->hinhAnh;
        } else {
            $hinhAnh->hinhAnh = 'images/no-image-available.jpg';
        }
    }
    protected function fixImageMonAn(MonAn $hinhAnh)
    {
        if (Storage::disk('public')->exists($hinhAnh->hinhAnh)) {
            $hinhAnh->hinhAnh = $hinhAnh->hinhAnh;
        } else {
            $hinhAnh->hinhAnh = 'images/no-image-available.jpg';
        }
    }
    public function index()
    {
        $lstQuanAn = QuanAn::paginate(5);
        foreach ($lstQuanAn as $item) {
            $this->fixImage($item);
        }
        return view('quanan.index-quanan', ['lstQuanAn' => $lstQuanAn]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $lstDiaDanh = DiaDanh::all();
        return view('quanan.create-quanan', ["lstDiaDanh" => $lstDiaDanh]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreQuanAnRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreQuanAnRequest $request)
    {
        $request->validate([
            'tenQuan' => 'required',
            'moTa' => 'required',
            'diaChi' => 'required',
            'soDienThoai' => 'required',
            'hinhAnh' => 'required'
        ], [
            'tenQuan.required' => 'Tên quán không được bỏ trống',
            'moTa.required' => 'Mô tả không được bỏ trống',
            'diaChi.required' => 'Địa chỉ không được bỏ trống',
            'soDienThoai.required' => 'Số điện thoại không được bỏ trống',
            'hinhAnh.required' => "Hình ảnh không được bỏ trống"
        ]);


        $quanAn = new QuanAn();
        $quanAn->fill([
            'dia_danh_id' => $request->input('dia_danh_id'),
            'tenQuan' => $request->input('tenQuan'),
            'moTa' => $request->input('moTa'),
            'diaChi' => $request->input('diaChi'),
            'sdt' => $request->input('soDienThoai'),
            'thoiGianHoatDong' => $request->input('thoiGianHoatDong'),
            'hinhAnh' => '',

        ]);
        $quanAn->save();

        if ($request->hasFile('hinhAnh')) {
            $quanAn->hinhAnh = Storage::disk('public')->put('images', $request->file('hinhAnh'));
        }
        $quanAn->save();
        return Redirect::route('quanAn.index', ['quanAn' => $quanAn]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\QuanAn  $quanAn
     * @return \Illuminate\Http\Response
     */
    public function show(QuanAn $quanAn)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\QuanAn  $quanAn
     * @return \Illuminate\Http\Response
     */
    public function edit(QuanAn $quanAn)
    {
        $lstQuanAn = QuanAn::all();
        $lstDiaDanh = DiaDanh::all();
        return view('quanan.edit-quanan', ['quanAn' => $quanAn, 'lstQuanAn' => $lstQuanAn, 'lstDiaDanh' => $lstDiaDanh]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateQuanAnRequest  $request
     * @param  \App\Models\QuanAn  $quanAn
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateQuanAnRequest $request, QuanAn $quanAn)
    {
        $request->validate([
            'tenQuan' => 'required',
            'moTa' => 'required',
            'diaChi' => 'required',
            'soDienThoai' => 'required',
        ], [
            'tenQuan.required' => "Tên quán ăn không được bỏ trống",
            'moTa.required' => 'Mô tả không được bỏ trống',
            'diaChi.required' => 'Địa không được bỏ trống',
            'soDienThoai.required' => 'SĐT không được bỏ trống',
        ]);

        if ($request->hasFile('hinhAnh')) {
            Storage::disk('public')->delete($quanAn->hinhAnh);
            $quanAn->hinhAnh = Storage::disk('public')->put('images', $request->file('hinhAnh'));
        }
        $quanAn->save();


        $quanAn->fill([
            'dia_danh_id' => $request->input('dia_danh_id'),
            'tenQuan' => $request->input('tenQuan'),
            'moTa' => $request->input('moTa'),
            'diaChi' => $request->input('diaChi'),
            'sdt' => $request->input('soDienThoai'),
            'thoiGianHoatDong' => $request->input('thoiGianHoatDong'),
        ]);
        $quanAn->save();
        return Redirect::route('quanAn.index', ['quanAn' => $quanAn]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\QuanAn  $quanAn
     * @return \Illuminate\Http\Response
     */
    public function destroy(QuanAn $quanAn)
    {
        Storage::disk('public')->delete($quanAn->hinhAnh);
        $quanAn->delete();
        return Redirect::route('quanAn.index');
    }

    public function timKiemQuanAn(Request $request)
    {
        $output = "";
        $lstQuanAn = QuanAn::with('diadanh')->paginate(5);
        if ($request->input('txtSearch') != "") {
            $lstQuanAn = QuanAn::where('tenQuan', 'LIKE', '%' . $request->input('txtSearch') . '%')->orWhere('moTa', 'LIKE', '%' . $request->input('txtSearch') . '%')->orWhere('diaChi', 'LIKE', '%' . $request->input('txtSearch') . '%')->with('diadanh')->paginate(5);
        }
        foreach ($lstQuanAn as $item) {
            $this->fixImage($item);
            $output .= '<tr>
                                <td>' . $item->id . '</td>                                
                               <td>' . $item->diadanh->tenDiaDanh . '</td>
                                <td>
                                       ' . $item->tenQuan . '
                                </td>             
                                               
                                 <td>
                                        ' . $item->moTa . '
                                </td>  
                                <td>
                                        ' . $item->diaChi . '
                                </td>  
                                <td>
                                        ' . $item->sdt . '
                                </td>  
                                <td>
                                        ' . $item->thoiGianHoatDong . '
                                </td>         
                                <td>
                                <img width="150" src="' . ($item->hinhAnh != null ? asset($item->hinhAnh) : asset("/images/no-image-available.jpg"))
                . '"  />
                                </td>        
                                <td>
                                    <label class="badge badge-primary">
                                            <a class="d-block text-light" href="' . route('quanAn.edit', ['quanAn' => $item]) . '"> Sửa</a>
                                    </label>
                                    <label>
                                        <form method="post" action="' . route('quanAn.destroy', ['quanAn' => $item]) . '">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="' . csrf_token() . '">
                                            <button style="outline: none; border: none" class="badge badge-danger"
                                                type="submit">Xoá</button>
                                        </form>
                                    </label>
                                </td>

                            </tr>';
        }
        return response()->json($output);
    }
}
