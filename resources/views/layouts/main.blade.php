
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
	<!--begin::Head-->
	<head><base href="">
        <meta charset="utf-8" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <title> SINTA | @yield('title') </title>

		<meta name="description" content="Updates and statistics" />
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
		<!--begin::Fonts-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
		<!--end::Fonts-->
		<!--begin::Page Vendors Styles(used by this page)-->
		<link href="{{ asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.css') }}" rel="stylesheet" type="text/css" />
		<!--end::Page Vendors Styles-->
		<!--begin::Global Theme Styles(used by all pages)-->
		<link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('assets/plugins/custom/prismjs/prismjs.bundle.css') }}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" href="{{ asset('assets/plugins/custom/toastr/toastr.min.css') }}">
		<!--end::Global Theme Styles-->
		<!--begin::Layout Themes(used by all pages)-->
		<link href="{{ asset('assets/css/themes/layout/header/base/dark.css') }}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('assets/css/themes/layout/header/menu/dark.css') }}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('assets/css/themes/layout/brand/light.css') }}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('assets/css/themes/layout/aside/light.css') }}" rel="stylesheet" type="text/css" />
		<!--end::Layout Themes-->
		{{-- <link rel="shortcut icon" href="{{ asset('assets/media/logos/favicon.png') }}" /> --}}
		@yield('css_page')

	</head>
	<!--end::Head-->
	<!--begin::Body-->
	<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading">
		<style>
			.toast {
				opacity: 1 !important;
			}
		</style>
		<!--begin::Main-->
		<!--begin::Header Mobile-->
		@include('layouts.headermobile')
		<!--end::Header Mobile-->
		<div class="d-flex flex-column flex-root">
			<!--begin::Page-->
			<div class="d-flex flex-row flex-column-fluid page">
				<!--begin::Aside-->
				@include('layouts.sidebar')
				<!--end::Aside-->
				<!--begin::Wrapper-->
				<div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">
					<!--begin::Header-->
					@include('layouts.header')
					<!--end::Header-->
					<!--begin::Content-->
					@yield('content')
					<!--end::Content-->
					<!--begin::Footer-->
					@include('layouts.footer')
					<!--end::Footer-->
				</div>
				<!--end::Wrapper-->
			</div>
			<!--end::Page-->
		</div>
		<!--end::Main-->

		<!-- Change password Modal-->
		<div class="modal fade" id="changePasswordModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Change Password</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<i aria-hidden="true" class="ki ki-close"></i>
						</button>
					</div>
					<form role="form" class="form" name="changepasswordform" id="changepasswordform" enctype="multipart/formdata" method="">
						<div class="modal-body" style="height: 350px;">
							<div class="mb-7">
								<div class="form-group row">
									<label class="col-lg-3 col-form-label">Current Password:</label>
									<div class="col-lg-9">
										<input type="password" class="form-control" id="old_password" name="old_password"
											   />
										<span class="form-text text-muted">Masukkan password lama</span>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-lg-3 col-form-label">New Password:</label>
									<div class="col-lg-9">
										<input type="password" class="form-control" id="new_password" name="new_password"
											   />
										<span class="form-text text-muted">Masukkan password baru</span>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-lg-3 col-form-label">New Password Confirmation:</label>
									<div class="col-lg-9">
										<input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation"
											   />
										<span class="form-text text-muted">Masukkan ulang password baru </span>
									</div>
								</div>
	
							</div>
	
						</div>
	
						<div class="modal-footer">
							<button type="submit" id="saveUpdatePassword" data-id="" class="btn btn-primary font-weight-bold">
								<i class="fa fa-save"></i> Update
							</button>
							
						</div>
					</form>
				</div>
			</div>
		</div>

		<script>var HOST_URL = "https://keenthemes.com/metronic/tools/preview";</script>
		<!--begin::Global Config(global config for global JS scripts)-->
		<script>var KTAppSettings = { "breakpoints": { "sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1200 }, "colors": { "theme": { "base": { "white": "#ffffff", "primary": "#3699FF", "secondary": "#E5EAEE", "success": "#1BC5BD", "info": "#8950FC", "warning": "#FFA800", "danger": "#F64E60", "light": "#F3F6F9", "dark": "#212121" }, "light": { "white": "#ffffff", "primary": "#E1F0FF", "secondary": "#ECF0F3", "success": "#C9F7F5", "info": "#EEE5FF", "warning": "#FFF4DE", "danger": "#FFE2E5", "light": "#F3F6F9", "dark": "#D6D6E0" }, "inverse": { "white": "#ffffff", "primary": "#ffffff", "secondary": "#212121", "success": "#ffffff", "info": "#ffffff", "warning": "#ffffff", "danger": "#ffffff", "light": "#464E5F", "dark": "#ffffff" } }, "gray": { "gray-100": "#F3F6F9", "gray-200": "#ECF0F3", "gray-300": "#E5EAEE", "gray-400": "#D6D6E0", "gray-500": "#B5B5C3", "gray-600": "#80808F", "gray-700": "#464E5F", "gray-800": "#1B283F", "gray-900": "#212121" } }, "font-family": "Poppins" };</script>
		<!--end::Global Config-->
		<!--begin::Global Theme Bundle(used by all pages)-->
		<script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
		<script src="{{ asset('assets/plugins/custom/prismjs/prismjs.bundle.js') }}"></script>
		<script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
		<script src="{{ asset('assets/js/matchAccount.js') }}"></script>
		<!--end::Global Theme Bundle-->

		<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
		<script src="{{ asset('assets/plugins/custom/toastr/toastr.min.js')}}"></script>
		<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

		<script type="text/javascript">
			const Toast = Swal.mixin({
				toast: true,
				position: 'top-end',
				showConfirmButton: false,
				timer: 3000,
				timerProgressBar: true,
				onOpen: (toast) => {
					toast.addEventListener('mouseenter', Swal.stopTimer)
					toast.addEventListener('mouseleave', Swal.resumeTimer)
				}
			});  
			
			function showtoastr($type,$message){
				Toast.fire({
					icon: $type,
					title: $message
				});
			}; 

			function imgtoastr($title,$body,$subtitle,$img){
				$(document).Toasts('create',{
					body: $body,
					title: $title,
					subtitle: $subtitle,
					image: '../../dist/img/user3-128x128.jpg',
					imageAlt: 'User Picture',
				})  
			};

			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});

			$(function () {
				$('[data-toggle="tooltip"]').tooltip()
			});

			function show_toastr($type,$title,$message)
			{
				switch($type)
				{
					case "warning":
					toastr.warning($message,$title,{"showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 1000});
					break;
					case "success" :
					toastr.success($message,$title,{"showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 1000});
					break;
					case "error":
					toastr.error($message,$title,{"showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 2000});
					break;
					case "info" :
					toastr.info($message,$title,{"showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 1000});
					break;
					default:
					toastr.info($message,$title,{"showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 1000});
					break;
				}
			}

			function changePasswordModal(){
				$('#changePasswordModal').modal("show");
			}

			$('#changepasswordform').submit(function (e) {
                e.preventDefault();
                var formData = new FormData($("#changepasswordform")[0]);
                var method = "POST";
                var url = './changepassword';

                

                $.ajax({
                    type: method, // define the type of HTTP verb we want to use (POST for our form)
                    url: url, // the url where we want to POST
                    data: formData,
                    contentType: false,
                    processData: false,
                    beforeSend: function () {
                        $('#saveUpdatePassword').attr('disabled', true).html("<i class='fa fa-spinner fa-spin'></i> processing");
                    }
                }).done(function (data) {
                    $("#changePasswordModal").modal('hide');
                    $("#changepasswordform")[0].reset();
                    
                }).fail(function (data) {
                    show_toastr('error', data.responseJSON.status, data.responseJSON.message);
                    $.each(data.responseJSON.errors, function (index, value) {
                        show_toastr('error', index, value);
                    });

                }).always(function () {
                    $('#saveUpdatePassword').attr('disabled', false).html("<i class='fa fa-save'></i> Save changes");
                });
            });

		</script>
		<script>
			function realtime() {
				var tanggallengkap = new String();
				var namahari = ("Minggu Senin Selasa Rabu Kamis Jumat Sabtu");
				namahari = namahari.split(" ");
				var namabulan = ("Januari Februari Maret April Mei Juni Juli Agustus September Oktober November Desember");
				namabulan = namabulan.split(" ");
				var tgl = new Date();
				var hari = tgl.getDay();
				var tanggal = tgl.getDate();
				var bulan = tgl.getMonth();
				var tahun = tgl.getFullYear();
				var s = tgl.getSeconds();
				var m = tgl.getMinutes();
				var h = tgl.getHours();
				tanggallengkap = namahari[hari] + ", " +tanggal + " " + namabulan[bulan] + " " + tahun + "  |  " + ("0" + h).substr(-2) + ":" + ("0" + m).substr(-2) + ":" + ("0" + s).substr(-2) + " WIB";

				document.getElementById("time").innerHTML = tanggallengkap;
				setTimeout("realtime()", 1000);
			}
			realtime();
		</script>

		@yield('js_page')
		

	</body>
	<!--end::Body-->
</html>