<!doctype html>
<html lang="ko" data-layout="vertical" data-topbar="light" data-sidebar-size="lg" data-sidebar-image="none"
      data-body-image="img-1" data-preloader="disable">

<head>
    <meta charset="utf-8"/>
    <title>{{env('APP_NAME')}} - 가상계좌 설정</title>
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
                            <h4 class="mb-sm-0">가상계좌 설정</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">사용자 관리</a></li>
                                    <li class="breadcrumb-item active">가상계좌 설정</li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- end page title -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header align-items-center d-flex">
                                <h4 class="card-title mb-0 flex-grow-1">가상계좌 설정</h4>
                            </div><!-- end card header -->

                            <div class="card-body">
                                <div class="live-preview">
                                    <div class="row">
                                        <div class="col-xl col-md-5">
                                            <div>
                                                <label for="basiInput" class="form-label">페이투스 아이디</label>
                                                @if($data != null)
                                                    <input type="text" class="form-control" id="p_id"
                                                           placeholder="페이투스 아이디 입력해주세요" value="{{$data->p_id}}" >
                                                @else
                                                    <input type="text" class="form-control" id="p_id"
                                                           placeholder="페이투스 아이디 입력해주세요" value="">
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-xl col-md-5">
                                            <div>
                                                <label for="basiInput" class="form-label">페이투스 비밀번호</label>
                                                @if($data != null)
                                                    <input type="text" class="form-control" id="p_pw"
                                                           placeholder="페이투스 비밀번호 입력해주세요" value="{{$data->p_pw}}" >
                                                @else
                                                    <input type="text" class="form-control" id="p_pw"
                                                           placeholder="페이투스 비밀번호 입력해주세요" value="">
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-xl col-md-5">
                                            <div>
                                                <label for="basiInput" class="form-label">페이투스 가맹점 고유번호</label>
                                                @if($data != null)
                                                    <input type="text" class="form-control" id="p_commuid"
                                                           placeholder="페이투스 가맹점 고유값 입력해주세요" value="{{$data->comp_uuid}}" >
                                                @else
                                                    <input type="text" class="form-control" id="p_commuid"
                                                           placeholder="페이투스 가맹점 고유값 입력해주세요" value="">
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-12 mt-3 mb-3">
                                            <div>
                                                <label for="basiInput" class="form-label">입금통지URL (페이투스 업체정보관리에서 입금통지URL 에 등록하세요)</label>
                                                @if($data != null)
                                                    <input type="text" class="form-control" id="rtpay_v1_url"
                                                           placeholder="값이 없을경우 키값을 입력후 저장시 표시됩니다" value="https://{{env('APP_URL')}}/api/v1/user/deposit_notification/{{$data->route_id}}" disabled>
                                                @else
                                                    <input type="text" class="form-control" id="rtpay_v1_url"
                                                           placeholder="값이 없을경우 키값을 입력후 저장시 표시됩니다" value="" disabled>
                                                @endif
                                            </div>
                                        </div>
                                        <!--end col-->
                                        <div class="col-12">
                                            <div class="text-end">
                                                <button type="button" class="btn btn-primary" id="account_setting">저장</button>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end row-->
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
<script type="module" src="/assets/js/ajax/account_setting.js"></script>
</body>

</html>
