<!doctype html>
<html lang="ko" data-layout="vertical" data-topbar="light" data-sidebar-size="lg" data-sidebar-image="none" data-body-image="img-1" data-preloader="disable">

<head>
    <meta charset="utf-8" />
    <title>페이원 - 계좌발급</title>
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
                                            <input id="bank_user_name" value="" type="text" class="form-control" placeholder="예금주 명">
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label for="projectname" class="col-form-label col-lg-2">계좌번호 *</label>
                                        <div class="col-lg-10">
                                            <input id="bank_number" value="" type="text" class="form-control" placeholder="계좌번호">
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label for="projectname" class="col-form-label col-lg-2">은행 *</label>
                                        <div class="col-lg-10">
                                            <select id="bank_code" class="form-select test">
                                                <option value="002" data-select2-id="2">한국산업은행</option>
                                                <option value="003" data-select2-id="10">중소기업은행</option>
                                                <option value="007" data-select2-id="11">수협은행</option>
                                                <option value="011" data-select2-id="12">농협(중앙회)</option>
                                                <option value="012" data-select2-id="13">농협(지역)</option>
                                                <option value="020" data-select2-id="14">우리은행</option>
                                                <option value="023" data-select2-id="15">SC은행</option>
                                                <option value="027" data-select2-id="16">한국씨티은행</option>
                                                <option value="031" data-select2-id="17">대구은행</option>
                                                <option value="032" data-select2-id="18">부산은행</option>
                                                <option value="034" data-select2-id="19">광주은행</option>
                                                <option value="035" data-select2-id="20">제주은행</option>
                                                <option value="037" data-select2-id="21">전북은행</option>
                                                <option value="039" data-select2-id="22">경남은행</option>
                                                <option value="045" data-select2-id="23">새마을금고</option>
                                                <option value="048" data-select2-id="24">신협</option>
                                                <option value="092" data-select2-id="25">토스뱅크</option>
                                                <option value="090" data-select2-id="26">카카오뱅크</option>
                                                <option value="052" data-select2-id="27">모간스탠리</option>
                                                <option value="054" data-select2-id="28">홍콩상하이은행</option>
                                                <option value="055" data-select2-id="29">도이치은행</option>
                                                <option value="056" data-select2-id="30">에이비엔암로은행</option>
                                                <option value="058" data-select2-id="31">미즈호코퍼레이트은행</option>
                                                <option value="059" data-select2-id="32">도쿄미쓰비시은행</option>
                                                <option value="060" data-select2-id="33">뱅크오브아메리카</option>
                                                <option value="064" data-select2-id="34">산림조합</option>
                                                <option value="071" data-select2-id="35">우체국</option>
                                                <option value="081" data-select2-id="36">KEB 하나은행</option>
                                                <option value="088" data-select2-id="37">신한은행</option>
                                                <option value="209" data-select2-id="38">유안타증권</option>
                                                <option value="218" data-select2-id="39">현대증권</option>
                                                <option value="230" data-select2-id="40">미래에셋증권</option>
                                                <option value="238" data-select2-id="41">대우증권</option>
                                                <option value="240" data-select2-id="42">삼성증권</option>
                                                <option value="243" data-select2-id="43">한국투자증권</option>
                                                <option value="247" data-select2-id="44">우리투자증권</option>
                                                <option value="261" data-select2-id="45">교보증권</option>
                                                <option value="262" data-select2-id="46">하이투자증권</option>
                                                <option value="263" data-select2-id="47">에이치엠씨투자증권</option>
                                                <option value="264" data-select2-id="48">키움증권</option>
                                                <option value="265" data-select2-id="49">이트레이드증권</option>
                                                <option value="266" data-select2-id="50">에스케이증권</option>
                                                <option value="267" data-select2-id="51">대신증권</option>
                                                <option value="268" data-select2-id="52">솔로몬투자증권</option>
                                                <option value="269" data-select2-id="53">한화증권</option>
                                                <option value="270" data-select2-id="54">하나대투증권</option>
                                                <option value="278" data-select2-id="55">굿모닝신한증권</option>
                                                <option value="279" data-select2-id="56">동부증권</option>
                                                <option value="280" data-select2-id="57">유진투자증권</option>
                                                <option value="287" data-select2-id="58">메리츠증권</option>
                                                <option value="289" data-select2-id="59">엔에이치투자증권</option>
                                                <option value="290" data-select2-id="60">부국증권</option>
                                                <option value="291" data-select2-id="61">신영증권</option>
                                                <option value="292" data-select2-id="62">엘아이지투자증권</option>
                                                <option value="089" data-select2-id="63">케이뱅크</option>
                                                <option value="105" data-select2-id="64">웰컴저축은행</option>
                                                <option value="288" data-select2-id="65">카카오페이증권</option>
                                                <option value="050" data-select2-id="66">상호저축은행</option>
                                                <option value="004" data-select2-id="67">국민은행</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row justify-content-end">
                                        <div class="col-lg-10">
                                            <button type="button" onclick="Won_shipment();" class="btn btn-primary info-change">1원인증</button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div style="display:none;" class="row" id="two">
                    <div class="col-lg-12">
                        <form id="three_company_add_form">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">본인계좌 1원 인증</h4>
                                    <div class="row mb-4">
                                        <label class="col-form-label col-lg-2">인증번호*</label>
                                        <div class="col-md-10">
                                            <input id="verifyVal" value="" type="text" class="form-control" placeholder="기 계좌로 입금된 1원의 입금자명을 적어주세요.">
                                        </div>
                                    </div>
                                    <p style="color:red">
                                        입금되지 않았다면 새로고침후 계좌번호를 확인해주세요.</p>
                                    <div class="row justify-content-end">
                                        <div class="col-lg-10">
                                            <button type="button" onclick="bank_check();" class="btn btn-primary info-change">발급</button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- end row -->
                </div>
                @if($_GET['mode'] == 1)
                <div style="display:none;" class="row" id="three">
                    <div class="col-lg-12">
                        <form id="three_company_add_form">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">입금하실 금액</h4>
                                    <div class="row mb-4">
                                        <label class="col-form-label col-lg-2">입금하실 금액*</label>
                                        <div class="col-md-10">
                                            <input id="verifyVal" value="" type="text" class="form-control" placeholder="입금하실 금액을 숫자로만 입력해주세요">
                                        </div>
                                    </div>
                                    <div class="row justify-content-end">
                                        <div class="col-lg-10">
                                            <button type="button" onclick="bank_check();" class="btn btn-primary info-change">발급</button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- end row -->
                </div>
                @endif
                <div style="display:none;" class="row" id="for">
                    <div class="col-lg-12">
                        <form id="three_company_add_form">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">계좌발급 완료</h4>
                                    <div class="row mb-4">
                                        <label class="col-form-label col-lg-2">입금하실 계좌번호 (경남은행)</label>
                                        <div class="col-md-10">
                                            <input id="bankAcctNo" value="" type="text" class="form-control" disabled>
                                        </div>
                                    </div>
                                    @if($_GET['mode'] == 1)
                                        <div class="row mb-4">
                                            <label class="col-form-label col-lg-2">입금 금액</label>
                                            <div class="col-md-10">
                                                <input id="money" value="" type="text" class="form-control" disabled>
                                            </div>
                                        </div>
                                    @endif
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
        <!-- END layout-wrapper -->

        <input type="hidden" value="{{$company_id}}" id="company_id">
        <input type="hidden" value="{{$route_id}}" id="route_id">
        <!-- JAVASCRIPT -->
        <script src="/assets/libs/jquery/jquery.min.js"></script>
        <script src="/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="/assets/libs/metismenu/metisMenu.min.js"></script>
        <script src="/assets/libs/simplebar/simplebar.min.js"></script>
        <script src="/assets/libs/node-waves/waves.min.js"></script>

        <!-- bootstrap datepicker -->
        <script src="/assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>

        <!-- dropzone plugin -->
        <script src="/assets/libs/dropzone/min/dropzone.min.js"></script>

        <script src="/assets/js/app.js"></script>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.9/js/select2.min.js"></script>

        <script>
            let route_id = $('#route_id').val();
            let company_id = $('#company_id').val();

            function Won_shipment(){
                $.ajax({
                    type: "POST",
                    url: '/api/v1/user/1won_shipment/'+route_id,
                    headers: {
                        "Content-Type": "application/json",
                    },
                    data:{
                        bankCode:$('#bank_code').val(),
                        acctNo:$('#bank_number').val(),
                        custNm:$('#bank_user_name').val()
                    },
                    success: function (res) {
                        $("#one").css("display","none");
                        $("#two").css("display","");
                        Swal.close()
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        let data = XMLHttpRequest.responseJSON;
                        Swal.fire({
                            icon: "error",
                            title: `에러(${data.result.resultCd})`,
                            text: data.result.advanceMsg,
                        });
                    },
                });
            }
        </script>

        <!-- end main content-->

</div>
</body>
</html>
