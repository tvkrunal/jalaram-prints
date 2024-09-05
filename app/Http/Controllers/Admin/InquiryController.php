<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\IdentificationDocumentsRequest;
use App\Http\Requests\PreviousExperienceRequest;
use App\Http\Requests\EmployeeContactRequest;
use App\Http\Requests\EmployeeRelativeRequest;
use App\Http\Requests\EmployeeDocumentRequest;
use App\Http\Requests\BankingDocumentRequest;
use App\Http\Requests\EmployeeJobRequest;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Models\EmployeeJobDetail;
use App\Models\EmployeeDocument;
use App\Models\EmployeeRelative;
use App\Classes\Helper\CommonUtil;
use App\Http\Requests\UserRequest;
use App\Http\Requests\InquiryRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Enums\StatusOption;
use App\Enums\Status;
use App\Enums\RoleType;
use App\Models\Leave;
use App\Models\LeaveType;
use App\Models\Role;
use App\Models\Inquiry;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Carbon\Carbon;
use Session;
use Hash;
use DB;

class InquiryController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            'auth',
            new Middleware('permission:Inquiry List', only: ['index', 'show','getData']),
            new Middleware('permission:Inquiry Create', only: ['create', 'store']),
            new Middleware('permission:Inquiry Edit', only: ['edit', 'update']),
            new Middleware('permission:Inquiry Delete', only: ['destroy']),
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('admin.inquiry.index');
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
        $query = Inquiry::query();
        
        
        $users = $query->select('id', 'customer_first_name', 'customer_last_name', 'email');

        if ($role == 'HR') {
            $users->whereDoesntHave('roles', function ($query) {
                $query->where('name', 'Administrator');
            });
        }
        $users = $users->get();

        return Datatables::of($users)
            ->addIndexColumn()
            ->editColumn('name', function ($data) {
                return $data->customer_first_name . ' ' . $data->customer_first_name;
            })
            ->addColumn('action', function ($data) {
                $actions = '';
                if (Gate::allows('User List')) {
                    $actions .= '<a href="javascript:;" data-url="' . url('admin/employees/' . $data->id) . '" class="btn btn-sm btn-square btn-neutral me-2 modal-popup-view" data-modal-title="Employee Details"><i class="bi bi-eye"></i></a>';
                }
                if (Gate::allows('User Edit')) {
                    $actions .= '<a href="' . url('admin/employees/' . $data->id . '/edit') . '" class="btn btn-sm btn-square btn-neutral me-2"><i class="bi bi-pencil-square"></i></a>';
                }
                if (Gate::allows('User Delete')) {
                    $actions .= '<a href="javascript:;" data-url="' . url('admin/employees/' . $data->id) . '" class="btn btn-sm btn-square btn-neutral text-danger-hover modal-popup-delete" data-modal-delete-text="Are you sure you want to delete this user?"><i class="bi bi-trash3-fill"></i></a>';
                }
                if (Gate::allows('Leave History List')) {
                    $actions .= '<a href="' . route('user.leaves.history', $data->id)  . '" class="btn btn-sm btn-square btn-neutral ms-2" ><i class="bi bi-clock-history"></i></a>';
                }
                return $actions;
            })
            ->rawColumns(['action'])
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
        $parentUsers = Inquiry::pluck('customer_first_name', 'id');
        $userRoles = Role::pluck('name', 'name');
        return view('admin.inquiry.create_update', compact('activeOrNot', 'projectManager', 'teamLeader', 'userRoles', 'parentUsers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param InquiryRequest $request
     *
     * @return Response
     */
    public function store(InquiryRequest $request)
    {
        $data = $request->all();
        $trashedUser = Inquiry::onlyTrashed()->where('email', $data['email'])->first();
        if (!empty($trashedUser)) {
            Session::flash('error', 'This user is already exist with deleted user, please contact your administrator');
            return redirect()->back();
        }
        if (request()->has('password')) {
            $data['password'] = Hash::make($data['password']);
        }
        if ($request->hasFile('profile')) {
            $imageName = CommonUtil::uploadFileToFolder($request->file('profile'), 'users');
            $data['profile'] = $imageName;
        }

        $data['is_active'] = $request->is_active ? 1 : 0;
        $user =  Inquiry::create($data);
        if ($user) {
            if (isset($data['parent_user_ids']) && !empty($data['parent_user_ids'])) {
                $user->parents()->sync($data['parent_user_ids']);
            } else {
                $user->parents()->sync([]);
            }

            $user->assignRole($data['role']);
            Session::flash('success', 'Employee has been added successfully');
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
    public function show($id)
    {
        $query = Inquiry::all();

        return Datatables::of($query)
            ->addIndexColumn()
            ->rawColumns(['action'])

            ->make(true);
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
        $user = Inquiry::find($id);
        $activeOrNot = StatusOption::asSelectArray();
        $projectManager = [];
        $teamLeader = [];
        $parentUsers = Inquiry::pluck('first_name', 'id');
        $userRoles = Role::pluck('name', 'name');
        return view('admin.inquiry.create_update', compact('user', 'activeOrNot', 'projectManager', 'teamLeader', 'userRoles', 'parentUsers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param InquiryRequest $request
     * @param User $user
     *
     * @return Response
     */
    public function update(InquiryRequest $request, $id)
    {
        $user = Inquiry::find($id);
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
            if (isset($data['parent_user_ids']) && !empty($data['parent_user_ids'])) {
                $user->parents()->sync($data['parent_user_ids']);
            } else {
                $user->parents()->sync([]);
            }
            DB::table('model_has_roles')->where('model_id', $user->id)->delete();
            $user->assignRole($data['role']);
            Session::flash('success', 'Employee has been updated successfully');
            return redirect()->route('inquiry.index');
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
        $user = Inquiry::find($id);
        $associatedProjectsCount = $user->projects()->count();

        if ($associatedProjectsCount > 0) {
            return response()->json(['success' => false], 200);
        }

        if (!empty($user->profile)) {
            CommonUtil::removeFile($user->profile);
        }

        $user->leaves()->delete();
        $user->projectHours()->delete();
        $user->projectMembers()->detach();
        $user->delete();
    }
}
