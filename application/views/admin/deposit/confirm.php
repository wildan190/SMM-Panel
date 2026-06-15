<div class="hstack gap-1 justify-content-center w-100">
	<a href="<?= base_url('admin/'.$this->uri->segment(2).'/confirm/'.$target->id) ?>/Success" class="btn btn-success w-100">Terima</a>
	<a href="<?= base_url('admin/'.$this->uri->segment(2).'/confirm/'.$target->id) ?>/Canceled" class="btn btn-danger w-100">Tolak</a>
</div>