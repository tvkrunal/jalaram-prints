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
                    <fieldset class="language">
                        <div class="mb-6">
                            <label class="form-label">Name <span class="text-danger">*</span></label>
                            {{ Form::text('name', Request::old('name'), ['class' => 'form-control']) }}
                            @if ($errors->has('name'))
                                <span class="text-danger">{{ $errors->first('name') }}</span>
                            @endif
                        </div>
                        <div>
                            <label class="form-label">Permission</label>
                            <div class="row gy-6">
                                <div class="col-lg-6">
                                    <div class="card mb-6">
                                        <h4 class="card-header text-black-100">Dashboard :-</h4>
                                        <div class="card-body">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input cursor-pointer"
                                                    @if (isset($role)) {{ in_array(1, $rolePermissions) ? 'checked' : false }} @else {{ 'checked' }} @endif
                                                    name="permission[]" type="checkbox" value="Dashboard List"
                                                    id="dashboard-list">
                                                <label for="dashboard-list" class="form-check-label">List </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="card mb-6">
                                        <h4 class="card-header text-black-100">Admin :-</h4>
                                        <div class="card-body">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input cursor-pointer"
                                                    {{ in_array(83, $rolePermissions) ? 'checked' : false }}
                                                    name="permission[]" type="checkbox" value="Admin List"
                                                    id="admin-list">
                                                <label for="admin-list" class="form-check-label">List</label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input cursor-pointer"
                                                    {{ in_array(103, $rolePermissions) ? 'checked' : false }}
                                                    name="permission[]" type="checkbox" value="Assets Create"
                                                    id="Assets Create">
                                                <label for="Assets Create" class="form-check-label">Create</label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input cursor-pointer"
                                                    {{ in_array(104, $rolePermissions) ? 'checked' : false }}
                                                    name="permission[]" type="checkbox" value="Assets Edit"
                                                    id="Assets Edit">
                                                <label for="Assets Edit" class="form-check-label">Edit</label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input cursor-pointer"
                                                    {{ in_array(105, $rolePermissions) ? 'checked' : false }}
                                                    name="permission[]" type="checkbox" value="Assets Delete"
                                                    id="Assets Delete">
                                                <label for="Assets Delete" class="form-check-label">Delete</label>
                                            </div>

                                            <h5 class="text-capitalize py-3 border-top mt-2">Roles</h5>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input  cursor-pointer"
                                                    {{ in_array(47, $rolePermissions) ? 'checked' : false }}
                                                    name="permission[]" type="checkbox" value="Roles List"
                                                    id="roles-list">
                                                <label for="roles-list" class="form-check-label">List</label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input  cursor-pointer"
                                                    {{ in_array(48, $rolePermissions) ? 'checked' : false }}
                                                    name="permission[]" type="checkbox" value="Roles Create"
                                                    id="roles-create">
                                                <label for="roles-create" class="form-check-label">Create</label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input  cursor-pointer"
                                                    {{ in_array(49, $rolePermissions) ? 'checked' : false }}
                                                    name="permission[]" type="checkbox" value="Roles Edit"
                                                    id="roles-edit">
                                                <label for="roles-edit" class="form-check-label">Edit</label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input cursor-pointer"
                                                    {{ in_array(50, $rolePermissions) ? 'checked' : false }}
                                                    name="permission[]" type="checkbox" value="Roles Delete"
                                                    id="roles-delete">
                                                <label for="roles-delete" class="form-check-label">Delete</label>
                                            </div>

                                            <h5 class="text-capitalize py-3 border-top mt-2">User</h5>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input  cursor-pointer"
                                                    {{ in_array(2, $rolePermissions) ? 'checked' : false }}
                                                    name="permission[]" type="checkbox" value="User List"
                                                    id="user-list">
                                                <label for="user-list" class="form-check-label">List</label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input  cursor-pointer"
                                                    {{ in_array(3, $rolePermissions) ? 'checked' : false }}
                                                    name="permission[]" type="checkbox" value="User Create"
                                                    id="user-create">
                                                <label for="user-create" class="form-check-label">Create</label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input  cursor-pointer"
                                                    {{ in_array(4, $rolePermissions) ? 'checked' : false }}
                                                    name="permission[]" type="checkbox" value="User Edit"
                                                    id="user-edit">
                                                <label for="user-edit" class="form-check-label">Edit</label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input  cursor-pointer"
                                                    {{ in_array(5, $rolePermissions) ? 'checked' : false }}
                                                    name="permission[]" type="checkbox" value="User Delete"
                                                    id="user-delete">
                                                <label for="user-delete" class="form-check-label">Delete</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </div>
                <div class="card-footer text-end">
                    <a href="{{ url('/admin/roles') }}" class="btn btn-neutral">Cancel</a>
                    {{ Form::submit('Submit', ['class' => 'btn btn-primary ms-2']) }}
                </div>
                {{ Form::close() }}
            </div>
        </div>
        <!-- /content area -->
        @include('layouts.admin.page_footer')
    </div>
@endsection
