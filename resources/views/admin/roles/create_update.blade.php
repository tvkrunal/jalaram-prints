@extends('layouts.admin.master')
@section('title', isset($role) ? 'Edit Roles' : 'Add Roles')
@section('module_title', 'Admin')
@section('content')
    <div class="content-wrapper">
        @include('layouts.admin.page_header', [
            'breadcrumb' => [route('users.index') => 'Admin', route('roles.index') => 'Roles'],
        ])
        <!-- Content area -->
        <div class="content">
            @if (Session::has('success'))
                <div class="alert alert-success">
                    {{ Session::get('success') }}
                </div>
            @endif
            <div class="card">
                @if (isset($role))
                    {{ Form::model($role, ['route' => ['roles.update', $role->id], 'method' => 'patch', 'enctype' => 'multipart/form-data']) }}
                @else
                    {{ Form::open(['route' => 'roles.store', 'enctype' => 'multipart/form-data', 'method' => 'post']) }}
                @endif
                <div class="card-header">
                    @if (isset($role))
                        <h4>Edit Role</h4>
                    @else
                        <h4>Add Role</h4>
                    @endif
                </div>
                <div class="card-body">
                    <div class="card">
                    <fieldset class="language">
                        <div class="m-4">
                            <label class="form-label">Name <span class="text-danger">*</span></label>
                            {{ Form::text('name', Request::old('name'), ['class' => 'form-control']) }}
                            @if ($errors->has('name'))
                                <span class="text-danger">{{ $errors->first('name') }}</span>
                            @endif
                        </div>
                        <div>
                            <label class="form-label m-4">Permission</label>
                            <div class="row gy-6">
                                <div class="col-lg-6 m-4">
                                    <div class="card mb-6">
                                        <h4 class="card-header text-black-100">Dashboard :-</h4>
                                        <div class="card-body">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input cursor-pointer"
                                                    @if (isset($role)) {{ in_array(2, $rolePermissions) ? 'checked' : false }} @else {{ 'checked' }} @endif
                                                    name="permission[]" type="checkbox" value="Dashboard List"
                                                    id="dashboard-list">
                                                <label for="dashboard-list" class="form-check-label">List </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-5 m-1">
                                    <div class="card mb-6">
                                        <h4 class="card-header text-black-100">Admin :-</h4>
                                        <div class="card-body">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input cursor-pointer"
                                                    {{ in_array(1, $rolePermissions) ? 'checked' : false }}
                                                    name="permission[]" type="checkbox" value="Admin List"
                                                    id="admin-list">
                                                <label for="admin-list" class="form-check-label">List</label>
                                            </div>

                                            <h5 class="text-capitalize py-3 border-top mt-2">Roles</h5>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input  cursor-pointer"
                                                    {{ in_array(7, $rolePermissions) ? 'checked' : false }}
                                                    name="permission[]" type="checkbox" value="Roles List"
                                                    id="roles-list">
                                                <label for="roles-list" class="form-check-label">List</label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input  cursor-pointer"
                                                    {{ in_array(8, $rolePermissions) ? 'checked' : false }}
                                                    name="permission[]" type="checkbox" value="Roles Create"
                                                    id="roles-create">
                                                <label for="roles-create" class="form-check-label">Create</label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input  cursor-pointer"
                                                    {{ in_array(9, $rolePermissions) ? 'checked' : false }}
                                                    name="permission[]" type="checkbox" value="Roles Edit"
                                                    id="roles-edit">
                                                <label for="roles-edit" class="form-check-label">Edit</label>
                                            </div>

                                            <h5 class="text-capitalize py-3 border-top mt-2">User</h5>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input  cursor-pointer"
                                                    {{ in_array(3, $rolePermissions) ? 'checked' : false }}
                                                    name="permission[]" type="checkbox" value="User List"
                                                    id="user-list">
                                                <label for="user-list" class="form-check-label">List</label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input  cursor-pointer"
                                                    {{ in_array(4, $rolePermissions) ? 'checked' : false }}
                                                    name="permission[]" type="checkbox" value="User Create"
                                                    id="user-create">
                                                <label for="user-create" class="form-check-label">Create</label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input  cursor-pointer"
                                                    {{ in_array(5, $rolePermissions) ? 'checked' : false }}
                                                    name="permission[]" type="checkbox" value="User Edit"
                                                    id="user-edit">
                                                <label for="user-edit" class="form-check-label">Edit</label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input  cursor-pointer"
                                                    {{ in_array(6, $rolePermissions) ? 'checked' : false }}
                                                    name="permission[]" type="checkbox" value="User Delete"
                                                    id="user-delete">
                                                <label for="user-delete" class="form-check-label">Delete</label>
                                            </div>

                                            <h5 class="text-capitalize py-3 border-top mt-2">Inquiry</h5>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input cursor-pointer"
                                                    {{ in_array(10, $rolePermissions) ? 'checked' : false }}
                                                    name="permission[]" type="checkbox" value="Inquiry List"
                                                    id="inquiry-list">
                                                <label for="inquiry-list" class="form-check-label">List</label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input cursor-pointer"
                                                    {{ in_array(11, $rolePermissions) ? 'checked' : false }}
                                                    name="permission[]" type="checkbox" value="Inquiry Create"
                                                    id="inquiry-create">
                                                <label for="inquiry-create" class="form-check-label">Create</label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input cursor-pointer"
                                                    {{ in_array(12, $rolePermissions) ? 'checked' : false }}
                                                    name="permission[]" type="checkbox" value="Inquiry Edit"
                                                    id="inquiry-edit">
                                                <label for="inquiry-edit" class="form-check-label">Edit</label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input cursor-pointer"
                                                    {{ in_array(13, $rolePermissions) ? 'checked' : false }}
                                                    name="permission[]" type="checkbox" value="Inquiry Delete"
                                                    id="inquiry-delete">
                                                <label for="inquiry-delete" class="form-check-label">Delete</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input cursor-pointer"
                                                    {{ in_array(14, $rolePermissions) ? 'checked' : false }}
                                                    name="permission[]" type="checkbox" value="Inquiry Update Stage"
                                                    id="inquiry-update-stage">
                                                <label for="inquiry-update-stage" class="form-check-label">Change Stage</label>
                                            </div>

                                            <h5 class="text-capitalize py-3 border-top mt-2">Customer</h5>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input  cursor-pointer"
                                                    {{ in_array(15, $rolePermissions) ? 'checked' : false }}
                                                    name="permission[]" type="checkbox" value="Customer List"
                                                    id="customer-list">
                                                <label for="customer-list" class="form-check-label">List</label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input  cursor-pointer"
                                                    {{ in_array(16, $rolePermissions) ? 'checked' : false }}
                                                    name="permission[]" type="checkbox" value="Customer Create"
                                                    id="customer-create">
                                                <label for="customer-create" class="form-check-label">Create</label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input  cursor-pointer"
                                                    {{ in_array(17, $rolePermissions) ? 'checked' : false }}
                                                    name="permission[]" type="checkbox" value="Customer Edit"
                                                    id="customer-edit">
                                                <label for="customer-edit" class="form-check-label">Edit</label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input cursor-pointer"
                                                    {{ in_array(18, $rolePermissions) ? 'checked' : false }}
                                                    name="permission[]" type="checkbox" value="Customer Delete"
                                                    id="customer-delete">
                                                <label for="customer-delete" class="form-check-label">Delete</label>
                                            </div>

                                            <h5 class="text-capitalize py-3 border-top mt-2">Price Master</h5>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input  cursor-pointer"
                                                    {{ in_array(19, $rolePermissions) ? 'checked' : false }}
                                                    name="permission[]" type="checkbox" value="Price Master List"
                                                    id="price-master-list">
                                                <label for="price-master-list" class="form-check-label">List</label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input  cursor-pointer"
                                                    {{ in_array(20, $rolePermissions) ? 'checked' : false }}
                                                    name="permission[]" type="checkbox" value="Price Master Create"
                                                    id="price-master-create">
                                                <label for="price-master-create" class="form-check-label">Create</label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input  cursor-pointer"
                                                    {{ in_array(21, $rolePermissions) ? 'checked' : false }}
                                                    name="permission[]" type="checkbox" value="Price Master Edit"
                                                    id="price-master-edit">
                                                <label for="price-master-edit" class="form-check-label">Edit</label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input  cursor-pointer"
                                                    {{ in_array(22, $rolePermissions) ? 'checked' : false }}
                                                    name="permission[]" type="checkbox" value="Price Master Delete"
                                                    id="price-master-delete">
                                                <label for="price-master-delete" class="form-check-label">Delete</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <div class="text-right m-4">
                        {{ Form::submit('Submit', ['class' => 'btn btn-primary ms-2']) }}
                        <a href="{{ url('/admin/roles') }}" class="btn btn-primary me-5">Cancel</a>
                    </div>
                </div>
            </div> 
            {{ Form::close() }}
        </div>
    </div>
    <!-- /content area -->
    @include('layouts.admin.page_footer')
    </div>
@endsection
