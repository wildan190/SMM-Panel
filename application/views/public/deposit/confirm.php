<div class="row justify-content-center">
	<div class="col-lg-12">
		<div class="text-left mb-3">
		</div>
		<div class="card">
			<div class="card-header bg-blue">
				<h5 class="card-title mb-0 text-white"><i class="fas fa-fw fa-times"></i> Batalkan Permintaan Deposit</h5>
			</div>
			<div class="card-body">
				<form method="post" action="<?= base_url('deposit/confirm/' . $target->id) ?>">
					<input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
					<div class="form-group">
						<label>Password *</label>
						<input type="password" class="form-control" name="password">
					</div>
					<div class="text-right">
						<button type="reset" class="btn btn-secondary">Reset</button>
						<button type="submit" class="btn btn-success"><i class="fa fa-paper-plane mr-1"></i> Submit</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
$('form').submit(function(){
    $(this).children('button[type=submit]').prop('disabled', true);
});
</script>