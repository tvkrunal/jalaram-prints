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
                    <div class="header-elements-inline mb-3">
                        <h5 class="card-title">Roles</h5>
                        <div class="header-elements">
                            <div class="list-icons">
                                <a class="list-icons-item" data-action="collapse"></a>
                                <a class="list-icons-item" data-action="reload"></a>
                                <a class="list-icons-item" data-action="remove"></a>
                            </div>  
                        </div>
                    </div>
                    <a href="{{ route('roles.create') }}" class="btn btn-success btn-labeled btn-labeled-left btn-sm legitRipple float-right"><b><i class="icon-plus3"></i></b> Add</a>
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
