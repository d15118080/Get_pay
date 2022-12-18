<!doctype html>
<html lang="ko" data-layout="vertical" data-topbar="light" data-sidebar-size="lg" data-sidebar-image="none" data-body-image="img-1" data-preloader="disable">

<head>
    <meta charset="utf-8" />
    <title>페이원 - 업체리스트</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
                            <h4 class="mb-sm-0">업체 리스트</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">페이원</a></li>
                                    <li class="breadcrumb-item active">업체 리스트</li>
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
                                            <h4 class="fs-16 mb-1">환영합니다! <b> {{session('name')}}</b> 님!</h4>
                                            <p class="text-muted mb-0">오늘도 즐거운 하루 되시길 바랍니다.</p>
                                        </div>
                                    </div><!-- end card header -->
                                </div>
                                <!--end col-->
                            </div>
                            <!--end row-->
                                {{--본사 리스트 [관리자] --}}
                                @if(count($data) != 0)
                                    @if($_GET['mode'] == "all")
                                        <div class="row">
                                            <div class="col-xl">
                                                <div class="card">
                                                    <div class="card-header align-items-center d-flex">
                                                        <h4>본사 리스트</h4>
                                                    </div><!-- end card header -->

                                                    <div class="card-body">
                                                        <div class="table-responsive table-card">
                                                            <table class="table table-borderless table-centered align-middle table-nowrap mb-0">
                                                                <thead class="text-muted table-light">
                                                                <tr class="text-center">
                                                                    <th scope="col">ID</th>
                                                                    <th scope="col">업체 명</th>
                                                                    <th scope="col">업체 수수료</th>
                                                                    <th scope="col">하부 지사</th>
                                                                    <th scope="col">하부 총판</th>
                                                                    <th scope="col">하부 가맹점</th>
                                                                    <th scope="col">현재 잔액</th>
                                                                    <th scope="col">생성일</th>
                                                                    <th scope="col">상태</th>
                                                                    <th scope="col">상세보기</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach($data  as $row)
                                                                    <tr class="text-center">
                                                                        <td>
                                                                            <a class="fw-medium link-primary text-center">{{$row->id}}</a>
                                                                        </td>
                                                                        <td>{{$row->company_name}}</td>
                                                                        <td>{{$row->company_margin * 100}} %</td>
                                                                        <td>{{$row->branch_count}} 개 업체</td>
                                                                        <td>{{$row->distributor_key}} 개 업체</td>
                                                                        <td>{{$row->franchisee_count}} 개 업체</td>
                                                                        <td><span>{{number_format($row->money)}} 원</span></td>
                                                                        <td>{{$row->date_ymd}} {{$row->date_time}}</td>
                                                                        <td>
                                                                            @if($row->withdraw_state == 0)
                                                                            <span class="badge badge-soft-success">출금 허용</span>
                                                                            @else
                                                                            <span class="badge badge-soft-danger">출금 차단</span>
                                                                            @endif
                                                                        </td>
                                                                        <td>
                                                                            <a href="#">상세보기</a>
                                                                        </td>
                                                                    </tr><!-- end tr -->
                                                                    @endforeach
                                                                </tbody><!-- end tbody -->
                                                            </table><!-- end table -->
                                                        </div>
                                                    </div>
                                                </div> <!-- .card-->
                                            </div> <!-- .col-->
                                        </div> <!-- end row-->
                                    @elseif( $_GET['mode'] == "branch")
                                        <div class="row">
                                        <div class="col-xl">
                                            <div class="card">
                                                <div class="card-header align-items-center d-flex">
                                                    <h4>지사 리스트</h4>
                                                </div><!-- end card header -->

                                                <div class="card-body">
                                                    <div class="table-responsive table-card">
                                                        <table class="table table-borderless table-centered align-middle table-nowrap mb-0">
                                                            <thead class="text-muted table-light">
                                                            <tr class="text-center">
                                                                <th scope="col">ID</th>
                                                                <th scope="col">업체 명</th>
                                                                <th scope="col">업체 수수료</th>
                                                                <th scope="col">하부 총판</th>
                                                                <th scope="col">하부 가맹점</th>
                                                                <th scope="col">현재 잔액</th>
                                                                <th scope="col">생성일</th>
                                                                <th scope="col">상태</th>
                                                                <th scope="col">상세보기</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @foreach($data  as $row)
                                                                <tr class="text-center">
                                                                    <td>
                                                                        <a class="fw-medium link-primary text-center">{{$row->id}}</a>
                                                                    </td>
                                                                    <td>{{$row->company_name}}</td>
                                                                    <td>{{$row->company_margin * 100}} %</td>
                                                                    <td>{{$row->distributor_key}} 개 업체</td>
                                                                    <td>{{$row->franchisee_count}} 개 업체</td>
                                                                    <td><span>{{number_format($row->money)}} 원</span></td>
                                                                    <td>{{$row->date_ymd}} {{$row->date_time}}</td>
                                                                    <td>
                                                                        @if($row->withdraw_state == 0)
                                                                            <span class="badge badge-soft-success">출금 허용</span>
                                                                        @else
                                                                            <span class="badge badge-soft-danger">출금 차단</span>
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        <a href="#">상세보기</a>
                                                                    </td>
                                                                </tr><!-- end tr -->
                                                            @endforeach
                                                            </tbody><!-- end tbody -->
                                                        </table><!-- end table -->
                                                    </div>
                                                </div>
                                            </div> <!-- .card-->
                                        </div> <!-- .col-->
                                    </div> <!-- end row-->
                                    @elseif( $_GET['mode'] == "distributor")
                                        <div class="row">
                                            <div class="col-xl">
                                                <div class="card">
                                                    <div class="card-header align-items-center d-flex">
                                                        <h4>총판 리스트</h4>
                                                    </div><!-- end card header -->

                                                    <div class="card-body">
                                                        <div class="table-responsive table-card">
                                                            <table class="table table-borderless table-centered align-middle table-nowrap mb-0">
                                                                <thead class="text-muted table-light">
                                                                <tr class="text-center">
                                                                    <th scope="col">ID</th>
                                                                    <th scope="col">업체 명</th>
                                                                    <th scope="col">업체 수수료</th>
                                                                    <th scope="col">하부 가맹점</th>
                                                                    <th scope="col">현재 잔액</th>
                                                                    <th scope="col">생성일</th>
                                                                    <th scope="col">상태</th>
                                                                    <th scope="col">상세보기</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                @foreach($data  as $row)
                                                                    <tr class="text-center">
                                                                        <td>
                                                                            <a class="fw-medium link-primary text-center">{{$row->id}}</a>
                                                                        </td>
                                                                        <td>{{$row->company_name}}</td>
                                                                        <td>{{$row->company_margin * 100}} %</td>
                                                                        <td>{{$row->franchisee_count}} 개 업체</td>
                                                                        <td><span>{{number_format($row->money)}} 원</span></td>
                                                                        <td>{{$row->date_ymd}} {{$row->date_time}}</td>
                                                                        <td>
                                                                            @if($row->withdraw_state == 0)
                                                                                <span class="badge badge-soft-success">출금 허용</span>
                                                                            @else
                                                                                <span class="badge badge-soft-danger">출금 차단</span>
                                                                            @endif
                                                                        </td>
                                                                        <td>
                                                                            <a href="#">상세보기</a>
                                                                        </td>
                                                                    </tr><!-- end tr -->
                                                                @endforeach
                                                                </tbody><!-- end tbody -->
                                                            </table><!-- end table -->
                                                        </div>
                                                    </div>
                                                </div> <!-- .card-->
                                            </div> <!-- .col-->
                                        </div> <!-- end row-->
                                    @elseif($_GET['mode'] == "franchisee")
                                        <div class="row">
                                            <div class="col-xl">
                                                <div class="card">
                                                    <div class="card-header align-items-center d-flex">
                                                        <h4>가맹점 리스트</h4>
                                                    </div><!-- end card header -->

                                                    <div class="card-body">
                                                        <div class="table-responsive table-card">
                                                            <table class="table table-borderless table-centered align-middle table-nowrap mb-0">
                                                                <thead class="text-muted table-light">
                                                                <tr class="text-center">
                                                                    <th scope="col">ID</th>
                                                                    <th scope="col">업체 명</th>
                                                                    <th scope="col">업체 수수료</th>
                                                                    <th scope="col">현재 잔액</th>
                                                                    <th scope="col">생성일</th>
                                                                    <th scope="col">상태</th>
                                                                    <th scope="col">상세보기</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                @foreach($data  as $row)
                                                                    <tr class="text-center">
                                                                        <td>
                                                                            <a class="fw-medium link-primary text-center">{{$row->id}}</a>
                                                                        </td>
                                                                        <td>{{$row->company_name}}</td>
                                                                        <td>{{$row->company_margin * 100}} %</td>
                                                                        <td><span>{{number_format($row->money)}} 원</span></td>
                                                                        <td>{{$row->date_ymd}} {{$row->date_time}}</td>
                                                                        <td>
                                                                            @if($row->withdraw_state == 0)
                                                                                <span class="badge badge-soft-success">출금 허용</span>
                                                                            @else
                                                                                <span class="badge badge-soft-danger">출금 차단</span>
                                                                            @endif
                                                                        </td>
                                                                        <td>
                                                                            <a href="#">상세보기</a>
                                                                        </td>
                                                                    </tr><!-- end tr -->
                                                                @endforeach
                                                                </tbody><!-- end tbody -->
                                                            </table><!-- end table -->
                                                        </div>
                                                    </div>
                                                </div> <!-- .card-->
                                            </div> <!-- .col-->
                                        </div> <!-- end row-->
                                @endif
                            @endif
                        </div> <!-- end .h-100-->
                    </div> <!-- end col -->
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

<script src="//code.jquery.com/jquery-3.6.2.js" integrity="sha256-pkn2CUZmheSeyssYw3vMp1+xyub4m+e+QK4sQskvuo4=" crossorigin="anonymous"></script>
<!-- sweetalert2 -->
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- jquery-cookie -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.js"></script>
</body>

</html>
