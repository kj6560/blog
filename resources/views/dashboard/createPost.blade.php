@extends('layouts.admin')
@section('content')
<style>
    figure.image {
        display: inline-block;
        border: 1px solid gray;
        margin: 0 2px 0 1px;
        background: #f5f2f0;
    }

    figure.align-left {
        float: left;
    }

    figure.align-right {
        float: right;
    }

    figure.image img {
        margin: 8px 8px 0 8px;
    }

    figure.image figcaption {
        margin: 6px 8px 6px 8px;
        text-align: center;
    }

    /*
 Alignment using classes rather than inline styles
 check out the "formats" option
*/

    img.align-left {
        float: left;
    }

    img.align-right {
        float: right;
    }

    /* Basic styles for Table of Contents plugin (tableofcontents) */
    .mce-toc {
        border: 1px solid gray;
    }

    .mce-toc h2 {
        margin: 4px;
    }

    .mce-toc li {
        list-style-type: none;
    }
</style>
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="col-xl-12">
            <div class="row">
                <!-- HTML5 Inputs -->
                <form action="/dashboard/storePost" enctype="multipart/form-data" method="POST">
                    @csrf
                    <div class="card mb-4">
                        <h5 class="card-header">Create Post</h5>
                        <div class="card-body">

                            <input class="form-control" type="text" name="id" value="{{isset($post) && $post->id?$post->id:''}}" hidden id="html5-text-input" />

                            <div class="mb-3 row">
                                <label for="html5-text-input" class="col-md-2 col-form-label">Title</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" autocomplete=false name="title" value="{{isset($post) && $post->title?$post->title:''}}" placeholder="Enter Post Title" id="html5-text-input" />
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="html5-text-input" class="col-md-2 col-form-label">Sub Title</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" autocomplete=false name="sub_title" value="{{isset($post) && $post->sub_title?$post->sub_title:''}}" placeholder="Enter Post Sub Title" id="html5-text-input" />
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="html5-text-input" class="col-md-2 col-form-label">Header Image</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="file" name="header_image" id="html5-text-input" />
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="exampleFormControlSelect1" class="form-label">Select Category</label>
                                <select class="form-select" id="exampleFormControlSelect1" aria-label="Select Parent Category" name="category_id">
                                    <option selected>Select Category</option>
                                    @foreach($categories as $categori)
                                    <option value="{{$categori['id']}}" @if(isset($post) && $post->category_id==$categori['id']) selected @endif>{{$categori['name']}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3 row">
                                <label for="exampleFormControlSelect1" class="form-label">Select Status</label>
                                <select class="form-select" id="exampleFormControlSelect1" aria-label="Select Status" name="status">
                                    <option selected>Select Status</option>
                                    <option value="1" @if(isset($post) && $post->status==1) selected @endif>Active</option>
                                    <option value="0" @if(isset($post) && $post->status==0) selected @endif>InActive</option>


                                </select>
                            </div>

                            <input id="media" type="file" name="media" style="display: none;" onchange="" />
                            <!-- Place the first <script> tag in your HTML's <head> -->
                            <script src="https://cdn.tiny.cloud/1/t8trt7qyuyi3ftgvf8l6rud39xnogvdybw7pkirh37ptzekd/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
                            <script src="https://cdnjs.cloudflare.com/ajax/libs/filepond/4.30.6/filepond.js" integrity="sha512-IScazm0Ff5XIgiPvkT/d5daN5+hCBq33ZhpWPBo8bpX7HDnhJTsPOZN63YctEX7GAL4HpdmWM24/G9gArerpRA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
                            <!-- Place the following <script> and <textarea> tags your HTML's <body> -->
                            <script>
                                const useDarkMode = window.matchMedia('(prefers-color-scheme: dark)').matches;


                                tinymce.init({
                                    selector: 'textarea#open-source-plugins',
                                    plugins: 'preview importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media template codesample table charmap pagebreak nonbreaking anchor insertdatetime advlist lists wordcount help charmap quickbars emoticons accordion',

                                    menubar: 'file edit view insert format tools table help',
                                    toolbar: "undo redo | accordion accordionremove | blocks fontfamily fontsize | bold italic underline strikethrough | align numlist bullist | link image | table media | lineheight outdent indent| forecolor backcolor removeformat | charmap emoticons | code fullscreen preview | save print | pagebreak anchor codesample | ltr rtl",

                                    automatic_uploads: true,
                                    image_advtab: true,
                                    file_picker_types: 'image',
                                    /* and here's our custom image picker*/
                                    file_picker_callback: function(cb, value, meta) {
                                        var input = document.createElement('input');
                                        input.setAttribute('type', 'file');
                                        input.setAttribute('accept', '*/*');

                                        input.onchange = function() {
                                            var file = this.files[0];

                                            var formData = new FormData();
                                            formData.append('image', file);
                                            formData.append('_token', '{{ csrf_token() }}');

                                            var xhr = new XMLHttpRequest();
                                            xhr.open('POST', '/dashboard/storePostMedia', true);

                                            xhr.onload = function() {
                                                if (xhr.status === 200) {
                                                    var response = JSON.parse(xhr.response);
                                                    if (response.message == "success") {
                                                        // File uploaded successfully, callback with the URL
                                                        cb(response.data, {
                                                            title: file.name
                                                        });
                                                    } else {
                                                        console.error('File upload failed:', response.message);
                                                    }
                                                }
                                            };

                                            xhr.onerror = function() {
                                                console.error('File upload failed.');
                                            };

                                            xhr.send(formData);
                                        };

                                        input.click();
                                    },
                                    height: 600,
                                    quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote quickimage quicktable',
                                    toolbar_mode: 'sliding',
                                    contextmenu: 'link image table',
                                    skin: useDarkMode ? 'oxide-dark' : 'oxide',
                                    content_css: useDarkMode ? 'dark' : 'default',
                                    content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:16px }'
                                });
                            </script>

                            <textarea id="open-source-plugins" name="content">{{isset($post) && $post->content?$post->content:''}}</textarea>


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