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
                            <h4 class="mb-sm-0">업체 등록</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item active"><a href="javascript: void(0);">업체 등록</a></li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- end page title -->
                {{--본사 추가--}}
                @if(session('state')==0)
                    @if($_GET['mode'] == 0)
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <form id="one_company_form" >
                                        <div class="card-body">
                                            <h4 class="card-title mb-4">본사 등록</h4>
                                            <div class="row mb-4">
                                                <label for="projectname" class="col-form-label col-lg-2">본사 이름</label>
                                                <div class="col-lg-10">
                                                    <input id="company_name" type="text" class="form-control" placeholder="본사 이름">
                                                </div>
                                            </div>


                                            <div class="row mb-4">
                                                <label for="projectname" class="col-form-label col-lg-2">아이디</label>
                                                <div class="col-lg-10">
                                                    <input id="user_id" type="text" class="form-control" placeholder="아이디 ">
                                                </div>
                                            </div>
                                            <div class="row mb-4">
                                                <label for="projectname" class="col-form-label col-lg-2">비밀번호</label>
                                                <div class="col-lg-10">
                                                    <input id="user_password" type="text" class="form-control"
                                                           placeholder="비밀번호">
                                                </div>
                                            </div>

                                            <div class="row mb-4">
                                                <label for="projectbudget" class="col-form-label col-lg-2">수수료</label>
                                                <div class="col-lg-10">
                                                    <input id="company_margin" name="projectbudget" type="text"
                                                           placeholder="수수료 를 입력해주세요. 0.3%일시에는 0.03 으로 입력 반드시 숫자와 . 만 가능합니다." class="form-control">
                                                </div>
                                            </div>


                                            <div class="row justify-content-end">
                                                <div class="col-lg-10">
                                                    <button type="button" class="company_add btn btn-primary" data-mode="0">생성
                                                    </button>
                                                </div>
                                            </div>

                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif
                @endif
                {{--지사 추가--}}
                @if($_GET['mode'] == 1)
                    <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <form id="one_company_form" >
                                <div class="card-body">
                                    <h4 class="card-title mb-4">지사 등록</h4>
                                    <div class="row mb-4">
                                        <label for="projectname" class="col-form-label col-lg-2">본사 선택</label>
                                        <div class="col-lg-10">
                                            <select class="form-control select2-ajax" id="set_key">
                                                <option value="">--선택---</option>
                                                @foreach($data as $row)
                                                <option value="{{$row->company_key}}">{{$row->company_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row mb-4">
                                        <label for="projectname" class="col-form-label col-lg-2">지사 이름</label>
                                        <div class="col-lg-10">
                                            <input id="company_name" type="text" class="form-control" placeholder="지사 이름">
                                        </div>
                                    </div>

                                    <div class="row mb-4">
                                        <label for="projectname" class="col-form-label col-lg-2">아이디</label>
                                        <div class="col-lg-10">
                                            <input id="user_id" type="text" class="form-control" placeholder="아이디 ">
                                        </div>
                                    </div>

                                    <div class="row mb-4">
                                        <label for="projectname" class="col-form-label col-lg-2">비밀번호</label>
                                        <div class="col-lg-10">
                                            <input id="user_password" type="text" class="form-control"
                                                   placeholder="비밀번호">
                                        </div>
                                    </div>

                                    <div class="row mb-4">
                                        <label for="projectbudget" class="col-form-label col-lg-2">수수료</label>
                                        <div class="col-lg-10">
                                            <input id="company_margin" name="projectbudget" type="text"
                                                   placeholder="수수료 를 입력해주세요. 0.3%일시에는 0.03 으로 입력 반드시 숫자와 . 만 가능합니다." class="form-control">
                                        </div>
                                    </div>


                                    <div class="row justify-content-end">
                                        <div class="col-lg-10">
                                            <button type="button" class="company_add btn btn-primary" data-mode="1">생성
                                            </button>
                                        </div>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @endif
                {{--총판 추가--}}
                @if($_GET['mode'] == 2)
                    <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <form id="two_company_form">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">총판 등록</h4>
                                    <div class="row mb-4">
                                        <label class="col-form-label col-lg-2">지사 선택 *</label>
                                        <div class="col-md-10">
                                            <select class="form-control select2-ajax" id="set_key">
                                                <option value="">--선택---</option>
                                                @foreach($data as $row)
                                                    <option value="{{$row->company_key}}">{{$row->company_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label for="projectname" class="col-form-label col-lg-2">총판 이름</label>
                                        <div class="col-lg-10">
                                            <input id="company_name" type="text" class="form-control" placeholder="총판 이름">
                                        </div>
                                    </div>

                                    <div class="row mb-4">
                                        <label for="projectname" class="col-form-label col-lg-2">아이디</label>
                                        <div class="col-lg-10">
                                            <input id="user_id" type="text" class="form-control" placeholder="아이디 ">
                                        </div>
                                    </div>

                                    <div class="row mb-4">
                                        <label for="projectname" class="col-form-label col-lg-2">비밀번호</label>
                                        <div class="col-lg-10">
                                            <input id="user_password" type="text" class="form-control"
                                                   placeholder="비밀번호">
                                        </div>
                                    </div>

                                    <div class="row mb-4">
                                        <label for="projectbudget" class="col-form-label col-lg-2">수수료</label>
                                        <div class="col-lg-10">
                                            <input id="company_margin" name="projectbudget" type="text"
                                                   placeholder="수수료 를 입력해주세요. 0.3%일시에는 0.03 으로 입력 반드시 숫자와 . 만 가능합니다." class="form-control">
                                        </div>
                                    </div>


                                    <div class="row justify-content-end">
                                        <div class="col-lg-10">
                                            <button type="button" class="company_add btn btn-primary" data-mode="2">생성
                                            </button>
                                        </div>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @endif
                {{--가맹점 추가--}}
                @if($_GET['mode'] == 3)
                    <div class="row">
                    <div class="col-lg-12">
                        <form id="three_company_add_form">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">가맹점 등록</h4>
                                    <div class="row mb-4">
                                        <label class="col-form-label col-lg-2">총판 선택 *</label>
                                        <div class="col-md-10">
                                            <select class="form-control select2-ajax" id="set_key">
                                                <option value="">--선택---</option>
                                                @foreach($data as $row)
                                                    <option value="{{$row->company_key}}">{{$row->company_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label for="projectname" class="col-form-label col-lg-2">가맹점 이름 *</label>
                                        <div class="col-lg-10">
                                            <input id="company_name" type="text" class="form-control" placeholder="가맹점 이름">
                                        </div>
                                    </div>


                                    <div class="row mb-4">
                                        <label for="projectname" class="col-form-label col-lg-2">아이디 *</label>
                                        <div class="col-lg-10">
                                            <input id="user_id" type="text" class="form-control" placeholder="아이디 ">
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label for="projectname" class="col-form-label col-lg-2">비밀번호 *</label>
                                        <div class="col-lg-10">
                                            <input id="user_password" type="text" class="form-control"
                                                   placeholder="비밀번호">
                                        </div>
                                    </div>

                                    <div class="row mb-4">
                                        <label for="projectbudget" class="col-form-label col-lg-2">수수료 *</label>
                                        <div class="col-lg-10">
                                            <input id="company_margin" name="projectbudget" type="text"
                                                   placeholder="수수료 를 입력해주세요. 0.3%일시에는 0.03 으로 입력 반드시 숫자와 . 만 가능합니다." class="form-control">
                                        </div>
                                    </div>

                                    <div class="row mb-4">
                                        <label for="projectname" class="col-form-label col-lg-2">출금비 *</label>
                                        <div class="col-lg-10">
                                            <input id="calculate_fee" type="test" class="form-control"
                                                   placeholder="숫자로만 를 입력해주세요.">
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label for="projectbudget" class="col-form-label col-lg-2">입금비 *</label>
                                        <div class="col-lg-10">
                                            <input id="company_fee" name="projectbudget" type="text"
                                                   placeholder="숫자로만 를 입력해주세요." class="form-control">
                                        </div>
                                    </div>

                                    <div class="row mb-4">
                                        <label for="projectbudget" class="col-form-label col-lg-2">가상계좌 옵션 *</label>
                                        <div class="col-lg-10">
                                            <select class="form-control select2-ajax" id="bank_mode">
                                                <option value="">--선택---</option>
                                                    <option value="0">영구계좌만 허용</option>
                                                    <option value="1">임시계좌만 허용</option>
                                                    <option value="2">둘다 허용</option>
                                            </select>
                                        </div>
                                    </div>


                                    <div class="row justify-content-end">
                                        <div class="col-lg-10">
                                            <button type="button" class="company_add btn btn-primary" data-mode="3">생성
                                            </button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                @endif
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
<script type="module" src="/assets/js/ajax/add_company.js"></script>
<!-- jquery-cookie -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.js"></script>
</body>

</html>
