<?php

namespace App\Http\Controllers;

use DataTables;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Models\Settings\Group;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('users');
    }

    public function getUserList(Request $request)
    {
        $data = User::get();

        return Datatables::of($data)
                ->addColumn('roles', function ($data) {
                    $roles = $data->getRoleNames()->toArray();
                    $badge = '';
                    if ($roles) {
                        $badge = implode(' , ', $roles);
                    }

                    return $badge;
                })
                ->addColumn('permissions', function ($data) {
                    $roles = $data->getAllPermissions();
                    $badges = '';
                    foreach ($roles as $key => $role) {
                        $badges .= '<span class="badge badge-dark m-1">'.$role->name.'</span>';
                    }

                    return $badges;
                })
                ->addColumn('action', function ($data) {
                    if ($data->name == 'Super Admin') {
                        return '';
                    }
                    if (Auth::user()->can('manage_user')) {

                        $edit = '<a class="menu-item mr-5 edit" id="edit" href="' . url('user/'.$data->id) . ' " title="Edit"><i class="ik ik-edit f-16 text-green"></i></a>';

                        $delete = '<a class="menu-item" id="delete" href="' . url('user/delete/'.$data->id) . ' " title="Delete"><i class="ik ik-trash-2 f-16 text-red"></i></a>';

                        return $edit . $delete;

                    } else {
                        return '';
                    }
                })
                ->rawColumns(['roles','permissions','action'])
                ->make(true);
    }

    public function create()
    {
        try {
            $roles = Role::pluck('name', 'id');
            $groups = Group::where('status', 1)->get();
            $users = User::all();
            return view('create-user', compact('roles','groups','users'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            // store user information
            $user = new User;
            $user->name = $request->name;
            $user->user_id = $request->user_id;
            $user->group_id = $request->group_id;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();

            // $user = User::create([
            //             'name' => $request->name,
            //             'group_id' => $request->group_id,
            //             'email' => $request->email,
            //             'password' => Hash::make($request->password),
            //         ]);

            // assign new role to the user
            $user->syncRoles($request->role);

            if ($user) {
                return redirect('users')->with('success', 'New user created!');
            } else {
                return redirect('users')->with('error', 'Failed to create new user! Try again.');
            }
        } catch (\Exception $e) {
            $bug = $e->getMessage();

            return redirect()->back()->with('error', $bug);
        }
    }

    public function edit($id)
    {
        try {
            $user = User::with('roles', 'permissions')->find($id);
            $groups = Group::where('status', 1)->get();
            $users = User::all();

            if ($user) {
                $user_role = $user->roles->first();
                $roles = Role::pluck('name', 'id');

                return view('user-edit', compact('user', 'user_role', 'roles','groups','users'));
            } else {
                return redirect('404');
            }
        } catch (\Exception $e) {
            $bug = $e->getMessage();

            return redirect()->back()->with('error', $bug);
        }
    }

    public function update(Request $request)
    {

        // update user info
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'name' => 'required | string ',
            'email' => 'required | email',
            'role' => 'required',
        ]);

        // check validation for password match
        if (isset($request->password)) {
            $validator = Validator::make($request->all(), [
                'password' => 'required | confirmed',
            ]);
        }

        if ($validator->fails()) {
            return redirect()->back()->withInput()->with('error', $validator->messages()->first());
        }

        try {
            $user = User::find($request->id);
            // $update = $user->update([
            //     'name' => $request->name,
            //     'group_id' => $request->group_id,
            //     'email' => $request->email,
            // ]);
            $user->name = $request->name;
            $user->user_id = $request->user_id;
            $user->group_id = $request->group_id;
            $user->email = $request->email;
            $user->update();

            // update password if user input a new password
            if (isset($request->password)) {
                $update = $user->update([
                    'password' => Hash::make($request->password),
                ]);
            }

            // sync user role
            // $user->syncRoles($request->role);

            return redirect('users')->with('success', 'User information updated succesfully!');
        } catch (\Exception $e) {
            $bug = $e->getMessage();

            return redirect()->back()->with('error', $bug);
        }
    }


    public function delete($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->delete();

            return redirect('users')->with('success', 'User removed!');
        } else {
            return redirect('users')->with('error', 'User not found');
        }
    }
}
