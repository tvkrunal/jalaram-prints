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
        $role = (Auth()->user()) ? Auth()->user()->getRoleNames()->first() : null;

        $search = $request->input('search');
        $query = Customer::query();
        
        
        $users = $query->select('id', 'customer_first_name', 'customer_last_name', 'email','customer_contact_no','address','city','pin_code','status','user_id');

        $users = $users->get();

        return Datatables::of($users)
            ->addIndexColumn()
            ->addColumn('user_id', function ($data) {
                return '<span class="fw-bold">' . $data->user->first_name . ' ' . $data->user->last_name . '</span>';
            })
            ->editColumn('name', function ($data) {
                return $data->full_name;
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
            Session::flash('success', 'customer has been added');
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        $customer = Customer::findOrFail($id);

        return view('admin.customer.create_update');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CustomerRequest $request, Customer $customer)
    {
        $customer = Customer::findOrFail($id);
        $customer->update($request->all());
     
        if ($customer->update($request->all())) {
            Session::flash('success', 'customer has been updeted successfully');
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
        $customer = Customer::findOrFail($id);
        $customer->delete();

        if ($customer->delete()) {
            Session::flash('success', 'customer has been deleted successfully');
            return redirect()->route('pricemaster.index');
        } else {
            Session::flash('error', 'Unable to deteted customer');
            return redirect()->back();
        }
    }
}
