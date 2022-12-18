<!doctype html>
<html lang="ko" data-layout="vertical" data-topbar="light" data-sidebar-size="lg" data-sidebar-image="none" data-body-image="img-1" data-preloader="disable">

<head>
    <meta charset="utf-8" />
    <title>페이원 - 대시보드</title>
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
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">페이원</a></li>
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
                                            <h4 class="fs-16 mb-1">환영합니다! <b> {{session('name')}}</b> 님!</h4>
                                            <p class="text-muted mb-0">오늘도 즐거운 하루 되시길 바랍니다.</p>
                                        </div>
                                    </div><!-- end card header -->
                                </div>
                                <!--end col-->
                            </div>
                            <!--end row-->

                            <div class="row">
                                <div class="col-xl-3 col-md-6">
                                    <!-- card -->
                                    <div class="card card-animate">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-grow-1 overflow-hidden">
                                                    @php
                                                    if(session('state') == 1 || session('state') == 2 || session('state') == 3){
                                                        $title = "하부 가맹점";
                                                    }elseif(session('state') == 4){
                                                        $title ="";
                                                    }else{
                                                        $title ="";
                                                    }
                                                    @endphp
                                                    <p class="text-uppercase fw-medium text-muted text-truncate mb-0">금일 {{$title}} 매출 금액</p>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-end justify-content-between mt-4">
                                                <div>
                                                    <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span id="today_money" class="counter-value" data-target="{{$today_money}}">0</span> 원</h4>
                                                    <a href="/transaction_history" class="text-decoration-underline">매출 내역 보기</a>
                                                </div>
                                                <div class="avatar-sm flex-shrink-0">
                                                        <span class="avatar-title bg-soft-primary rounded fs-3">
                                                            <i class="bx bx-money text-primary"></i>
                                                        </span>
                                                </div>
                                            </div>
                                        </div><!-- end card body -->
                                    </div><!-- end card -->
                                </div><!-- end col -->
                                <div class="col-xl-3 col-md-6">
                                    <!-- card -->
                                    <div class="card card-animate">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-grow-1 overflow-hidden">
                                                    <p class="text-uppercase fw-medium text-muted text-truncate mb-0">금일 출금 금액</p>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-end justify-content-between mt-4">
                                                <div>
                                                    <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span id="today_w_money"  class="counter-value" data-target="{{$today_withdraw_money}}">0</span> 원</h4>
                                                    <a href="/calculates" class="text-decoration-underline">출금 내역 보기</a>
                                                </div>
                                                <div class="avatar-sm flex-shrink-0">
                                                        <span class="avatar-title bg-soft-primary rounded fs-3">
                                                            <i class="bx bx-money-withdraw text-primary"></i>
                                                        </span>
                                                </div>
                                            </div>
                                        </div><!-- end card body -->
                                    </div><!-- end card -->
                                </div><!-- end col -->
                                <div class="col-xl-2 col-md-6">
                                    <!-- card -->
                                    <div class="card card-animate">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-grow-1 overflow-hidden">
                                                    <p class="text-uppercase fw-medium text-muted text-truncate mb-0">현재 잔액</p>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-end justify-content-between mt-4">
                                                <div>
                                                    <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span id="my_money" class="counter-value" data-target="{{$my_money}}">0</span> 원</h4>
                                                    <a href="" class="text-decoration-underline">출금 요청</a>
                                                </div>
                                                <div class="avatar-sm flex-shrink-0">
                                                        <span class="avatar-title bg-soft-primary rounded fs-3">
                                                            <i class="bx bxs-bank text-primary"></i>
                                                        </span>
                                                </div>
                                            </div>
                                        </div><!-- end card body -->
                                    </div><!-- end card -->
                                </div><!-- end col -->
                                <div class="col-xl-2 col-md-6">
                                    <!-- card -->
                                    <div class="card card-animate">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-grow-1 overflow-hidden">
                                                    <p class="text-uppercase fw-medium text-muted text-truncate mb-0">금일 {{$title}} 입금 건수</p>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-end justify-content-between mt-4">
                                                <div>
                                                    <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span id="today_count"  class="counter-value" data-target="{{$today_money_count}}">0</span> 건</h4>
                                                    <a href="/transaction_history" class="text-decoration-underline">매출 내역 더보기</a>
                                                </div>
                                                <div class="avatar-sm flex-shrink-0">
                                                        <span class="avatar-title bg-soft-primary rounded fs-3">
                                                            <i class="bx bxs-download text-primary"></i>
                                                        </span>
                                                </div>
                                            </div>
                                        </div><!-- end card body -->
                                    </div><!-- end card -->
                                </div><!-- end col -->
                                <div class="col-xl-2 col-md-6">
                                    <!-- card -->
                                    <div class="card card-animate">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-grow-1 overflow-hidden">
                                                    <p class="text-uppercase fw-medium text-muted text-truncate mb-0">금일 출금 건수</p>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-end justify-content-between mt-4">
                                                <div>
                                                    <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span id="today_count"  class="counter-value" data-target="{{$today_withdraw_count}}">0</span> 건</h4>
                                                    <a href="/calculates" class="text-decoration-underline">정산 내역 더보기</a>
                                                </div>
                                                <div class="avatar-sm flex-shrink-0">
                                                        <span class="avatar-title bg-soft-primary rounded fs-3">
                                                            <i class="bx bxs-download text-primary"></i>
                                                        </span>
                                                </div>
                                            </div>
                                        </div><!-- end card body -->
                                    </div><!-- end card -->
                                </div><!-- end col -->
                            </div> <!-- end row-->

                            <div class="row">
                                <div class="col-xl-8">
                                    <div class="card">
                                        <div class="card-header border-0 align-items-center d-flex">
                                            <h4 class="card-title mb-0 flex-grow-1">거래 요약</h4>
                                        </div><!-- end card header -->
                                        <div class="card-body p-0 pb-2">
                                            <div class="w-100">
                                                <div id="customer_impression_charts" data-colors='["--vz-secondary", "--vz-primary", "--vz-primary-rgb, 0.50"]' class="apex-charts" dir="ltr"></div>
                                            </div>
                                        </div><!-- end card body -->
                                    </div><!-- end card -->
                                </div><!-- end col -->

                                <div class="col-xl-4">
                                    <!-- card -->
                                    <div class="card card-height-100">
                                        <div class="card-header align-items-center d-flex">
                                            <h4 class="card-title mb-0 flex-grow-1">공지사항</h4>
                                        </div><!-- end card header -->

                                        <!-- card body -->
                                        <div class="card-body" style="overflow: scroll; width: 100%; height: 200px;">
                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item"><a href="#"><b>[2022-12-14] [공지]</b> 무중단 점검 안내</a></li>

                                            </ul>
                                        </div>
                                        <!-- end card body -->
                                    </div>
                                    <!-- end card -->
                                </div>
                                <!-- end col -->
                            </div>
                            @if(count($data) != 0)
                                @if(session('state') == 0)
                                {{--최고 관리자 거래내역--}}
                                <div class="row">
                                    <div class="col-xl">
                                        <div class="card">
                                            <div class="card-header align-items-center d-flex">
                                                <h4 class="card-title mb-0 flex-grow-1">최근 거래내역<br><b style="font-size: 12px">수수료 는 해당 업체 위로 올려주는 금액이며 괄호 안에있는 금액이 실 해당 업체의 적립금 입니다.</b></h4>
                                                <div class="flex-shrink-0">
                                                    <a href="#" class="btn btn-soft-info btn-sm">
                                                        <i class="ri-file-list-3-line align-middle"></i> 더보기
                                                    </a>
                                                </div>
                                            </div><!-- end card header -->

                                            <div class="card-body">
                                                <div class="table-responsive table-card">
                                                    <table class="table table-borderless table-centered align-middle table-nowrap mb-0">
                                                        <thead class="text-muted table-light">
                                                        <tr class="text-center">
                                                            <th scope="col">거래 번호</th>
                                                            <th scope="col">거래 일자</th>
                                                            <th scope="col">거래 대상</th>
                                                            <th scope="col">입금자</th>
                                                            <th scope="col">거래 금액</th>
                                                            <th scope="col">본사 수수료(실적립금)</th>
                                                            <th scope="col">지사 수수료(실적립금)</th>
                                                            <th scope="col">총판 수수료(실적립금)</th>
                                                            <th scope="col">가맹점 수수료(실적립금)</th>
                                                            <th scope="col">상태</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($data as $row)
                                                        <tr class="text-center">
                                                            <td>
                                                                <a class="fw-medium link-primary text-center">{{$row->transaction_key}}</a>
                                                            </td>
                                                            <td>{{$row->date_ymd}} {{$row->date_time}}</td>
                                                            <td>{{$row->company_name}}</td>
                                                            <td>{{$row->transaction_user_name}}</td>
                                                            <td><span class="text-success">{{number_format($row->transaction_money)}}</span>원</td>
                                                            <td>
                                                                {{$row->head_fee}}<span>원</span>
                                                            </td>
                                                            <td>
                                                                {{$row->branch_fee}}<span>원</span>
                                                            </td>
                                                            <td>
                                                                {{$row->distributor_fee}}<span>원</span>
                                                            </td>
                                                            <td>
                                                                {{number_format($row->franchisee_fee)}}({{number_format($row->franchisee_money)}})<span>원</span>
                                                            </td>
                                                            <td>
                                                                <span class="badge badge-soft-success">입금 완료</span>
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
                                @elseif(session('state') == 1)
                                {{--본사 거래내역--}}
                                <div class="row">
                                    <div class="col-xl">
                                        <div class="card">
                                            <div class="card-header align-items-center d-flex">
                                                <h4 class="card-title mb-1 flex-grow-1">최근 거래내역 <br><b style="font-size: 12px">수수료 는 해당 업체 위로 올려주는 금액이며 괄호 안에있는 금액이 실 해당 업체의 적립금 입니다.</b></h4>
                                                <div class="flex-shrink-0">
                                                    <a href="#" class="btn btn-soft-info btn-sm">
                                                        <i class="ri-file-list-3-line align-middle"></i> 더보기
                                                    </a>
                                                </div>
                                            </div><!-- end card header -->

                                            <div class="card-body">
                                                <div class="table-responsive table-card">
                                                    <table class="table table-borderless table-centered align-middle table-nowrap mb-0">
                                                        <thead class="text-muted table-light">
                                                        <tr class="text-center">
                                                            <th scope="col">거래 번호</th>
                                                            <th scope="col">거래 일자</th>
                                                            <th scope="col">거래 대상</th>
                                                            <th scope="col">입금자</th>
                                                            <th scope="col">거래 금액</th>
                                                            <th scope="col">지사 수수료(실적립금)</th>
                                                            <th scope="col">총판 수수료(실적립금)</th>
                                                            <th scope="col">가맹점 수수료(실적립금)</th>
                                                            <th scope="col">상태</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($data as $row)
                                                            <tr class="text-center">
                                                                <td>
                                                                    <a class="fw-medium link-primary text-center">{{$row->transaction_key}}</a>
                                                                </td>
                                                                <td>{{$row->date_ymd}} {{$row->date_time}}</td>
                                                                <td>{{$row->company_name}}</td>
                                                                <td>{{$row->transaction_user_name}}</td>
                                                                <td><span class="text-success">{{number_format($row->transaction_money)}}</span>원</td>
                                                                <td>
                                                                    {{$row->branch_fee}}<span>원</span>
                                                                </td>
                                                                <td>
                                                                    {{$row->distributor_fee}}<span>원</span>
                                                                </td>
                                                                <td>
                                                                    {{number_format($row->franchisee_fee)}}({{number_format($row->franchisee_money)}})<span>원</span>
                                                                </td>
                                                                <td>
                                                                    <span class="badge badge-soft-success">입금 완료</span>
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
                                @elseif(session('state') == 2)
                                {{--지사 거래내역--}}
                                <div class="row">
                                    <div class="col-xl">
                                        <div class="card">
                                            <div class="card-header align-items-center d-flex">
                                                <h4 class="card-title mb-1 flex-grow-1">최근 거래내역 <br><b style="font-size: 12px">수수료 는 해당 업체 위로 올려주는 금액이며 괄호 안에있는 금액이 실 해당 업체의 적립금 입니다.</b></h4>
                                                <div class="flex-shrink-0">
                                                    <a href="#" class="btn btn-soft-info btn-sm">
                                                        <i class="ri-file-list-3-line align-middle"></i> 더보기
                                                    </a>
                                                </div>
                                            </div><!-- end card header -->

                                            <div class="card-body">
                                                <div class="table-responsive table-card">
                                                    <table class="table table-borderless table-centered align-middle table-nowrap mb-0">
                                                        <thead class="text-muted table-light">
                                                        <tr class="text-center">
                                                            <th scope="col">거래 번호</th>
                                                            <th scope="col">거래 일자</th>
                                                            <th scope="col">거래 대상</th>
                                                            <th scope="col">입금자</th>
                                                            <th scope="col">거래 금액</th>
                                                            <th scope="col">총판 수수료(실적립금)</th>
                                                            <th scope="col">가맹점 수수료(실적립금)</th>
                                                            <th scope="col">상태</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($data as $row)
                                                            <tr class="text-center">
                                                                <td>
                                                                    <a class="fw-medium link-primary text-center">{{$row->transaction_key}}</a>
                                                                </td>
                                                                <td>{{$row->date_ymd}} {{$row->date_time}}</td>
                                                                <td>{{$row->company_name}}</td>
                                                                <td>{{$row->transaction_user_name}}</td>
                                                                <td><span class="text-success">{{number_format($row->transaction_money)}}</span>원</td>
                                                                <td>
                                                                    {{$row->distributor_fee}}<span>원</span>
                                                                </td>
                                                                <td>
                                                                    {{number_format($row->franchisee_fee)}}({{number_format($row->franchisee_money)}})<span>원</span>
                                                                </td>
                                                                <td>
                                                                    <span class="badge badge-soft-success">입금 완료</span>
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
                                @elseif(session('state') == 3)
                                {{--총판 거래내역--}}
                                <div class="row">
                                    <div class="col-xl">
                                        <div class="card">
                                            <div class="card-header align-items-center d-flex">
                                                <h4 class="card-title mb-0 flex-grow-1">최근 거래내역<br><b style="font-size: 12px">수수료 는 해당 업체 위로 올려주는 금액이며 괄호 안에있는 금액이 실 해당 업체의 적립금 입니다.</b></h4>
                                                <div class="flex-shrink-0">
                                                    <a href="#" class="btn btn-soft-info btn-sm">
                                                        <i class="ri-file-list-3-line align-middle"></i> 더보기
                                                    </a>
                                                </div>
                                            </div><!-- end card header -->

                                            <div class="card-body">
                                                <div class="table-responsive table-card">
                                                    <table class="table table-borderless table-centered align-middle table-nowrap mb-0">
                                                        <thead class="text-muted table-light">
                                                        <tr class="text-center">
                                                            <th scope="col">거래 번호</th>
                                                            <th scope="col">거래 일자</th>
                                                            <th scope="col">거래 대상</th>
                                                            <th scope="col">입금자</th>
                                                            <th scope="col">거래 금액</th>
                                                            <th scope="col">가맹점 수수료(실적립금)</th>
                                                            <th scope="col">상태</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($data as $row)
                                                            <tr class="text-center">
                                                                <td>
                                                                    <a class="fw-medium link-primary text-center">{{$row->transaction_key}}</a>
                                                                </td>
                                                                <td>{{$row->date_ymd}} {{$row->date_time}}</td>
                                                                <td>{{$row->company_name}}</td>
                                                                <td>{{$row->transaction_user_name}}</td>
                                                                <td><span class="text-success">{{number_format($row->transaction_money)}}</span>원</td>
                                                                <td>
                                                                    {{number_format($row->franchisee_fee)}}({{number_format($row->franchisee_money)}})<span>원</span>
                                                                </td>
                                                                <td>
                                                                    <span class="badge badge-soft-success">입금 완료</span>
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
                                @elseif(session('state') == 4)
                                {{--가맹점 거래내역--}}
                                <div class="row">
                                    <div class="col-xl">
                                        <div class="card">
                                            <div class="card-header align-items-center d-flex">
                                                <h4 class="card-title mb-0 flex-grow-1">최근 거래내역</h4>
                                                <div class="flex-shrink-0">
                                                    <a href="#" class="btn btn-soft-info btn-sm">
                                                        <i class="ri-file-list-3-line align-middle"></i> 더보기
                                                    </a>
                                                </div>
                                            </div><!-- end card header -->

                                            <div class="card-body">
                                                <div class="table-responsive table-card">
                                                    <table class="table table-borderless table-centered align-middle table-nowrap mb-0">
                                                        <thead class="text-muted table-light">
                                                        <tr class="text-center">
                                                            <th scope="col">거래 번호</th>
                                                            <th scope="col">거래 일자</th>
                                                            <th scope="col">거래 대상</th>
                                                            <th scope="col">입금자</th>
                                                            <th scope="col">거래 금액</th>
                                                            <th scope="col">수수료</th>
                                                            <th scope="col">실적립 금액</th>
                                                            <th scope="col">상태</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($data as $row)
                                                            <tr class="text-center">
                                                                <td>
                                                                    <a class="fw-medium link-primary text-center">{{$row->transaction_key}}</a>
                                                                </td>
                                                                <td>{{$row->date_ymd}} {{$row->date_time}}</td>
                                                                <td>{{$row->company_name}}</td>
                                                                <td>{{$row->transaction_user_name}}</td>
                                                                <td><span class="text-success">{{number_format($row->transaction_money)}}</span> 원</td>
                                                                <td>
                                                                    {{number_format($row->franchisee_fee)}}<span> 원</span>
                                                                </td>
                                                                <td>{{number_format($row->franchisee_money)}} 원</td>
                                                                <td>
                                                                    <span class="badge badge-soft-success">입금 완료</span>
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

                            @if(count($data) == 0)
                            <div id="index_not_data" class="row">
                                <div class="col-xl">
                                    <div class="card">
                                        <div class="card-header align-items-center d-flex">
                                            <h4 class="card-title mb-0 flex-grow-1">최근 거래내역</h4>
                                            <div class="flex-shrink-0">
                                                <a href="#" class="btn btn-soft-info btn-sm">
                                                    <i class="ri-file-list-3-line align-middle"></i> 더보기
                                                </a>
                                            </div>
                                        </div><!-- end card header -->

                                        <div class="card-body">
                                            <div class="table-responsive table-card">
                                                <div class="mb-1 mt-1 text-center">데이터가 존재하지 않습니다.</div>
                                            </div>
                                        </div>
                                    </div> <!-- .card-->
                                </div> <!-- .col-->
                            </div> <!-- end row-->
                            @endif
                        </div> <!-- end .h-100-->
                    </div> <!-- end col -->
                    @if(session('state') == 4 && session('bank_mode_int') != 3)
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
                                                @if($bank_mode_int == 0 || $bank_mode_int == 2)
                                                <div class="col-md-12">
                                                    <div class="mb-3">
                                                        <label for="firstNameinput" class="form-label">영구 계좌 발급 링크</label>
                                                        <input type="text" class="form-control" value="https://paysone.kr/account_issuance/{{$bank_route}}?mode=0" id="firstNameinput" disabled>
                                                    </div>
                                                </div>
                                                @endif
                                                @if($bank_mode_int == 1 || $bank_mode_int == 2)
                                                <div class="col-md-12">
                                                    <div class="mb-3">
                                                        <label for="lastNameinput" class="form-label">임시 계좌 발급 링크</label>
                                                        <input type="text" class="form-control" value="https://paysone.kr/account_issuance/{{$bank_route}}?mode=1" id="lastNameinput" disabled>
                                                    </div>
                                                </div>
                                                @endif
                                            </div>
                                            <!--end row-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- end col -->
                    </div>
                    @endif
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
<!-- login -->
<script type="module" src="/assets/js/ajax/index.js"></script>
<!-- jquery-cookie -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.js"></script>
</body>

</html>
