<?php
if ($this->input->post()) {
	$this->load->view('admin/'.$this->uri->segment(2).'/result', ['result' => $this->input->post('access')]);
}
?>
<form method="post">
	<input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
    <p><input type="checkbox" name="access[admin]" value="1" />Admin</p>
    <p><input type="checkbox" name="access[user]" value="1" />User</p>
    <p><input type="checkbox" name="access[order]" value="1" />Order</p>
    <p><input type="checkbox" name="access[deposit]" value="1" />Deposit</p>
    <p><input type="checkbox" name="access[service]" value="1" />Layanan</p>
    <p><input type="submit" name="submit" class="btn btn-info" value="Submit" /></p>
</form>