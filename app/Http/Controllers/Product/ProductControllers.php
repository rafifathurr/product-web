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
                    return redirect()->route('admin.users.index')->with(['success' => 'Produk Berhasil Dibuat!']);
                } else {
                    DB::rollBack();
                    return back()->with(['gagal' => 'Produk Gagal Diperbarui!']);
                }
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

    // Edit Data View by id
    public function edit($id)
    {
        $data['title'] = "Edit Products";
        $data['disabled_'] = '';
        $data['url'] = 'update';
        $data['products'] = Product::where('id', $id)->first();
        $data['categories'] = Category::all();
        return view('product.create', $data);
    }

    // Update Function to Database
    public function update(Request $req)
    {
        date_default_timezone_set("Asia/Bangkok");
        $datenow = date('Y-m-d H:i:s');
        $product_pay = Product::where('id', $req->id)->update([
            'product_name' => $req->name,
            'category_id' => $req->category,
            'price' => $req->price,
            'desc' => $req->desc,
            'updated_at' => $datenow,
            'updated_by' => Auth::user()->id
        ]);

        $destination = 'Uploads/Product/';
        if ($req->hasFile('uploads')) {
            $file = $req->file('uploads');
            $name_file = time() . '_' . $req->file('uploads')->getClientOriginalName();
            Storage::disk('Uploads')->putFileAs($destination, $file, $name_file);
            Product::where('id', $req->id)->update(['upload' => $name_file]);
        }

        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.product.index')->with(['success' => 'Data successfully updated!']);
        } else {
            return redirect()->route('user.product.index')->with(['success' => 'Data successfully updated!']);
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
