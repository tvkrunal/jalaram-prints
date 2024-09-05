<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PriceMaster;
use App\Http\Requests\PriceMasterRequest;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Session;


class PriceMasterController extends Controller
{
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
                return redirect()->route('price.index');
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
        public function show(PriceMaster $price)
        {
            $price = PriceMaster::all();
    
            return Datatables::of($query)
                ->addIndexColumn()
                ->rawColumns(['action'])
    
                ->make(true);
        }
    
        /**
         * Show the form for editing the specified resource.
         *
         * @param PriceMaster $price
         *
         * @return Response
         */
        public function edit(PriceMaster $price)
        {
            // $price = PriceMaster::findOrFail($price);

            return view('admin.price_master.create_update', compact('price'));
        }
    
        /**
         * Update the specified resource in storage.
         *
         * @param PriceMasterRequest $request
         * @param PriceMaster $price
         *
         * @return Response
         */
        public function update(PriceMasterRequest $request,PriceMaster $price)
        {
            $data = $request->all();
            $price->update($data);
            
            if ($price->update($data)) {
                Session::flash('success', 'Price has been updeted successfully');
                return redirect()->route('price.index');
            } else {
                Session::flash('error', 'Unable to update Price');
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
        public function destroy(PriceMaster $price)
        {
            $price->delete();

            if ($price->delete()) {
                Session::flash('success', 'Price has been deleted successfully');
                return redirect()->route('price.index');
            } else {
                Session::flash('error', 'Unable to deteted Price');
                return redirect()->back();
            }
         
        }
    }
