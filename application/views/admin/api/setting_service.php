    <div class="row">
        <div class="col-sm-12">
            <div class="text-left mb-2">
                <a href="<?= base_url('admin/'.$this->uri->segment(2).'/') ?>" class="btn btn-success"><i class="uil uil-angle-double-left"></i> Kembali</a>
            </div>
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold"><i class="uil uil-edit mr-2"></i>Kelola Pembaruan Otomatis</h6>
                </div>
                <div class="card-body">
                    <form method="post" action="<?= base_url() ?>admin/api/update_setting_service">
                        <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />

                        <table class="table table-bordered table-striped table-hover m-0">
							<thead>
								<tr class="">
									<th>Provider</th>
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
                                    <th>Tipe Keuntungan</th>
                                    <th>Keuntungan /K</th>
                                    <th>Cutoff Saldo</th>
                                    <th>Kurs</th>
                                    <th>Rate</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach ($target as $key => $value) {
                            ?>
                                <tr>
									<td>
                                        <input type="text" name="name[]" class="form-control" value="<?= $value['name'] ? $value['name'] : '0' ?>" required=""> 
                                    </td>
                                    <td colspan="2">
                                        <select name="auto_update[]" class="form-control" required="" id="status-<?= $value['id'] ?>">
                                            <option value="">Semua</option>
                                            <?php
                                            foreach ($status as $skey => $svalue) {
                                            ?>
                                                <option value="<?= $skey ?>" <?= ($skey == $value['auto_update']) ? 'selected' : '' ?>><?= $svalue['name'] ?></option>

                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </td>
                                    <td>
										<select name="profit_type[]" class="form-control" required="">
											<option value="biasa" <?= ($value['profit_type'] == 'biasa') ? 'selected' : '' ; ?>>Nominal</option>
											<option value="persen" <?= ($value['profit_type'] == 'persen') ? 'selected' : '' ; ?>>Persentase</option>
                                        </select>
										<small>Keterangan: [Nominal] Input nominal. [Persentase] Input angka 1-100 tanpa tanda %</small>
                                    </td>

                                    <td>
                                        <input type="number" name="profit[]" class="form-control" value="<?= ($value['profit']) ? $value['profit'] : '0' ?>" required=""> 
                                    </td>
                                    <td>
                                        <input type="number" name="cutoff_balance[]" class="form-control" value="<?= ($value['cutoff_balance']) ? $value['cutoff_balance'] : '0' ?>" required=""> 
                                    </td>
                                    <td width="10%">
                                        <select name="kurs[]" class="form-control" required="">
											<option value="IDR" <?= ($value['kurs'] == 'IDR') ? 'selected' : '' ; ?>>IDR</option>
											<option value="USD" <?= ($value['kurs'] == 'USD') ? 'selected' : '' ; ?>>USD</option>
                                        </select>
										
                                    </td>
                                    <td>
                                        <input type="number" name="rate[]" class="form-control" value="<?= ($value['rate']) ? $value['rate'] : '0' ?>" required="">
                                        <small>Keterangan: Input [Rate] Jika Menggunakan Kurs USD</small>
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