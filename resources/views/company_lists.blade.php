<!doctype html>
<html lang="ko" data-layout="vertical" data-topbar="light" data-sidebar-size="lg" data-sidebar-image="none" data-body-image="img-1" data-preloader="disable">

<head>
    <meta charset="utf-8" />
    <title>{{env('APP_NAME')}} - 업체리스트</title>
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
                            <h4 class="mb-sm-0">업체 리스트</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">{{env('APP_NAME')}}</a></li>
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
                                                                    <th scope="col">수정</th>
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
                                                                            <a class="head_edit" data-id="{{$row->id}}" data-mode="head">수정</a>
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
                                                                <th scope="col">수정</th>
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
                                                                        <a class="company_edit" data-id="{{$row->id}}" data-mode="franchisee">수정</a>
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
                                                                    <th scope="col">수정</th>
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
                                                                            <a class="company_edit" data-id="{{$row->id}}" data-mode="franchisee">수정</a>
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
                                                                    <th scope="col">수정</th>
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
                                                                            <a class="franchisee_edit" data-id="{{$row->id}}" data-mode="franchisee">수정</a>
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
        <!-- Grids in modals -->
        <!--본사 수정-->
        <div class="modal fade" id="head_company_edit" tabindex="-1" aria-labelledby="exampleModalgridLabel" aria-modal="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalgridLabel">업체수정</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="javascript:void(0);">
                            <div class="row">
                                <div class="col-lg-12 mb-3">
                                    <div>
                                        <label for="firstName" class="form-label">업체 이름</label>
                                        <input type="text" class="form-control" id="company_name" placeholder="">
                                    </div>
                                </div><!--end col-->
                                <div class="col-lg-12 mb-3">
                                    <div>
                                        <label for="lastName" class="form-label">수수료</label>
                                        <input type="text" class="form-control" id="company_margin" placeholder="">
                                    </div>
                                </div><!--end col-->
                                <div class="col-lg-12 mb-3">
                                    <div>
                                        <label for="lastName" class="form-label">잔액</label>
                                        <input type="text" class="form-control" id="company_money" placeholder="">
                                    </div>
                                </div><!--end col-->
                                <div class="col-lg-12 mb-3">
                                    <label for="genderInput" class="form-label">출금 상태</label>
                                    <div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="w_state" id="w_state" value="0">
                                            <label class="form-check-label" for="w_state">출금 가능</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="w_state" id="w_state2" value="1">
                                            <label class="form-check-label" for="w_state2">출금 불가</label>
                                        </div>
                                    </div>
                                </div><!--end col-->
                                <div class="col-lg-12 mb-3">
                                    <label for="genderInput" class="form-label">장 구분</label>
                                    <div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="a_state" id="a_state1" value="0">
                                            <label class="form-check-label" for="a_state1">가상계좌 사용</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="a_state" id="a_state2" value="1">
                                            <label class="form-check-label" for="a_state2">RTPay 사용</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="a_state" id="a_state3" value="2">
                                            <label class="form-check-label" for="a_state2">둘다 사용</label>
                                        </div>
                                    </div>
                                </div><!--end col-->
                                <div class="col-lg-12">
                                    <div class="hstack gap-2 justify-content-end">
                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">취소</button>
                                        <button id="head_save" type="button" class="btn btn-primary" >저장</button>
                                    </div>
                                </div><!--end col-->
                            </div><!--end row-->
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--가맹점 수정-->
        <div class="modal fade" id="franchisee_edit" tabindex="-1" aria-labelledby="exampleModalgridLabel" aria-modal="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalgridLabel">업체수정</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="javascript:void(0);">
                            <div class="row">
                                <div class="col-lg-12 mb-3">
                                    <div>
                                        <label for="firstName" class="form-label">업체 이름</label>
                                        <input type="text" class="form-control" id="franchisee_name" placeholder="">
                                    </div>
                                </div><!--end col-->
                                <div class="col-lg-12 mb-3">
                                    <div>
                                        <label for="lastName" class="form-label">수수료</label>
                                        <input type="text" class="form-control" id="franchisee_margin" placeholder="">
                                    </div>
                                </div><!--end col-->
                                <div class="col-lg-12 mb-3">
                                    <div>
                                        <label for="lastName" class="form-label">잔액</label>
                                        <input type="text" class="form-control" id="franchisee_money" placeholder="">
                                    </div>
                                </div><!--end col-->
                                <div class="col-lg-12 mb-3">
                                    <label for="genderInput" class="form-label">출금 상태</label>
                                    <div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="franchisee_w_state" id="franchisee_w_state1" value="0">
                                            <label class="form-check-label" for="franchisee_w_state1">출금 가능</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="franchisee_w_state" id="franchisee_w_state2" value="1">
                                            <label class="form-check-label" for="franchisee_w_state2">출금 불가</label>
                                        </div>
                                    </div>
                                </div><!--end col-->
                                <div class="col-lg-12 mb-3">
                                    <label for="genderInput" class="form-label">가상계좌 옵션</label>
                                    <div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="franchisee_bank_mode_int" id="franchisee_bank_mode_int1" value="0">
                                            <label class="form-check-label" for="franchisee_bank_mode_int">영구 계좌만 사용</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="franchisee_bank_mode_int" id="franchisee_bank_mode_int2" value="1">
                                            <label class="form-check-label" for="franchisee_bank_mode_int">임시 계좌만 사용</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="franchisee_bank_mode_int" id="franchisee_bank_mode_int3" value="2">
                                            <label class="form-check-label" for="franchisee_bank_mode_int">둘다 사용</label>
                                        </div>
                                    </div>
                                </div><!--end col-->
                                <div class="col-lg-12">
                                    <div class="hstack gap-2 justify-content-end">
                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">취소</button>
                                        <button id="franchisee_save" type="button" class="btn btn-primary" >저장</button>
                                    </div>
                                </div><!--end col-->
                            </div><!--end row-->
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--기타업체 수정-->
        <div class="modal fade" id="company_edit" tabindex="-1" aria-labelledby="exampleModalgridLabel" aria-modal="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalgridLabel">업체수정</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="javascript:void(0);">
                            <div class="row">
                                <div class="col-lg-12 mb-3">
                                    <div>
                                        <label for="firstName" class="form-label">업체 이름</label>
                                        <input type="text" class="form-control" id="name" placeholder="">
                                    </div>
                                </div><!--end col-->
                                <div class="col-lg-12 mb-3">
                                    <div>
                                        <label for="lastName" class="form-label">수수료</label>
                                        <input type="text" class="form-control" id="margin" placeholder="">
                                    </div>
                                </div><!--end col-->
                                <div class="col-lg-12 mb-3">
                                    <div>
                                        <label for="lastName" class="form-label">잔액</label>
                                        <input type="text" class="form-control" id="money" placeholder="">
                                    </div>
                                </div><!--end col-->
                                <div class="col-lg-12 mb-3">
                                    <label for="genderInput" class="form-label">출금 상태</label>
                                    <div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="company_w_state" id="company_w_state1" value="0">
                                            <label class="form-check-label" for="company_w_state1">출금 가능</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="company_w_state" id="company_w_state2" value="1">
                                            <label class="form-check-label" for="company_w_state2">출금 불가</label>
                                        </div>
                                    </div>
                                </div><!--end col-->
                                <div class="col-lg-12">
                                    <div class="hstack gap-2 justify-content-end">
                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">취소</button>
                                        <button id="company_save" type="button" class="btn btn-primary" >저장</button>
                                    </div>
                                </div><!--end col-->
                            </div><!--end row-->
                        </form>
                    </div>
                </div>
            </div>
        </div>
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

<script type="module" src="/assets/js/ajax/company_edit.js"></script>
</body>

</html>
