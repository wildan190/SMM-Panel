<div class="row">
    <div class="col-md-5">
        <div class="card">
            <div class="card-header"><h5>Unggah Banner</h5></div>
            <div class="card-body">
                <form action="<?= base_url('admin/banner/upload') ?>" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" />
                    <div class="mb-3">
                        <label>Judul/Keterangan</label>
                        <input type="text" name="title" class="form-control" placeholder="Promo Cashback" required>
                    </div>
                    <div class="mb-3">
                        <label>File Gambar</label>
                        <input type="file" name="banner_file" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Upload Banner</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-7">
        <div class="card text-dark">
            <div class="card-header"><h5>Daftar Banner</h5></div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Gambar</th>
                            <th>Judul</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($banners as $b): ?>
                        <tr>
                            <td><img src="<?= base_url('assets/images/slider/'.$b['image']) ?>" width="100" class="rounded shadow-sm"></td>
                            <td><?= $b['title'] ?></td>
                            <td><a href="<?= base_url('admin/banner/delete/'.$b['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus?')">Hapus</a></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>