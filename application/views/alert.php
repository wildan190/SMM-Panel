<div class="row">
    <div class="col-md-12">
        <?php
        $alert = $this->session->flashdata('alert');

        if ($alert) {
        ?>
            <div class="alert alert-<?php echo $alert['alert'] ?> alert-dismissible fade show" role="alert">
                <b class="alert-heading fs-5"><i class="<?= ($alert['title'] == 'Ups!' ? 'fas fa-times-circle fs-6 me-1' : 'fas fa-check-circle fs-6 me-1') ?>"></i><strong><?php echo $alert['title'] ?></b>
                </strong> <?php echo $alert['msg'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php
        }
        $this->session->unset_userdata('alert');

        if ($this->session->flashdata('swalalert')) {
        ?>
            <script type="text/javascript">
                $(document).ready(function() {
                    var swalalert = <?= json_encode($this->session->flashdata('swalalert')) ?>;
                    var alertIcon = (swalalert.title == 'Gagal!' || swalalert.title == 'Ups!' || swalalert.alert == 'danger') ? 'error' : swalalert.alert;

                    Swal.fire({
                        title: swalalert.title,
                        html: swalalert.msg,
                        icon: alertIcon,
                        confirmButtonText: 'Okay',
                        customClass: {
                            confirmButton: 'btn btn-primary',
                        },
                        buttonsStyling: false,
                    });
                });
            </script>
        <?php
            $this->session->unset_userdata('swalalert');
        }
        ?>

    </div>
</div>