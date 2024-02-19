<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<!--begin::Head-->

<head>
    {{--<base href="../../../../">--}}
    <meta charset="utf-8" />
    <title> Sinta | Login </title>
    <meta name="description" content="Singin page example" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <!--begin::Fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <!--end::Fonts-->
    <!--begin::Page Custom Styles(used by this page)-->
    <link href="{{ asset('assets/css/pages/login/login-5.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Page Custom Styles-->
    <!--begin::Global Theme Styles(used by all pages)-->
    <link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/plugins/custom/prismjs/prismjs.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Global Theme Styles-->
    <!--begin::Layout Themes(used by all pages)-->
    <link href="{{ asset('assets/css/themes/layout/header/base/light.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/themes/layout/header/menu/light.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/themes/layout/brand/dark.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/themes/layout/aside/dark.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Layout Themes-->
    <link rel="shortcut icon" href="{{ asset('assets/media/logos/favicon.png') }}" />
    {!! htmlScriptTagJsApi() !!}
    <style>
        .untuk-kotak-tengh {
            -webkit-box-pack: center;
            justify-content: center;
            -webkit-box-align: center;
            margin-top: 10px;
        }
    </style>
    <style>
        @media (max-width: 1000px) {
            .login-aside{
                display: none !important;
            }
            .untuk-kotak-tengh{
                padding: 100px;
            }
        }
    </style>
</head>
<!--end::Head-->
<!--begin::Body-->

<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading" style="background-color: #ffffff;">
    <!--begin::Main-->
    @if(session()->has('message_success'))
    <div class="alert alert-success alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>{{ session()->get('message_success') }}</strong>
    </div>
    @endif
    @if(session()->has('message_error'))
    <div class="alert alert-danger alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>{{ session()->get('message_error') }}</strong>
    </div>
    @endif
    <div class="d-flex flex-column flex-root">
        <!--begin::Login-->
        <div class="login login-5 wizard d-flex flex-column flex-lg-row flex-column-fluid">
            <!--begin::Aside-->
                {{--<div class="login-aside d-flex flex-column flex-row-auto">--}}
                <!--begin::Aside Top-->
                <div class="d-flex flex-column-auto flex-column pt-lg-0 pt-15">
                    <!--end::Aside header-->
                    <!--begin::Aside Title-->
                    {{--<h3 class="font-weight-bolder text-center font-size-h4 text-dark-50">User Experience &amp; Interface--}}
                    {{--Design--}}
                    {{--<br/>Strategy SaaS Solutions</h3>--}}
                    <!--end::Aside Title-->
                </div>
                <!--end::Aside Top-->
                <!--begin::Aside Bottom-->
                {{--<div class="aside-img d-flex flex-row-fluid bgi-no-repeat bgi-position-x-center"--}}
                {{--style="background-position-y: calc(100% + 1rem); background-image: url(assets/media/svg/illustrations/login-visual-5.svg)"></div>--}}

                <!--end::Aside Bottom-->
            </div>
            <!--begin::Aside-->
            <!--begin::Content-->
            {{--<div class="login-content flex-row-fluid d-flex flex-column" style="background-image:url({{url('assets/media/logos/logo-rekon.png')}})">--}}
            <div class="login-content flex-row-fluid d-flex flex-column" >

                <div class="d-flex flex-row-fluid untuk-kotak-tengh">
                    <!--begin::Signin-->
                    <div class="login-form">
                        <!--begin::Form-->
                        <form class="form" id="kt_login_singin_form" action="{{ url('login/store') }}" novalidate method="POST">
                            @csrf
                            <!--begin::Title-->
                            
                            <!--begin::Title-->
                            <!--begin::Form group-->
                            <div class="form-group">
                                <label class="font-size-h6 font-weight-bolder text-dark">Your Username</label>
                                <input class="form-control form-control-solid py-7 px-6 rounded-lg border-0" type="text" name="username" autocomplete="off" value="" />
                                @if($errors->has('username'))
                                <p class="text-danger" style="font-size: 11px; padding-top: 0px;">{{$errors->first('username')}}</p>
                                @endif
                            </div>
                            <!--end::Form group-->
                            <!--begin::Form group-->
                            <div class="form-group">
                                <div class="d-flex justify-content-between mt-n5">
                                    <label class="font-size-h6 font-weight-bolder text-dark pt-5">Your Password</label>
                                </div>
                                <input class="form-control form-control-solid py-7 px-6 rounded-lg border-0" type="password" name="password" autocomplete="off" value="" />
                                @if($errors->has('password'))
                                <p class="text-danger" style="font-size: 11px; padding-top: 0px;">{{$errors->first('password')}}</p>
                                @endif
                            </div>
                            <!--end::Form group-->
                            <!--begin::Action-->
                            <div class="pb-lg-0 pb-5">
                                <button type="submit" style="background-color:#14AF4E;" id="kt_login_singin_form_submit_button" class="btn btn-primary btn-lg btn-block font-weight-bolder font-size-h6 px-8 py-4 my-3 mr-3">
                                    Sign In
                                </button>
                            </div>
                            <div class="pb-lg-0 pb-5">
                                <label>
                                    <a href="{{ url('forgetpassword') }}">Reset Password</a>
                                </label>      
                            </div>
                            <!--end::Action-->
                        </form>
                        <!--end::Form-->
                    </div>
                    <!--end::Signin-->
                </div>

                <!--end::Wrapper-->
            </div>
            <!--end::Content-->
        </div>
        <!--end::Login-->

    </div>


    <!--end::Main-->
    {{--<script>var HOST_URL = "https://keenthemes.com/metronic/tools/preview";</script>--}}
    <!--begin::Global Config(global config for global JS scripts)-->
    <script>
        var KTAppSettings = {
            "breakpoints": {
                "sm": 576,
                "md": 768,
                "lg": 992,
                "xl": 1200,
                "xxl": 1200
            },
            "colors": {
                "theme": {
                    "base": {
                        "white": "#ffffff",
                        "primary": "#3699FF",
                        "secondary": "#E5EAEE",
                        "success": "#1BC5BD",
                        "info": "#8950FC",
                        "warning": "#FFA800",
                        "danger": "#F64E60",
                        "light": "#F3F6F9",
                        "dark": "#212121"
                    },
                    "light": {
                        "white": "#ffffff",
                        "primary": "#E1F0FF",
                        "secondary": "#ECF0F3",
                        "success": "#C9F7F5",
                        "info": "#EEE5FF",
                        "warning": "#FFF4DE",
                        "danger": "#FFE2E5",
                        "light": "#F3F6F9",
                        "dark": "#D6D6E0"
                    },
                    "inverse": {
                        "white": "#ffffff",
                        "primary": "#ffffff",
                        "secondary": "#212121",
                        "success": "#ffffff",
                        "info": "#ffffff",
                        "warning": "#ffffff",
                        "danger": "#ffffff",
                        "light": "#464E5F",
                        "dark": "#ffffff"
                    }
                },
                "gray": {
                    "gray-100": "#F3F6F9",
                    "gray-200": "#ECF0F3",
                    "gray-300": "#E5EAEE",
                    "gray-400": "#D6D6E0",
                    "gray-500": "#B5B5C3",
                    "gray-600": "#80808F",
                    "gray-700": "#464E5F",
                    "gray-800": "#1B283F",
                    "gray-900": "#212121"
                }
            },
            "font-family": "Poppins"
        };
    </script>
    <!--end::Global Config-->
    <!--begin::Global Theme Bundle(used by all pages)-->
    <script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('assets/plugins/custom/prismjs/prismjs.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
    <!--end::Global Theme Bundle-->
    <!--begin::Page Scripts(used by this page)-->
    {{-- <script src="{{ asset('assets/js/pages/custom/login/login-5.js') }}"></script> --}}
    <!--end::Page Scripts-->
</body>
<!--end::Body-->

</html>