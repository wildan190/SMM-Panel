    <div class="row justify-content-center">
        <div class="col-sm-12">
            <div class="text-left mb-2">
                <a href="<?= base_url('admin/'.$this->uri->segment(2).'/') ?>" class="btn btn-success"><i class="uil uil-angle-double-left"></i> Kembali</a>
            </div>
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold"><i class="uil uil-plus mr-2"></i>Ubah Data</h6>
                </div>
                <div class="card-body">
                    <form method="post" action="<?= base_url() ?>admin/order/mass_form">
                        <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />

                        <table class="table table-colored-bordered table-bordered-dark table-hover m-0">
							<thead>
								<tr class="bg-blue">
                                    <th>ID Pesanan</th>
                                    <th>Status</th>
                                    <th><select name="mass_status" class="form-control form-control-sm" id="mass-status">
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
                                    <th>Start Count</th>
                                    <th>Remains</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach ($target as $key => $value) {
                            ?>
                                <tr>
                                    <td><input type="text" name="id[]" class="form-control" value="<?= $value['id'] ?>"></td>
                                    <td colspan="2">
                                        <select name="status[]" class="form-control" required="" id="status-<?= $value['id'] ?>">
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
                        </table><hr>
                        <div class="text-right">
                            <button type="reset" class="btn btn-secondary"><i class="uil uil-history"></i> Reset</button>
                            <button type="submit" class="btn btn-success"><i class="uil uil-message"></i> Submit</button>
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