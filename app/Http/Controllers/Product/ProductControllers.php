<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\product\Product;
use App\Models\category\Category;
use Illuminate\Support\Facades\Storage;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Session;

class ProductControllers extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    // Index View and Scope Data
    public function index()
    {
        return view('product.index', [
            "title" => "List Products",
            "products" => Product::where('deleted_at', null)->get()
        ]);
    }

    // Store Function to Database
    public function store(Request $request)
    {

        DB::beginTransaction();
        $product_result = Product::lockforUpdate()
            ->create([
                'name' => $request->name,
                'price' => $request->price,
            ]);

        if ($product_result) {
            DB::commit();

            $destination = 'Uploads/Product/';
            if ($request->hasFile('picture')) {
                $file = $request->file('picture');
                $name_file = time() . '_' . $request->file('picture')->getClientOriginalName();
                Storage::disk('Uploads')->putFileAs($destination, $file, $name_file);
                DB::beginTransaction();
                $product_update = Product::where('id', $product_result->id)->update(['picture' => $name_file]);

                if ($product_update) {
                    DB::commit();
                    return redirect()->route('admin.product.index')->with(['success' => 'Produk Berhasil Dibuat!']);
                } else {
                    DB::rollBack();
                    return back()->with(['gagal' => 'Produk Gagal Dibuat!']);
                }
            } else {
                return redirect()->route('admin.product.index')->with(['success' => 'Produk Berhasil Dibuat!']);
            }
        } else {
            DB::rollBack();
            return back()->with(['gagal' => 'Produk Gagal Dibuat!']);
        }
    }

    // Detail Data View by id
    public function show($id)
    {
        $product_data = Product::find($id);
        return $product_data->toArray();
    }

    // Update Function to Database
    public function update(Request $request)
    {
        DB::beginTransaction();
        $product_result = Product::where('id', $request->id)->update([
            'name' => $request->name,
            'price' => $request->price,
        ]);

        if ($product_result) {
            DB::commit();

            $destination = 'Uploads/Product/';
            if ($request->hasFile('picture')) {
                $file = $request->file('picture');
                $name_file = time() . '_' . $request->file('picture')->getClientOriginalName();
                Storage::disk('Uploads')->putFileAs($destination, $file, $name_file);
                DB::beginTransaction();
                $product_update = Product::where('id', $request->id)->update(['picture' => $name_file]);

                if ($product_update) {
                    DB::commit();
                    return redirect()->route('admin.product.index')->with(['success' => 'Produk Berhasil Diperbarui!']);
                } else {
                    DB::rollBack();
                    return back()->with(['gagal' => 'Produk Gagal Diperbarui!']);
                }
            } else {
                return redirect()->route('admin.product.index')->with(['success' => 'Produk Berhasil Dibuat!']);
            }
        } else {
            DB::rollBack();
            return back()->with(['gagal' => 'Produk Gagal Diperbarui!']);
        }
    }

    // Delete Data Function
    public function delete(Request $request)
    {
        $datenow = date('Y-m-d H:i:s');

        DB::beginTransaction();
        $exec = Product::where('id', $request->id)->update([
            'status' => 0,
            'deleted_at' => $datenow,
            'updated_at' => $datenow,
        ]);

        if ($exec) {
            DB::commit();
            Session::flash('success', 'User Berhasil Dihapus!');
        } else {
            DB::rollBack();
            Session::flash('gagal', 'User Gagal Dihapus!');
        }
    }

    public function detailproduct(Request $req)
    {
        $data = Product::with('category')->where("id", $req->id_prod)->first();
        return $data;
    }
}
