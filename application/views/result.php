<?php if ($result = $this->session->flashdata('result')) : ?>
    <div class="alert alert-<?php echo $result['alert']; ?> alert-dismissible fade show" role="alert">
        <b class="alert-heading fs-5">
            <i class="<?= ($result['title'] == 'Gagal!' || $result['title'] == 'Ups!' || $result['alert'] == 'danger' ? 'fas fa-times-circle fs-6 me-1' : 'fas fa-check-circle fs-6 me-1') ?>"></i>
            <?php echo $result['title']; ?>
        </b>
        <?php if ($result['title'] == 'Gagal!' || $result['title'] == 'Ups!' || $result['alert'] == 'danger') : ?>
            <?php echo $result['msg']; ?>
        <?php else : ?>
            <br /><?php echo $result['msg']; ?>
        <?php endif; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
    </div>
    <script type="text/javascript">
        $(document).ready(function() {
            var alertIcon = '<?= ($result['title'] == 'Gagal!' || $result['title'] == 'Ups!' || $result['alert'] == 'danger') ? 'error' : $result['alert'] ?>';

            Swal.fire({
                title: '<?= $result['title']; ?>',
                html: '<?= $result['msg']; ?>', // Menggunakan opsi 'html' untuk mendukung teks HTML
                icon: alertIcon,
                confirmButtonText: 'Okay',
                customClass: {
                    confirmButton: 'btn btn-primary bg-gradient',
                },
                buttonsStyling: false,
            });
        });
    </script>
<?php endif;
$this->session->unset_userdata('result');
