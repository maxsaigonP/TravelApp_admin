<?php

namespace App\Http\Controllers;

use App\Models\MonAn;
use App\Http\Requests\StoreMonAnRequest;
use App\Http\Requests\UpdateMonAnRequest;
use App\Models\QuanAn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class MonAnController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected function fixImage(MonAn $hinhAnh)
    {
        if (Storage::disk('public')->exists($hinhAnh->hinhAnh)) {
            $hinhAnh->hinhAnh = $hinhAnh->hinhAnh;
        } else {
            $hinhAnh->hinhAnh = 'images/no-image-available.jpg';
        }
    }
    public function index()
    {
        $lstMonAn = MonAn::with('quanan')->paginate(5);
        foreach ($lstMonAn as $item) {
            $this->fixImage($item);
        }
        return view('monan.index-monan', ['lstMonAn' => $lstMonAn]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $lstQuanAn = QuanAn::all();
        $lstMonAn = MonAn::all();
        return view('monan.create-monan', ['lstQuanAn' => $lstQuanAn, 'lstMonAn' => $lstMonAn]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreMonAnRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMonAnRequest $request)
    {
        $request->validate([
            'tenMon' => 'required',
            'hinhAnh' => 'required',
        ], [
            'tenMon.required' => "Tên món ăn không được bỏ trống",
            'hinhAnh.required' => 'Bắt buộc chọn hình ảnh'
        ]);

        $monAn = new MonAn();
        $monAn->fill([
            'quan_an_id' => $request->input('quan_an_id'),
            'tenMon' => $request->input('tenMon'),
            'hinhAnh' => '',

        ]);
        $monAn->save();

        if ($request->hasFile('hinhAnh')) {
            $monAn->hinhAnh = Storage::disk('public')->put('images', $request->file('hinhAnh'));
        }
        $monAn->save();

        return Redirect::route('monAn.index', ['monAn' => $monAn]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MonAn  $monAn
     * @return \Illuminate\Http\Response
     */
    public function show(MonAn $monAn)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MonAn  $monAn
     * @return \Illuminate\Http\Response
     */
    public function edit(MonAn $monAn)
    {
        $lstQuanAn = QuanAn::all();
        $lstMonAn = MonAn::all();
        return view('monan.edit-monan', ['monAn' => $monAn, 'lstMonAn' => $lstMonAn, 'lstQuanAn' => $lstQuanAn]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMonAnRequest  $request
     * @param  \App\Models\MonAn  $monAn
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMonAnRequest $request, MonAn $monAn)
    {
        $request->validate([
            'tenMon' => 'required',
        ], [
            'tenMon.required' => "Tên món ăn không được bỏ trống",
        ]);

        if ($request->hasFile('hinhAnh')) {
            Storage::disk('public')->delete($monAn->hinhAnh);
            $monAn->hinhAnh = Storage::disk('public')->put('images', $request->file('hinhAnh'));
        }
        $monAn->save();

        $monAn->fill([
            'quan_an_id' => $request->input('quan_an_id'),
            'tenMon' => $request->input('tenMon'),

        ]);
        $monAn->save();
        return Redirect::route('monAn.index', ['monAn' => $monAn]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MonAn  $monAn
     * @return \Illuminate\Http\Response
     */
    public function destroy(MonAn $monAn)
    {
        Storage::disk('public')->delete($monAn->hinhAnh);
        $monAn->delete();
        return Redirect::route('monAn.index');
    }

    public function timKiemMonAn(Request $request)
    {
        $output = "";
        $lstMonAn = MonAn::paginate(5);
        if ($request->input('txtSearch') != "") {
            $lstMonAn = MonAn::where('tenMon', 'LIKE', '%' . $request->input('txtSearch') . '%')->paginate(5);
        }
        foreach ($lstMonAn as $item) {
            $this->fixImage($item);
            $output .= '<tr>
                                <td>' . $item->id . '</td>                                
                               <td>' . $item->quanan->tenQuan . '</td>
                                <td>
                                       ' . $item->tenMon . '
                                </td>             
                                <td>
                                <img width="150" src="' . ($item->hinhAnh != null ? asset($item->hinhAnh) : asset("/images/no-image-available.jpg"))
                . '"  />
                                </td>
                                <td>
                                    <label class="badge badge-primary">
                                            <a class="d-block text-light" href="' . route('monAn.edit', ['monAn' => $item]) . '"> Sửa</a>
                                    </label>
                                    <label>
                                        <form method="post" action="' . route('monAn.destroy', ['monAn' => $item]) . '">
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
