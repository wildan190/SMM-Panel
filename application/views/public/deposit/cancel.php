<form method="post" action="<?= base_url('deposit/cancel/' . $target->id) ?>">
	<input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>"
		value="<?= $this->security->get_csrf_hash() ?>" />
	<div class="form-group mb-2">
		<label class="form-label">Password *</label>
		<input type="password" class="form-control" name="password">
	</div>
	<div class="hstack gap-1 justify-content-end">
		<button type="submit" class="btn btn-danger btn-sm round"><i
				class="fas fa-times-circle fs-6 me-2"></i>Batalkan</button>
	</div>
</form>
<script type="text/javascript">
	$('form').submit(function () {
		$(this).children('button[type=submit]').prop('disabled', true);
	});
</script>