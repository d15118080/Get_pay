<!doctype html>
<html lang="ko" data-layout="vertical" data-topbar="light" data-sidebar-size="lg" data-sidebar-image="none"
      data-body-image="img-1" data-preloader="disable">

<head>
    <meta charset="utf-8"/>
    <title>페이원 - 텔레그램 알림 설정</title>
    <meta name="viewport" content="initial-scale=1.0,user-scalable=no,maximum-scale=1,width=device-width"/>
    <meta content="Themesbrand" name="author"/>
    <!-- App favicon -->
    <link rel="shortcut icon" href="/assets/images/favicon.ico">

    <!-- jsvectormap css -->
    <link href="/assets/libs/jsvectormap/css/jsvectormap.min.css" rel="stylesheet" type="text/css"/>

    <!--Swiper slider css-->
    <link href="/assets/libs/swiper/swiper-bundle.min.css" rel="stylesheet" type="text/css"/>

    <!-- Layout config Js -->
    <script src="/assets/js/layout.js"></script>
    <!-- Bootstrap Css -->
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <!-- Icons Css -->
    <link href="/assets/css/icons.min.css" rel="stylesheet" type="text/css"/>
    <!-- App Css-->
    <link href="/assets/css/app.min.css" rel="stylesheet" type="text/css"/>
    <!-- custom Css-->
    <link href="/assets/css/custom.min.css" rel="stylesheet" type="text/css"/>
</head>

<body>
<!-- Begin page -->
<div id="layout-wrapper">
    @include('include.header')
    <!-- ========== App Menu ========== -->
    @include('include.sidebar')
    <!-- Left Sidebar End -->
    <!-- Vertical Overlay-->
    <div class="vertical-overlay"></div>

    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0">계정 설정</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item "><a href="javascript: void(0);">사용자 관리</a></li>
                                    <li class="breadcrumb-item active">계정 설정</li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- end page title -->
                    <div class="row">
                        <div class="col-lg-12">
                            <form id="three_company_add_form">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title mb-4">계정 설정</h4>
                                        <div class="row mb-4">
                                            <label class="col-form-label col-lg-2">2차인증 사용 여부 *</label>
                                            <div class="col-md-10">
                                                <select class="form-control select2-ajax" id="auth_state">
                                                    @if($data->auth_2 == 1)
                                                        <option value="1">사용함</option>
                                                        <option value="0">사용안함</option>
                                                    @else
                                                        <option value="0">사용안함</option>
                                                        <option value="1">사용함</option>
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        @if($data->auth_2_password != null)
                                        <div class="row mb-4">
                                            <label for="projectname" class="col-form-label col-lg-2">2차 비밀번호(재설정) *</label>
                                            <div class="col-lg-10">
                                                <input id="auth_password" type="text" class="form-control" placeholder="재설정 할 2차 비밀번호">
                                            </div>
                                        </div>
                                        @else
                                        <div class="row mb-4">
                                            <label for="projectname" class="col-form-label col-lg-2">2차 비밀번호(처음셋팅) *</label>
                                            <div class="col-lg-10">
                                                <input id="auth_password" type="text" class="form-control" placeholder="사용할 2차 비밀번호">
                                            </div>
                                        </div>
                                        @endif
                                        <div class="row mb-4">
                                            <label for="projectname" class="col-form-label col-lg-2">비밀번호 변경 *</label>
                                            <div class="col-lg-10">
                                                <input id="user_password" type="text" class="form-control" placeholder="변경할 비밀번호 ">
                                            </div>
                                        </div>

                                        <div class="row justify-content-end">
                                            <div class="col-lg-10">
                                                <button type="button" class="save btn btn-primary">저장
                                                </button>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                <!-- end row -->
            </div>
            <!-- container-fluid -->
        </div>
        <!-- End Page-content -->

        @include('include.fotter')
    </div>
    <!-- end main content-->

</div>
<!-- END layout-wrapper -->

<!-- JAVASCRIPT -->
<script src="/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/assets/libs/simplebar/simplebar.min.js"></script>
<script src="/assets/libs/node-waves/waves.min.js"></script>
<script src="/assets/libs/feather-icons/feather.min.js"></script>
<script src="/assets/js/pages/plugins/lord-icon-2.1.0.js"></script>
<script src="/assets/js/plugins.js"></script>

<!-- apexcharts -->
<script src="/assets/libs/apexcharts/apexcharts.min.js"></script>

<!-- Vector map-->
<script src="/assets/libs/jsvectormap/js/jsvectormap.min.js"></script>
<script src="/assets/libs/jsvectormap/maps/world-merc.js"></script>

<!--Swiper slider js-->
<script src="/assets/libs/swiper/swiper-bundle.min.js"></script>

<!-- App js -->
<script src="/assets/js/app.js"></script>

<script src="//code.jquery.com/jquery-3.6.2.js" integrity="sha256-pkn2CUZmheSeyssYw3vMp1+xyub4m+e+QK4sQskvuo4="
        crossorigin="anonymous"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- login -->
<script type="module" src="/assets/js/ajax/user_setting.js"></script>
<!-- jquery-cookie -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.js"></script>
</body>

</html>
