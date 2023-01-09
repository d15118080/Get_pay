<!doctype html>
<html lang="ko" data-layout="vertical" data-topbar="light" data-sidebar-size="lg" data-sidebar-image="none"
      data-body-image="img-1" data-preloader="disable">

<head>
    <meta charset="utf-8"/>
    <title>{{env('APP_NAME')}} - 계좌발급</title>
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
<div id="layout-wrapper">
    @include('include.empty_header')
    <!-- ========== App Menu ========== -->
    @include('include.empty_sidebar')
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
                            <h4 class="mb-sm-0 font-size-18">가상계좌 발급</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">가상계좌 발급</a></li>
                                    <li class="breadcrumb-item active">가상계좌 발급</li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- end page title -->
                <div class="row" id="one">
                    <div class="col-lg-12">
                        <form id="three_company_add_form">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">본인확인</h4>
                                    <div class="row mb-4">
                                        <label class="col-form-label col-lg-2">예금주 명 *</label>
                                        <div class="col-md-10">
                                            <input id="bank_user_name" value="" type="text" class="form-control"
                                                   placeholder="예금주 명">
                                        </div>
                                    </div>
                                    <div class="row justify-content-end">
                                        <div class="col-lg-10">
                                            <button type="button" onclick="Won_shipment();"
                                                    class="btn btn-primary info-change">본인인증
                                            </button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div style="display:none;" class="row" id="for">
                    <div class="col-lg-12">
                        <form id="three_company_add_form">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">계좌발급 완료</h4>
                                    <div class="row mb-4">
                                        <label class="col-form-label col-lg-2">입금하실 계좌번호 (케이뱅크)</label>
                                        <div class="col-md-10">
                                            <input id="bankAcctNo" value="" type="text" class="form-control" disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- End Page-content -->
                @include('include.fotter')

            </div>
            <!-- end main content-->
        </div>
    </div>
</div>
<!-- END layout-wrapper -->

<input type="hidden" value="{{$mid}}" id="mid">
<input type="hidden" value="{{$company_id}}" id="company_id">
<input type="hidden" value="{{$route_id}}" id="route_id">
<!-- JAVASCRIPT -->
<script src="//code.jquery.com/jquery-3.6.2.js" integrity="sha256-pkn2CUZmheSeyssYw3vMp1+xyub4m+e+QK4sQskvuo4=" crossorigin="anonymous"></script>


<script src="/assets/js/app.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.js"></script>
<script  src="/assets/js/ajax/bank_add_v2.js"></script>
<!-- end main content-->
</body>
</html>
