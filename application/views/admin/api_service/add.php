<form class="form-horizontal" method="post" action="<?= base_url('admin/api_service/form') ?>">
    <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="name" class="form-label">Nama Provider <span class="text-danger">*</span></label>
                <select class="form-control select2-data" name="name" id="name">
                    <option value="">Pilih Salah Satu...</option>
                    <?php foreach ($api as $key => $value) { ?>
                        <option value="<?= $value['id'] ?>">
                            <?= $value['name'] ?>
                        </option>
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
            <div class="form-group mb-0">
                <label class="form-label">Parameter [Body] <span class="text-danger">*</span></label>
                <div id="parameter">
                </div>
            </div>
            <button type="button" class="btn btn-primary" onclick="add_parameter();"><i class="fas fa-plus-circle fs-6 me-2"></i>Add Parameter</button>
            <hr style="margin-top: 1.2rem; margin-bottom: .8rem;">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group mb-2">
                        <label for="success_response" class="form-label">Success Response: (JSON) <span class="text-danger">*</span></label>
                        <br>
                        <small>Validate Json here: <a rel="noopener noreferrer" href="https://jsonlint.com/" target="_new">https://jsonlint.com/</a></small>
                        <textarea class="form-control" id="success_response" style="height: 150px;" name="success_response"></textarea>
                    </div>
                </div>
                <hr style="margin-top: 1.2rem; margin-bottom: .8rem;">
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="form-label">Response Service Base Data<a href="javascript:;" class="text-primary ms-1" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" data-bs-original-title="<em>Base Data</em> yang membungkus service, kosongkan jika response api tidak ada <em>Base Data</em>"><i class="fas fa-exclamation-circle"></i></a></label>
                        <input type="text" class="form-control" id="data_service_key" name="data_service_key">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="form-label">Response Service ID <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="service_id_key" name="service_id_key">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="form-label">Response Service Category <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="category_key" name="category_key">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="form-label">Response Service Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="service_name_key" name="service_name_key">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="form-label">Response Service Price <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="price_key" name="price_key">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="form-label">Response Service Min <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="min_key" name="min_key">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="form-label">Response Service Max <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="max_key" name="max_key">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="form-label">Response Service Description<a href="javascript:;" class="text-primary ms-1" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" data-bs-original-title="Kosongkan jika response api tidak ada <em>Description</em>"><i class="fas fa-exclamation-circle"></i></a></label>
                        <input type="text" class="form-control" id="description_key" name="description_key">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="form-label">Response Service Refill <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="refill_key" name="refill_key">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="form-label">Response Service Type <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="type_key" name="type_key">
                    </div>
                </div>
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
    $('a[data-bs-toggle=tooltip]').tooltip();

    function add_parameter() {
        var key = Math.floor(Math.random() * 99999);
        $('#parameter').append('<div class="row" id="form_' + key + '"><div class="form-group col-4"><input type="text" class="form-control" id="param_key_' + key + '" name="param_key[]"></div><div class="form-group col-4"><select class="select2-data form-control" id="param_type_' + key + '" name="param_type[]" onchange="param_type(' + key + ', this.value)"><option value="primary">Primary</option><option value="custom">Custom</option></select></div><div class="form-group col-4" id="form_pv_' + key + '"><select class="select2-data form-control" id="param_value_' + key + '" name="param_value[]"><option value="api_id">API ID</option><option value="api_key">API Key</option><option value="secret_key">Secret Key</option></select></div><div class="form-group col-12"><button type="button" class="btn btn-secondary" onclick="remove_parameter(' + key + ')"><i class="fas fa-trash fs-6 me-2"></i>Remove Parameter</button></div></div>');
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
            $('#form_pv_' + key).html('<select class="select2-data form-control" id="param_value_' + key + '" name="param_value[]"><option value="api_id">API ID</option><option value="api_key">API Key</option><option value="secret_key">Secret Key</option></select>');
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

    function add_response_api() {
        $('#response_api').append('<input type="text" class="form-control input_api" name="response_api[]">');
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

    function add_response_sbased() {
        $('#response_sbased').append('<input type="text" class="form-control input_sbased" name="response_sbased[]">');
    }

    function remove_response_sbased() {
        var response_api = $('.input_sbased');
        if (response_api.length > 0) {
            response_api.each((key, value) => {
                if (response_api.length - 1 == key) {
                    $(value).remove();
                }
            });
        }
    }

    function add_response_sid() {
        $('#response_sid').append('<input type="text" class="form-control input_sid" name="response_sid[]">');
    }

    function remove_response_sid() {
        var response_api = $('.input_sid');
        if (response_api.length > 0) {
            response_api.each((key, value) => {
                if (response_api.length - 1 == key) {
                    $(value).remove();
                }
            });
        }
    }

    function add_response_scat() {
        $('#response_scat').append('<input type="text" class="form-control input_scat" name="response_scat[]">');
    }

    function remove_response_scat() {
        var response_api = $('.input_scat');
        if (response_api.length > 0) {
            response_api.each((key, value) => {
                if (response_api.length - 1 == key) {
                    $(value).remove();
                }
            });
        }
    }

    function add_response_sname() {
        $('#response_sname').append('<input type="text" class="form-control input_sname" name="response_sname[]">');
    }

    function remove_response_sname() {
        var response_api = $('.input_sname');
        if (response_api.length > 0) {
            response_api.each((key, value) => {
                if (response_api.length - 1 == key) {
                    $(value).remove();
                }
            });
        }
    }

    function add_response_sprice() {
        $('#response_sprice').append('<input type="text" class="form-control input_sprice" name="response_sprice[]">');
    }

    function remove_response_sprice() {
        var response_api = $('.input_sprice');
        if (response_api.length > 0) {
            response_api.each((key, value) => {
                if (response_api.length - 1 == key) {
                    $(value).remove();
                }
            });
        }
    }

    function add_response_smin() {
        $('#response_smin').append('<input type="text" class="form-control input_smin" name="response_smin[]">');
    }

    function remove_response_smin() {
        var response_api = $('.input_smin');
        if (response_api.length > 0) {
            response_api.each((key, value) => {
                if (response_api.length - 1 == key) {
                    $(value).remove();
                }
            });
        }
    }

    function add_response_smax() {
        $('#response_smax').append('<input type="text" class="form-control input_smax" name="response_smax[]">');
    }

    function remove_response_smax() {
        var response_api = $('.input_smax');
        if (response_api.length > 0) {
            response_api.each((key, value) => {
                if (response_api.length - 1 == key) {
                    $(value).remove();
                }
            });
        }
    }

    function add_response_sdesc() {
        $('#response_sdesc').append('<input type="text" class="form-control input_sdesc" name="response_sdesc[]">');
    }

    function remove_response_sdesc() {
        var response_api = $('.input_sdesc');
        if (response_api.length > 0) {
            response_api.each((key, value) => {
                if (response_api.length - 1 == key) {
                    $(value).remove();
                }
            });
        }
    }

    function add_response_stype() {
        $('#response_stype').append('<input type="text" class="form-control input_stype" name="response_stype[]">');
    }

    function remove_response_stype() {
        var response_api = $('.input_stype');
        if (response_api.length > 0) {
            response_api.each((key, value) => {
                if (response_api.length - 1 == key) {
                    $(value).remove();
                }
            });
        }
    }

    function add_type() {
        var key = Math.floor(Math.random() * 99999);
        $('#type').append('<div class="row" id="type_' + key + '"><div class="form-group col-5" id="form_tk_' + key + '"><select class="select2-data form-control" id="type_key_' + key + '" name="type_key[]"><option value="Default">Default</option><option value="Package">Package</option><option value="SEO">SEO</option><option value="Custom Comments">Custom Comments</option><option value="Mentions">Mentions</option><option value="Mentions with Hashtags">Mentions with Hashtags</option><option value="Mentions Custom List">Mentions Custom List</option><option value="Mentions Hashtag">Mentions Hashtag</option><option value="Mentions User Followers">Mentions User Followers</option><option value="Mentions Media Likers">Mentions Media Likers</option><option value="Custom Comments Package">Custom Comments Package</option><option value="Comment Likes">Comment Likes</option><option value="Poll">Poll</option><option value="Comment Replies">Comment Replies</option><option value="Invites from Groups">Invites from Groups</option></select></div><div class="form-group col-5"><input type="text" class="form-control" id="type_value_' + key + '" name="type_value[]"></div><div class="form-group col-2 d-grid"><button type="button" class="btn btn-secondary" onclick="remove_type(' + key + ')"><i class="fas fa-trash fs-6"></i></button></div></div>');
        $("select#type_key_" + key).each((_i, e) => {
            var $e = $(e);
            $e.select2({
                dropdownParent: $e.parent()
            });
        });
    }

    function remove_type(key) {
        $('#type_' + key).remove();
    }

    function add_response_sstat() {
        $('#response_sstat').append('<input type="text" class="form-control input_sstat" name="response_sstat_loc[]">');
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

    function add_response_srefill() {
        $('#response_srefill').append('<input type="text" class="form-control input_srefill" name="response_srefill_loc[]">');
    }

    function remove_response_srefill() {
        var response_api = $('.input_srefill');
        if (response_api.length > 0) {
            response_api.each((key, value) => {
                if (response_api.length - 1 == key) {
                    $(value).remove();
                }
            });
        }
    }

    function change_response(key) {
        if ($('#form_' + key).is(':checked')) {
            $('#formExt_' + key).removeClass('d-none');
        } else {
            $('#formExt_' + key).addClass('d-none');
        }
    }
</script>