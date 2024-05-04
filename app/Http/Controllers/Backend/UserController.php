<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

use App\Services\Interfaces\UserServiceInterface as UserService;
use App\Repositories\Interfaces\ProvinceRepositoryInterface as ProvinceService;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UploadImageRequest;
use App\Http\Requests\UpdateUserRequest;



use Illuminate\Support\Facades\Config;


class UserController extends Controller
{

    protected $userService;
    protected $provinceReponsitory;
    public function __construct(
        UserService $userService,
        ProvinceService $provinceReponsitory

    ) {
        $this->userService = $userService;
        $this->provinceReponsitory = $provinceReponsitory;
    }

    public function index()
    {
        $template = 'backend.user.index';
        // dd($config['seo']);
        // $users = User::leftJoin('provinces', 'users.province_id', '=', 'provinces.code')
        //     ->leftJoin('districts', 'users.district_id', '=', 'districts.code')
        //     ->leftJoin('wards', 'users.ward_id', '=', 'wards.code')
        //     ->select('users.*', 'provinces.name as province_name', 'districts.name as district_name', 'wards.name as ward_name')
        //     ->paginate(10);
        $users = User::with(['province', 'district', 'ward', 'role'])
            ->select('users.*')
            ->paginate(10);
        //dd($users);
        // foreach ($users as $user) {
        //     echo "Tên: " . $user->username;
        //     if ($user->role) {
        //         echo "Vai trò: " . $user->role->name;
        //     } else {
        //         echo "Vai trò: Không có";
        //     }
        // }
        return view('backend.dashboard.layout', compact(
            'template',
            'users'
        ));
    }

    public function create(Request $request)
    {
        $template = 'backend.user.create';
        $roles = Role::all();
        $provinces = $this->provinceReponsitory->all($request);
        return view('backend.dashboard.layout', compact(
            'provinces',
            'roles',
            'template'
        ));
    }

    public function store(StoreUserRequest $request)
    {
        if ($this->userService->create($request)) {
            session()->push('notifications', ['message' => 'Thêm người dùng thành công', 'type' => 'success']);
            return redirect()->route('user.index')->with('success', 'Thêm mới người dùng thành công');
        }
        // DB::beginTransaction();
        // try {

        //     $payload = $request->except('_token', 're_password');
        //     $carbonDate = Carbon::createFromFormat('Y-m-d', $payload['birthday']);
        //     $payload['birthday'] = $carbonDate->format('Y-m-d H:i:s');
        //     $payload['password'] = Hash::make($payload['password']);
        //     // dd($payload);
        //     $user = User::create($payload);
        //     DB::commit();
        //     return redirect()->route('user.index')->with('success', 'Thêm mới người dùng thành công');
        // } catch (\Exception $e) {
        //     DB::rollBack();
        //     echo $e->getMessage();
        //     return redirect()->route('user.index')->with('error', 'Thêm mới người dùng không thành công, Hãy thủ lại !!');
        // }
    }

    public function edit(Request $request, $id)
    {
        $template = 'backend.user.edit';
        $provinces = $this->provinceReponsitory->all($request);
        $user = User::leftJoin('provinces', 'users.province_id', '=', 'provinces.code')
            ->leftJoin('districts', 'users.district_id', '=', 'districts.code')
            ->leftJoin('wards', 'users.ward_id', '=', 'wards.code')
            ->leftJoin('roles', 'users.user_role', '=', 'roles.id')
            ->select('users.*', 'roles.name as role_name', 'provinces.name as province_name', 'districts.name as district_name', 'wards.name as ward_name')
            ->where('users.id', $id)
            ->firstOrFail();
        $user->birthday = date('Y-m-d', strtotime($user->birthday));
        return view('backend.dashboard.layout', compact(
            'template',
            'provinces',
            'user'
        ));
    }

    public function updateUser(UpdateUserRequest $request, $id)
    {
        $payload = $request->except('_token', '_method');
        $carbonDate = Carbon::createFromFormat('Y-m-d', $payload['birthday']);
        $payload['birthday'] = $carbonDate->format('Y-m-d H:i:s');

        $user = User::findOrFail($id);
        $user->update($payload);
        session()->push('notifications', ['message' => 'Cập nhật người dùng thành công : ' . $user->username . ' ', 'type' => 'success']);
        return redirect()->route('user.edit', $user->id)->with('success', 'Cập nhật người dùng thành công');
    }

    public function updateAvatar(UploadImageRequest $request, $id)
    {
        // Tìm người dùng theo ID
        $user = User::find($id);

        if ($user && auth()->check()) {
            $image = $request->file('image');
            if ($image) {
                $path = $image->store('public/avatars');
                $fileName = basename($path);
                // update ảnh vào db
                $user->update(['image' => $fileName]);
                session()->push('notifications', ['message' => 'Cập nhật ảnh đại diện thành công : ' . $user->username . ' ', 'type' => 'success']);
                return back()->with('success', 'Cập nhật ảnh đại diện thành công');
            }
        }
        session()->push('notifications', ['message' => 'Cập nhật ảnh đại diện không thành công : ' . $user->username . ' ', 'type' => 'error']);
        return back()->with('error', 'Cập nhật ảnh đại diện không thành công');
    }

    public function deleteUser($id)
    {
        // echo 1;
        // die();
        $user = User::findOrFail($id);
        // Xóa người dùng
        $user->delete();
        session()->push('notifications', ['message' => 'Người dùng đã được xóa thành công : ' . $user->username . ' ', 'type' => 'success']);
        return redirect()->route('user.index')->with('success', 'Người dùng đã được xóa thành công');
    }
}
