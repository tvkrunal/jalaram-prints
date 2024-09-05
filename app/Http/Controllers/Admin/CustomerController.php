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
            ->addColumn('action', function ($data) {
                $actions = '';
                if (Gate::allows('Customer List')) {
                    $actions .= '<a href="javascript:;" data-url="' . url('admin/customer/' . $data->id) . '" class="btn btn-sm btn-square btn-neutral me-2 modal-popup-view" data-modal-title="Employee Details"><i class="fa fa-eye"></i></a>';
                }
                if (Gate::allows('Customer Edit')) {
                    $actions .= '<a href="' . url('admin/customer/' . $data->id . '/edit') . '" class="btn btn-sm btn-square btn-neutral me-2"><i class="fa fa-pencil-square-o"></i></a>';
                }
                if (Gate::allows('Customer Delete')) {
                    $actions .= '<a href="javascript:;" data-url="' . url('admin/customer/' . $data->id) . '" class="btn btn-sm btn-square btn-neutral text-danger-hover modal-popup-delete" data-modal-delete-text="Are you sure you want to delete this user?"><i class="fa fa-trash-o"></i></a>';
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
        return view('admin.customer.create_update');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CustomerRequest $request)
    {
        $data = $request->all();
        $data['user_id'] = Auth::user()->id;
         
        if ($customer = Customer::create($data)) {
            Session::flash('success', 'Customer has been added');
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
        return view('admin.customer.create_update',compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CustomerRequest $request, Customer $customer)
    {
        $data = $request->all();
     
        if ($customer->update($data)) {
            Session::flash('success', 'Customer has been updeted successfully');
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
