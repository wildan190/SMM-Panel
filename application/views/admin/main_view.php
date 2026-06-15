<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Halaman Admin</title>
	<link rel="shortcut icon" href="<?= (website_config('favicon')) ? website_config('favicon') : $config['favicon'] ?>">

	<!-- css -->
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css">
	<link rel="stylesheet" type="text/css" href="https://use.fontawesome.com/releases/v5.4.2/css/all.css">
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
	<link href="<?= base_url() ?>assets/template/libs/%40mdi/font/css/materialdesignicons.min.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="<?= base_url() ?>assets/template/css/app.min.css">

	<!-- javascript -->
	<script src="<?= base_url() ?>assets/template/libs/jquery/jquery.min.js"></script>
	<script src="<?= base_url() ?>assets/template/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="<?= base_url() ?>assets/template/libs/jquery-slimscroll/jquery.slimscroll.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>


	<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet" />
	<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>
	<style type="text/css">
		.hide {
			display: none !important
		}

		.show {
			display: block !important
		}
	</style>
</head>

<body>
	<header id="topnav">
		<nav class="navbar-custom">
			<div class="container-fluid">
				<ul class="list-unstyled topbar-right-menu float-right mb-0">
					<li class="dropdown notification-list">
						<a class="navbar-toggle nav-link">
							<div class="lines">
								<span></span>
								<span></span>
								<span></span>
							</div>
						</a>
					</li>
					<?php if (admin()) { ?>
						<li class="dropdown notification-list">
							<a class="nav-link dropdown-toggle nav-user" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
								<img src="<?= base_url() ?>assets/template/profile.png" class="rounded-circle"> <span class="ml-1"><?= user('username') ?> <i class="mdi mdi-chevron-down"></i></span>
							</a>
							<div class="dropdown-menu dropdown-menu-right dropdown-menu-animated profile-dropdown">
								<a href="<?= base_url('admin/auth/setting') ?>" class="dropdown-item notify-item"><i class="mdi mdi-settings"></i> <span>Pengaturan Akun</span></a>
								<a href="<?= base_url('admin/auth/logout') ?>" class="dropdown-item notify-item"><i class="mdi mdi-logout"></i> <span>Keluar</span></a>
							</div>
						</li>
					<?php } ?>
				</ul>
				<ul class="list-inline menu-left mb-0">
					<li class="float-left">
						<a href="<?= base_url() ?>" class="logo" style="text-decoration: none; color: #fff; font-size: 20px; letter-spacing: 0.3em; font-weight: bold;">
							<span class="logo-lg"><i class="mdi mdi-settings"></i> HALAMAN ADMIN</span>
							<span class="logo-sm"><i class="mdi mdi-settings"></i></span>
						</a>
					</li>
				</ul>
			</div>
		</nav>
		<div class="topbar-menu">
			<div class="container-fluid">
				<div id="navigation">
					<ul class="navigation-menu">
						<li class="has-submenu">
							<a href="<?= base_url('admin') ?>"><i class="fa fa-home fa-fw"></i>Dasbor</a>
						</li>
						<?php if (admin()) { ?>
							<li class="has-submenu">
								<a href="#"><i class="fa fa-cubes fa-fw"></i>Layanan</a>
								<ul class="submenu">
									<li><a href="<?= base_url('admin/api') ?>">API</a></li>
									<li><a href="<?= base_url('admin/service_category') ?>">Kategori Layanan</a></li>
									<li><a href="<?= base_url('admin/service') ?>">Layanan</a></li>
									<li><a href="<?= base_url('admin/custom_price') ?>">Harga Khusus</a></li>
								</ul>
							</li>
							<li class="has-submenu">
								<a href="<?= base_url('admin/admin') ?>"><i class="fa fa-user-secret fa-fw"></i>Admin</a>
							</li>
							<li class="has-submenu">
								<a href="#"><i class="fa fa-users fa-fw"></i>Pengguna</a>
								<ul class="submenu">
									<li><a href="<?= base_url('admin/user') ?>">Pengguna</a></li>
									<li><a href="<?= base_url('admin/user/hof') ?>">Top Pengguna</a></li>
								</ul>
							</li>
							<li class="has-submenu">
								<a href="#"><i class="fa fa-shopping-cart fa-fw"></i>Pesanan</a>
								<ul class="submenu">
									<li><a href="<?= base_url('admin/order') ?>">Pesanan</a></li>
									<li><a href="<?= base_url('admin/order/report') ?>">Laporan</a></li>
								</ul>
							</li>
							<li class="has-submenu">
								<a href="#"><i class="fa fa-university fa-fw"></i>Deposit</a>
								<ul class="submenu">
									<li><a href="<?= base_url('admin/deposit/direct') ?>">Kirim Saldo</a></li>
									<li><a href="<?= base_url('admin/deposit_method') ?>">Metode Deposit</a></li>
									<li><a href="<?= base_url('admin/deposit') ?>">Deposit</a></li>
									<li><a href="<?= base_url('admin/deposit/report') ?>">Laporan</a></li>
								</ul>
							</li>
							<li class="has-submenu">
								<a href="<?= base_url('admin/ticket') ?>"><i class="fa fa-envelope fa-fw"></i>Tiket <?php if ($unread_ticket > 0) { ?><span class="badge badge-warning badge-pill
									"><?= $unread_ticket ?></span><?php } ?></a>
							</li>
							<li class="has-submenu">
								<a href="#"><i class="fa fa-sticky-note fa-fw"></i>Log</a>
								<ul class="submenu">
									<li><a href="<?= base_url('admin/log_login_user') ?>">Pengguna Masuk</a></li>
									<li><a href="<?= base_url('admin/log_login_admin') ?>">Admin Masuk</a></li>
									<li><a href="<?= base_url('admin/log_balance_usage') ?>">Penggunaan Saldo</a></li>
									<li><a href="<?= base_url('admin/log_bank_mutation') ?>">Mutasi Bank</a></li>
									<li><a href="<?= base_url('admin/log_sms') ?>">SMS</a></li>
								</ul>
							</li>
							<li class="has-submenu">
								<a href="#"><i class="fa fa-magic fa-fw"></i>Pengaturan</a>
								<ul class="submenu">
									<li><a href="<?= base_url('admin/info') ?>">Informasi</a></li>
									<li><a href="<?= base_url('admin/page') ?>">Halaman</a></li>
									<li><a href="<?= base_url('admin/website_config') ?>">Konfigurasi Website</a></li>
								</ul>
							</li>
						<?php } ?>
					</ul>
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
	</header>
	<div class="wrapper">
		<div class="container-fluid" style="padding-bottom: 30px;">
			<div class="page-title-alt-bg"></div>
			<div class="page-title-box text-center">
				<h4 class="page-title">HALAMAN ADMIN</h4>
			</div>
			<div class="row">
				<div class="col-sm-12"><?php $this->load->view('result') ?></div>
			</div>
			<?= $content ?>
		</div>
	</div>
	<footer class="footer">
		<div class="container-fluid">
			<div class="row">
				<div class="col-12 text-center">2018 &copy; <?= (website_config('title')) ? website_config('title') : $config['title'] ?>. Crafted with <i class="mdi mdi-heart text-danger"></i> by <a href="https://penuliskode.com" target="_blank">Penulis Kode</a>.</div>
			</div>
		</div>
	</footer>
	<div class="modal fade" id="modal-delete" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none;">
		<div class="modal-dialog modal-dialog-centered modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title text-center"><i class="fa fa-trash fa-fw"></i> Hapus Data</h5>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				</div>
				<div class="modal-body">
					Apakah Anda yakin?
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
					<a href="#" class="btn btn-primary" id="btn-yes">Ya, Hapus</a>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="modal-detail" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none;">
		<div class="modal-dialog modal-dialog-centered modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title text-center"><i class="fa fa-search fa-fw"></i> Detail Data</h5>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				</div>
				<div class="modal-body" id="modal-detail-body">
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
				</div>
			</div>
		</div>
	</div>
	<script src="<?= base_url() ?>assets/template/js/jquery.core.js"></script>
	<script src="<?= base_url() ?>assets/template/js/jquery.app.js"></script>
	<script type="text/javascript">
		function confirm_delete(url) {
			$('#modal-delete #btn-yes').attr({
				'href': url
			});
			$('#modal-delete').modal();
		}

		function detail(url) {
			$.ajax({
				type: "GET",
				url: url,
				beforeSend: function() {
					$('#modal-detail-body').html('Sedang memuat...');
				},
				success: function(result) {
					$('#modal-detail-body').html(result);
				},
				error: function() {
					$('#modal-detail-body').html('Terjadi kesalahan.');
				}
			});
			$('#modal-detail').modal();
		}
	</script>
	<script type="text/javascript">
		$(document).ready(function() {
			$('.select2').select2();
		});
	</script>
</body>

</html>