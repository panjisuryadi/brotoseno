<?php

namespace Modules\User\Http\Controllers;

use Modules\User\DataTables\UsersDataTable;
use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Modules\Upload\Entities\Upload;
use Modules\UserCabang\Models\UserCabang;

class UsersController extends Controller
{
    public function index(UsersDataTable $dataTable) {
        abort_if(Gate::denies('access_user_management'), 403);

        return $dataTable->render('user::users.index');
    }


    public function create() {
        abort_if(Gate::denies('access_user_management'), 403);

        return view('user::users.create');
    }


    public function store(Request $request) {
        abort_if(Gate::denies('access_user_management'), 403);

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|max:255|confirmed'
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'is_active' => $request->is_active,
            'kode_user' => $request->kode_user
        ]);

       UserCabang::create([
            'user_id'         => $user->id,
            'cabang_id'       => $request->cabang_id
             ]);

        $user->assignRole($request->role);

        if ($request->has('image')) {
            $tempFile = Upload::where('folder', $request->image)->first();

            if ($tempFile) {
                $user->addMedia(Storage::path('public/temp/' . $request->image . '/' . $tempFile->filename))->toMediaCollection('avatars');

                Storage::deleteDirectory('public/temp/' . $request->image);
                $tempFile->delete();
            }
        }

        toast("User Created & Assigned '$request->role' Role!", 'success');

        return redirect()->route('users.index');
    }


    public function edit(User $user) {
        abort_if(Gate::denies('access_user_management'), 403);

        return view('user::users.edit', compact('user'));
    }


    public function update(Request $request, User $user) {
        abort_if(Gate::denies('access_user_management'), 403);

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|max:255|unique:users,email,'.$user->id,
            'kode_user'    => 'required|unique:users,kode_user,'.$user->id,
        ]);

        $user->update([
            'name'     => $request->name,
            'email'    => $request->email,
            'kode_user'    => $request->kode_user,
            'is_active' => $request->is_active
        ]);

        $user->syncRoles($request->role);

        if ($request->has('image')) {
            $tempFile = Upload::where('folder', $request->image)->first();
             //dd($tempFile);
            if ($user->getFirstMedia('avatars')) {
                $user->getFirstMedia('avatars')->delete();
            }

            if ($tempFile) {
                $user->addMedia(Storage::path('public/temp/' . $request->image . '/' . $tempFile->filename))->toMediaCollection('avatars');

                Storage::deleteDirectory('public/temp/' . $request->image);
                $tempFile->delete();
            }
        }

        $cabangs = UserCabang::where('user_id',$user->id)->first();
        if (empty($cabangs)) {
              UserCabang::create([
                'user_id'         => $user->id,
                'cabang_id'       => $request->cabang_id
                 ]);
        }else{
        $cabangs->update([
                        'cabang_id' => $request->cabang_id
                       ]);
                   }


        toast("User Updated & Assigned '$request->role' Role!", 'info');

        return redirect()->route('users.index');
    }


      public function codeGenerate()
        {
             $codeNumber =   User::generateCode();
             $existingCode = User::where('kode_user', $codeNumber)->exists();
             if ($existingCode) {
               return response()->json(['code' => 'Kode Eksis']);
             }
             $existingCode = true;
              return response()->json(['code' => $codeNumber]);
        }


    public function destroy(User $user) {
        abort_if(Gate::denies('access_user_management'), 403);
        $user->delete();
        toast('User Deleted!', 'warning');
        return redirect()->route('users.index');
    }
}
