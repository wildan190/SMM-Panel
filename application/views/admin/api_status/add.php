<form class="form-horizontal" method="post" action="<?= base_url('admin/api_status/form') ?>">
    <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="name" class="form-label">Nama Provider <span class="text-danger">*</span></label>
                <select class="form-control select2-data" name="name" id="name">
                    <option value="">Pilih Salah Satu...</option>
                    <?php foreach ($api as $key =>
                        $value) { ?>
                        <option value="<?= $value['id'] ?>"><?= $value['name'] ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">API URL <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="end_point">
            </div>
            <div class="form-group">
                <label for="method" class="form-label">HTTP Method <span class="text-danger">*</span></label>
                <select class="form-control select2-data" name="method">
                    <option value="POST">POST</option>
                    <option value="GET">GET</option>
                </select>
            </div>
            <div class="form-group">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input input-primary" id="mass_status" value="1" name="mass_status">
                    <label class="form-check-label text-muted" for="mass_status">Update Status Massal (Untuk SMM Luar Ex: JAP, SMMLite, Followiz, dll)</label>
                </div>
            </div>
            <hr style="margin-top: 1.2rem; margin-bottom: .8rem;">
            <div class="form-group mb-0">
                <label class="form-label">Parameter [Body] <span class="text-danger">*</span></label>
                <div id="parameter">
                </div>
            </div>
            <button type="button" class="btn btn-primary" onclick="add_parameter();"><i class="fas fa-plus-circle fs-6 me-2"></i>Add Parameter</button>
            <hr style="margin-top: 1.2rem; margin-bottom: .8rem;">
            <div class="row">
                <div class="form-group col-md-12">
                    <label for="success_response" class="form-label">Success Response: (JSON) <span class="text-danger">*</span></label>
                    <br />
                    <small>Validate Json here: <a rel="noopener noreferrer" href="https://jsonlint.com/" target="_new">https://jsonlint.com/</a></small>
                    <textarea class="form-control" style="height: 150px;" name="success_response"></textarea>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="form-label">Response Status <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="status_key">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="form-label">Response Start Count <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="start_count_key">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="form-label">Response Remains <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="remains_key">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr style="margin-top: 1.2rem; margin-bottom: .8rem;">
    <div class="mb-0">
        <button type="submit" class="btn btn-primary float-end"><i class="fas fa-plus-circle fs-6 me-2"></i>Tambah</button>
        <button class="btn btn-danger float-end me-2" type="reset"><i class="fas fa-sync fs-6 me-2"></i>Ulangi</button>
    </div>
</form>
<script type="text/javascript">
    $('a[data-bs-toggle=tooltip]').tooltip();

    function add_parameter() {
        var key = Math.floor(Math.random() * 99999);
        $('#parameter').append('<div class="row" id="form_' + key + '"><div class="form-group col-4"><input type="text" class="form-control" id="param_key_' + key + '" name="param_key[]"></div><div class="form-group col-4"><select class="select2-data form-control" id="param_type_' + key + '" name="param_type[]" onchange="param_type(' + key + ', this.value)"><option value="primary">Primary</option><option value="custom">Custom</option></select></div><div class="form-group col-4" id="form_pv_' + key + '"><select class="select2-data form-control" id="param_value_' + key + '" name="param_value[]"><option value="api_id">API ID</option><option value="api_key">API Key</option><option value="secret_key">Secret Key</option><option value="id">Order ID</option></select></div><div class="form-group col-12"><button type="button" class="btn btn-secondary" onclick="remove_parameter(' + key + ')"><i class="fas fa-trash fs-6 me-2"></i>Remove Parameter</button></div></div>');
        $("select#param_type_" + key).each((_i, e) => {
            var $e = $(e);
            $e.select2({
                dropdownParent: $e.parent()
            });
        });
        $("select#param_value_" + key).each((_i, e) => {
            var $e = $(e);
            $e.select2({
                dropdownParent: $e.parent()
            });
        });
    }

    function param_type(key, value) {
        if (value == 'primary') {
            $('#form_pv_' + key).html('<select class="select2-data form-control" id="param_value_' + key + '" name="param_value[]"><option value="api_id">API ID</option><option value="api_key">API Key</option><option value="secret_key">Secret Key</option><option value="id">Order ID</option></select>');
            $("select#param_value_" + key).each((_i, e) => {
                var $e = $(e);
                $e.select2({
                    dropdownParent: $e.parent()
                });
            });
        } else {
            $('#form_pv_' + key).html('<input type="text" class="form-control" id="param_value_' + key + '" name="param_value[]">');
        }
    }

    function remove_parameter(key) {
        $('#form_' + key).remove();
    }

    function add_response_sstat() {
        $('#response_sstat').append('<input type="text" class="form-control input_sstat" name="response_sstat[]">');
    }

    function remove_response_sstat() {
        var response_api = $('.input_sstat');
        if (response_api.length > 0) {
            response_api.each((key, value) => {
                if (response_api.length - 1 == key) {
                    $(value).remove();
                }
            });
        }
    }

    function add_response_sscount() {
        $('#response_sscount').append('<input type="text" class="form-control input_sscount" name="response_sscount[]">');
    }

    function remove_response_sscount() {
        var response_api = $('.input_sscount');
        if (response_api.length > 0) {
            response_api.each((key, value) => {
                if (response_api.length - 1 == key) {
                    $(value).remove();
                }
            });
        }
    }

    function add_response_sremains() {
        $('#response_sremains').append('<input type="text" class="form-control input_sremains" name="response_sremains[]">');
    }

    function remove_response_sremains() {
        var response_api = $('.input_sremains');
        if (response_api.length > 0) {
            response_api.each((key, value) => {
                if (response_api.length - 1 == key) {
                    $(value).remove();
                }
            });
        }
    }

    function add_status() {
        var key = Math.floor(Math.random() * 99999);
        $('#statuslist').append('<div class="row" id="status_' + key + '"><div class="form-group col-5" id="form_sk_' + key + '"><select class="select2-data form-control" id="status_key_' + key + '" name="status_key[]"><option value="Pending">Pending</option><option value="Processing">Processing</option><option value="Success">Success</option><option value="Error">Error</option><option value="Partial">Partial</option></select></div><div class="form-group col-5"><input type="text" class="form-control" id="status_value_' + key + '" name="status_value[]"></div><div class="form-group col-2 d-grid"><button type="button" class="btn btn-secondary" onclick="remove_status(' + key + ')"><i class="fas fa-trash fs-6"></i></button></div></div>');
        $("select#status_key_" + key).each((_i, e) => {
            var $e = $(e);
            $e.select2({
                dropdownParent: $e.parent()
            });
        });
    }

    function remove_status(key) {
        $('#status_' + key).remove();
    }
</script>