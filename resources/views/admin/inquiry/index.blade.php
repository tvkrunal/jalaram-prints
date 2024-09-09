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
					@if(auth()->user()->hasRole('Admin'))
					<div class="row">
					    <div class="col-xl-3 col-lg-4 col-md-6 col-10 ml-auto mb-4">
							<div class="d-flex align-items-center">
								<select class="form-control mr-4" style="" id="status-select">
									<option value="" >Stages</option>
									<option value="1">Inquiry</option>
									<option value="2">In Process</option>
									<option value="3">Completed</option>
								</select>
								<a href="{{ route('inquiry.create') }}" class="btn btn-success btn-labeled btn-labeled-left btn-sm legitRipple float-right"><b><i class="icon-plus3"></i></b> Add</a>
							</div>
                        </div>
					</div>
					@endif

                    <table class="table table-responsive datatable-basic inquiry-table" id="data-table">
						<thead>
							<tr>
                            	<th>ID</th>
                           		<th>Customer Name</th>
                           		<th>Type Of Job</th>
                           		<th>Delivery Date</th>
                           		<th>Stage</th>
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
        var table = $('#data-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            "order": [[ 1, "asc" ]],
            ajax: {
                url: '{!! route('inquiry.data') !!}',
                data: function (d) {
                    d.status = $('#status-select').val();
                }
            },
            columns: [
                { data: 'id', name: 'id' },
                { data: 'name', name: 'name' },
                { data: 'type_of_job', name: 'type_of_job' },
                { data: 'delivery_date', name: 'delivery_date' },
                { data: 'stage', name: 'stage' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });

        // Reload the table when the status filter is changed
        $('#status-select').change(function() {
            table.ajax.reload();
        });

		/**
         *  Update inquiry stage
         */
        $('body').on('click', '.update-stage', function (event) {
            event.preventDefault();
            var id = $(this).data("id");
            let updateStrage = $(this).attr('data-url');
			let currentStage = $(this).attr('data-stage');
            if(id) {
				var token = $("meta[name='_token']").attr("content");
                $.ajax({
                    type: 'POST',
					url: updateStrage,
					data: {
						"id": id,
						"_token": token,
						"stage" : currentStage
					},
                    success: function (data) {
                        if(data.status) {
							table.ajax.reload();
                        }
                    }
                });
            } else {
             
            }
        });
    });
</script>
@endsection
