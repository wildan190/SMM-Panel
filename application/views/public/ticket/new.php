<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0"><i class="fas fa-comment-medical me-2"></i>Tiket Baru</h4>
            </div>
            <div class="card-body pb-3">
                <form method="POST" action="<?= base_url('ticket/new') ?>">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
                    <div class="form-group">
                        <label class="form-label">Subjek <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="subject" value="<?= set_value('subject') ?>">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Tipe <span class="text-danger">*</span></label>
                        <select class="select2 form-control" name="type">
                            <option value="order">Pesanan</option>
                            <option value="deposit">Deposit</option>
                            <option value="service">Layanan</option>
                            <option value="other">Lainnya</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Pesan <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="msg" rows="4"><?= set_value('msg') ?></textarea>
                    </div>
                    <hr>
                    <div class="mb-0">
                        <button type="submit" class="btn btn-primary float-end"><i class="far fa-comments fs-6 me-2"></i>Kirim</button>
                        <button type="reset" class="btn btn-danger float-end me-2"><i class="fas fa-sync fs-6 me-2"></i>Ulangi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class=" card">
            <div class="card-header">
                <h4 class="mb-0"><i class="fas fa-info-circle me-2"></i>Informasi</h4>
            </div>
            <div class="card-body pb-3">
                <strong>Cara Membuat Tiket Baru :</strong>
                <ul>
                    <li>Input <em>Subjek</em> yang Anda inginkan.</li>
                    <li>Kami akan segera merespon tiket Anda.</li>
                </ul>
                <strong>Penting !</strong>
                <ul>
                    <li>Kami berhak menghapus atau memblokir akun Anda apabila terbukti melakukan tindakan
                        pelanggaran
                        pada Tiket.</li>
                </ul>
            </div>
        </div>
    </div>
</div>