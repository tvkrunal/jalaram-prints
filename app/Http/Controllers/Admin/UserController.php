<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\IdentificationDocumentsRequest;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Classes\Helper\CommonUtil;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Enums\StatusOption;
use App\Enums\Status;
use App\Enums\RoleType;
use App\Models\Leave;
use App\Models\LeaveType;
use App\Models\Role;
use App\Models\User;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Carbon\Carbon;
use Session;
use Hash;
use DB;

class UserController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            'auth',
            new Middleware('permission:User List', only: ['index', 'show','getData']),
            new Middleware('permission:User Create', only: ['create', 'store']),
            new Middleware('permission:User Edit', only: ['edit', 'update']),
            new Middleware('permission:User Delete', only: ['destroy']),
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('admin.user.index');
    }

    /**
     * Get all user for listing
     *
     * @param Request $request
     */
    public function getData(Request $request)
    {
        $role = (Auth()->user()) ? Auth()->user()->getRoleNames()->first() : null;

        $search = $request->input('search');
        $status = $request->input('status');
        $query = User::query();
        
        
        $users = $query->select('id', 'first_name', 'last_name', 'email', 'is_active', 'profile');

        $users = $users->get();

        return Datatables::of($users)
            ->addIndexColumn()
            ->addColumn('is_active', function ($data) {
                return $data->is_active;
            })
            ->addColumn('user_role', function ($data) {
                return $data->getRoleNames()->first();
            })
            ->editColumn('is_active', function ($data) {
                if ($data->is_active == 1) {
                    return '<div class="badge rounded-pill bg-success text-white actions">Active</div>';
                } else {
                    return '<div class="badge rounded-pill bg-warning text-white actions">Inactive</div>';
                }
            })
            ->editColumn('name', function ($data) {
                return $data->first_name . ' ' . $data->last_name;
            })
            ->addColumn('action', function ($data) {
                $actions = '';
                if (Gate::allows('User List')) {
                    $actions .= '<a href="javascript:;" data-url="' . url('admin/users/' . $data->id) . '" class="btn btn-sm btn-square btn-neutral me-2 modal-popup-view" data-modal-title="Employee Details"><i class="fa fa-eye"></i></a>';
                }
                if (Gate::allows('User Edit')) {
                    $actions .= '<a href="' . url('admin/users/' . $data->id . '/edit') . '" class="btn btn-sm btn-square btn-neutral me-2"><i class="fa fa-pencil-square-o"></i></a>';
                }
                if (Gate::allows('User Delete')) {
                    $actions .= '<a href="javascript:;" data-url="' . url('admin/users/' . $data->id) . '" class="btn btn-sm btn-square btn-neutral text-danger-hover modal-popup-delete" data-modal-delete-text="Are you sure you want to delete this user?"><i class="fa fa-trash-o"></i></a>';
                }
                return $actions;
            })
            ->rawColumns(['action', 'user_role', 'is_active', 'profile'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $activeOrNot = StatusOption::asSelectArray();
        $projectManager = [];
        $teamLeader = [];
        $parentUsers = User::pluck('first_name', 'id');
        $userRoles = Role::pluck('name', 'name');
        return view('admin.user.create_update', compact('activeOrNot', 'projectManager', 'teamLeader', 'userRoles', 'parentUsers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserRequest $request
     *
     * @return Response
     */
    public function store(UserRequest $request)
    {
        $data = $request->all();
        if (request()->has('password')) {
            $data['password'] = Hash::make($data['password']);
        }
        if ($request->hasFile('profile')) {
            $imageName = CommonUtil::uploadFileToFolder($request->file('profile'), 'users');
            $data['profile'] = $imageName;
        }

        $data['is_active'] = $request->is_active ? 1 : 0;
        $user =  User::create($data);
        if ($user) {
            $user->assignRole($data['role']);
            Session::flash('success', 'User has been added successfully');
            return redirect()->route('users.index');
        } else {
            Session::flash('error', 'Unable to add employee');
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     *
     * @return Response
     */
    public function show(User $user)
    {
        $data  = [
            'Name'           =>  $user->full_name,
            'Email'          =>  $user->email,
            'Status'         =>  $user->is_active == 1 ? 'Active' : 'Inactive',
            'Role'           =>  $user->getRoleNames()->first(),
        ];
        return $data;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     *
     * @return Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $activeOrNot = StatusOption::asSelectArray();
        $projectManager = [];
        $teamLeader = [];
        $parentUsers = User::pluck('first_name', 'id');
        $userRoles = Role::pluck('name', 'name');
        return view('admin.user.create_update', compact('user', 'activeOrNot', 'projectManager', 'teamLeader', 'userRoles', 'parentUsers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserRequest $request
     * @param User $user
     *
     * @return Response
     */
    public function update(UserRequest $request, $id)
    {
        $user = User::find($id);
        $data = $request->all();
        $removeUserImage = false;
        if ($request->file('profile')) {
            $imageName = CommonUtil::uploadFileToFolder($request->file('profile'), 'users');
            $data['profile'] = $imageName;
            $removeUserImage = true;
        }
        if ($removeUserImage && !empty($user->profile)) {
            CommonUtil::removeFile($user->profile);
        }

        $data['is_active'] = $request->is_active ? 1 : 0;

        if ($user->update($data)) {
            DB::table('model_has_roles')->where('model_id', $user->id)->delete();
            $user->assignRole($data['role']);
            Session::flash('success', 'User has been updated successfully');
            return redirect()->route('users.index');
        } else {
            Session::flash('error', 'Unable to update employee');
            return redirect()->back();
        }
    }

    /**
     * Delete User
     *
     * @param User $user
     *
     * @return Response
     */
    public function destroy($id)
    {
        $user = User::find($id);

        $user->delete();
    }
}
