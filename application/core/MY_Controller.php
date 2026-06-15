<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
	function update_category()
	{
		$check_category = $this->service_category_model->get_rows(['where' => [['type' => 'SM']]]);
		foreach ($check_category as $key => $value) {
			$category = $value['name'];
			$type = null;
			if ($this->lib->pregmatch('Threads', $category)) {
				$type = 'Threads';
			} elseif ($this->lib->pregmatch('Facebook', $category)) {
				$type = 'Facebook';
			} elseif ($this->lib->pregmatch('Twitter', $category)) {
				$type = 'Twitter';
			} elseif ($this->lib->pregmatch('Youtube', $category)) {
				$type = 'Youtube';
			} elseif ($this->lib->pregmatch('Spotify', $category)) {
				$type = 'Spotify';
			} elseif ($this->lib->pregmatch('Telegram', $category)) {
				$type = 'Telegram';
			} elseif ($this->lib->pregmatch('Website', $category)) {
				$type = 'Website';
			} elseif ($this->lib->pregmatch('Web', $category)) {
				$type = 'Website';
			} elseif ($this->lib->pregmatch('Tiktok', $category)) {
				$type = 'Tiktok';
			} elseif ($this->lib->pregmatch('Tik Tok', $category)) {
				$type = 'Tiktok';
			} elseif ($this->lib->pregmatch('Reviews', $category)) {
				$type = 'Reviews';
			} elseif ($this->lib->pregmatch('Linkedin', $category)) {
				$type = 'Linkedin';
			} elseif ($this->lib->pregmatch('Snapchat', $category)) {
				$type = 'Snapchat';
			} elseif ($this->lib->pregmatch('SoundCloud', $category)) {
				$type = 'SoundCloud';
			} elseif ($this->lib->pregmatch('Twitter', $category)) {
				$type = 'Twitter';
			} elseif ($this->lib->pregmatch('Google', $category)) {
				$type = 'Google';
			} elseif ($this->lib->pregmatch('Twitch', $category)) {
				$type = 'Twitch';
			} elseif ($this->lib->pregmatch('Instagram', $category)) {
				$type = 'Instagram';
			} elseif ($this->lib->pregmatch('Promo', $category)) {
				$type = 'Promo';
			} else {
				$type = 'Other';
			}

			$this->service_category_model->update(['type_category' => $type], ['id' => $value['id']]);
		}
	}
	function render($content, $data = null)
	{
		if (user() == true)
			$data['unread_ticket'] = $this->ticket_model->get_count(['where' => [['user_id' => user(), 'is_read_user' => '0']]]);
		$data_query = [
			'select' => 'order_list.*, service.name AS service_name',
			'join' => [
				[
					'table' => 'service',
					'on' => 'service.id = order_list.service_id',
					'param' => 'LEFT'
				]
			],
			'where' => [['user_id' => user()]],
			'order_by' => 'order_list.id DESC',
			'limit' => '5',
		];
		$data['orders'] = $this->order_model->get_rows($data_query);
		$data['page'] = $this->page_model->get_rows();
		$data['info_popup'] = $this->info_model->get_rows(['where' => [['is_popup' => '1']], 'order_by' => 'id DESC', 'limit' => '5']);
		$data['config'] = $this->config->item('web');
		$data['content'] = $this->load->view($content, $data, true);
		$this->load->view('public/main', $data);
	}
	function render_auth($content, $data = null)
	{
		$data['config'] = $this->config->item('web');
		$data['content'] = $this->load->view($content, $data, true);
		$this->load->view('public/auth_view', $data);
	}
	function render_login($content, $data = null)
	{
		$data['config'] = $this->config->item('web');
		$data['content'] = $this->load->view($content, $data, true);
		$this->load->view('public/auth_login', $data);
	}
	function render_register($content, $data = null)
	{
		$data['config'] = $this->config->item('web');
		$data['content'] = $this->load->view($content, $data, true);
		$this->load->view('public/auth_register', $data);
	}
	function render_forgot($content, $data = null)
	{
		$data['config'] = $this->config->item('web');
		$data['content'] = $this->load->view($content, $data, true);
		$this->load->view('public/auth_forgot', $data);
	}
	function render_admin($content, $data = null)
	{
		$data['unread_ticket'] = $this->ticket_model->get_count(['where' => [['is_read_admin' => '0']]]);
		$data['depo_pending'] = $this->deposit_model->get_count(['where' => [['status' => 'Pending']]]);
		$data['config'] = $this->config->item('web');
		$data['content'] = $this->load->view($content, $data, true);
		$this->load->view('admin/main_tes', $data);
	}
}
