@extends('layouts.admin')
@section('content')
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="col-xl-6">
            <div class="row">
                <!-- HTML5 Inputs -->
                <form action="/dashboard/storeCategory" enctype="multipart/form-data"  method="POST">
                    @csrf
                    <div class="card mb-4">
                        <h5 class="card-header">Create Category</h5>

                        <input class="form-control" type="text" name="id" value="{{isset($category) && $category->id?$category->id:''}}" hidden id="html5-text-input" />


                        <div class="card-body">
                            
                            <div class="mb-3 row">
                                <label for="html5-text-input" class="col-md-2 col-form-label">Name</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" name="name" value="{{isset($category) && $category->name?$category->name:''}}" placeholder="Enter Category Name" id="html5-text-input" />
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="html5-text-input" class="col-md-2 col-form-label">Description</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" name="description"  value="{{isset($category) && $category->description?$category->description:''}}" id="html5-text-input" />
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="exampleFormControlSelect1" class="form-label">Select Status</label>
                                <select class="form-select" id="exampleFormControlSelect1" aria-label="Select Status" name="status">
                                    <option selected>Select Status</option>
                                    <option value="1" @if(isset($category) && $category->status==1) selected @endif>Active</option>
                                    <option value="0" @if(isset($category) && $category->status==0) selected @endif>InActive</option>
                                    
                                    
                                </select>
                            </div>
                            <div class="mb-3 row">
                                <label for="exampleFormControlSelect1" class="form-label">Select Featured</label>
                                <select class="form-select" id="exampleFormControlSelect1" aria-label="Select Featured" name="featured">
                                    <option selected>Select Featured</option>
                                    <option value="0" @if(isset($category) && $category->featured==0) selected @endif>General</option>
                                    <option value="1" @if(isset($category) && $category->featured==1) selected @endif>Featured</option>
                                    
                                </select>
                            </div>
                            <div class="mb-3 row">
                                <label for="exampleFormControlSelect1" class="form-label">Select Popular</label>
                                <select class="form-select" id="exampleFormControlSelect1" aria-label="Select Popular" name="popular">
                                    <option selected>Select Popular</option>
                                    <option value="0" @if(isset($category) && $category->popular==0) selected @endif>General</option>
                                    <option value="1" @if(isset($category) && $category->popular==1) selected @endif>Popular</option>
                                    
                                </select>
                            </div>
                            <div class="mb-3 row">
                                <label for="exampleFormControlSelect1" class="form-label">Select Parent</label>
                                <select class="form-select" id="exampleFormControlSelect1" aria-label="Select Parent Category" name="parent">
                                    <option selected>Select Parent Category</option>
                                    <option value="0">Parent</option>
                                    @foreach($parent_categories as $categori)
                                    <option value="{{$categori['id']}}" @if(isset($category) && $category->id==$categori['id']) selected @endif>{{$category['name']}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="formFile" class="form-label">Image</label>
                                <input type="file" name="image" id="inputImage" class="form-control">
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