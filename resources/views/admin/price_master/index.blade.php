@extends('layouts.admin.master')
@section('title', 'Price Master')
@section('content')
    <div class="content-wrapper">
    @include('layouts.admin.page_header',['breadcrumb'=>[route('price-master.index')=>'Price Master']])
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
						<h5 class="card-title">Price Master</h5>
                        <div class="header-elements">
							<div class="list-icons">
								<a class="list-icons-item" data-action="collapse"></a>
								<a class="list-icons-item" data-action="reload"></a>
								<a class="list-icons-item" data-action="remove"></a>
							</div>
						</div>
                    </div>
                    <div class="card-body">
						<a href="{{ route('price-master.create') }}" class="btn btn-success btn-labeled btn-labeled-left btn-sm legitRipple float-right"><b><i class="icon-plus3"></i></b> Add</a>
                    </div>
                    <table class="table table-responsive datatable-basic customer-table" id="data-table">
						<thead>
							<tr>
                            	<th>ID</th>
                           		<th>Item Type</th>
								<th>Media</th>
                                <th>GSM</th>
                           		<th>Qty</th>
								<th>Min Cost</th>
                                <th>Max Cost</th>
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
                ajax: '{!! route('price.master.data') !!}',
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'item_type', name: 'item_type' },
                    { data: 'media', name: 'media' },
                    { data: 'gsm', name: 'gsm' },
                    { data: 'qty', name: 'qty' },
                    { data: 'min_cost', name: 'min_cost' },
                    { data: 'max_cost', name: 'max_cost' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ]
			});
        });
    </script>
@endsection
