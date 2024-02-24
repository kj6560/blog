@extends('layouts.admin')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="content-wrapper">
        <!-- Responsive Table -->
        <div class="card">
            <h5 class="card-header">Site Settings</h5>
            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead>
                        <tr class="text-nowrap">
                            <th>Settings Id</th>
                            <th>Settings Name</th>
                            <th>Settings Value</th>
                            <th>Settings Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($settings as $setting)
                        <tr>
                            <th scope="row">{{$setting->id}}</th>
                            <td>{{$setting->key}}</td>
                            <td>{{$setting->value}}</td>
                            <td>{{$setting->status ==1?"Active":"InActive"}}</td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="/dashboard/editSiteSettings/{{$setting->id}}"><i class="bx bx-edit-alt me-2"></i> Edit</a>
                                        <a class="dropdown-item" href="/dashboard/deletesetting/{{$setting->id}}"><i class="bx bx-trash me-2"></i> Delete</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <!--/ Responsive Table -->
    </div>
</div>
@stop