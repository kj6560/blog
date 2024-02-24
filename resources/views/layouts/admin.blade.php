<!DOCTYPE html>

<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="{{asset('admin/assets')}}/" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>{{"Dashboard ".$site_settings['site_name']}}</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{asset('admin/assets')}}/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="{{asset('admin/assets')}}/vendor/fonts/boxicons.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.5.1/tinymce.min.js" integrity="sha512-UhysBLt7bspJ0yBkIxTrdubkLVd4qqE4Ek7k22ijq/ZAYe0aadTVXZzFSIwgC9VYnJabw7kg9UMBsiLC77LXyw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- Core CSS -->
    <link rel="stylesheet" href="{{asset('admin/assets')}}/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{asset('admin/assets')}}/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{asset('admin/assets')}}/css/demo.css" />
    <link rel="stylesheet" href="{{asset('admin/assets')}}/css/bootstrap-datetimepicker.min.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{asset('admin/assets')}}/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <link rel="stylesheet" href="{{asset('admin/assets')}}/vendor/libs/apex-charts/apex-charts.css" />

    <script src="{{asset('admin/assets')}}/vendor/js/helpers.js"></script>


    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{asset('admin/assets')}}/js/config.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    @php
    $success = Session::get('success');
    $error = Session::get('error');
    @endphp
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->

            <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
                <div class="app-brand demo">
                    <a href="/" class="app-brand-link">
                        <span class="app-brand-text demo menu-text fw-bolder ms-2">Nomad Pulse</span>
                    </a>

                    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
                        <i class="bx bx-chevron-left bx-sm align-middle"></i>
                    </a>
                </div>

                <div class="menu-inner-shadow"></div>

                <ul class="menu-inner py-1">
                    <!-- Dashboard -->
                    <li class="menu-item active">
                        <a href="/dashboard" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-home-circle"></i>
                            <div data-i18n="Analytics">Dashboard</div>
                        </a>
                    </li>

                    <li class="menu-item">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons bx bx-layout"></i>
                            <div data-i18n="Layouts">Users</div>
                        </a>

                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="/dashboard/users" class="menu-link">
                                    <div data-i18n="Without menu">All Users </div>
                                </a>
                            </li>
                        </ul>

                    </li>

                    <!-- category -->
                    <li class="menu-item">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons bx bx-layout"></i>
                            <div data-i18n="Layouts">Category</div>
                        </a>

                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="/dashboard/createCategory" class="menu-link">
                                    <div data-i18n="Without menu">Create Category</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="/dashboard/categoryList" class="menu-link">
                                    <div data-i18n="Without navbar">List Category</div>
                                </a>
                            </li>

                        </ul>
                    </li>

                    <!-- Post -->
                    <li class="menu-item">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons bx bx-layout"></i>
                            <div data-i18n="Layouts">Post</div>
                        </a>

                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="/dashboard/createPost" class="menu-link">
                                    <div data-i18n="Without menu">Create Post</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="/dashboard/postList" class="menu-link">
                                    <div data-i18n="Without navbar">List Posts</div>
                                </a>
                            </li>

                        </ul>
                    </li>

                    
                    <!-- Events -->
                    <li class="menu-item">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons bx bx-layout"></i>
                            <div data-i18n="Layouts">Events</div>
                        </a>

                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="/dashboard/createEvents" class="menu-link">
                                    <div data-i18n="Without menu">Create Events</div>
                                </a>
                            </li>

                            <li class="menu-item">
                                <a href="/dashboard/eventsList" class="menu-link">
                                    <div data-i18n="Without navbar">List Events</div>
                                </a>
                            </li>

                            <li class="menu-item">
                                <a href="/dashboard/eventUsers" class="menu-link">
                                    <div data-i18n="Without menu">Event Users</div>
                                </a>
                            </li>

                            <li class="menu-item">
                                <a href="/dashboard/eventGallery" class="menu-link">
                                    <div data-i18n="Without menu">Event Gallery </div>
                                </a>
                            </li>

                            <li class="menu-item">
                                <a href="/dashboard/eventSliders" class="menu-link">
                                    <div data-i18n="Without menu">Event Sliders</div>
                                </a>
                            </li>
                            
                        </ul>
                    </li>


                    <!-- Email Settings -->
                    <li class="menu-item">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons bx bx-layout"></i>
                            <div data-i18n="Layouts">Email Settings</div>
                        </a>

                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="/dashboard/emailTemplates" class="menu-link">
                                    <div data-i18n="Without menu">Email Templates </div>
                                </a>
                            </li>
                        </ul>
                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="/dashboard/createEmailTemplates" class="menu-link">
                                    <div data-i18n="Without menu">Create Template </div>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <!-- Admin Settings -->
                    <li class="menu-item">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons bx bx-layout"></i>
                            <div data-i18n="Layouts">Admin Settings</div>
                        </a>

                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="/dashboard/siteSettingsList" class="menu-link">
                                    <div data-i18n="Without menu">Site Settings </div>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <!-- Gallery -->
                    <li class="menu-item">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons bx bx-layout"></i>
                            <div data-i18n="Layouts">Gallery</div>
                        </a>

                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="/dashboard/siteGallery" class="menu-link">
                                    <div data-i18n="Without menu">Site Gallery </div>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <!-- Event Results -->

                </ul>
            </aside>
            <!-- / Menu -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->

                <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
                    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
                        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                            <i class="bx bx-menu bx-sm"></i>
                        </a>
                    </div>

                    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">

                        <ul class="navbar-nav flex-row align-items-center ms-auto">

                            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                                    <div class="avatar avatar-online">
                                        <img src="{{asset('admin/assets')}}/img/avatars/1.png" alt class="w-px-40 h-auto rounded-circle" />
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 me-3">
                                                    <div class="avatar avatar-online">
                                                        <img src="{{asset('admin/assets')}}/img/avatars/1.png" alt class="w-px-40 h-auto rounded-circle" />
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <span class="fw-semibold d-block">John Doe</span>
                                                    <small class="text-muted">Admin</small>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="dropdown-divider"></div>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <i class="bx bx-user me-2"></i>
                                            <span class="align-middle">My Profile</span>
                                        </a>
                                    </li>

                                    <li>
                                        <div class="dropdown-divider"></div>
                                    </li>
                                    <li>
                                    <a class="dropdown-item" href="/logout">
                                            <i class="bx bx-user me-2"></i>
                                            <span class="align-middle">Logout</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <!--/ User -->
                        </ul>
                    </div>
                </nav>

                <!-- / Navbar -->

                <!-- Content wrapper -->
                @yield('content')


                <footer class="content-footer footer bg-footer-theme">
                    <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
                        <div class="mb-2 mb-md-0">
                            ©
                            <script>
                                document.write(new Date().getFullYear());
                            </script>
                            , made with ❤️ by
                            <a href="https://shiwkesh.com" target="_blank" class="footer-link fw-bolder">Shiwkesh Schematics</a>
                        </div>

                    </div>
                </footer>
                <!-- Core JS -->
                <!-- build:js assets/vendor/js/core.js -->
                <script src="{{asset('admin/assets')}}/vendor/libs/jquery/jquery.js"></script>
                <script src="{{asset('admin/assets')}}/vendor/libs/popper/popper.js"></script>
                <script src="{{asset('admin/assets')}}/vendor/js/bootstrap.js"></script>
                <script src="{{asset('admin/assets')}}/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

                <script src="{{asset('admin/assets')}}/vendor/js/menu.js"></script>
                <!-- endbuild -->



                <!-- Main JS -->
                <script src="{{asset('admin/assets')}}/js/main.js"></script>
                <script src="{{asset('admin/assets')}}/js/bootstrap-datetimepicker.min.js"></script>

                <!-- Page JS -->
                <script src="{{asset('admin/assets')}}/js/dashboards-analytics.js"></script>

                <!-- Place this tag in your head or just before your close body tag. -->
                <script async defer src="https://buttons.github.io/buttons.js"></script>

</body>
<script>
    var success = "{{!empty($success)?$success:'NA'}}";
    var error = "{{!empty($error)?$error:'NA'}}";
    if (success != 'NA') {
        Swal.fire({
            title: 'Done',
            text: success,
            icon: 'success',
            confirmButtonText: 'Okay',

        }).then((result) => {
            if (result.isConfirmed) {
                window.location.reload();
            }
        })
    }
    if (error != 'NA') {
        Swal.fire({
            title: 'Failed!',
            text: error,
            icon: 'error',
            confirmButtonText: 'Okay',

        });
    }
</script>


</html>