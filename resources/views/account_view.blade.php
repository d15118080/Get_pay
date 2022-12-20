<!doctype html>
<html lang="ko" data-layout="vertical" data-topbar="light" data-sidebar-size="lg" data-sidebar-image="none" data-body-image="img-1" data-preloader="disable">

<head>
    <meta charset="utf-8" />
    <title>{{env('APP_NAME')}} - 대시보드</title>
    <meta name="viewport" content="initial-scale=1.0,user-scalable=no,maximum-scale=1,width=device-width" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="/assets/images/favicon.ico">

    <!-- jsvectormap css -->
    <link href="/assets/libs/jsvectormap/css/jsvectormap.min.css" rel="stylesheet" type="text/css" />

    <!--Swiper slider css-->
    <link href="/assets/libs/swiper/swiper-bundle.min.css" rel="stylesheet" type="text/css" />

    <!-- Layout config Js -->
    <script src="/assets/js/layout.js"></script>
    <!-- Bootstrap Css -->
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="/assets/css/app.min.css" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href="/assets/css/custom.min.css" rel="stylesheet" type="text/css" />
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
                            <h4 class="mb-sm-0">대시보드</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">{{env('APP_NAME')}}</a></li>
                                    <li class="breadcrumb-item active">대시보드</li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <div class="row">
                    <div class="col">
                        <div class="h-100">
                            <div class="row mb-3 pb-1">
                                <div class="col-12">
                                    <div class="d-flex align-items-lg-center flex-lg-row flex-column">
                                        <div class="flex-grow-1">
                                            <h4 class="fs-16 mb-1">가상계좌 발급 링크!</h4>
                                        </div>
                                    </div><!-- end card header -->
                                </div>
                                <!--end col-->
                            </div>
                            <!--end row-->
                        </div> <!-- end .h-100-->
                    </div> <!-- end col -->
                        <div class="row">
                            <div class="col-xl">
                                <div class="card">
                                    <div class="card-header align-items-center d-flex">
                                        <h4 class="card-title mb-0 flex-grow-1">가상계좌 발급 링크</h4>
                                    </div><!-- end card header -->

                                    <div class="card-body">
                                        <p class="text-muted">본 가상계좌 링크를 회원에게 주시면 됩니다 <b style="color: darkred">임시 계좌는 발급후 10분이내 미입금시 삭제 처리됩니다</b></p>
                                        <div class="live-preview">
                                            <div action="javascript:void(0);">
                                                <div class="row">
                                                    @if($bank_route == "" || $bank_route == null)
                                                        <div class="col-md-12">
                                                            <div class="mb-3">
                                                                본사 가상게좌 등록 대기중입니다.
                                                            </div>
                                                        </div>
                                                    @else
                                                        @if($bank_mode_int == 0 || $bank_mode_int == 2)
                                                            <div class="col-md-12">
                                                                <div class="mb-3">
                                                                    <label for="firstNameinput" class="form-label">영구 계좌 발급 링크</label>
                                                                    <input type="text" class="form-control" value="https://{{env('APP_URL')}}/account_issuance/{{$bank_route}}?mode=0" id="firstNameinput" disabled>
                                                                </div>
                                                            </div>
                                                        @endif
                                                        @if($bank_mode_int == 1 || $bank_mode_int == 2)
                                                            <div class="col-md-12">
                                                                <div class="mb-3">
                                                                    <label for="lastNameinput" class="form-label">임시 계좌 발급 링크</label>
                                                                    <input type="text" class="form-control" value="https://{{env('APP_URL')}}/account_issuance/{{$bank_route}}?mode=1" id="lastNameinput" disabled>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endif
                                                </div>
                                                <!--end row-->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- end col -->
                        </div>
                </div>
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

<!-- Dashboard init -->
<script src="/assets/js/pages/dashboard-ecommerce.init.js"></script>

<!-- App js -->
<script src="/assets/js/app.js"></script>

<script src="//code.jquery.com/jquery-3.6.2.js" integrity="sha256-pkn2CUZmheSeyssYw3vMp1+xyub4m+e+QK4sQskvuo4=" crossorigin="anonymous"></script>
<!-- sweetalert2 -->
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- jquery-cookie -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.js"></script>
</body>

</html>
