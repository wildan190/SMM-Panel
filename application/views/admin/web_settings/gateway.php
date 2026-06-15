<?php $this->load->view('admin/' . $this->uri->segment(2) . '/menu') ?>
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h4 class="mb-0"><i class="fas fa-cogs me-2"></i><?= $page ?></h4>
        </div>
        <div class="card-body pb-3">
            <form method="post" role="form" enctype="multipart/form-data" id="main-form">
                <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
                <div class="alert alert-primary">
                    <div class="alert-body">
                        <p class="mb-0">Endpoint WA Gateway -> <b><em><a href="https://api.ultrasender.biz.id" target="_blank">https://api.ultrasender.biz.id/</a></em></b></p>
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col-sm-6">
                        <label for="whatsapp_gateway" class="form-label">
                            Notifikasi Whatsapp Admin </label>
                        <input type="text" name="wa_admin" value="<?= website_config('wa_admin') ?>" class="form-control" id="whatsapp_gateway" placeholder="6282277777960">
                    </div>
                    <div class="col-sm-6">
                        <label for="wa_url" class="form-label">
                            Endpoint </label>
                        <input type="text" name="wa_endpoint" value="<?= website_config('wa_endpoint') ?>" class="form-control" id="wa_url" placeholder="Endpoint">
                    </div>
                    <div class="col-sm-6">
                        <label for="wa_api_key" class="form-label">
                            Api Key </label>
                        <input type="text" name="wa_app_key" value="<?= website_config('wa_app_key') ?>" class="form-control" id="wa_api_key" placeholder="Api Key">
                    </div>
                    <div class="col-sm-6">
                        <label for="wa_sender" class="form-label">
                            Nomor WhatsApp Bot </label>
                        <input type="text" name="wa_auth_key" value="<?= website_config('wa_auth_key') ?>" class="form-control" id="wa_sender" placeholder="Nomor WhatsApp Bot">
                    </div>
                </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h4 class="mb-0"><i class="fas fa-cogs me-2"></i>OTP & Notification</h4>
        </div>
        <div class="card-body pb-3">
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th style="background-color: rgba(var(--bs-primary-rgb), 0.2);" colspan="2">Daftar
                                        Variabel Umum</th>
                                </tr>
                                <tr>
                                    <th>
                                        <label class="form-label">Nama Lengkap User</label>
                                        <div class="input-group">
                                            <input class="form-control form-control-sm" id="user_fullname" value="{{user_fullname}}" disabled>
                                            <button type="button" class="btn btn-sm btn-primary" onclick="copy_text('Teks', '{{user_fullname}}');"><i class="fas fa-copy fs-6 me-2"></i> Salin</button>
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                    <th>
                                        <label class="form-label">Username User</label>
                                        <div class="input-group">
                                            <input class="form-control form-control-sm" id="user_username" value="{{user_username}}" disabled>
                                            <button type="button" class="btn btn-sm btn-primary" onclick="copy_text('Teks', '{{user_username}}');"><i class="fas fa-copy fs-6 me-2"></i> Salin</button>
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                    <th>
                                        <label class="form-label">URL Website</label>
                                        <div class="input-group">
                                            <input class="form-control form-control-sm" id="url" value="{{url}}" disabled>
                                            <button type="button" class="btn btn-sm btn-primary" onclick="copy_text('Teks', '{{url}}');"><i class="fas fa-copy fs-6 me-2"></i>
                                                Salin</button>
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                    <th>
                                        <label class="form-label">Nama Website</label>
                                        <div class="input-group">
                                            <input class="form-control form-control-sm" id="title" value="{{title}}" disabled>
                                            <button type="button" class="btn btn-sm btn-primary" onclick="copy_text('Teks', '{{title}}');"><i class="fas fa-copy fs-6 me-2"></i>
                                                Salin</button>
                                        </div>
                                    </th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <label class="form-label">Send OTP</label>
                    <select class="select2-data form-control" name="send_wa_otp">
                        <option value="on" <?= (website_config('send_wa_otp') == 'on') ? 'selected' : '' ?>>On <?= (website_config('send_wa_otp') == 'on') ? '(Dipilih)' : '' ?></option>
                        <option value="off" <?= (website_config('send_wa_otp') == 'off') ? 'selected' : '' ?>>Off <?= (website_config('send_wa_otp') == 'off') ? '(Dipilih)' : '' ?></option>
                    </select>
                    <div class="table-responsive mt-3">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th style="background-color: rgba(var(--bs-primary-rgb), 0.2);" colspan="2">Daftar Variabel OTP</th>
                                </tr>
                                <tr>
                                    <th>
                                        <label class="form-label">Link OTP</label>
                                        <div class="input-group">
                                            <input class="form-control form-control-sm" id="otp" value="{{otp}}" disabled>
                                            <button type="button" class="btn btn-sm btn-primary" onclick="copy_text('Teks', '{{otp}}');"><i class="fas fa-copy fs-6 me-2"></i> Salin</button>
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                    <th>
                                        <label class="form-label">Waktu Login</label>
                                        <div class="input-group">
                                            <input class="form-control form-control-sm" id="login_time" value="{{login_time}}" disabled>
                                            <button type="button" class="btn btn-sm btn-primary" onclick="copy_text('Teks', '{{login_time}}');"><i class="fas fa-copy fs-6 me-2"></i> Salin</button>
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                    <th>
                                        <label class="form-label">IP Address</label>
                                        <div class="input-group">
                                            <input class="form-control form-control-sm" id="ip_address" value="{{ip_address}}" disabled>
                                            <button type="button" class="btn btn-sm btn-primary" onclick="copy_text('Teks', '{{ip_address}}');"><i class="fas fa-copy fs-6 me-2"></i> Salin</button>
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                    <th>
                                        <label class="form-label">UA Device</label>
                                        <div class="input-group">
                                            <input class="form-control form-control-sm" id="ua_device" value="{{ua_device}}" disabled>
                                            <button type="button" class="btn btn-sm btn-primary" onclick="copy_text('Teks', '{{ua_device}}');"><i class="fas fa-copy fs-6 me-2"></i> Salin</button>
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                    <th>
                                        <label class="form-label">UA Browser</label>
                                        <div class="input-group">
                                            <input class="form-control form-control-sm" id="ua_browser" value="{{ua_browser}}" disabled>
                                            <button type="button" class="btn btn-sm btn-primary" onclick="copy_text('Teks', '{{ua_browser}}');"><i class="fas fa-copy fs-6 me-2"></i> Salin</button>
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                    <th>
                                        <label class="form-label">Email User</label>
                                        <div class="input-group">
                                            <input class="form-control form-control-sm" id="ua_browser" value="{{user_email}}" disabled>
                                            <button type="button" class="btn btn-sm btn-primary" onclick="copy_text('Teks', '{{user_email}}');"><i class="fas fa-copy fs-6 me-2"></i> Salin</button>
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                    <th>
                                        <label class="form-label">Whatsapp User</label>
                                        <div class="input-group">
                                            <input class="form-control form-control-sm" id="ua_browser" value="{{user_whatsapp}}" disabled>
                                            <button type="button" class="btn btn-sm btn-primary" onclick="copy_text('Teks', '{{user_whatsapp}}');"><i class="fas fa-copy fs-6 me-2"></i> Salin</button>
                                        </div>
                                    </th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="form-group">
                        <label class="form-label">OTP Login » Messages</label>
                        <textarea class="form-control" name="wa_otp_login" rows="10"><?= website_config('wa_otp_login') ?></textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-label mt-1">OTP Register » Messages</label>
                        <textarea class="form-control" name="wa_otp_register" rows="10"><?= website_config('wa_otp_register') ?></textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-label mt-1">OTP Reset Password » Messages</label>
                        <textarea class="form-control" name="wa_otp_reset" rows="10"><?= website_config('wa_otp_reset') ?></textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-label mt-1">OTP Admin Register » Messages</label>
                        <textarea class="form-control" name="wa_admin_otp_register" rows="10"><?= website_config('wa_admin_otp_register') ?></textarea>
                    </div>
                </div>
            </div>
            <hr class="mt-2">
            <div class="row">
                <div class="col-md-3">
                    <label class="form-label">Send Deposit</label>
                    <select class="select2-data form-control" name="send_wa_deposit">
                        <option value="on" <?= (website_config('send_wa_deposit') == 'on') ? 'selected' : '' ?>>On <?= (website_config('send_wa_deposit') == 'on') ? '(Dipilih)' : '' ?></option>
                        <option value="off" <?= (website_config('send_wa_deposit') == 'off') ? 'selected' : '' ?>>Off <?= (website_config('send_wa_deposit') == 'off') ? '(Dipilih)' : '' ?></option>
                    </select>
                    <div class="table-responsive mt-4">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th style="background-color: rgba(var(--bs-primary-rgb), 0.2);" colspan="2">Daftar
                                        Variabel Deposit</th>
                                </tr>
                                <tr>
                                    <th>
                                        <label class="form-label">ID Deposit</label>
                                        <div class="input-group">
                                            <input class="form-control form-control-sm" id="deposit_id" value="{{deposit_id}}" disabled>
                                            <button type="button" class="btn btn-sm btn-primary" onclick="copy_text('Teks', '{{deposit_id}}');"><i class="fas fa-copy fs-6 me-2"></i>
                                                Salin</button>
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                    <th>
                                        <label class="form-label">Metode Deposit</label>
                                        <div class="input-group">
                                            <input class="form-control form-control-sm" id="deposit_method" value="{{deposit_method}}" disabled>
                                            <button type="button" class="btn btn-sm btn-primary" onclick="copy_text('Teks', '{{deposit_method}}');"><i class="fas fa-copy fs-6 me-2"></i> Salin</button>
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                    <th>
                                        <label class="form-label">Jumlah Transfer</label>
                                        <div class="input-group">
                                            <input class="form-control form-control-sm" id="deposit_transfer" value="{{deposit_transfer}}" disabled>
                                            <button type="button" class="btn btn-sm btn-primary" onclick="copy_text('Teks', '{{deposit_transfer}}');"><i class="fas fa-copy fs-6 me-2"></i> Salin</button>
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                    <th>
                                        <label class="form-label">Saldo Diterima</label>
                                        <div class="input-group">
                                            <input class="form-control form-control-sm" id="deposit_amount" value="{{deposit_amount}}" disabled>
                                            <button type="button" class="btn btn-sm btn-primary" onclick="copy_text('Teks', '{{deposit_amount}}');"><i class="fas fa-copy fs-6 me-2"></i> Salin</button>
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                    <th>
                                        <label class="form-label">Status Deposit</label>
                                        <div class="input-group">
                                            <input class="form-control form-control-sm" id="deposit_status" value="{{deposit_status}}" disabled>
                                            <button type="button" class="btn btn-sm btn-primary" onclick="copy_text('Teks', '{{deposit_status}}');"><i class="fas fa-copy fs-6 me-2"></i> Salin</button>
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                    <th>
                                        <label class="form-label">Tanggal Pembuatan Deposit</label>
                                        <div class="input-group">
                                            <input class="form-control form-control-sm" id="deposit_create" value="{{deposit_create}}" disabled>
                                            <button type="button" class="btn btn-sm btn-primary" onclick="copy_text('Teks', '{{deposit_create}}');"><i class="fas fa-copy fs-6 me-2"></i> Salin</button>
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                    <th>
                                        <label class="form-label">Tanggal Pembaruan Deposit</label>
                                        <div class="input-group">
                                            <input class="form-control form-control-sm" id="deposit_update" value="{{deposit_update}}" disabled>
                                            <button type="button" class="btn btn-sm btn-primary" onclick="copy_text('Teks', '{{deposit_update}}');"><i class="fas fa-copy fs-6 me-2"></i> Salin</button>
                                        </div>
                                    </th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="form-group">
                        <label class="form-label">Deposit Pending » Messages</label>
                        <textarea class="form-control" name="wa_deposit_pending" rows="10"><?= website_config('wa_deposit_pending') ?></textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-label mt-1">Deposit Success » Messages</label>
                        <textarea class="form-control" name="wa_deposit_success" rows="10"><?= website_config('wa_deposit_success') ?></textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-label mt-1">Deposit Cancel » Messages</label>
                        <textarea class="form-control" name="wa_deposit_canceled" rows="10"><?= website_config('wa_deposit_canceled') ?></textarea>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="form-label">Deposit Pending » Messages Admin</label>
                        <textarea class="form-control" name="wa_admin_deposit_pending" rows="10"><?= website_config('wa_admin_deposit_pending') ?></textarea>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="form-label">Deposit Success » Messages Admin</label>
                        <textarea class="form-control" name="wa_admin_deposit_success" rows="10"><?= website_config('wa_admin_deposit_success') ?></textarea>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="form-label">Deposit Canceled » Messages Admin</label>
                        <textarea class="form-control" name="wa_admin_deposit_canceled" rows="10"><?= website_config('wa_admin_deposit_canceled') ?></textarea>
                    </div>
                </div>
            </div>
            <hr class="mt-2">
            <div class="row">
                <div class="col-md-3">
                    <label class="form-label">Send Ticket User</label>
                    <select class="select2-data form-control" name="send_wa_ticket_user">
                        <option value="on" <?= (website_config('send_wa_ticket_user') == 'on') ? 'selected' : '' ?>>On <?= (website_config('send_wa_ticket_user') == 'on') ? '(Dipilih)' : '' ?></option>
                        <option value="off" <?= (website_config('send_wa_ticket_user') == 'off') ? 'selected' : '' ?>>Off <?= (website_config('send_wa_ticket_user') == 'off') ? '(Dipilih)' : '' ?></option>
                    </select>
                    <label class="form-label mt-3">Send Ticket Admin</label>
                    <select class="select2-data form-control" name="send_wa_ticket_admin">
                        <option value="on" <?= (website_config('send_wa_ticket_admin') == 'on') ? 'selected' : '' ?>>On <?= (website_config('send_wa_ticket_admin') == 'on') ? '(Dipilih)' : '' ?></option>
                        <option value="off" <?= (website_config('send_wa_ticket_admin') == 'off') ? 'selected' : '' ?>>Off <?= (website_config('send_wa_ticket_admin') == 'off') ? '(Dipilih)' : '' ?></option>
                    </select>
                    <div class="table-responsive mt-3">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th style="background-color: rgba(var(--bs-primary-rgb), 0.2);" colspan="2">Daftar Variabel Ticket</th>
                                </tr>
                                <tr>
                                    <th>
                                        <label class="form-label">Nama Lengkap Admin</label>
                                        <div class="input-group">
                                            <input class="form-control form-control-sm" id="admin_fullname" value="{{admin_fullname}}" disabled>
                                            <button type="button" class="btn btn-sm btn-primary" onclick="copy_text('Teks', '{{admin_fullname}}');"><i class="fas fa-copy fs-6 me-2"></i> Salin</button>
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                    <th>
                                        <label class="form-label">Username Admin</label>
                                        <div class="input-group">
                                            <input class="form-control form-control-sm" id="admin_username" value="{{admin_username}}" disabled>
                                            <button type="button" class="btn btn-sm btn-primary" onclick="copy_text('Teks', '{{admin_username}}');"><i class="fas fa-copy fs-6 me-2"></i> Salin</button>
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                    <th>
                                        <label class="form-label">ID Ticket</label>
                                        <div class="input-group">
                                            <input class="form-control form-control-sm" id="ticket_id" value="{{ticket_id}}" disabled>
                                            <button type="button" class="btn btn-sm btn-primary" onclick="copy_text('Teks', '{{ticket_id}}');"><i class="fas fa-copy fs-6 me-2"></i> Salin</button>
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                    <th>
                                        <label class="form-label">Subject Ticket</label>
                                        <div class="input-group">
                                            <input class="form-control form-control-sm" id="ticket_subject" value="{{ticket_subject}}" disabled>
                                            <button type="button" class="btn btn-sm btn-primary" onclick="copy_text('Teks', '{{ticket_subject}}');"><i class="fas fa-copy fs-6 me-2"></i> Salin</button>
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                    <th>
                                        <label class="form-label">Status Ticket</label>
                                        <div class="input-group">
                                            <input class="form-control form-control-sm" id="ticket_status" value="{{ticket_status}}" disabled>
                                            <button type="button" class="btn btn-sm btn-primary" onclick="copy_text('Teks', '{{ticket_status}}');"><i class="fas fa-copy fs-6 me-2"></i> Salin</button>
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                    <th>
                                        <label class="form-label">Tanggal Pembuatan Ticket</label>
                                        <div class="input-group">
                                            <input class="form-control form-control-sm" id="ticket_create" value="{{ticket_create}}" disabled>
                                            <button type="button" class="btn btn-sm btn-primary" onclick="copy_text('Teks', '{{ticket_create}}');"><i class="fas fa-copy fs-6 me-2"></i> Salin</button>
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                    <th>
                                        <label class="form-label">Tanggal Pembaruan Ticket</label>
                                        <div class="input-group">
                                            <input class="form-control form-control-sm" id="ticket_update" value="{{ticket_update}}" disabled>
                                            <button type="button" class="btn btn-sm btn-primary" onclick="copy_text('Teks', '{{ticket_update}}');"><i class="fas fa-copy fs-6 me-2"></i> Salin</button>
                                        </div>
                                    </th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="form-group">
                        <label class="form-label">Create Ticket User » Messages</label>
                        <textarea class="form-control" name="wa_ticket_create" rows="10"><?= website_config('wa_ticket_create') ?></textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-label mt-1">Reply Ticket User » Messages</label>
                        <textarea class="form-control" name="wa_ticket_reply" rows="10"><?= website_config('wa_ticket_reply') ?></textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-label mt-1">Close Ticket User » Messages</label>
                        <textarea class="form-control" name="wa_ticket_close" rows="10"><?= website_config('wa_ticket_close') ?></textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-label mt-1">Create Ticket Admin » Messages</label>
                        <textarea class="form-control" name="wa_admin_ticket_create" rows="10"><?= website_config('wa_admin_ticket_create') ?></textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-label mt-1">Reply Ticket Admin » Messages</label>
                        <textarea class="form-control" name="wa_admin_ticket_reply" rows="10"><?= website_config('wa_admin_ticket_reply') ?></textarea>
                    </div>
                </div>
            </div>
            <div class="mb-0">
                <button type="submit" class="btn btn-primary float-end"><i class="fas fa-edit fs-6 me-2"></i>Simpan</button>
            </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="modal_scanqr" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Scan QR</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="body_scanqr">
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function scanQr() {
        var phone = $('#phone_wagw').val()
        if (phone == '') {
            Swal.fire({
                icon: "error",
                title: "Ups!",
                html: "Input tidak boleh kosong.",
                customClass: {
                    confirmButton: 'btn btn-primary',
                },
                buttonsStyling: false,
            });
        } else {
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>admin/web_settings?act=wagateway',
                data: 'scan&phone=' + $('#phone_wagw').val(),
                dataType: 'json',
                success: function(result) {
                    $.unblockUI();
                    if (result.device == 'connected') {
                        window.location.reload(true);
                    } else {
                        $('#body_scanqr').html(result.qr);
                        $('#modal_scanqr').modal('show');
                        setInterval(function() {
                            $.ajax({
                                type: 'POST',
                                url: '<?= base_url() ?>admin/web_settings?act=wagateway',
                                data: 'connection&phone=' + $('#phone_wagw').val(),
                                dataType: 'json',
                                success: function(result) {
                                    if (result == 'connected') {
                                        window.location.reload(true);
                                    }
                                }
                            });
                        }, 5000);
                    }
                },
                error: function() {
                    $.unblockUI();
                    Swal.fire({
                        icon: "error",
                        title: "Ups!",
                        html: "Terjadi kesalahan.",
                        customClass: {
                            confirmButton: 'btn btn-primary',
                        },
                        buttonsStyling: false,
                    });
                },
                beforeSend: function() {
                    $.blockUI({
                        message: '',
                        css: {
                            backgroundColor: 'transparent',
                            border: '0'
                        },
                        overlayCSS: {
                            backgroundColor: '#fff',
                            opacity: 0.8
                        }
                    });
                }
            });
        }
    }
</script>