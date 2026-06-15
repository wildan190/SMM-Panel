<div class="row justify-content-center">
    <div class="col-md-12">
        <a href="<?= base_url('admin/' . $this->uri->segment(2) . '/') ?>" class="btn btn-primary mb-3"><i class="fas fa-arrow-circle-left fs-6 me-2"></i>Kembali</a>
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0"><i class="fas fa-plus-circle me-2"></i>Tambah Data</h4>
            </div>
            <div class="card-body">
                <form method="post">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
                    <div class="form-group mb-2 row">
                        <div class="form-group mb-2 col-md-12">
                            <label class="form-label">Kategori *</label>
                            <select class="form-control select2-data" name="category" id="category">
                                <?php
                                foreach ($service_category as $key => $value) {
                                ?>
                                    <option value="<?= $value['id'] ?>"><?= $value['name'] ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group mb-2 row">
                        <div class="form-group mb-2 col-md-12">
                            <label class="form-label">Layanan *</label>
                            <select class="form-control select2-data" name="service" id="service">
                            </select>
                        </div>
                    </div>
                    <div class="hstack gap-1 justify-content-end">
                        <button type="reset" class="btn btn-danger"><i class="fas fa-cancel fs-6 me-2"></i>Reset</button>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-plus-circle fs-6 me-2"></i>Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('.select2-data').select2();
    });
</script>
<script>
    $(function() {
        $('#category').on('change', function() {
            var category = $('#category').val();
            $.ajax({
                type: "GET",
                url: "<?= base_url('admin/service_recommended/service_list/') ?>" + category + "?<?= $this->security->get_csrf_token_name() ?>=<?= $this->security->get_csrf_hash() ?>",
                dataType: "json",
                success: function(data) {
                    $('#service').html(data.msg);
                },
                error: function() {
                    alert('Terjadi kesalahan, silakan refresh halaman inis.');
                }
            });
        });
    });
</script>