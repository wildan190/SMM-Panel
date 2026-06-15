<div class="row justify-content-center">
	<div class="col-lg-6">
		<div class="card shadow mb-4">
            <div class="card-header py-3">
				<h6 class="m-0 font-weight-bold"><i class="uil uil-search-alt mr-2"></i> Cari Invoice</h6>
            </div>
            <div class="card-body">
                <form action="<?= base_url() ?>transaction/check_order_form" method="post">
                <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
                    <div class="form-group">
                        <div class="input-group mb-3">
							<input type="text" class="form-control" name="id" id="id" value="<?= $this->input->get('search') ?>" placeholder="Cari ID Invoice: 238120312XXX">
							<div class="input-group-append">
								<button class="btn btn-blue" type="submit"><i class="uil-search-alt"></i> Cari Invoice</button>
							</div>
						</div>
                    </div>
                </form>
			</div>
		</div>
	</div>
</div>