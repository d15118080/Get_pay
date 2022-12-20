<div class="app-menu navbar-menu border-end">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="/" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="/assets/images/logo-sm.png" alt="" height="22">
                    </span>
            <span class="logo-lg">
                        <p>{{env('APP_NAME')}}</p>
                    </span>
        </a>
        <!-- Light Logo-->
        <a href="/" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="/assets/images/logo-sm.png" alt="" height="22">
                    </span>
            <span class="logo-lg">
                        <img src="/assets/images/logo-light.png" alt="" height="17">
                    </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">

            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span data-key="t-menu">메뉴</span></li>
                <li class="nav-item">
                    <a class="nav-link" href="/">
                        <i class="ri-dashboard-2-line"></i> <span data-key="t-ecommerce">대시보드</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebardeal" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarApps">
                        <i class="ri-apps-2-line"></i> <span data-key="t-apps">매출 관리</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebardeal">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="/transaction_history" class="nav-link" data-key="t-calendar"> 거래 내역 </a>
                            </li>
                            <li class="nav-item">
                                <a href="/calculates" class="nav-link" data-key="t-chat"> 정산 내역 </a>
                            </li>
                            <li class="nav-item">
                                <a href="/calculate_view" class="nav-link" data-key="t-email"> 정산 요청</a>
                            </li>
                            @if(session('state') == 0 || session('state') == 1)
                            <li class="nav-item">
                                <a href="/calculate_admin_view" class="nav-link" data-key="t-email"> 정산 요청 승인/거절 </a>
                            </li>
                            @endif
                        </ul>
                    </div>
                </li>
{{--                이노페이 / Rtpay 관련 추후 추가예정--}}
{{--                <li class="nav-item">--}}
{{--                    <a class="nav-link menu-link" href="#money_setting" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarApps">--}}
{{--                        <i class="ri-apps-2-line"></i> <span data-key="t-apps">잔액 관리</span>--}}
{{--                    </a>--}}
{{--                    <div class="collapse menu-dropdown" id="money_setting">--}}
{{--                        <ul class="nav nav-sm flex-column">--}}
{{--                            <li class="nav-item">--}}
{{--                                <a href="/charge" class="nav-link" data-key="t-calendar"> 충전 요청(입금확인요청) </a>--}}
{{--                            </li>--}}
{{--                            <li class="nav-item">--}}
{{--                                <a href="#" class="nav-link" data-key="t-email"> 송금 요청</a>--}}
{{--                            </li>--}}
{{--                            <li class="nav-item">--}}
{{--                                <a href="#" class="nav-link" data-key="t-email"> 송금 내역</a>--}}
{{--                            </li>--}}
{{--                        </ul>--}}
{{--                    </div>--}}
{{--                </li>--}}
                @if(session('state') == 0)
                {{--관리자메뉴--}}
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarAccount-1" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarLayouts">
                        <i class="ri-account-circle-line"></i> <span data-key="t-layouts">본사 관리</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarAccount-1">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="/company_lists?mode=all"  class="nav-link" data-key="t-horizontal">본사 리스트</a>
                            </li>
                            <li class="nav-item">
                                <a href="/add_company?mode=0" class="nav-link" data-key="t-detached">본사 추가</a>
                            </li>
                        </ul>
                    </div>
                </li>
                @endif

                @if(session('state') == 1 ||session('state') == 0)
                {{--본사메뉴--}}
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarAccount-2" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarLayouts">
                        <i class="ri-account-circle-line"></i> <span data-key="t-layouts">지사 관리</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarAccount-2">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="/company_lists?mode=branch"  class="nav-link" data-key="t-horizontal">지사 리스트</a>
                            </li>
                            <li class="nav-item">
                                <a href="/add_company?mode=1" class="nav-link" data-key="t-detached">지사 추가</a>
                            </li>
                        </ul>
                    </div>
                </li>
                @endif

                @if(session('state') == 2 || session('state') == 1 || session('state') == 0)
                {{--지사 메뉴--}}
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarAccount-3" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarLayouts">
                        <i class="ri-account-circle-line"></i> <span data-key="t-layouts">총판 관리</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarAccount-3">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="/company_lists?mode=distributor"  class="nav-link" data-key="t-horizontal">총판 리스트</a>
                            </li>
                            @if(session('state') == 1 || session('state') == 0)
                            <li class="nav-item">
                                <a href="/add_company?mode=2"  class="nav-link" data-key="t-detached">총판 추가</a>
                            </li>
                            @endif
                        </ul>
                    </div>
                </li>
                @endif

                @if(session('state') == 3 || session('state') == 2 || session('state') == 1 || session('state') == 0)
                {{--총판 메뉴--}}
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarAccount-4" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarLayouts">
                        <i class="ri-account-circle-line"></i> <span data-key="t-layouts">가맹점 관리</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarAccount-4">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="/company_lists?mode=franchisee"  class="nav-link" data-key="t-horizontal">가맹점 리스트</a>
                            </li>
                            @if(session('state') == 1 || session('state') == 0)
                            <li class="nav-item">
                                <a href="/add_company?mode=3"  class="nav-link" data-key="t-detached">가맹점 추가</a>
                            </li>
                            @endif
                        </ul>
                    </div>
                </li>
                @endif

                {{--공통메뉴--}}
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarSetting" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarPages">
                        <i class="ri-settings-2-line"></i> <span data-key="t-pages">사용자 관리</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarSetting">
                        <ul class="nav nav-sm flex-column">
{{--                            <li class="nav-item">--}}
{{--                                <a href="#" class="nav-link" data-key="t-starter"> 하부계정 관리 </a>--}}
{{--                            </li>--}}

{{--                                @if(session('bank_mode') == 1 || session('bank_mode') == 2)--}}
{{--                                <li class="nav-item">--}}
{{--                                    <a href="/rtpay_setting" class="nav-link" data-key="t-team"> RTpay(뱅킹) 설정 </a>--}}
{{--                                </li>--}}
{{--                                @endif--}}
                            @if(session('state') == 1)
                                @if(session('bank_mode') == 0 || session('bank_mode') == 2)
                                <li class="nav-item">
                                    <a href="/account_setting" class="nav-link" data-key="t-timeline"> 가상계좌 설정 </a>
                                </li>
                                @endif
                            @endif
                            <li class="nav-item">
                                <a href="/user_telegram_setting" class="nav-link" data-key="t-faqs"> 텔레그램 알림 </a>
                            </li>
                            <li class="nav-item">
                                <a href="/user_setting" class="nav-link" data-key="t-pricing"> 계정 설정 </a>
                            </li>
                        </ul>
                    </div>
                </li>
{{--                <li class="nav-item">--}}
{{--                    <a class="nav-link" href="/">--}}
{{--                        <i class="ri-notification-4-line"></i> <span data-key="t-noti">공지사항</span>--}}
{{--                    </a>--}}
{{--                </li>--}}
            </ul>
        </div>
        <!-- Sidebar -->
    </div>

    <div class="sidebar-background"></div>
</div>
