<style>
	.Pending {
		color: #e58a00;
		border: 0.25rem solid #e58a00;
		font-size: 1.5rem;
		font-weight: 700;
		display: inline-block;
		padding: 0.25rem 0.50rem 0.05rem 0.50rem;
		text-transform: uppercase;
		border-radius: 1rem;
		font-family: 'Courier';
	}

	.Success {
		color: #4BA56E;
		border: 0.25rem solid #4BA56E;
		font-size: 1.5rem;
		font-weight: 700;
		display: inline-block;
		padding: 0.25rem 0.50rem 0.05rem 0.50rem;
		text-transform: uppercase;
		border-radius: 1rem;
		font-family: 'Courier';
	}

	.Canceled {
		color: #F64D35;
		border: 0.15rem solid #F64D35;
		font-size: 1.5rem;
		font-weight: 700;
		display: inline-block;
		padding: 0.25rem 0.50rem 0.05rem 0.50rem;
		text-transform: uppercase;
		border-radius: 1rem;
		font-family: 'Courier';
	}
</style>
<div class="row">
	<div class="col-md-6">
		<strong>Domain</strong>
	</div>
	<div class="col-md-6 mb-2">
		<input type="text" class="form-control" value="<?= $target->domain ?>" disabled>
	</div>
	<div class="col-md-6">
		<strong>Status</strong>
	</div>
	<div class="col-md-6 mb-2">
		<input type="text" class="form-control" value="<?= $target->status ?>" disabled>
	</div>
</div>