<!doctype html>
<html lang="ko" data-layout="vertical" data-topbar="light" data-sidebar-size="lg" data-sidebar-image="none"
      data-body-image="img-1" data-preloader="disable">

<head>
    <meta charset="utf-8"/>
    <title>페이원 - 거래내역</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Themesbrand" name="author"/>
    <!-- App favicon -->
    <link rel="shortcut icon" href="/assets/images/favicon.ico">

    <!-- jsvectormap css -->
    <link href="/assets/libs/jsvectormap/css/jsvectormap.min.css" rel="stylesheet" type="text/css"/>

    <!--Swiper slider css-->
    <link href="/assets/libs/swiper/swiper-bundle.min.css" rel="stylesheet" type="text/css"/>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css"/>
    <!--datatable responsive css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css"/>

    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">

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
                            <h4 class="mb-sm-0">거래 내역</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">매출관리</a></li>
                                    <li class="breadcrumb-item active">거래내역</li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- end page title -->
                <div class="row">
                    <div class="col-xl">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="card mini-stats-wid">
                                    <div class="card-body">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <p class="text-muted fw-medium">조회 기간중 입금건수 </p>
                                                <h4 class="mb-0" ><span id="count"></span><span> 건</span></h4>
                                            </div>
                                            <div class="flex-shrink-0 align-self-center">
                                                <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                                            <span class="avatar-title">
                                                                <i class="bx bx-copy-alt font-size-24"></i>
                                                            </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card mini-stats-wid">
                                    <div class="card-body">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <p class="text-muted fw-medium">조회 기간중 총 입금 금액</p>
                                                <h4 class="mb-0" ><span id="sum"></span><span> 원</span></h4>
                                            </div>
                                            <div class="flex-shrink-0 align-self-center">
                                                <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
                                                            <span class="avatar-title rounded-circle bg-primary">
                                                                <i class="bx bx-archive-in font-size-24"></i>
                                                            </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">거래내역</h5>
                                <h4 class="card-title mb-0 flex-grow-1"><b style="font-size: 12px">수수료 는 해당 업체 위로 올려주는 금액이며 괄호 안에있는 금액이 실 해당 업체의 적립금 입니다.</b></h4>
                                <div action="" method="get" class="mt-3 mb-3 row gy-2 gx-3 align-items-center">
                                    <div class="col-sm-auto">
                                        <input class="form-control" id="start_date" type="date">
                                    </div>
                                    <div class="col-sm-auto">
                                        ~
                                    </div>
                                    <div class="col-sm-auto">
                                        <input class="form-control" id="end_date" type="date">
                                    </div>

                                    <div class="col-sm-auto">
                                        <button id="Lookup" class="btn btn-primary w-md">조회</button>
                                    </div>
                                </div>
                            </div>

                            {{--관리자 전용테이블--}}
                            <div class="card-body">
                                <table id="admin_history" class="display table table-bordered dt-responsive"
                                       style="width:100%">
                                    <thead>
                                    @if(session('state') == 0 || session('state') == 1)
                                        <tr>
                                            <th>ID</th>
                                            <th>거래번호</th>
                                            <th>거래 타겟</th>
                                            <th>거래 금액</th>
                                            <th>입금자</th>
                                            <th>본사 적립금액</th>
                                            <th>지사 적립금액</th>
                                            <th>총판 적립금액</th>
                                            <th>가맹점 수수료</th>
                                            <th>가맹점 적립금액</th>
                                            <th>거래 날짜</th>
                                            <th>거래 시간</th>
                                        </tr>
                                    @elseif(session('state') == 2)
                                        <tr>
                                            <th>ID</th>
                                            <th>거래번호</th>
                                            <th>거래 타겟</th>
                                            <th>거래 금액</th>
                                            <th>입금자</th>
                                            <th>지사 적립금액</th>
                                            <th>총판 적립금액</th>
                                            <th>가맹점 수수료</th>
                                            <th>가맹점 적립금액</th>
                                            <th>거래 날짜</th>
                                            <th>거래 시간</th>
                                        </tr>
                                    @elseif(session('state') == 3)
                                        <tr>
                                            <th>ID</th>
                                            <th>거래번호</th>
                                            <th>거래 타겟</th>
                                            <th>거래 금액</th>
                                            <th>입금자</th>
                                            <th>총판 적립금액</th>
                                            <th>가맹점 수수료</th>
                                            <th>가맹점 적립금액</th>
                                            <th>거래 날짜</th>
                                            <th>거래 시간</th>
                                        </tr>
                                    @elseif(session('state') == 4)
                                        <tr>
                                            <th>ID</th>
                                            <th>거래번호</th>
                                            <th>거래 타겟</th>
                                            <th>거래 금액</th>
                                            <th>입금자</th>
                                            <th>가맹점 수수료</th>
                                            <th>가맹점 적립금액</th>
                                            <th>거래 날짜</th>
                                            <th>거래 시간</th>
                                        </tr>
                                    @endif
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div><!--end col-->
                </div><!--end row-->

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
<script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/libs/simplebar/simplebar.min.js"></script>
<script src="assets/libs/node-waves/waves.min.js"></script>
<script src="assets/libs/feather-icons/feather.min.js"></script>
<script src="assets/js/pages/plugins/lord-icon-2.1.0.js"></script>
<script src="assets/js/plugins.js"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<!--datatable js-->
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- jquery-cookie -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.js"></script>
<script type="module" src="/assets/js/ajax/transaction_history.js"></script>
<!-- App js -->
<script src="assets/js/app.js"></script>
</body>

</html>