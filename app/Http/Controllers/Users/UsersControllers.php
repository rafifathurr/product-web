<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\role\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;

class UsersControllers extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    // Index View and Scope Data
    public function index()
    {
        return view('users.index', [
            "title" => "List User",
            "users" => User::where('deleted_at', null)->get()
        ]);
    }

    // Store Function to Database
    public function store(Request $request)
    {
        $exec = User::where('email', $request->email)->first();
        $exec_2 = User::where('phone', $request->phone)->first();

        if ($exec || $exec_2) {
            return back()->with(['gagal' => 'Email, atau No. Telepon Sudah Tersedia!']);
        } else {

            DB::beginTransaction();
            $default_password = bcrypt('user');

            $user_result = User::lockforUpdate()
                ->create([
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'password' => $default_password,
                    'name' => $request->name
                ]);

            if ($user_result) {
                DB::commit();
                return redirect()->route('admin.users.index')->with(['success' => 'User Berhasil Dibuat!']);
            } else {
                DB::rollBack();
                return back()->with(['gagal' => 'User Gagal Dibuat!']);
            }
        }
    }

    // Show Function
    public function show($id)
    {
        $user_data = User::find($id);
        return $user_data->toArray();
    }


    // Update Function to Database
    public function update(Request $request)
    {

        DB::beginTransaction();

        $user_result = User::where('id', $request->id)
            ->update([
                'email' => $request->email,
                'phone' => $request->phone,
                'name' => $request->name
            ]);

        if ($user_result) {
            DB::commit();
            return redirect()->route('admin.users.index')->with(['success' => 'User Berhasil Diubah!']);
        } else {
            DB::rollBack();
            return back()->with(['gagal' => 'User Gagal Diubah!']);
        }
    }

    // Delete Data Function
    public function delete(Request $request)
    {
        $datenow = date('Y-m-d H:i:s');

        DB::beginTransaction();
        $exec = User::where('id', $request->id)->update([
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
}
