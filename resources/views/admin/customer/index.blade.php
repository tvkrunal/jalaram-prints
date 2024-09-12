@extends('layouts.admin.master')
@section('title', 'Customer')
@section('content')
    <div class="content-wrapper">
		@include('layouts.admin.page_header',['breadcrumb'=>[route('customer.index')=>'Customer']])
			<!-- Content area -->
			<div class="content">
				@if(Session::has('success'))
					<div class="alert alert-success">
						{{Session::get('success')}}
					</div>
				@endif
				<!-- Basic datatable -->
				<div class="card">
					<div class="card-header header-elements-inline">
						<h5 class="card-title">Customer</h5>
                        <div class="header-elements">
							<div class="list-icons">
								<a class="list-icons-item" data-action="collapse"></a>
								<a class="list-icons-item" data-action="reload"></a>
								<a class="list-icons-item" data-action="remove"></a>
							</div>
						</div>
                    </div>
                    <div class="card-body">
						<a href="{{ route('customer.create') }}" class="btn btn-success btn-labeled btn-labeled-left btn-sm legitRipple float-right"><b><i class="icon-plus3"></i></b> Add</a>
                    </div>
                    <table class="table table-responsive datatable-basic customer-table" id="data-table">
						<thead>
							<tr>
                            	<th>ID</th>
                           		<th>Name</th>
								<th>Contact No</th>
								<th>Email</th>
								<th>Address</th>
								<th>City</th>
								<th>Pin Code</th>
								<th>User</th>
								<th>Status</th>
                                <th>Action</th>
							</tr>
						</thead>
					</table>
				</div>
				<!-- /basic datatable -->
            </div>
			<!-- /content area -->
		@include('layouts.admin.page_footer')
	</div>
@endsection
@section('scripts')
    <script>
        $(function() {
            window.dataGridTable =$('#data-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
				"order": [[ 1, "asc" ]],
                ajax: '{!! route('customer.data') !!}',
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'name', name: 'name' },
					{ data: 'contact_no', name: 'contact_no' },
                    { data: 'email', name: 'email' },
					{ data: 'address', name: 'address' },
                    { data: 'city', name: 'city' },
					{ data: 'pin_code', name: 'pin_code' },
					{ data: 'user_id', name: 'user_id' },
					{ data: 'status', name: 'status' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ]
			});
        });
    </script>
@endsection
