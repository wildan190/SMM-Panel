    <div class="row">
        <div class="col-md-12">
		    <a href="<?= base_url('admin/'.$this->uri->segment(2).'/') ?>" class="btn btn-primary mb-3"><i class="fas fa-arrow-circle-left fs-6 me-2"></i>Kembali</a>
		<div class="card">
            <div class="card-header">
				<h4 class="mb-0"><i class="fas fa-edit me-2"></i>Ubah Data</h4>
            </div>
                <div class="card-body">
                    <form method="post" action="<?= base_url() ?>admin/order/mass_form">
                        <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
								<div class="table-responsive table-card mb-2">
                        <table class="table table-nowrap table-bordered table-striped align-middle table-hover m-0">
							<thead>
								<tr class="bg-blue">
                                    <th>ID Pesanan</th>
                                    <th>Status</th>
                                    <th><select name="mass_status" class="form-control select2-data form-control-sm" id="mass-status">
                                            <option value="">Semua</option>
                                                <?php
                                                foreach ($status as $key => $value) {
                                                ?>
                                                <option value="<?= $key ?>"><?= $value['name'] ?></option>
                                                <?php
                                                }
                                                ?>
                                        </select>
                                    </th>
                                    <th>Jumlah Awal</th>
                                    <th>Jumlah Kurang</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach ($target as $key => $value) {
                            ?>
                                <tr>
                                    <td><input type="text" name="id[]" class="form-control" value="<?= $value['id'] ?>"></td>
                                    <td colspan="2">
                                        <select name="status[]" class="form-control select2-data" required="" id="status-<?= $value['id'] ?>">
                                            <option value="">Semua</option>
                                            <?php
                                            foreach ($status as $skey => $svalue) {
                                            ?>
                                                <option value="<?= $skey ?>" <?= ($skey == $value['status']) ? 'selected' : '' ?>><?= $svalue['name'] ?></option>

                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text" name="start_count[]" class="form-control" required="" value="<?= $value['start_count'] ? $value['start_count'] : '0' ?>">
                                    </td>
                                    <td>
                                        <input type="text" name="remains[]" class="form-control" required="" value="<?= $value['remains'] ? $value['remains'] : '0' ?>">
                                    </td>
                                </tr>
                                <?php }  ?>
                            </tbody>
                        </table>
                        </div><hr>
					<div class="hstack gap-1 w-100 justify-content-end">
					<button type="reset" class="btn btn-danger float-end me-2"><i class="fas fa-sync fs-6 me-2"></i>Reset</button>
                        <button type="submit" class="btn btn-primary float-end"><i class="fas fa-edit fs-6 me-2"></i>Ubah</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
function select(selectId, optionValToSelect) {
	var selectElement = document.getElementById(selectId);
	var selectOptions = selectElement.options;
	for (var opt, j = 0; opt = selectOptions[j]; j++) {
		if (opt.value == optionValToSelect) {
			selectElement.selectedIndex = j;
			break;
		}
	}
}
$('#mass-status').on('change', function() {
	var status = $('#mass-status').val();
    <?php
    foreach ($target as $key => $value) {
    ?>
    select('status-<?= $value['id'] ?>', status);
    <?php } ?>
});
</script>