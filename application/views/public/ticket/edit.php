<div id="modal-result" class="modal-result-container"></div>
<form id="edit_ticket_<?= $target->id ?>">
    <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
    <input type="hidden" name="id" value="<?= $target->id ?>">
    <div class="form-group">
        <label class="form-label">Pesan <span class="text-danger">*</span></label>
        <textarea class="form-control" name="content" rows="4">
<?= str_replace('\r\n', '
', htmlentities($target->msg)) ?>
</textarea>
    </div>
    <div class="mb-0">
        <button type="button" class="btn btn-primary float-end" onclick="ticket_submit();"><i class="fas fa-edit fs-6 me-2"></i>Ubah</button>
        <button type="reset" class="btn btn-danger float-end me-2"><i class="fas fa-sync fs-6 me-2"></i>Ulangi</button>
    </div>
</form>
<script type="text/javascript">
    function ticket_submit() {
        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>ticket/edit/<?= $target->id ?>",
            data: $('#edit_ticket_<?= $target->id ?>').serialize(),
            dataType: "html",
            success: function(data) {
                $.unblockUI();
                var response = JSON.parse(data);

                var alertClass = response.result.alert || 'danger';

                var alertHtml = '<div class="alert alert-' + alertClass + ' alert-dismissible fade show" role="alert">' +
                    '<strong>' + (response.result.title || 'Kesalahan!') + '</strong> ' + (response.result.msg || 'Terjadi kesalahan.') +
                    '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
                    '</div>';

                $('.modal-result-container').html(alertHtml);

                if (response.result.alert === 'success') {
                    // Jika respons berhasil, reload halaman setelah 2 detik
                    setTimeout(function() {
                        location.reload();
                    }, 2000);
                }
            },
            error: function() {
                $.unblockUI();
                var alertHtml = '<div class="alert alert-danger alert-dismissible fade show" role="alert">' +
                    '<strong>Kesalahan!</strong> Terjadi kesalahan.' +
                    '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
                    '</div>';
                $('.modal-result-container').html(alertHtml);
            },
            beforeSend: function() {
                $.blockUI({
                    message: '',
                    baseZ: 10000,
                    css: {
                        backgroundColor: 'transparent',
                        border: '0'
                    },
                    overlayCSS: {
                        backgroundColor: '#fff',
                        opacity: 0.8
                    }
                });
                $('.modal-result-container').html('<div class="progress rounded-corner mb-1 m-b-15"><div class="progress-bar bg-primary progress-bar-striped" style="width: 100%"></div></div>');
            }
        });
    }
</script>