<style>
    .form-check .form-check-input {
        cursor: pointer;
    }
</style>
<form class="form-horizontal" method="post" action="<?= base_url('admin/api_refill/form/' . $target->api_id) ?>">
    <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="name" class="form-label">Nama Provider <span class="text-danger">*</span></label>
                <select class="form-control select2-data" name="name" id="name">
                    <option value="">Pilih Salah Satu...</option>
                    <?php foreach ($api as $key => $value) { ?>
                        <option value="<?= $value['id'] ?>" <?= ($value['id'] == $target->api_id) ? 'selected' : ''; ?>>
                            <?= $value['name'] ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">API URL <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="end_point" value="<?= $target->end_point ?>">
            </div>
            <div class="form-group">
                <label for="order_method" class="form-label">HTTP Method <span class="text-danger">*</span></label>
                <select class="form-control select2-data" name="method" id="method">
                    <option value="POST" <?= ($target->method == 'POST') ? 'selected' : '' ?>>POST</option>
                    <option value="GET" <?= ($target->method == 'GET') ? 'selected' : '' ?>>GET</option>
                </select>
            </div>
            <hr style="margin-top: 1.2rem; margin-bottom: .8rem;">
            <div class="form-group mb-0">
                <label class="form-label">Parameter [Body] <span class="text-danger">*</span></label>
                <div id="parameter">
                    <?php if (!empty($api_request_param)) {
                        foreach ($api_request_param as $key => $value) {
                            if ($value['api_type'] == 'refill') {
                            }
                    ?>
                            <div class="row" id="form_<?= $value['id'] ?>">
                                <div class="form-group col-4">
                                    <input type="text" class="form-control" id="param_key_<?= $value['id'] ?>" name="param_key[]" value="<?= $value['param_key'] ?>">
                                </div>
                                <div class="form-group col-4">
                                    <select class="select2-data form-control" id="param_type_<?= $value['id'] ?>" name="param_type[]" onchange="param_type(<?= $value['id'] ?>, this.value)">
                                        <option value="primary" <?= ($value['param_type'] == 'primary') ? 'selected' : ''; ?>>Primary</option>
                                        <option value="custom" <?= ($value['param_type'] == 'custom') ? 'selected' : ''; ?>>Custom</option>
                                    </select>
                                </div>
                                <div class="form-group col-4" id="form_pv_<?= $value['id'] ?>">
                                    <?php if ($value['param_type'] == 'custom') { ?>
                                        <input type="text" class="form-control" id="param_value_<?= $value['id'] ?>" name="param_value[]" value="<?= $value['param_value'] ?>">
                                    <?php } else { ?>
                                        <select class="select2-data form-control" id="param_value_<?= $value['id'] ?>" name="param_value[]">
                                            <option value="api_id" <?= ($value['param_value'] == 'api_id') ? 'selected' : ''; ?>>API ID</option>
                                            <option value="api_key" <?= ($value['param_value'] == 'api_key') ? 'selected' : ''; ?>>API Key</option>
                                            <option value="secret_key" <?= ($value['param_value'] == 'secret_key') ? 'selected' : ''; ?>>Secret Key</option>
                                            <option value="order_id" <?= ($value['param_value'] == 'order_id') ? 'selected' : ''; ?>>Order ID</option>
                                        </select>
                                    <?php } ?>
                                </div>
                                <div class="form-group col-12"><button type="button" class="btn btn-secondary" onclick="remove_parameter(<?= $value['id'] ?>)"><i class="fas fa-trash fs-6 me-2"></i>Remove Parameter</button></div>
                            </div>
                    <?php }
                    } ?>
                </div>
            </div>
            <button type="button" class="btn btn-primary" onclick="add_parameter();"><i class="fas fa-plus-circle fs-6 me-2"></i>Add Parameter</button>
            <hr style="margin-top: 1.2rem; margin-bottom: .8rem;">
            <div class="form-group">
                <label for="order_success_response" class="form-label">Success Response: (JSON) <span class="text-danger">*</span></label>
                <br>
                <small>Validate JSON here: <a rel="noopener noreferrer" href="https://jsonlint.com/" target="_new">https://jsonlint.com/</a></small>
                <textarea class="form-control" id="success_response" style="height: 150px;" name="success_response"><?= $target->success_response ?></textarea>
            </div>
            <div class="form-group mb-3">
                <label class="form-label">Response ID Refill <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="refill_id_key" value="<?= $target->refill_id_key ?>">
            </div>
            <hr class="mt-1">
        </div>
    </div>
    <div class="mb-0">
        <button type="submit" class="btn btn-primary float-end"><i class="fas fa-plus-circle fs-6 me-2"></i>Tambah</button>
        <button class="btn btn-danger float-end me-2" type="reset"><i class="fas fa-sync fs-6 me-2"></i>Ulangi</button>
    </div>
</form>
<script type="text/javascript">
    function add_parameter() {
        var key = Math.floor(Math.random() * 99999);
        $('#parameter').append('<div class="row" id="form_' + key + '"><div class="form-group col-4"><input type="text" class="form-control" id="param_key_' + key + '" name="param_key[]"></div><div class="form-group col-4"><select class="select2-data form-control" id="param_type_' + key + '" name="param_type[]" onchange="param_type(' + key + ', this.value)"><option value="primary">Primary</option><option value="custom">Custom</option></select></div><div class="form-group col-4" id="form_pv_' + key + '"><select class="select2-data form-control" id="param_value_' + key + '" name="param_value[]"><option value="api_id">API ID</option><option value="api_key">API Key</option><option value="secret_key">Secret Key</option><option value="order_id">Order ID</option></select></div><div class="form-group col-12"><button type="button" class="btn btn-secondary" onclick="remove_parameter(' + key + ')"><i class="fas fa-trash fs-6 me-2"></i>Remove Parameter</button></div></div>');
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
            $('#form_pv_' + key).html('<select class="select2-data form-control" id="param_value_' + key + '" name="param_value[]"><option value="api_id">API ID</option><option value="api_key">API Key</option><option value="secret_key">Secret Key</option><option value="order_id">Order ID</option></select>');
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

    function change_parameter(key) {
        if ($('#param_' + key).is(':checked')) {
            $('#formExt_' + key).removeClass('d-none');
        } else {
            $('#formExt_' + key).addClass('d-none');
        }
    }

    function add_response_api() {
        $('#response_api').append('<input type="text" class="form-control input_api" name="response_api_loc[]">');
    }

    function remove_response_api() {
        var response_api = $('.input_api');
        if (response_api.length > 0) {
            response_api.each((key, value) => {
                if (response_api.length - 1 == key) {
                    $(value).remove();
                }
            });
        }
    }

    function add_response_rid() {
        $('#response_rid').append('<input type="text" class="form-control input_rid" name="response_rid[]">');
    }

    function remove_response_rid() {
        var response_api = $('.input_rid');
        if (response_api.length > 0) {
            response_api.each((key, value) => {
                if (response_api.length - 1 == key) {
                    $(value).remove();
                }
            });
        }
    }

    function change_response() {
        if ($('#use_response_rid').is(':checked')) {
            $('input[name="response_api_loc[]"]').attr('disabled', 'true');
            $('input[name="response_api_value"]').attr('disabled', 'true');
            $('select[name="response_api_type"]').attr('disabled', 'true');
            $('button[onclick="add_response_api();"]').attr('disabled', 'true');
            $('button[onclick="remove_response_api();"]').attr('disabled', 'true');
        } else {
            $('input[name="response_api_loc[]"]').removeAttr('disabled');
            $('input[name="response_api_value"]').removeAttr('disabled');
            $('select[name="response_api_type"]').removeAttr('disabled');
            $('button[onclick="add_response_api();"]').removeAttr('disabled');
            $('button[onclick="remove_response_api();"]').removeAttr('disabled');
        }
    }
</script>