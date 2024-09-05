<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PriceMaster;
use App\Http\Requests\PriceMasterRequest;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Session;


class PriceMasterController extends Controller implements HasMiddleware
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
        return view('admin.price_master.index');
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
        $query = PriceMaster::query();
            
            
        $price = $query->select('id', 'item_type', 'media', 'gsm','qty','min_cost','max_cost');
    
            if ($role == 'HR') {
                $price->whereDoesntHave('roles', function ($query) {
                    $query->where('name', 'Administrator');
                });
            }
            $price = $price->get();
    
            return Datatables::of($price)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $actions = '';
                    if (Gate::allows('User List')) {
                        $actions .= '<a href="javascript:;" data-url="' . url('admin/price-master/' . $data->id) . '" class="btn btn-sm btn-square btn-neutral me-2 modal-popup-view" data-modal-title="Employee Details"><i class="fa fa-eye"></i></a>';
                    }
                    if (Gate::allows('User Edit')) {
                        $actions .= '<a href="' . url('admin/price-master/' . $data->id . '/edit') . '" class="btn btn-sm btn-square btn-neutral me-2"><i class="fa fa-pencil-square-o""></i></a>';
                    }
                    if (Gate::allows('User Delete')) {
                        $actions .= '<a href="javascript:;" data-url="' . url('admin/price-master/' . $data->id) . '" class="btn btn-sm btn-square btn-neutral text-danger-hover modal-popup-delete" data-modal-delete-text="Are you sure you want to delete this user?"><i class="fa fa-trash-o"></i></a>';
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
            return view('admin.price_master.create_update');
        }
    
        /**
         * Store a newly created resource in storage.
         *
         * @param PriceMasterRequest $request
         *
         * @return Response
         */
        public function store(PriceMasterRequest $request)
        {
            $data = $request->all();
            $data['user_id'] = Auth::user()->id;
         
            if ($price = PriceMaster::create($data)) {
                Session::flash('success', 'Price has been added');
                return redirect()->route('price-master.index');
            } else {
                Session::flash('error', 'Unable to create Price');
                return redirect()->back();
            }

        }
    
        /**
         * Display the specified resource.
         *
         * @param PriceMaster $price
         *
         * @return Response
         */
        public function show(PriceMaster $priceMaster)
        {
            $data  = [
                'ID'                        =>  $priceMaster->id,
                'Item Type'                 =>  $priceMaster->item_type,
                'Media'                     =>  $priceMaster->media,
                'GSM'                       =>  $priceMaster->gsm,
                'Qty'                       =>  $priceMaster->qty,
                'Min Cost'                  =>  $priceMaster->min_cost,
                'Max Cost'                  =>  $priceMaster->max_cost,
            ];
    
            return $data;
        }
    
        /**
         * Show the form for editing the specified resource.
         *
         * @param PriceMaster $price
         *
         * @return Response
         */
        public function edit(PriceMaster $priceMaster)
        {
            return view('admin.price_master.create_update', compact('priceMaster'));
        }
    
        /**
         * Update the specified resource in storage.
         *
         * @param PriceMasterRequest $request
         * @param PriceMaster $price
         *
         * @return Response
         */
        public function update(PriceMasterRequest $request,PriceMaster $priceMaster)
        {
            $data = $request->all();
            
            if ($priceMaster->update($data)) {
                Session::flash('success', 'Price master has been updeted successfully');
                return redirect()->route('price-master.index');
            } else {
                Session::flash('error', 'Unable to update price master');
                return redirect()->back();
            }

        }
    
        /**
         * Delete User
         *
         * @param PriceMaster $price
         *
         * @return Response
         */
        public function destroy(PriceMaster $priceMaster)
        {
            $priceMaster->delete();
        }
    }
