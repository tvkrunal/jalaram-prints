<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Requests\CustomerRequest;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Gate;
use App\Enums\StatusOption;
use App\Enums\Status;
use Illuminate\Support\Facades\Auth;
use Session;

class CustomerController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            'auth',
            new Middleware('permission:Customer List', only: ['index', 'show','getData']),
            new Middleware('permission:Customer Create', only: ['create', 'store']),
            new Middleware('permission:Customer Edit', only: ['edit', 'update']),
            new Middleware('permission:Customer Delete', only: ['destroy']),
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('admin.customer.index');
    }

     /**
     * Get all user for listing
     *
     * @param Request $request
     */
    public function getData(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');
        $query = Customer::query();
        
        $customers = $query->select('id', 'first_name', 'last_name', 'email','contact_no','address','city','pin_code','status','user_id');

        $customers = $customers->get();

        return Datatables::of($customers)
            ->addIndexColumn()
            ->addColumn('user_id', function ($data) {
                return '<span class="fw-bold">' . $data->user->first_name . ' ' . $data->user->last_name . '</span>';
            })
            ->editColumn('name', function ($data) {
                return $data->full_name;
            })
            ->editColumn('status', function ($data) {
                if ($data->status == 1) {
                    return '<div class="badge rounded-pill bg-success text-white actions">Active</div>';
                } else {
                    return '<div class="badge rounded-pill bg-warning text-white actions">Inactive</div>';
                }
            })
            ->addColumn('action', function ($data) {
                $actions = '';
                if (Gate::allows('Customer List')) {
                    $actions .= '<a href="javascript:;" data-url="' . route('customer.show',$data->id) . '" class="btn btn-sm btn-square btn-neutral me-2 modal-popup-view" data-modal-title="Employee Details"><i class="fa fa-eye"></i></a>';
                }
                if (Gate::allows('Customer Edit')) {
                    $actions .= '<a href="' . route('customer.edit',$data->id) . '" class="btn btn-sm btn-square btn-neutral me-2"><i class="fa fa-pencil-square-o"></i></a>';
                }
                if (Gate::allows('Customer Delete')) {
                    $actions .= '<a href="javascript:;" data-url="' . route('customer.destroy',$data->id) . '" class="btn btn-sm btn-square btn-neutral text-danger-hover modal-popup-delete" data-modal-delete-text="Are you sure you want to delete this user?"><i class="fa fa-trash-o"></i></a>';
                }
                return $actions;
            })
            ->rawColumns(['action','user_id','status'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $activeOrNot = StatusOption::asSelectArray();
        return view('admin.customer.create_update',compact('activeOrNot'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CustomerRequest $request)
    {
        $data = $request->all();
        $data['user_id'] = Auth::user()->id;
        $data['status'] = $request->status ? 1 : 0;
         
        if ($customer = Customer::create($data)) {
            Session::flash('success', 'Customer created successfully');
            return redirect()->route('customer.index');
        } else {
            Session::flash('error', 'Unable to create customer');
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        $data  = [
            'ID'                        =>  $customer->id,
            'First Name'                =>  $customer->first_name,
            'Last Name'                 =>  $customer->last_name,
            'Email'                     =>  $customer->email,
            'Contact No'                =>  $customer->contact_no,
            'Status'                    =>  $customer->status == 1 ? 'Active' : 'Inactive',
            'Address'                   =>  $customer->address,
            'City'                      =>  $customer->city,
            'Pin Code'                  =>  $customer->pin_code,
        ];

        return $data;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        $activeOrNot = StatusOption::asSelectArray();
        return view('admin.customer.create_update', compact('activeOrNot','customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CustomerRequest $request, Customer $customer)
    {
        $data = $request->all();
        $data['status'] = $request->status ? 1 : 0;
     
        if ($customer->update($data)) {
            Session::flash('success', 'Customer updeted successfully');
            return redirect()->route('customer.index');
        } else {
            Session::flash('error', 'Unable to update customer');
            return redirect()->back();
        }   
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();
    }

}
