@extends('layouts.admin.master')
@section('title', 'Dashboard')
@section('content')
@section('module_title', 'Dashboard')

<div class="content-wrapper">
    <div class="content">
        <div class="row gy-6 pb-6">
            <div class="col-xxl-3 col-sm-6">
                <a href="">
                    <div class="card h-full">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h6 class="font-bold text-muted text-sm mb-2">Inquiry</h6>
                                    <span class="h3 font-bold mb-0">{{ 0 }}</span>
                                </div>
                                <div class="col-auto">
                                    <div
                                        class="bg-tertiary text-white text-xl rounded-circle h-12 w-12 hstack justify-content-center">
                                        <i class="bi bi-calendar-check"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xxl-3 col-sm-6">
                <a href="">
                    <div class="card h-full">
                        <div class="card-body row gx-0">
                            <div class="col">
                                <h6 class="font-bold text-muted text-sm mb-2">Designing</h6>
                                <span class="h3 font-bold mb-0">0</span>
                            </div>
                            <div class="col-auto">
                                <div
                                    class="bg-warning text-white text-xl rounded-circle h-12 w-12 hstack justify-content-center">
                                    <i class="bi bi-clock-history text-lg"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xxl-3 col-sm-6">
                <a href="">
                    <div class="card h-full">
                        <div class="card-body row gx-0">
                            <div class="col">
                                <h6 class="font-bold text-muted text-sm mb-2">Complete</h6>
                                <span class="h3 font-bold mb-0">0</span>
                            </div>
                            <div class="col-auto">
                                <div
                                    class="bg-primary text-white text-xl rounded-circle h-12 w-12 hstack justify-content-center">
                                    <i class="bi bi-people text-lg"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xxl-3 col-sm-6">
                <a href="">
                    <div class="card h-full">
                        <div class="card-body row gx-0">
                            <div class="col">
                                <h6 class="font-bold text-muted text-sm mb-2">Pending</h6>
                                <span class="h3 font-bold mb-0">0</span>
                            </div>
                            <div class="col-auto">
                                <div
                                    class="bg-info text-white text-xl rounded-circle h-12 w-12 hstack justify-content-center">
                                    <i class="bi bi-journal-text text-lg"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
