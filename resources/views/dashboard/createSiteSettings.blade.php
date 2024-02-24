@extends('layouts.admin')
@section('content')
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="col-xl-6">
            <div class="row">
                <!-- HTML5 Inputs -->
                <form action="/dashboard/storeSiteSettings" enctype="multipart/form-data"  method="POST">
                    @csrf
                    <div class="card mb-4">
                        <h5 class="card-header">Create Site Settings</h5>

                        <input class="form-control" type="text" name="id" value="{{isset($setting) && $setting->id?$setting->id:''}}" hidden id="html5-text-input" />


                        <div class="card-body">
                            
                            <div class="mb-3 row">
                                <label for="html5-text-input" class="col-md-2 col-form-label">Name</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" name="key" value="{{isset($setting) && $setting->key?$setting->key:''}}" placeholder="Enter setting Name" id="html5-text-input" />
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="html5-text-input" class="col-md-2 col-form-label">Value</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" name="value"  value="{{isset($setting) && $setting->value?$setting->value:''}}" id="html5-text-input" />
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="html5-text-input" class="col-md-2 col-form-label">Description</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" name="description"  value="{{isset($setting) && $setting->description?$setting->description:''}}" id="html5-text-input" />
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="exampleFormControlSelect1" class="form-label">Select Status</label>
                                <select class="form-select" id="exampleFormControlSelect1" aria-label="Select Status" name="status">
                                    <option selected>Select Status</option>
                                    <option value="1" @if(isset($setting) && $setting->status==1) selected @endif>Active</option>
                                    <option value="0" @if(isset($setting) && $setting->status==0) selected @endif>InActive</option>
                                    
                                    
                                </select>
                            </div>
                            
                            <div class="mb-3 row">
                                <label for="html5-search-input" class="col-md-2 col-form-label"></label>
                                <div class="col-md-10">
                                    <input class="btn btn-primary" type="submit" value="submit" id="html5-search-input" />
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@stop