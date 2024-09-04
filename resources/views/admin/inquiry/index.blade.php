@extends('layouts.admin.master')
@section('title', 'Inquiry')
@section('content')
    <div class="content-wrapper">
		@include('layouts.admin.page_header',['breadcrumb'=>[route('inquiry.index')=>'Inquiry']])
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
						<h5 class="card-title">Inquiry</h5>
                        <div class="header-elements">
							<div class="list-icons">
								<a class="list-icons-item" data-action="collapse"></a>
								<a class="list-icons-item" data-action="reload"></a>
								<a class="list-icons-item" data-action="remove"></a>
							</div>
						</div>
                    </div>
                    <div class="card-body">
						<a href="{{ route('inquiry.create') }}" class="btn btn-success btn-labeled btn-labeled-left btn-sm legitRipple float-right"><b><i class="icon-plus3"></i></b> Add</a>
                    </div>
                    <table class="table table-responsive datatable-basic inquiry-table" id="data-table">
						<thead>
							<tr>
                            	<th>ID</th>
                           		<th>Customer Name</th>
								<th>Email</th>
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
                ajax: '{!! route('inquiry.data') !!}',
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'customer_first_name', name: 'customer_first_name' },
                    { data: 'email', name: 'email' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ]
			});
        });
    </script>
@endsection
