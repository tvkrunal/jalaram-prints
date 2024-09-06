<?php

namespace App\Http\Controllers\Admin;

use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Classes\Helper\CommonUtil;
use App\Http\Requests\InquiryRequest;
use App\Http\Requests\CustomerRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Enums\StatusOption;
use App\Enums\Status;
use App\Models\Role;
use App\Models\Customer;
use App\Models\Inquiry;
use App\Models\PriceMaster;
use App\Models\InquiryProcess;
use App\Models\InquiryPriceItem;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
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
        $search = $request->input('search');
        $status = $request->input('status');
        $query = Inquiry::query();
        
        $inquiry = $query->select('id', 'customer_id','type_of_job','delivery_date','status');

        $inquiries = $inquiry->get();

        return Datatables::of($inquiries)
            ->addIndexColumn()
            ->editColumn('name', function ($data) {
                return isset($data->customer) ? $data->customer->full_name : '-';
            })
            ->editColumn('stage', function ($data) {
                if ($data->status == 1) {
                    return '<div class="badge rounded-pill bg-soft-success text-primary">Inquiry</div>';
                } else {
                    return '<div class="badge rounded-pill bg-soft-warning text-warning">Unknown</div>';
                }
            })
            ->addColumn('action', function ($data) {
                $actions = '';
                if (Gate::allows('Inquiry List')) {
                    $actions .= '<a href="javascript:;" data-url="' . url('admin/employees/' . $data->id) . '" class="btn btn-sm btn-square btn-neutral me-2 modal-popup-view" data-modal-title="Employee Details"><i class="fa fa-eye"></i></a>';
                }
                if (Gate::allows('Inquiry Edit')) {
                    $actions .= '<a href="' . url('admin/employees/' . $data->id . '/edit') . '" class="btn btn-sm btn-square btn-neutral me-2"><i class="fa fa-pencil-square-o"></i></a>';
                }
                if (Gate::allows('Inquiry Delete')) {
                    $actions .= '<a href="javascript:;" data-url="' . url('admin/employees/' . $data->id) . '" class="btn btn-sm btn-square btn-neutral text-danger-hover modal-popup-delete" data-modal-delete-text="Are you sure you want to delete this user?"><i class="fa fa-trash-o"></i></a>';
                }
                return $actions;
            })
            ->rawColumns(['action','stage'])
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
        $priceMasters = PriceMaster::pluck('item_type','id');
        $customers = Customer::get()->pluck('full_name', 'id');
        return view('admin.inquiry.create_update', compact('activeOrNot', 'projectManager', 'teamLeader', 'customers', 'priceMasters'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param InquiryRequest $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $data['status'] = 1;
        $data['user_id'] = Auth::user()->id;
        $inquiry =  Inquiry::create($data);
        if ($inquiry) {
            if (!empty($data['processes'])) {
                foreach($data['processes']  as $key => $value) {
                    InquiryProcess::updateOrCreate([
                        'title' => $value,
                        'inquiry_id' => $inquiry->id
                    ]);
                }
            }

            if (!empty($data['inquiryPriceItemSection'])) {
                foreach($data['inquiryPriceItemSection']  as $key => $inquiryPriceItemSection) {
                    InquiryPriceItem::updateOrCreate([
                        'price_master_id' => $inquiryPriceItemSection['price_master_id'],
                        'media' => $inquiryPriceItemSection['media'],
                        'gsm' => $inquiryPriceItemSection['gsm'],
                        'qty' => $inquiryPriceItemSection['qty'],
                        'cost' => $inquiryPriceItemSection['cost'],
                        'total_hours' => $inquiryPriceItemSection['total_hours'],
                        'cost_calculation' => $inquiryPriceItemSection['cost_calculation'],
                        'inquiry_id' => $inquiry->id
                    ]);
                }
            }
            Session::flash('success', 'Inquiry created successfully');
            return redirect()->route('inquiry.index');
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
        $customers = Customer::get()->pluck('full_name', 'id');
        return view('admin.inquiry.create_update', compact('user', 'activeOrNot', 'projectManager', 'teamLeader', 'customers', 'parentUsers'));
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

        $user->delete();
    }

    /**
     * Display the specified resource.
     */
    public function getCustomerDetails($id)
    {
        $customer = Customer::findOrfail($id);

        if(!empty($customer)) {
            return response()->json(['status' => true, 'message' => __('Customer Details Retrieved Successfully'),'customer' => $customer]);
        } else {
            return response()->json(['status' => false, 'message' => __('Something went wrong')]);
        }
    }


     /**
     * Display the specified resource.
     */
    public function storeCustomerDetails(CustomerRequest $request)
    {
        $data = $request->all();
        $data['user_id'] = Auth::user()->id;

        if ($customer = Customer::create($data)) {
            Session::flash('success', 'Customer created successfully');
            return response()->json(['status' => true, 'message' => 'Customer created successfully']);
        } else {
            return response()->json(['status' => false, 'message' => __('Something went wrong')]);
        }
    }


    /**
     * Display the specified resource.
     */
    public function getPriceMasterDetails($id)
    {
        $priceMaster = PriceMaster::findOrfail($id);

        if(!empty($priceMaster)) {
            return response()->json(['status' => true, 'message' => __('Customer Details Retrieved Successfully'),'priceMaster' => $priceMaster]);
        } else {
            return response()->json(['status' => false, 'message' => __('Something went wrong')]);
        }
    }
}
