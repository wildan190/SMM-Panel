<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ticket extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		if (website_config('mt_web') == 1) {
			exit(redirect(base_url('maintenance')));
		}
		check_cookie(get_cookie('smm_login'));
		if (user() == false)
			exit(redirect(base_url('auth/logout')));
	}
	public function index()
	{
		// filter input = 1
		// FORM INPUT //
		$rows = [
			'10' => '10',
			'25' => '25',
			'50' => '50',
			'100' => '100',
		];
		$status = [
			'Waiting' => 'Waiting',
			'User Reply' => 'User Reply',
			'Responded' => 'Responded',
			'Closed' => 'Closed',
		];
		// END FORM INPUT //
		// SETTINGS //
		$data_query = [
			'select' => '*',
			'where' => [['user_id' => user()]],
			'order_by' => 'id DESC',
			'limit' => '10',
			'offset' => ($this->uri->segment(3)) ? $this->uri->segment(3) : 0
		];
		// END SETTINGS //
		// SORT & SEARCH
		if ($this->input->get('rows')) {
			if (array_key_exists($this->input->get('rows'), $rows) == false)
				exit(redirect(base_url('ticket/history')));
			$data_query['limit'] = $this->input->get('rows');
		}

		if ($this->input->get('status') <> '') {
			if (array_key_exists($this->input->get('status'), $status) == false)
				exit(redirect(base_url('ticket/history')));
			$data_query['where'][]['status'] = $this->input->get('status');
		}
		if ($this->input->get('search') <> '') {
			$data_query['where'][] = "id LIKE '%" . $this->db->escape_str(strip_tags($this->input->get('search'))) . "%'";
		}
		// END SORT & SEARCH
		// PAGINATION //
		if ($this->uri->segment(3) <> '' and is_numeric($this->uri->segment(3)) == false)
			exit('shafou.com');
		$config['base_url'] = base_url('ticket/index');
		$config['total_rows'] = $this->ticket_model->get_count($data_query);
		$config['per_page'] = $data_query['limit'];
		$config['awal'] = $data_query['offset'] + 1;
		$config['akhir'] = $data_query['offset'] + $data_query['limit'];
		$this->pagination->initialize($config);
		// END PAGINATION //
		$this->render('public/ticket/index', ['page_type' => 'Data Tiket', 'table' => $this->ticket_model->get_rows($data_query), 'total_data' => $config['total_rows'], 'awal' => $config['awal'], 'akhir' => $config['akhir'], 'rows' => $rows, 'status' => $status]);
	}
	public function new()
	{
		// filter input = 1
		if ($this->input->post()) {
			$this->form_validation->set_rules('subject', 'Subjek', 'required|min_length[1]|max_length[50]');
			$this->form_validation->set_rules('msg', 'Pesan', 'required|min_length[1]|max_length[255]');
			if ($this->form_validation->run() == true) {
				if ($this->ticket_model->get_count(['where' => [['user_id' => user()], "status IN ('Waiting')"]]) >= 5) {
					$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Masih ada 5 tiket dengan status waiting.'));
					exit(redirect(base_url('ticket/new')));
				}
				$data_input = [
					'user_id' => user(),
					'subject' => $this->db->escape_str($this->input->post('subject')),
					'type' => $this->db->escape_str($this->input->post('type')),
					'status' => 'Waiting',
					'is_read_user' => '1',
					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s'),
				];
				$insert_ticket = $this->ticket_model->insert($data_input);
				if ($insert_ticket) {
					$this->ticket_reply_model->insert([
						'ticket_id' => $insert_ticket,
						'sender' => 'user',
						'msg' => $this->db->escape_str(strip_tags($this->input->post('msg'))),
						'created_at' => date('Y-m-d H:i:s'),
					]);
					$this->session->set_flashdata('result', array('alert' => 'success', 'title' => 'Tiket berhasil dikirim!', 'msg' => 'Mohon menunggu balasan Admin.'));
					exit(redirect(base_url('ticket')));
				} else {
					$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Kesalahan tidak terduga.'));
					exit(redirect(base_url('ticket/new')));
				}
			} else {
				$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => '<br />' . validation_errors()));
				exit(redirect(base_url('ticket/new')));
			}
		}
		$this->render('public/ticket/new', ['page_type' => 'Tiket Baru']);
	}
	public function reply($i = '', $csrf = '')
	{
		// filter input = 1
		if ($csrf <> $this->security->get_csrf_hash())
			exit(show_404());
		$i = addslashes(strip_tags(htmlspecialchars($this->db->escape_str($i))));
		$target = $this->ticket_model->get_row(['user_id' => user(), 'id' => $i]);
		if ($target == false)
			show_404();
		$this->ticket_model->update(['is_read_user' => '1'], ['id' => $i]);
		if ($this->input->post()) {
			$this->form_validation->set_rules('msg', 'Pesan', 'required');
			if ($target->status == 'Closed') {
				$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Tiket sudah ditutup.'));
				exit(redirect(base_url('ticket/reply/' . $i . '/' . $this->security->get_csrf_hash())));
			}
			if ($this->form_validation->run() == true) {
				$data_input = [
					'ticket_id' => $i,
					'sender' => 'user',
					'msg' => $this->db->escape_str(strip_tags($this->input->post('msg'))),
					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s'),
				];
				$insert_reply = $this->ticket_reply_model->insert($data_input);
				if ($insert_reply) {
					$this->ticket_model->update(['is_read_admin' => '0', 'status' => 'User Reply', 'updated_at' => date('Y-m-d H:i:s')], ['id' => $i]);
					$this->session->set_flashdata('result', array('alert' => 'success', 'title' => 'Balasan berhasil dikirim!', 'msg' => 'Mohon menunggu balasan Admin.'));
					exit(redirect(base_url('ticket/reply/' . $i . '/' . $this->security->get_csrf_hash())));
				} else {
					$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Kesalahan tidak terduga.'));
					exit(redirect(base_url('ticket/reply/' . $i . '/' . $this->security->get_csrf_hash())));
				}
			} else {
				$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => '<br />' . validation_errors()));
			}
		}
		$this->render('public/ticket/reply', ['page_type' => 'Balas Tiket', 'target' => $target, 'ticket_reply' => $this->ticket_reply_model->get_rows(['where' => [['ticket_id' => $i]]])]);
	}
	public function edit($i = '')
	{
		$target = $this->ticket_reply_model->get_by_id($i);

		if ($target == false) {
			show_404();
			return;
		}

		$created_at = strtotime($target->created_at);
		$limiter_time = strtotime('-5 minutes');

		// if ($created_at < $limiter_time) {
		// 	// Edit tidak diizinkan jika created_at lebih dari 5 menit yang lalu
		// 	$this->sendJsonResponse(['alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Waktu untuk mengedit tiket telah berakhir.'], $target);
		// 	return;
		// }

		// Melanjutkan dengan proses edit jika masih dalam batas waktu
		if ($this->input->post()) {
			$this->form_validation->set_rules('content', 'Pesan', 'required');
			$data_input = [
				'msg' => $this->db->escape_str(strip_tags($this->input->post('content'))),
				'updated_at' => date('Y-m-d H:i:s')
			];

			if ($created_at < $limiter_time) {
				// Edit tidak diizinkan jika created_at lebih dari 5 menit yang lalu
				$this->sendJsonResponse(['alert' => 'danger', 'title' => 'Gagal!', 'msg' => '<br />Waktu untuk mengedit Pesan telah berakhir.'], $target);
				return;
			}

			if ($this->form_validation->run() == false) {
				$this->sendJsonResponse(['alert' => 'danger', 'title' => 'Gagal!', 'msg' => '<br />' . validation_errors()], $target);
			} else {
				$update_target = $this->ticket_reply_model->update($data_input, ['id' => $target->id]);

				if ($update_target) {
					$this->sendJsonResponse(['alert' => 'success', 'title' => 'Berhasil!', 'msg' => '<br />Pesan telah diperbaharui.'], $target);
				} else {
					$this->sendJsonResponse(['alert' => 'danger', 'title' => 'Gagal!', 'msg' => '<br />Tidak ada perubahan data.'], $target);
				}
			}

			return; // Tidak perlu redirect atau exit
		}

		$this->load->view('public/ticket/edit', ['target' => $target]);
	}

	// Fungsi untuk mengirim respons JSON
	private function sendJsonResponse($result, $target)
	{
		$response['result'] = $result;
		$response['target'] = $target;
		echo json_encode($response);
	}
	public function delete($i = '', $csrf = '')
	{
		if ($csrf <> $this->security->get_csrf_hash())
			exit(show_404());
		$target = $this->ticket_reply_model->get_by_id($i);
		if ($target == false) show_404();

		$created_at = strtotime($target->created_at);
		$limiter_time = strtotime('-5 minutes');
		if ($created_at < $limiter_time) {
			$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Waktu untuk menghapus Pesan telah berakhir.'));
			exit(redirect(base_url('ticket/reply/' . $target->ticket_id . '/' . $csrf)));
		}
		$delete_target = $this->ticket_reply_model->delete(['id' => $i]);
		if ($delete_target) {
			$this->session->set_flashdata('result', array('alert' => 'success', 'title' => 'Yeay!', 'msg' => 'Pesan berhasil dihapus.'));
		} else {
			$this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Kesalahan tidak terduga.'));
		}
		redirect(base_url('ticket/reply/' . $target->ticket_id . '/' . $csrf));
	}
}
