@extends('layouts.admin.master')
@section('title', 'Roles')
@section('module_title', 'Admin')
@section('content')
    <div class="content-wrapper">
        @include('layouts.admin.page_header', [
            'breadcrumb' => ['dashboard' => 'Admin', route('roles.index') => 'Roles'],
        ])
        <!-- Content area -->
        <div class="content">
            <!-- Basic datatable -->
            <div class="card">
                <div class="card-header">
                    <div class="row gy-4">
                        <div class="col-md-5 col-sm-4 col-12 hstack">
                            <h4>Roles</h4>
                        </div>
                        <div class="col-md-7 col-sm-8 col-12 hstack justify-content-end gap-3">
                            <div class="input-group input-group-sm w-md-56">
                                <span class="input-group-text"><i class="bi bi-search"></i></span>
                                <input type="search" class="form-control" id="roleSearch" placeholder="Type to filter..."
                                    aria-controls="data-table">
                            </div>
                            <a href="{{ route('roles.create') }}" class="btn btn-sm btn-success flex-none"><i
                                    class="bi bi-plus-lg me-2"></i>Add</a>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <table class="table datatable-basic roles-table" id="data-table">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
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
            window.dataGridTable = $('#data-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                searching: false,
                lengthChange: false,
                bLengthChange: false,
                aaSorting: [
                    [1, 'desc']
                ],
                ajax: {
                    url: '{!! route('roles.data') !!}',
                    data: function(d) {
                        d.search = $('#roleSearch').val();
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'id',
                        orderable: true,
                        searchable: false
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
                drawCallback: function(settings) {
                    $('#data-table tbody tr').addClass('border-top table-hover-tr');
                }
            });

            /**
             * Search
             */
            $('#roleSearch').on('keyup', function() {
                var value = $(this).val();
                window.dataGridTable.search(value).draw();
            });

            /**
             * Clear search input and reload datatable
             */
            $('#roleSearch').on('search', function() {
                if (!this.value) {
                    window.dataGridTable.search('').draw();
                }
            });
        });
    </script>
@endsection
