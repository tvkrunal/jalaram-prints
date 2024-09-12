@extends('layouts.admin.master')
@section('title', 'Users')
@section('content')
    <div class="content-wrapper">
		@include('layouts.admin.page_header',['breadcrumb'=>[route('users.index')=>'Users']])
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
						<h5 class="card-title">Users</h5>
                        <div class="header-elements">
							<div class="list-icons">
								<a class="list-icons-item" data-action="collapse"></a>
								<a class="list-icons-item" data-action="reload"></a>
								<a class="list-icons-item" data-action="remove"></a>
							</div>
						</div>
                    </div>
                    <div class="card-body">
						<a href="{{ route('users.create') }}" class="btn btn-success btn-labeled btn-labeled-left btn-sm legitRipple float-right"><b><i class="icon-plus3"></i></b> Add</a>
                    </div>
                    <table class="table table-responsive datatable-basic users-table" id="data-table">
						<thead>
							<tr>
                            	<th>ID</th>
                           		<th>First Name</th>
                            	<th>Last Name</th>
								<th>Email</th>
                                <th>Status</th>
                                <th>Action</th>
							</tr>
						</thead>
					</table>
				</div>
				<!-- /basic datatable -->
            </div>
			<!-- /content area -->
            @include('admin.user.user_update_status_modal')
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
                ajax: '{!! route('users.data') !!}',
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'first_name', name: 'first_name' },
                    { data: 'last_name', name: 'last_name' },
                    { data: 'email', name: 'email' },
                    { data: 'is_active', name: 'is_active' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ]
			});
        });
    </script>
@endsection
