@extends('layouts.admin.master')
@section('title', isset($role) ? 'Edit Roles' : 'Add Roles')
@section('module_title', 'Admin')
@section('content')
    <div class="content-wrapper">
        @include('layouts.admin.page_header', [
            'breadcrumb' => [route('employees.index') => 'Admin', route('roles.index') => 'Roles'],
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
                                        <h4 class="card-header bg-gray-100">Dashboard :-</h4>
                                        <div class="card-body">
                                            <!-- <h5 class="text-capitalize">Dashboard</h5> -->
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input cursor-pointer"
                                                    @if (isset($role)) {{ in_array(1, $rolePermissions) ? 'checked' : false }} @else {{ 'checked' }} @endif
                                                    name="permission[]" type="checkbox" value="Dashboard List"
                                                    id="dashboard-list">
                                                <label for="dashboard-list" class="form-check-label">List </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card mb-6">
                                        <h4 class="card-header bg-gray-100">HR :-</h4>
                                        <div class="card-body">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input cursor-pointer" {{ in_array(99, $rolePermissions) ? "checked" : false }} name="permission[]" type="checkbox" value="Recruitment Pipeline" id="recruitment pipeline">
                                                <label for="recruitment pipeline" class="form-check-label">Recruitment Pipeline </label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input cursor-pointer" {{ in_array(73, $rolePermissions) ? "checked" : false }} name="permission[]" type="checkbox" value="Hr List" id="hr-list">
                                                <label for="hr-list" class="form-check-label">List </label>
                                            </div>
                                            <h5 class="text-capitalize py-3 border-top mt-2">Candidates</h5>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input cursor-pointer" {{ in_array(55, $rolePermissions) ? "checked" : false }} name="permission[]" type="checkbox" value="Candidates List" id="candidates-list">
                                                <label for="candidates-list" class="form-check-label">List</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input cursor-pointer" {{ in_array(97, $rolePermissions) ? "checked" : false }} name="permission[]" type="checkbox" value="Candidates Create" id="candidates-create">
                                                <label for="candidates-create" class="form-check-label">Create</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input cursor-pointer" {{ in_array(98, $rolePermissions) ? "checked" : false }} name="permission[]" type="checkbox" value="Candidates Edit" id="candidates-update">
                                                <label for="candidates-update" class="form-check-label">Update</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input cursor-pointer" {{ in_array(56, $rolePermissions) ? "checked" : false }} name="permission[]" type="checkbox" value="Candidates Delete" id="candidates-delete">
                                                <label for="candidates-delete" class="form-check-label">Delete</label>
                                            </div>
                                            <h5 class="text-capitalize py-3 border-top mt-2">Careers</h5>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input cursor-pointer" {{ in_array(51, $rolePermissions) ? "checked" : false }} name="permission[]" type="checkbox" value="Careers List" id="careers-list">
                                                <label for="careers-list" class="form-check-label">List</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input cursor-pointer" {{ in_array(52, $rolePermissions) ? "checked" : false }} name="permission[]" type="checkbox" value="Careers Create" id="careers-create">
                                                <label for="careers-create" class="form-check-label">Create</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input cursor-pointer" {{ in_array(53, $rolePermissions) ? "checked" : false }} name="permission[]" type="checkbox" value="Careers Edit" id="careers-edit">
                                                <label for="careers-edit" class="form-check-label">Edit</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input cursor-pointer" {{ in_array(54, $rolePermissions) ? "checked" : false }} name="permission[]" type="checkbox" value="Careers Delete" id="careers-delete">
                                                <label for="careers-delete" class="form-check-label">Delete</label>
                                            </div>
                                            <h5 class="text-capitalize py-3 border-top mt-2">Hire Developers</h5>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input cursor-pointer" {{ in_array(57, $rolePermissions) ? "checked" : false }} name="permission[]" type="checkbox" value="Hire Developers List" id="hire-developers-list">
                                                <label for="hire-developers-list" class="form-check-label">List</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input cursor-pointer" {{ in_array(58, $rolePermissions) ? "checked" : false }} name="permission[]" type="checkbox" value="Hire Developers Create" id="hire-developers-create">
                                                <label for="hire-developers-create" class="form-check-label">Create</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input cursor-pointer" {{ in_array(59, $rolePermissions) ? "checked" : false }} name="permission[]" type="checkbox" value="Hire Developers Edit" id="hire-developers-edit">
                                                <label for="hire-developers-edit" class="form-check-label">Edit</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input  cursor-pointer" {{ in_array(60, $rolePermissions) ? "checked" : false }} name="permission[]" type="checkbox" value="Hire Developers Delete" id="hire-developers-delete">
                                                <label for="hire-developers-delete" class="form-check-label">Delete</label>
                                            </div>
                                            <h5 class="text-capitalize  py-3 border-top mt-2">Request A Quote</h5>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input  cursor-pointer" {{ in_array(39, $rolePermissions) ? "checked" : false }} name="permission[]" type="checkbox" value="Request A Quote List" id="request-a-quote-list">
                                                <label for="request-a-quote-list" class="form-check-label">List</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input  cursor-pointer" {{ in_array(40, $rolePermissions) ? "checked" : false }} name="permission[]" type="checkbox" value="Request A Quote Create" id="request-a-quote-create">
                                                <label for="request-a-quote-create" class="form-check-label">Create</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input  cursor-pointer" {{ in_array(41, $rolePermissions) ? "checked" : false }} name="permission[]" type="checkbox" value="Request A Quote Edit" id="request-a-quote-edit">
                                                <label for="request-a-quote-edit" class="form-check-label">Edit</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input  cursor-pointer" {{ in_array(42, $rolePermissions) ? "checked" : false }} name="permission[]" type="checkbox" value="Request A Quote Delete" id="request-a-quote-delete">
                                                <label for="request-a-quote-delete" class="form-check-label">Delete</label>
                                            </div>
                                            <h5 class="text-capitalize  py-3 border-top mt-2">Emails</h5>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input  cursor-pointer" {{ in_array(109, $rolePermissions) ? "checked" : false }} name="permission[]" type="checkbox" value="Mails List" id="mails-list">
                                                <label for="mails-list" class="form-check-label">List</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input  cursor-pointer" {{ in_array(111, $rolePermissions) ? "checked" : false }} name="permission[]" type="checkbox" value="Mails Create" id="mails-create">
                                                <label for="mails-create" class="form-check-label">Create</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input  cursor-pointer" {{ in_array(110, $rolePermissions) ? "checked" : false }} name="permission[]" type="checkbox" value="Mails Edit" id="mails-edit">
                                                <label for="mails-edit" class="form-check-label">Edit</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input  cursor-pointer" {{ in_array(113, $rolePermissions) ? "checked" : false }} name="permission[]" type="checkbox" value="Mails Delete" id="mails-delete">
                                                <label for="mails-delete" class="form-check-label">Delete</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input  cursor-pointer" {{ in_array(112, $rolePermissions) ? "checked" : false }} name="permission[]" type="checkbox" value="Confirmation Mail" id="confirmation-mail">
                                                <label for="confirmation-mail" class="form-check-label">Mail Template</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card mb-6">
                                        <h4 class="card-header bg-gray-100">Leaves :-</h4>
                                        <div class="card-body">
                                            <h5 class="text-capitalize mb-3">Leaves</h5>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input  cursor-pointer"
                                                    {{ in_array(66, $rolePermissions) ? 'checked' : false }}
                                                    name="permission[]" type="checkbox" value="Leaves List"
                                                    id="leaves-list" id="leave-list">
                                                <label for="leave-list" class="form-check-label"
                                                    for="leaves-list">List</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input  cursor-pointer"
                                                    {{ in_array(7, $rolePermissions) ? 'checked' : false }}
                                                    name="permission[]" type="checkbox" value="Approved Leave List"
                                                    id="approved-leave-list">
                                                <label for="approved-leave-list" class="form-check-label">Approved Leave
                                                    List</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input  cursor-pointer"
                                                    {{ in_array(6, $rolePermissions) ? 'checked' : false }}
                                                    name="permission[]" type="checkbox" value="Pending Leave List"
                                                    id="pending-leave-list">
                                                <label for="pending-leave-list" class="form-check-label">Pending Leave
                                                    List</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input  cursor-pointer"
                                                    {{ in_array(8, $rolePermissions) ? 'checked' : false }}
                                                    name="permission[]" type="checkbox" value="Rejected Leave List"
                                                    id="rejected-leave-list">
                                                <label for="rejected-leave-list" class="form-check-label">Rejected Leave
                                                    List</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input  cursor-pointer"
                                                    {{ in_array(81, $rolePermissions) ? 'checked' : false }}
                                                    name="permission[]" type="checkbox" value="Canceled Leave List"
                                                    id="canceled-leave-list">
                                                <label for="canceled-leave-list" class="form-check-label">Canceled Leave
                                                    List</label>
                                            </div>
                                            <h5 class="text-capitalize py-3 border-top mt-2">Leave Type</h5>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input  cursor-pointer"
                                                    {{ in_array(9, $rolePermissions) ? 'checked' : false }}
                                                    name="permission[]" type="checkbox" value="Leave Type List"
                                                    id="leave-type-list">
                                                <label for="leave-type-list" class="form-check-label">List</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input  cursor-pointer"
                                                    {{ in_array(10, $rolePermissions) ? 'checked' : false }}
                                                    name="permission[]" type="checkbox" value="Leave Type Create"
                                                    id="leave-type-create">
                                                <label for="leave-type-create" class="form-check-label">Create</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input  cursor-pointer"
                                                    {{ in_array(11, $rolePermissions) ? 'checked' : false }}
                                                    name="permission[]" type="checkbox" value="Leave Type Edit"
                                                    id="leave-type-edit">
                                                <label for="leave-type-edit" class="form-check-label">Edit</label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input  cursor-pointer"
                                                    {{ in_array(12, $rolePermissions) ? 'checked' : false }}
                                                    name="permission[]" type="checkbox" value="Leave Type Delete"
                                                    id="leave-type-delete">
                                                <label for="leave-type-delete" class="form-check-label">Delete</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input  cursor-pointer"
                                                    {{ in_array(82, $rolePermissions) ? 'checked' : false }}
                                                    name="permission[]" type="checkbox" value="Leave Analytic List"
                                                    id="leave-analytic-list">
                                                <label for="leave-analytic-list" class="form-check-label">Leave Analytic
                                                    List</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input  cursor-pointer"
                                                    {{ in_array(84, $rolePermissions) ? 'checked' : false }}
                                                    name="permission[]" type="checkbox" value="Leave History List"
                                                    id="leave-history-list">
                                                <label for="leave-history-list" class="form-check-label">Leave History
                                                    List</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card mb-6">
                                        <h4 class="card-header bg-gray-100">Sales :-</h4>
                                        <div class="card-body">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input  cursor-pointer"
                                                    {{ in_array(74, $rolePermissions) ? 'checked' : false }}
                                                    name="permission[]" type="checkbox" value="Sales List"
                                                    id="sales-list">
                                                <label for="sales-list" class="form-check-label">List</label>
                                            </div>
                                            <h5 class="text-capitalize py-3 border-top mt-2">Sales Contacts</h5>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input  cursor-pointer"
                                                    {{ in_array(77, $rolePermissions) ? 'checked' : false }}
                                                    name="permission[]" type="checkbox" value="Sales Contacts List"
                                                    id="sales-contacts-list">
                                                <label for="sales-contacts-list" class="form-check-label">List</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input  cursor-pointer"
                                                    {{ in_array(78, $rolePermissions) ? 'checked' : false }}
                                                    name="permission[]" type="checkbox" value="Sales Contacts Create"
                                                    id="sales-contacts-create">
                                                <label for="sales-contacts-create" class="form-check-label">Create</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input  cursor-pointer"
                                                    {{ in_array(79, $rolePermissions) ? 'checked' : false }}
                                                    name="permission[]" type="checkbox" value="Sales Contacts Edit"
                                                    id="sales-contacts-edit">
                                                <label for="sales-contacts-edit" class="form-check-label">Edit</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input  cursor-pointer"
                                                    {{ in_array(80, $rolePermissions) ? 'checked' : false }}
                                                    name="permission[]" type="checkbox" value="Sales Contacts Delete"
                                                    id="sales-contacts-delete">
                                                <label for="sales-contacts-delete" class="form-check-label">Delete</label>
                                            </div>

                                            <h5 class="text-capitalize py-3 border-top mt-2">Consultation Inquiry</h5>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input  cursor-pointer"
                                                    {{ in_array(106, $rolePermissions) ? 'checked' : false }}
                                                    name="permission[]" type="checkbox"
                                                    value="Consultations Inquiries List" id="Consultation-list">
                                                <label for="Consultation-list" class="form-check-label">List</label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input cursor-pointer"
                                                    {{ in_array(107, $rolePermissions) ? 'checked' : false }}
                                                    name="permission[]" type="checkbox"
                                                    value="Consultations Inquiries Delete" id="Consultations-delete">
                                                <label for="Consultations-delete" class="form-check-label">Delete</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card mb-6">
                                        <h4 class="card-header bg-gray-100">Users :-</h4>
                                        <div class="card-body">
                                            <h5 class="text-capitalize pb-3">User Leave</h5>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input  cursor-pointer"
                                                    {{ in_array(62, $rolePermissions) ? 'checked' : false }}
                                                    name="permission[]" type="checkbox" value="User Leaves List"
                                                    id="user-leaves-list">
                                                <label for="user-leaves-list" class="form-check-label">List</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input  cursor-pointer"
                                                    {{ in_array(63, $rolePermissions) ? 'checked' : false }}
                                                    name="permission[]" type="checkbox" value="User Leaves Create"
                                                    id="user-leaves-create">
                                                <label for="user-leaves-create" class="form-check-label">Create</label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input  cursor-pointer"
                                                    {{ in_array(64, $rolePermissions) ? 'checked' : false }}
                                                    name="permission[]" type="checkbox" value="User Leaves Edit"
                                                    id="user-leaves-edit">
                                                <label for="user-leaves-edit" class="form-check-label">Edit</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input  cursor-pointer"
                                                    {{ in_array(65, $rolePermissions) ? 'checked' : false }}
                                                    name="permission[]" type="checkbox" value="User Leaves Delete"
                                                    id="user-leaves-delete">
                                                <label for="user-leaves-delete" class="form-check-label">Delete</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card mb-6">
                                        <h4 class="card-header bg-gray-100">Contact us :-</h4>
                                        <div class="card-body">
                                            <h5 class="text-capitalize pb-3">Contact us</h5>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input  cursor-pointer"
                                                    {{ in_array(13, $rolePermissions) ? 'checked' : false }}
                                                    name="permission[]" type="checkbox" value="Contact Us List"
                                                    id="contact-us-list">
                                                <label for="contact-us-list" class="form-check-label">List</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input  cursor-pointer"
                                                    {{ in_array(14, $rolePermissions) ? 'checked' : false }}
                                                    name="permission[]" type="checkbox" value="Contact Us Delete"
                                                    id="contact-us-delete">
                                                <label for="contact-us-delete" class="form-check-label">Delete</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <h4 class="card-header bg-gray-100">PMS</h4>
                                        <div class="card-body">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input cursor-pointer"
                                                    {{ in_array(89, $rolePermissions) ? 'checked' : false }}
                                                    name="permission[]" type="checkbox" value="Pms List" id="pms-list">
                                                <label for="pms-list" class="form-check-label">List</label>
                                            </div>
                                            <h5 class="text-capitalize py-3 border-top mt-2">Project</h5>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input cursor-pointer"
                                                    {{ in_array(90, $rolePermissions) ? 'checked' : false }}
                                                    name="permission[]" type="checkbox" value="Projects List"
                                                    id="project-list">
                                                <label for="project-list" class="form-check-label">List</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input cursor-pointer"
                                                    {{ in_array(91, $rolePermissions) ? 'checked' : false }}
                                                    name="permission[]" type="checkbox" value="Projects Create"
                                                    id="project-create">
                                                <label for="project-create" class="form-check-label">Create</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input cursor-pointer"
                                                    {{ in_array(92, $rolePermissions) ? 'checked' : false }}
                                                    name="permission[]" type="checkbox" value="Projects Edit"
                                                    id="project-edit">
                                                <label for="project-edit" class="form-check-label">Edit</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input cursor-pointer"
                                                    {{ in_array(93, $rolePermissions) ? 'checked' : false }}
                                                    name="permission[]" type="checkbox" value="Projects Delete"
                                                    id="project-delete">
                                                <label for="project-delete" class="form-check-label">Delete</label>
                                            </div>
                                            <h5 class="text-capitalize py-3 border-top mt-2">Project Hours</h5>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input cursor-pointer"
                                                    {{ in_array(94, $rolePermissions) ? 'checked' : false }}
                                                    name="permission[]" type="checkbox" value="Project Hours List"
                                                    id="project-hours-list">
                                                <label for="project-hours-list" class="form-check-label">List</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input cursor-pointer"
                                                    {{ in_array(95, $rolePermissions) ? 'checked' : false }}
                                                    name="permission[]" type="checkbox" value="Project Hours Create"
                                                    id="project-hours-create">
                                                <label for="project-hours-create" class="form-check-label">Create</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input cursor-pointer"
                                                    {{ in_array(96, $rolePermissions) ? 'checked' : false }}
                                                    name="permission[]" type="checkbox" value="Project Hours Edit"
                                                    id="project-hours-edit">
                                                <label for="project-hours-edit" class="form-check-label">Edit</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input cursor-pointer"
                                                    {{ in_array(101, $rolePermissions) ? 'checked' : false }}
                                                    name="permission[]" type="checkbox" value="Project Hours Delete"
                                                    id="project-hours-delete">
                                                <label for="project-hours-delete" class="form-check-label">Delete</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input cursor-pointer"
                                                    {{ in_array(114, $rolePermissions) ? 'checked' : false }}
                                                    name="permission[]" type="checkbox" value="Project Hours Export"
                                                    id="project-hours-export">
                                                <label for="project-hours-export" class="form-check-label">Export</label>
                                            </div>
                                            <h5 class="text-capitalize py-3 border-top mt-2">Employee Sheet</h5>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input cursor-pointer"
                                                    {{ in_array(100, $rolePermissions) ? 'checked' : false }}
                                                    name="permission[]" type="checkbox" value="Employee Sheet"
                                                    id="employee-sheet">
                                                <label for="employee-sheet" class="form-check-label">List</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="card mb-6">
                                        <h4 class="card-header bg-gray-100">Admin :-</h4>
                                        <div class="card-body">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input cursor-pointer"
                                                    {{ in_array(83, $rolePermissions) ? 'checked' : false }}
                                                    name="permission[]" type="checkbox" value="Admin List"
                                                    id="admin-list">
                                                <label for="admin-list" class="form-check-label">List</label>
                                            </div>

                                            <h5 class="text-capitalize py-3 border-top mt-2">Employee Email Track
                                                Unsubscribe</h5>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input cursor-pointer"
                                                    {{ in_array(70, $rolePermissions) ? 'checked' : false }}
                                                    name="permission[]" type="checkbox"
                                                    value="Employee Email Track Unsubscribe List"
                                                    id="employee-email-track-unsubscribe-list">
                                                <label for="employee-email-track-unsubscribe-list"
                                                    class="form-check-label">List</label>
                                            </div>

                                            <h5 class="text-capitalize py-3 border-top mt-2">Company Assets</h5>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input cursor-pointer"
                                                    {{ in_array(102, $rolePermissions) ? 'checked' : false }}
                                                    name="permission[]" type="checkbox" value="Assets List"
                                                    id="Assets List">
                                                <label for="Assets List" class="form-check-label">List</label>
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

                                            <h5 class="text-capitalize py-3 border-top mt-2">Employee Track Email</h5>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input  cursor-pointer"
                                                    {{ in_array(69, $rolePermissions) ? 'checked' : false }}
                                                    name="permission[]" type="checkbox" value="Employee Track Email List"
                                                    id="employee-track-email-list">
                                                <label for="employee-track-email-list"
                                                    class="form-check-label">List</label>
                                            </div>


                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input cursor-pointer"
                                                    {{ in_array(71, $rolePermissions) ? 'checked' : false }}
                                                    name="permission[]" type="checkbox"
                                                    value="Employee Track Email Details"
                                                    id="employee-track-email-details">
                                                <label for="employee-track-email-details"
                                                    class="form-check-label">Details</label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input cursor-pointer"
                                                    {{ in_array(72, $rolePermissions) ? 'checked' : false }}
                                                    name="permission[]" type="checkbox"
                                                    value="Employee Track Email Specific Email Data"
                                                    id="employee-track-email-specific-email-data">
                                                <label for="employee-track-email-specific-email-data"
                                                    class="form-check-label">Specific Email Data</label>
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

                                            <h5 class="text-capitalize py-3 border-top mt-2">Salary Slip</h5>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input  cursor-pointer"
                                                    {{ in_array(67, $rolePermissions) ? 'checked' : false }}
                                                    name="permission[]" type="checkbox" value="Salary Slip List"
                                                    id="salary-slip-list">
                                                <label for="salary-slip-list" class="form-check-label">List</label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input cursor-pointer"
                                                    {{ in_array(68, $rolePermissions) ? 'checked' : false }}
                                                    name="permission[]" type="checkbox" value="Salary Slip Download"
                                                    id="salary-slip-download">
                                                <label for="salary-slip-download"
                                                    class="form-check-label">Download</label>
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
                                    <div class="card mb-6">
                                        <h4 class="card-header bg-gray-100">Marketing :-</h4>
                                        <div class="card-body">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input  cursor-pointer"
                                                    {{ in_array(75, $rolePermissions) ? 'checked' : false }}
                                                    name="permission[]" type="checkbox" value="Marketing List"
                                                    id="marketing-list">
                                                <label for="marketing-list" class="form-check-label">List</label>
                                            </div>
                                            <h5 class="text-capitalize py-3 border-top mt-2">Area We Serve</h5>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input  cursor-pointer"
                                                    {{ in_array(43, $rolePermissions) ? 'checked' : false }}
                                                    name="permission[]" type="checkbox" value="Area We Serve List"
                                                    id="area-we-serve-list">
                                                <label for="area-we-serve-list" class="form-check-label">List</label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input  cursor-pointer"
                                                    {{ in_array(44, $rolePermissions) ? 'checked' : false }}
                                                    name="permission[]" type="checkbox" value="Area We Serve Create"
                                                    id="area-we-serve-create">
                                                <label for="area-we-serve-create" class="form-check-label">Create</label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input  cursor-pointer"
                                                    {{ in_array(45, $rolePermissions) ? 'checked' : false }}
                                                    name="permission[]" type="checkbox" value="Area We Serve Edit"
                                                    id="area-we-serve-edit">
                                                <label for="area-we-serve-edit" class="form-check-label">Edit</label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input  cursor-pointer"
                                                    {{ in_array(46, $rolePermissions) ? 'checked' : false }}
                                                    name="permission[]" type="checkbox" value="Area We Serve Delete"
                                                    id="area-we-serve-delete">
                                                <label for="area-we-serve-delete" class="form-check-label">Delete</label>
                                            </div>

                                            <h5 class="text-capitalize py-3 border-top mt-2">Blogs</h5>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input  cursor-pointer"
                                                    {{ in_array(31, $rolePermissions) ? 'checked' : false }}
                                                    name="permission[]" type="checkbox" value="Blogs List"
                                                    id="blogs-list">
                                                <label for="blogs-list" class="form-check-label">List</label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input  cursor-pointer"
                                                    {{ in_array(32, $rolePermissions) ? 'checked' : false }}
                                                    name="permission[]" type="checkbox" value="Blogs Create"
                                                    id="blogs-create">
                                                <label for="blogs-create" class="form-check-label">Create</label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input  cursor-pointer"
                                                    {{ in_array(33, $rolePermissions) ? 'checked' : false }}
                                                    name="permission[]" type="checkbox" value="Blogs Edit"
                                                    id="blogs-edit">
                                                <label for="blogs-edit" class="form-check-label">Edit</label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input  cursor-pointer"
                                                    {{ in_array(34, $rolePermissions) ? 'checked' : false }}
                                                    name="permission[]" type="checkbox" value="Blogs Delete"
                                                    id="blogs-delete">
                                                <label for="blogs-delete" class="form-check-label">Delete</label>
                                            </div>

                                            <h5 class="text-capitalize py-3 border-top mt-2">Categories</h5>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input  cursor-pointer"
                                                    {{ in_array(23, $rolePermissions) ? 'checked' : false }}
                                                    name="permission[]" type="checkbox" value="Categories List"
                                                    id="categories-list">
                                                <label for="categories-list" class="form-check-label">List</label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input  cursor-pointer"
                                                    {{ in_array(24, $rolePermissions) ? 'checked' : false }}
                                                    name="permission[]" type="checkbox" value="Categories Create"
                                                    id="categories-create">
                                                <label for="categories-create" class="form-check-label">Create</label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input  cursor-pointer"
                                                    {{ in_array(25, $rolePermissions) ? 'checked' : false }}
                                                    name="permission[]" type="checkbox" value="Categories Edit"
                                                    id="categories-edit">
                                                <label for="categories-edit" class="form-check-label">Edit</label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input  cursor-pointer"
                                                    {{ in_array(26, $rolePermissions) ? 'checked' : false }}
                                                    name="permission[]" type="checkbox" value="Categories Delete"
                                                    id="categories-delete">
                                                <label for="categories-delete" class="form-check-label">Delete</label>
                                            </div>

                                            <h5 class="text-capitalize py-3 border-top mt-2">Life At Techvoot</h5>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input  cursor-pointer"
                                                    {{ in_array(35, $rolePermissions) ? 'checked' : false }}
                                                    name="permission[]" type="checkbox" value="Life At Techvoot List"
                                                    id="life-at-techvoot-list">
                                                <label for="life-at-techvoot-list" class="form-check-label">List</label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input  cursor-pointer"
                                                    {{ in_array(36, $rolePermissions) ? 'checked' : false }}
                                                    name="permission[]" type="checkbox" value="Life At Techvoot Create"
                                                    id="life-at-techvoot-create">
                                                <label for="life-at-techvoot-create"
                                                    class="form-check-label">Create</label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input  cursor-pointer"
                                                    {{ in_array(37, $rolePermissions) ? 'checked' : false }}
                                                    name="permission[]" type="checkbox" value="Life At Techvoot Edit"
                                                    id="life-at-techvoot-edit">
                                                <label for="life-at-techvoot-edit" class="form-check-label">Edit</label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input  cursor-pointer"
                                                    {{ in_array(38, $rolePermissions) ? 'checked' : false }}
                                                    name="permission[]" type="checkbox" value="Life At Techvoot Delete"
                                                    id="life-at-techvoot-delete">
                                                <label for="life-at-techvoot-delete"
                                                    class="form-check-label">Delete</label>
                                            </div>

                                            <h5 class="text-capitalize py-3 border-top mt-2">Tags</h5>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input  cursor-pointer"
                                                    {{ in_array(27, $rolePermissions) ? 'checked' : false }}
                                                    name="permission[]" type="checkbox" value="Tags List"
                                                    id="tags-list">
                                                <label for="tags-list" class="form-check-label">List</label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input  cursor-pointer"
                                                    {{ in_array(28, $rolePermissions) ? 'checked' : false }}
                                                    name="permission[]" type="checkbox" value="Tags Create"
                                                    id="tags-create">
                                                <label for="tags-create" class="form-check-label">Create</label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input  cursor-pointer"
                                                    {{ in_array(29, $rolePermissions) ? 'checked' : false }}
                                                    name="permission[]" type="checkbox" value="Tags Edit"
                                                    id="tags-edit">
                                                <label for="tags-edit" class="form-check-label">Edit</label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input  cursor-pointer"
                                                    {{ in_array(30, $rolePermissions) ? 'checked' : false }}
                                                    name="permission[]" type="checkbox" value="Tags Delete"
                                                    id="tags-delete">
                                                <label for="tags-delete" class="form-check-label">Delete</label>
                                            </div>

                                            <h5 class="text-capitalize py-3 border-top mt-2">Technologies</h5>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input  cursor-pointer"
                                                    {{ in_array(19, $rolePermissions) ? 'checked' : false }}
                                                    name="permission[]" type="checkbox" value="Technologies List"
                                                    id="technologies-list">
                                                <label for="technologies-list" class="form-check-label">List</label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input  cursor-pointer"
                                                    {{ in_array(20, $rolePermissions) ? 'checked' : false }}
                                                    name="permission[]" type="checkbox" value="Technologies Create"
                                                    id="technologies-create">
                                                <label for="technologies-create" class="form-check-label">Create</label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input  cursor-pointer"
                                                    {{ in_array(21, $rolePermissions) ? 'checked' : false }}
                                                    name="permission[]" type="checkbox" value="Technologies Edit"
                                                    id="technologies-edit">
                                                <label for="technologies-edit" class="form-check-label">Edit</label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input  cursor-pointer"
                                                    {{ in_array(22, $rolePermissions) ? 'checked' : false }}
                                                    name="permission[]" type="checkbox" value="Technologies Delete"
                                                    id="technologies-delete">
                                                <label for="technologies-delete" class="form-check-label">Delete</label>
                                            </div>

                                            <h5 class="text-capitalize py-3 border-top mt-2">Testimonials</h5>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input  cursor-pointer"
                                                    {{ in_array(15, $rolePermissions) ? 'checked' : false }}
                                                    name="permission[]" type="checkbox" value="Testimonials List"
                                                    id="testimonials-list">
                                                <label for="testimonials-list" class="form-check-label">List</label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input  cursor-pointer"
                                                    {{ in_array(16, $rolePermissions) ? 'checked' : false }}
                                                    name="permission[]" type="checkbox" value="Testimonials Create"
                                                    id="testimonials-create">
                                                <label for="testimonials-create" class="form-check-label">Create</label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input cursor-pointer"
                                                    {{ in_array(17, $rolePermissions) ? 'checked' : false }}
                                                    name="permission[]" type="checkbox" value="Testimonials Edit"
                                                    id="testimonials-edit">
                                                <label for="testimonials-edit" class="form-check-label">Edit</label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input cursor-pointer"
                                                    {{ in_array(18, $rolePermissions) ? 'checked' : false }}
                                                    name="permission[]" type="checkbox" value="Testimonials Delete"
                                                    id="testimonials-delete">
                                                <label for="testimonials-delete" class="form-check-label">Delete</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card mb-6">
                                        <h4 class="card-header bg-gray-100">Leave Calender :-</h4>
                                        <div class="card-body">
                                            <h5 class="text-capitalize pb-3">Leave Calendar</h5>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input cursor-pointer"
                                                    {{ in_array(76, $rolePermissions) ? 'checked' : false }}
                                                    name="permission[]" type="checkbox" value="Leave Calendar List"
                                                    id="leave-calender-list">
                                                <label for="leave-calender-list" class="form-check-label">List</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <h4 class="card-header bg-gray-100">News Letters :-</h4>
                                        <div class="card-body">
                                            <h5 class="text-capitalize pb-3">News Letters</h5>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input cursor-pointer"
                                                    {{ in_array(61, $rolePermissions) ? 'checked' : false }}
                                                    name="permission[]" type="checkbox" id="news-letter"
                                                    value="News Letters List">
                                                <label for="news-letter" class="form-check-label">List</label>
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
