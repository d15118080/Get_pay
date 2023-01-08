<!doctype html>
<html lang="ko" data-layout="vertical" data-topbar="light" data-sidebar-size="lg" data-sidebar-image="none"
      data-body-image="img-1" data-preloader="disable">

<head>
    <meta charset="utf-8"/>
    <title>{{env('APP_NAME')}} - 익스 전환 요청</title>
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
                            <h4 class="mb-sm-0">익스체인지 머니 전환 요청</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">익스 체인지</a></li>
                                    <li class="breadcrumb-item active">익스체인지 머니 전환 요청</li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- end page title -->
                <div class="row setp1">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header align-items-center">
                                <h4 class="card-title mb-0 flex-grow-1">익스체인지 머니 전환 요청</h4>
                                <b class="mt-3">전환 가능 금액 :{{number_format($company_money)}} 원 <br>출금 수수료
                                    : {{$calculate_fee}} 원 + 0.1%</b>
                                <br>
                                <p style="color:red;">정산 요청가능 시간 : 02:00/06:00/08:00/10:00/12:00/14:00/15:00/16:00/18:00/ 19:00/21:00/00:00/ 외 해당시간 전에 '정산요청' 하시면 1시간뒤 출금됩니다</p>
                            </div><!-- end card header -->

                            <div class="card-body">
                                <div class="live-preview">
                                    <div class="row gy-4">
                                        <div class="col-xl">
                                            <div>
                                                <label for="basiInput" class="form-label">전환 요청 금액</label>
                                                <input type="text" class="form-control" id="money"
                                                       placeholder="전환 요청 금액" value="">
                                            </div>
                                        </div>
                                        <!--end col-->
                                    </div>
                                    <!--end row-->
                                    <div class="col-12 mt-3">
                                        <div class="text-end">
                                            <button type="button" class="btn btn-primary" id="calculate_send">신청
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end col-->
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

<!-- App js -->
<script src="/assets/js/app.js"></script>

<script src="//code.jquery.com/jquery-3.6.2.js" integrity="sha256-pkn2CUZmheSeyssYw3vMp1+xyub4m+e+QK4sQskvuo4="
        crossorigin="anonymous"></script>
<!-- sweetalert2 -->
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- jquery-cookie -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.js"></script>
<script type="module" src="/assets/js/ajax/transform.js"></script>
</body>

</html>
