<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="description" content="<?= (website_config('meta_description')) ? website_config('meta_description') : $config['meta']['description'] ?>" />
	<meta name="keywords" content="<?= (website_config('meta_keywords')) ? website_config('meta_keywords') : $config['meta']['keywords'] ?>" />
	<meta name="author" content="<?= (website_config('meta_author')) ? website_config('meta_author') : $config['meta']['author'] ?>" />
	<title><?= (website_config('bartitle')) ? website_config('bartitle') : $config['bartitle'] ?></title>
	<link rel="shortcut icon" href="<?= (website_config('favicon')) ? website_config('favicon') : $config['favicon'] ?>">

	<!-- css -->
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css">
	<link rel="stylesheet" type="text/css" href="https://use.fontawesome.com/releases/v5.4.2/css/all.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
	<link href="<?= base_url() ?>assets/template/libs/%40mdi/font/css/materialdesignicons.min.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="<?= base_url() ?>assets/template/css/app.min.css">


	<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet" />
	<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>

	<!-- javascript -->
	<script src="<?= base_url() ?>assets/template/libs/jquery/jquery.min.js"></script>
	<script src="<?= base_url() ?>assets/template/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="<?= base_url() ?>assets/template/libs/jquery-slimscroll/jquery.slimscroll.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
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
				<?php if ($this->session->userdata('login')) { ?>
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
						<li class="dropdown notification-list">
							<a class="nav-link dropdown-toggle nav-user" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
								<img src="<?= base_url() ?>assets/template/profile.png" class="rounded-circle"> <span class="ml-1"><?= user('username') ?> <i class="mdi mdi-chevron-down"></i></span>
							</a>
							<div class="dropdown-menu dropdown-menu-right dropdown-menu-animated profile-dropdown">
								<a href="<?= base_url('user/setting') ?>" class="dropdown-item notify-item"> <i class="mdi mdi-settings"></i> <span>Pengaturan Akun</span></a>
								<a href="<?= base_url('auth/logout') ?>" class="dropdown-item notify-item"> <i class="mdi mdi-logout"></i> <span>Keluar</span></a>
							</div>
						</li>
					</ul>
				<?php } ?>
				<ul class="list-inline menu-left mb-0">
					<li class="float-left">
						<a href="<?= base_url() ?>" class="logo" style="text-decoration: none; color: #fff; font-size: 20px; letter-spacing: 0.3em; font-weight: bold;">
							<span class="logo-lg"><i class="mdi mdi-cart"></i> <?= (website_config('title')) ? website_config('title') : $config['title'] ?></span>
							<span class="logo-sm"><i class="mdi mdi-cart"></i></span>
						</a>
					</li>
				</ul>
			</div>
		</nav>
		<div class="topbar-menu">
			<div class="container-fluid">
				<div id="navigation">
					<ul class="navigation-menu">
						<?php if ($this->session->userdata('login')) { ?>
							<li class="has-submenu">
								<a href="<?= base_url() ?>"><i class="fa fa-home fa-fw"></i>Dashboard</a>
							</li>
							<li class="has-submenu">
								<a href="<?= base_url('page/hof') ?>"><i class="fa fa-trophy fa-fw"></i>Top Pengguna</a>
							</li>
							<li class="has-submenu">
								<a href="#"><i class="fa fa-shopping-cart fa-fw"></i>Pesan</a>
								<ul class="submenu">
									<li><a href="<?= base_url('order/single') ?>">Pesan Baru</a></li>
									<li><a href="<?= base_url('order/massal') ?>">Pesan Massal</a></li>
									<li><a href="<?= base_url('order/history') ?>">Riwayat</a></li>
									<li><a href="<?= base_url('order/graph') ?>">Grafik</a></li>
								</ul>
							</li>
							<li class="has-submenu">
								<a href="#"><i class="fa fa-university fa-fw"></i>Deposit</a>
								<ul class="submenu">
									<li><a href="<?= base_url('deposit/new') ?>">Deposit Baru</a></li>
									<li><a href="<?= base_url('deposit/history') ?>">Riwayat</a></li>
								</ul>
							</li>
							<li class="has-submenu">
								<a href="#"><i class="fa fa-envelope fa-fw"></i>Tiket <?php if ($unread_ticket > 0) { ?><span class="badge badge-warning badge-pill
									"><?= $unread_ticket ?></span><?php } ?></a>
								<ul class="submenu">
									<li><a href="<?= base_url('ticket/submit') ?>">Kirim</a></li>
									<li><a href="<?= base_url('ticket') ?>">Daftar</a></li>
								</ul>
							</li>
							<li class="has-submenu">
								<a href="<?= base_url('api/documentation') ?>"><i class="fa fa-book fa-fw"></i>Dokumentasi API</a>
							</li>
							<li class="has-submenu">
								<a href="<?= base_url('page/price_list') ?>"><i class="fa fa-tags fa-fw"></i>Daftar Harga</a>
							</li>
							<li class="has-submenu">
								<a href="#"><i class="fa fa-file fa-fw"></i>Log</a>
								<ul class="submenu">
									<li><a href="<?= base_url('user/log_login') ?>">Masuk</a></li>
									<li><a href="<?= base_url('user/log_balance_usage') ?>">Penggunaan Saldo</a></li>
									<li><a href="<?= base_url('user/setting') ?>">Pengaturan Akun</a></li>
								</ul>
							</li>
							<?php if (user('level') <> 'Member') { ?>
								<li class="has-submenu">
									<a href="#"><i class="fa fa-user fa-fw"></i>Staff</a>
									<ul class="submenu">
										<li><a href="<?= base_url('staff/add_user') ?>">Tambah Pengguna</a></li>
										<li><a href="<?= base_url('staff/balance_transfer') ?>">Transfer Saldo</a></li>
									</ul>
								</li>
							<?php } ?>
						<?php } else { ?>
							<li class="has-submenu">
								<a href="<?= base_url() ?>"><i class="fa fa-home fa-fw"></i>Halaman Utama</a>
							</li>
							<li class="has-submenu">
								<a href="<?= base_url('auth/login') ?>"><i class="fa fa-user fa-fw"></i>Masuk</a>
							</li>
							<li class="has-submenu">
								<a href="<?= base_url('auth/register') ?>"><i class="fa fa-user-plus fa-fw"></i>Daftar</a>
							</li>
							<li class="has-submenu">
								<a href="<?= base_url('page/price_list') ?>"><i class="fa fa-tags fa-fw"></i>Daftar Harga</a>
							</li>
							<li class="has-submenu">
								<a href="#"><i class="fa fa-file fa-fw"></i>Halaman</a>
								<ul class="submenu">
									<?php
									foreach ($page as $key => $value) {
									?>
										<li><a href="<?= base_url('page/site/' . $value['id']) ?>"><?= $value['title'] ?></a></li>
									<?php
									}
									?>
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
				<h4 class="page-title">
					<?php if ($this->session->userdata('login')) { ?>
						Sisa Saldo: Rp <?= number_format(user('balance'), 0, ',', '.') ?>
					<?php } else { ?>
						<?= (website_config('title')) ? website_config('title') : $config['title'] ?>
					<?php } ?>
				</h4>
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
	<?php if ($this->session->userdata('login')) { ?>
		<?php if (user('is_read_popup') == '0') { ?>
			<div class="modal fade" id="modal-info" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none;">
				<div class="modal-dialog modal-dialog-centered modal-lg">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title text-center"><i class="mdi mdi-bullhorn fa-fw"></i> Informasi</h5>
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						</div>
						<div class="modal-body" style="max-height: 400px; overflow: auto;">
							<?php if (count($info_popup) == 0) { ?>
								<div class="alert alert-info text-center">Belum ada informasi yang ditampilkan.</div>
								<?php } else {
								foreach ($info_popup as $key => $value) {
								?>
									<div class="alert alert-info" style="color: #000">
										<span class="float-right text-muted"><?= $this->lib->format_datetime($value['created_at']) ?></span>
										<h5><?= $this->lib->status_info($value['category']) ?></h5>
										<p><?= nl2br($value['content']) ?></p>
									</div>
							<?php
								}
							}
							?>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
							<button type="button" class="btn btn-primary" onclick="read_popup()"><i class="mdi mdi-thumbs-up fa-fw"></i> Saya Sudah Membaca</button>
						</div>
					</div>
				</div>
			</div>
			<script type="text/javascript">
				$('#modal-info').modal('show');

				function read_popup() {
					$.ajax({
						type: "GET",
						url: "<?= base_url('user/read_popup') ?>",
						success: function() {
							$('#modal-info').modal('hide');
						},
						error: function() {
							alert('Terjadi kesalahan, refresh halaman ini.');
						}
					});
				}
			</script>
		<?php } ?>
		<div class="modal fade" id="modal-detail" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none;">
			<div class="modal-dialog modal-dialog-centered modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title"><i class="fa fa-search fa-fw"></i> Detail Data</h5>
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
	<?php } ?>
	<script src="<?= base_url() ?>assets/template/js/jquery.core.js"></script>
	<script src="<?= base_url() ?>assets/template/js/jquery.app.js"></script>
	<script type="text/javascript">
		$(".select2").select2();
	</script>
</body>

</html>