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
use App\Enums\StageType;
use App\Models\Role;
use App\Models\Customer;
use App\Models\Inquiry;
use App\Models\PriceMaster;
use App\Models\InquiryProcess;
use App\Enums\RoleType;
use App\Models\InquiryBilling;
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
            new Middleware('permission:Inquiry Update Stage', only: ['updateInquiryStage']),
            new Middleware('permission:Inquiry Billing', only: ['inquiryBilling','storeInquiryBilling']),
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $stages = StageType::asArray(); 
        return view('admin.inquiry.index', compact('stages'));
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

        if (Auth::user()->hasRole('Designer')) {
            $query->where('status',2);
        }
        
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }


        if (Auth::user()->hasRole('Printing')) {
            $query->where('status',3);
        }

        // if (Auth::user()->hasRole('Processor')) {
        //     $query->where('status',4);
        // }

        if (Auth::user()->hasRole('Accountant')) {
            $query->whereIn('status',[4,5]);
        }
        
        // Continue with the rest of your query logic or other processing here
        
        $inquiries = $query->select('id', 'customer_id', 'type_of_job', 'delivery_date', 'status','user_id')->get();

        return Datatables::of($inquiries)
            ->addIndexColumn()
            ->addColumn('user_id', function ($data) {
                return isset($data->user) ? $data->user->full_name : '-';
            })
            ->editColumn('name', function ($data) {
                return isset($data->customer) ? $data->customer->full_name : '-';
            })
            ->editColumn('stage', function ($data) {
                switch ($data->status) {
                    case 1:
                        return '<div class="badge rounded-pill bg-success text-white actions">Inquiry</div>';
                    case 2:
                        return '<div class="badge rounded-pill bg-warning text-white actions">Design</div>';
                    case 3:
                        return '<div class="badge rounded-pill bg-info text-white actions">Print</div>';
                    case 4:
                        return '<div class="badge rounded-pill bg-secondary text-white actions">Billing</div>';
                    case 5:
                        return '<div class="badge rounded-pill bg-success text-white actions">Completed</div>';
                    default:
                        return '<div class="badge rounded-pill bg-secondary text-white actions">Unknown</div>';
                } 
            })
            ->addColumn('action', function ($data) {
                $actions = '';
                if (Gate::allows('Inquiry List')) {
                    $actions .= '<a href="javascript:;" data-url="' . route('inquiry.show',$data->id) . '" class="btn btn-sm btn-square btn-neutral me-2 modal-popup-view" Title="View"><i class="fa fa-eye"></i></a>';
                }

                if (Gate::allows('Inquiry Edit')) {
                    $actions .= '<a href="' . route('inquiry.edit',$data->id) . '" class="btn btn-sm btn-square btn-neutral me-2" Title="Edit"><i class="fa fa-pencil-square-o"></i></a>';
                }

                if (Gate::allows('Inquiry Delete')) {
                    $actions .= '<a href="javascript:;" data-url="' . route('inquiry.destroy',$data->id) . '" class="btn btn-sm btn-square btn-neutral text-danger-hover modal-popup-delete" Title="Delete"><i class="fa fa-trash-o"></i></a>';
                }

                if (Gate::allows('Inquiry Update Stage') && !isset($data->billing) ) {
                    $actions .= '<a href="javascript:;" data-url="'. route('update.inquiry.stage') . '" data-id="'.$data->id.'" data-stage="'.$data->status.'"class="btn btn-sm btn-square btn-neutral text-danger-hover update-stage" Title="Update Stage"><i class="fa fa-arrow-right"></i></a>';
                }

                if (Gate::allows('Inquiry Billing') && Auth::user()->hasRole('Admin') || Auth::user()->hasRole('Accountant')) {
                    if(isset($data->billing) && ($data->status == 4)) {
                        $actions .= '<a href="javascript:;" data-url="'. route('update.inquiry.stage') . '" data-id="'.$data->id.'" data-stage="'.$data->status.'"class="btn btn-sm btn-square btn-neutral text-danger-hover update-stage" Title="Update Stage"><i class="fa fa-arrow-right"></i></a>';
                    }

                    if($data->status == 4 && !($data->billing)) {
                        $actions .= '<a href="'. route('inquiry.billing',$data->id).'" class="btn btn-sm btn-square btn-neutral text-danger-hover inquiry-billing" Title="Billing"><i class="fa fa-money"></i></a>';
                    }
                }
                return $actions;
            })
            ->rawColumns(['action', 'stage'])
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
        $priceMasters = PriceMaster::pluck('item_type','id');
        $customers = Customer::get()->pluck('full_name', 'id');
        return view('admin.inquiry.create_update', compact('activeOrNot','customers', 'priceMasters'));
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
                    if(!empty($inquiryPriceItemSection['price_master_id'])) {
                        InquiryPriceItem::updateOrCreate([
                            'price_master_id' => $inquiryPriceItemSection['price_master_id'],
                            'media' => $inquiryPriceItemSection['media'],
                            'gsm' => $inquiryPriceItemSection['gsm'],
                            'qty' => $inquiryPriceItemSection['qty'],
                            'cost' => $inquiryPriceItemSection['cost'],
                            'total_hours' => $inquiryPriceItemSection['total_hours'],
                            'inquiry_id' => $inquiry->id
                        ]);
                    }
                }
            }
            $inquiry->cost_calculation = $request->cost_calculation;
            $inquiry->update();
            Session::flash('success', 'Inquiry created successfully');
            return redirect()->route('inquiry.index');
        } else {
            Session::flash('error', 'Unable to add Inquiry');
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Inquiry $inquiry
     *
     * @return Response
     */
    public function show(Inquiry $inquiry)
    {
        $data  = [
            'ID'                   => $inquiry->id ?? '',
            'Customer Name'        => isset($inquiry->customer) && !empty($inquiry->customer) ? $inquiry->customer->full_name : '',
            'Type Of Job'          => $inquiry->type_of_job ?? '',
            'Delivery Date'        => !empty($inquiry->delivery_date) ? $inquiry->delivery_date : '',
            'Designing Detail'     => $inquiry->designing_details ?? '',
            'User Name'            => isset($inquiry->user) && !empty($inquiry->user) ? $inquiry->user->full_name : '',
            'Job Description'      => $inquiry->job_description ?? '',
            'Cost Calculation'     => $inquiry->cost_calculation ?? '',
            'Status'               => $inquiry->status == 1 ? 'inquiry' :
                                      ($inquiry->status == 2 ? 'Design' :
                                      ($inquiry->status == 3 ? 'Print' :
                                      ($inquiry->status == 4 ? 'Billing' :
                                      ($inquiry->status == 5 ? 'Completed' : 'Unknown')))) 

        ];

        return $data;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Inquiry $inquiry
     *
     * @return Response
     */
    public function edit(Inquiry $inquiry)
    {
        $activeOrNot = StatusOption::asSelectArray();
        $priceMasters = PriceMaster::pluck('item_type','id');
        $customers = Customer::get()->pluck('full_name', 'id');
        $processes = !empty($inquiry->processes) ? $inquiry->processes()->pluck('title')->toArray() : [];
        return view('admin.inquiry.create_update', compact('inquiry', 'activeOrNot','customers', 'priceMasters','processes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param InquiryRequest $request
     * @param Inquiry $inquiry
     *
     * @return Response
     */
    public function update(InquiryRequest $request, Inquiry $inquiry)
    {
        $data = $request->all();

        $data['status'] = 1;
        $data['user_id'] = Auth::user()->id;
        

        if ($inquiry->update($data)) {
            if (!empty($data['processes'])) {
                InquiryProcess::where('inquiry_id',$inquiry->id)->delete();
                foreach($data['processes']  as $key => $value) {
                    InquiryProcess::updateOrCreate([
                        'title' => $value,
                        'inquiry_id' => $inquiry->id
                    ]);
                }
            }

            if (!empty($data['inquiryPriceItemSection'])) {
                foreach($data['inquiryPriceItemSection']  as $key => $inquiryPriceItemSection) {
                    if(!empty($inquiryPriceItemSection['price_master_id'])) {
                        InquiryPriceItem::updateOrCreate([
                            'price_master_id' => $inquiryPriceItemSection['price_master_id'],
                            'media' => $inquiryPriceItemSection['media'],
                            'gsm' => $inquiryPriceItemSection['gsm'],
                            'qty' => $inquiryPriceItemSection['qty'],
                            'cost' => $inquiryPriceItemSection['cost'],
                            'total_hours' => $inquiryPriceItemSection['total_hours'],
                            'inquiry_id' => $inquiry->id
                        ]);
                    }
                }
            }
            $inquiry->cost_calculation = $request->cost_calculation ?? Null;
            $inquiry->update();
            Session::flash('success', 'Inquiry updated successfully');
            return redirect()->route('inquiry.index');
        } else {
            Session::flash('error', 'Unable to update inquiry');
            return redirect()->back();
        }
    }

    /**
     * Delete Inquiry
     *
     * @param Inquiry $inquiry
     *
     * @return Response
     */
    public function destroy(Inquiry $inquiry)
    {
        $inquiry->delete();

        if(!empty($inquiry->inquiryPriceItems)) {
            $inquiry->inquiryPriceItems()->delete();
        }

        if (!empty($inquiry->processes)) {
            $inquiry->processes()->delete();
        }
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


    public function updateInquiryStage(Request $request) {
        if(empty($request)){
            return response()->json(['status' => false, 'message' => __('Something went wrong')]);
        }
        $inquiry  =  Inquiry::findOrFail($request->id);
        switch ($inquiry->status) {
            case 1:
                $inquiry->status = 2;
                if($inquiry->type_of_job == "Print") {
                    $inquiry->status = 3; //print
                }
                break;
            case 2:
                $inquiry->status = 3;
                break;
            case 3:
                $inquiry->status =  4;
                break;
            case 4:
                $inquiry->status =  5;
                break;
            default:
                break;
        }
        $inquiry->update();
        return response()->json(['status' => true, 'message' => __('Inquiry stage updated Successfully')]);
    }


    public function destroyInquiryPriceItem($id) {
        $inquiryPriceItem = InquiryPriceItem::findOrfail($id);

        if(!empty($inquiryPriceItem)) {
            $inquiryPriceItem->delete();
            return response()->json(['status' => true, 'message' => __('Inquiry price item deleted Successfully')]);
        } else {
            return response()->json(['status' => false, 'message' => __('Something went wrong')]);
        }
    }

    public function inquiryBilling($id) {

        $inquiry = Inquiry::findOrFail($id);

        if(empty($inquiry)) {
            Session::flash('error', 'Inquiry not found');
            return redirect()->back();
        }
        $priceMasters = PriceMaster::pluck('item_type','id');
        $customers = Customer::get()->pluck('full_name', 'id');
        $processes = !empty($inquiry->processes) ? $inquiry->processes()->pluck('title')->toArray() : [];
        return view('admin.inquiry.billing',compact('inquiry', 'priceMasters', 'processes', 'customers'));
    }

    public function storeInquiryBilling(Request $request) {

        $data = $request->all();
        $inquiryBilling = InquiryBilling::create($data);

        if ($inquiryBilling) {
            Session::flash('success', 'Inquiry billing created successfully');
            return redirect()->route('inquiry.index');
        } else {
            Session::flash('error', 'Unable to update inquiry billing');
            return redirect()->back();
        }
    }
}
