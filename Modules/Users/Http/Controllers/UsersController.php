<?php

namespace Modules\Users\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\MArea;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $data = new \stdClass();
        $data->num = 1;

        $data->waroeng = MArea::with(['m_ws' => function ($query) {
            $query->whereNull('m_w_deleted_at');
        }])
            ->whereNull('m_area_deleted_at')
            ->get();

        $data->lokasi = DB::table('m_w')->select('m_w_id', 'm_w_nama')->get();
        $data->roles = DB::table('roles')->get();

        return view('users::index', compact('data'));
    }

    public function list_users()
    {
        $data = new \stdClass();
        $userRoles = DB::table('model_has_roles')
            ->rightJoin('users', 'users.users_id', 'model_id')
            ->leftJoin('roles', 'role_id', 'roles.id')
            ->leftJoin('m_w', 'waroeng_id', 'm_w_id')
            ->select('users.users_id as users_id', 'users.name as username', 'email', 'm_w_nama', 'roles.name as rolename')
            ->orderBy('waroeng_id', 'asc')
            ->get();

        $userArray = [];

        foreach ($userRoles as $userRole) {
            $userId = $userRole->users_id;
            $roleName = $userRole->rolename;

            if (!isset($userArray[$userId])) {
                $userArray[$userId] = [
                    'users_id' => $userId,
                    'username' => $userRole->username,
                    'email' => $userRole->email,
                    'm_w_nama' => $userRole->m_w_nama,
                    'roles' => [$roleName],
                ];
            } else {
                $userArray[$userId]['roles'][] = $roleName;
            }
        }

        $data->users = array_values($userArray);

        $data2 = [];
        $no = 1;
        foreach ($data->users as $value) {
            $row = [];
            $row[] = $no++;
            $row[] = $value['username'];
            $row[] = $value['email'];
            $row[] = $value['m_w_nama'];
            $row[] = implode(', ', $value['roles']);
            $row[] = '<a id="buttonEdit" class="btn btn-sm btn-warning buttonEdit"
            value="' . $value['users_id'] . '"><i class="fa fa-pencil"></i></a>';
            $data2[] = $row;
        }

        $output = [
            'data' => $data2,
        ];

        return response()->json($output);

    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function action(Request $request)
    {
        $data = $request->waroeng_akses; // mengambil data dari Select2 dalam format JSON dan mengubahnya menjadi array
        $waroeng_akses = implode(',', $data); // menggabungkan data menjadi string dengan delimiter koma

        if ($request->action == 'add') {
            // Kode untuk menambah pengguna baru
            $data = array(
                'users_id' => 1,
                'name' => strtolower($request->name),
                'email' => strtolower($request->email),
                'password' => Hash::make($request->password),
                'waroeng_id' => $request->waroeng_id,
                'waroeng_akses' => '[' . $waroeng_akses . ']',
                'created_by' => Auth::user()->users_id,
                'created_at' => Carbon::now(),
            );
            DB::table('users')->insert($data);
            $user = DB::table('users')->max('users_id');
            User::where('users_id', $user)->first()->assignRole($request->roles);
        } elseif ($request->action == 'edit') {
            // Kode untuk mengedit pengguna
            if (!empty($request->password)) {
                $data = array(
                    'name' => strtolower($request->name),
                    'email' => strtolower($request->email),
                    'password' => Hash::make($request->password),
                    'waroeng_id' => $request->waroeng_id,
                    'waroeng_akses' => '[' . $waroeng_akses . ']',
                    'updated_by' => Auth::user()->users_id,
                    'updated_at' => Carbon::now(),
                    'users_status_sync' => 'send',
                    'users_client_target' => DB::raw('DEFAULT'),
                );
            } else {
                $data = array(
                    'name' => strtolower($request->name),
                    'email' => strtolower($request->email),
                    'waroeng_id' => $request->waroeng_id,
                    'waroeng_akses' => '[' . $waroeng_akses . ']',
                    'updated_by' => Auth::user()->users_id,
                    'updated_at' => Carbon::now(),
                    'users_status_sync' => 'send',
                    'users_client_target' => DB::raw('DEFAULT'),
                );
            }

            // Mengupdate data pengguna
            DB::table('users')->where('users_id', $request->id)->update($data);

            // Mengassign role baru tanpa menghapus data sebelumnya
            $user = User::where('users_id', $request->id)->first();
            $user->syncRoles($request->roles);
        }

        return response()->json($request);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $userRoles = DB::table('model_has_roles')
            ->rightJoin('users', 'users.users_id', 'model_id')
            ->leftJoin('roles', 'role_id', 'roles.id')
            ->leftJoin('m_w', 'waroeng_id', 'm_w_id')
            ->select('users.users_id as users_id', 'users.name as username', 'email', 'm_w_nama', 'roles.name as rolename', 'users.waroeng_akses', 'users.waroeng_id')
            ->where('users.users_id', $id)
            ->get();

        $userData = new \stdClass();

        foreach ($userRoles as $userRole) {
            $userData->users_id = $userRole->users_id;
            $userData->username = $userRole->username;
            $userData->email = $userRole->email;
            $userData->m_w_nama = $userRole->m_w_nama;
            $userData->waroeng_id = $userRole->waroeng_id;
            $userData->waroeng_akses = $userRole->waroeng_akses;

            if (!isset($userData->roles)) {
                $userData->roles = [];
            }

            $userData->roles[] = $userRole->rolename;
        }

        $jsonOutput = json_encode($userData);
        return response()->json($userData, 200);
    }
    public function reset_pass($id)
    {
        DB::table('users')
            ->where('users_id', $id)
            ->update([
                'password' => Hash::make(123456),
                'verified' => null,
                'users_status_sync' => 'send',
                'users_client_target' => DB::raw('DEFAULT'),
            ]);
        return response()->json(['success' => 'success']);
    }
    public function noakses()
    {
        return view('users::no_akses');
    }

    public function profile()
    {
        return view('users::profile');
    }

    public function pass_update(Request $request)
    {
        $user = DB::table('users')
            ->where('email', $request->email)
            ->first();

        if (!$user) {
            // Jika pengguna tidak ditemukan, tampilkan pesan kesalahan
            return redirect()->back()->with('error', 'Email tidak ditemukan.');
        }

        // Lakukan pembaruan kata sandi dan atribut lainnya
        DB::table('users')
            ->where('email', $request->email)
            ->update([
                'password' => Hash::make($request->new_password),
                'users_status_sync' => 'send',
                'users_client_target' => DB::raw('DEFAULT'),
            ]);

        // Set session flash data untuk pesan sukses
        return redirect()->back()->with('success', 'Kata sandi berhasil diubah.');
    }

}
