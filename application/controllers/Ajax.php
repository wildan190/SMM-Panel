<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ajax extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
	}
	public function deposit_method_list($type = '', $category = '')
	{
		// filter input = 1
		if ($this->input->get($this->security->get_csrf_token_name()) <> $this->security->get_csrf_hash())
			exit("No direct script access allowed");
		if (in_array($type, ['auto', 'manual']) == false)
			exit("No direct script access allowed");
		if (in_array($category, ['bank', 'pulsa', 'other']) == false)
			exit("No direct script access allowed");
		header('Content-Type: application/json');
		$deposit_method = $this->deposit_method_model->get_rows(['where' => [['type' => $type, 'category' => $category, 'status' => '1']]]);
		if (count($deposit_method) < 1) {
			$result = ['msg' => '<option value="">Metode pembayaran tidak tersedia.</option>'];
		} else {
			$list = '<option value="">Pilih...</option>';
			foreach ($deposit_method as $key => $value) {
				$list .= '<option value="' . $value['id'] . '">' . $value['name'] . '</option>';
			}
			$result = ['msg' => $list];
		}
		exit(json_encode($result, JSON_PRETTY_PRINT));
	}
	public function deposit_method_detail($i = '')
	{
		// filter input = 1
		$i = $this->db->escape_str($i);
		if ($this->input->get($this->security->get_csrf_token_name()) <> $this->security->get_csrf_hash())
			exit("No direct script access allowed");
		header('Content-Type: application/json');
		$deposit_method = $this->deposit_method_model->get_row(['id' => $i, 'status' => '1']);
		if ($deposit_method == false) {
			$msg = [
				'min_deposit' => '0'
			];
		} else {
			$msg = [
				'min_deposit' => currency($deposit_method->min_deposit)
			];
		}
		$result = ['msg' => $msg];
		exit(json_encode($result, JSON_PRETTY_PRINT));
	}
	public function deposit_get_balance($i = '')
	{
		// filter input = 1
		$i = $this->db->escape_str($i);
		if ($this->input->get($this->security->get_csrf_token_name()) <> $this->security->get_csrf_hash())
			exit("No direct script access allowed");
		if (is_numeric($this->input->get('amount')) == false)
			exit("No direct script access allowed");
		header('Content-Type: application/json');
		$deposit_method = $this->deposit_method_model->get_by_id($i);
		if ($deposit_method == false) {
			$result = [
				'msg' => 0
			];
		} else {
			$result = [
				'msg' => currency(round($deposit_method->rate * $this->input->get('amount')))
			];
		}
		exit(json_encode($result, JSON_PRETTY_PRINT));
	}

	public function get_rate($i = '')
	{
		// filter input = 1
		$i = $this->db->escape_str($i);
		if ($this->input->get($this->security->get_csrf_token_name()) <> $this->security->get_csrf_hash())
			exit("No direct script access allowed");
		header('Content-Type: application/json');

		$result = [
			'msg' => currency(benefit('rate_payout', user('benefit')) * $i)
		];

		exit(json_encode($result, JSON_PRETTY_PRINT));
	}

	public function category_list($i = '')
	{
		// filter input = 1
		$i = $this->db->escape_str($i);

		if ($this->input->get($this->security->get_csrf_token_name()) <> $this->security->get_csrf_hash())
			exit("No direct script access allowed");
		header('Content-Type: application/json');
		if ($i <> '0') {
			$service = $this->service_category_model->get_rows(['where' => [['type_category' => $i]], 'order_by' => 'name ASC']);
		} else {
			$service = $this->service_category_model->get_rows(['order_by' => 'name ASC']);
		}
		if (count($service) < 1) {
			$result = ['msg' => '<option value="">Kategori tidak tersedia.</option>'];
		} else {
			$list = '<option value="">— ' . ($i == '0' ? 'Pilih Semua Kategori' : 'Pilih Kategori ' . $i) . ' —</option>';
			foreach ($service as $key => $value) {
				$list .= '<option value="' . $value['id'] . '"> ' . $value['name'] . '';
			}
			$result = ['msg' => $list];
		}
		exit(json_encode($result, JSON_PRETTY_PRINT));
	}

	public function service_list($i = '')
	{
		// filter input = 1
		$i = $this->db->escape_str($i);
		if ($this->input->get($this->security->get_csrf_token_name()) <> $this->security->get_csrf_hash())
			exit("No direct script access allowed");
		header('Content-Type: application/json');
		$service = $this->service_model->get_rows(['where' => [['service_category_id' => $i, 'status' => '1']], 'order_by' => 'price ASC']);
		if (count($service) < 1) {
			$result = ['msg' => '<option value="">Layanan tidak tersedia.</option>'];
		} else {
			$list = '<option value="">— Pilih Layanan —</option>';
			foreach ($service as $key => $value) {
				if ($value['refill'] == 1) {
					$refill = '♻️';
				} else {
					$refill = '';
				}
				$categories = $this->service_category_model->get_row(['id' => $i]);
				if ($categories->type_category == 'Instagram') {
					$icon = '<i class="fab fa-instagram"></i>';
				} else {
					$icon = '<i class="fa-solid fa-shuffle"></i>';
				}
				$list .= '<option value="' . $value['id'] . '">' . $value['id'] . ' — ' . $value['name'] . ' — Rp ' . number_format($value['price'], 0, ',', '.') . ' ' . $refill . '</option>';
			}
			$result = ['msg' => $list, 'cat' => $categories, 'icon' => $icon];
		}
		exit(json_encode($result, JSON_PRETTY_PRINT));
	}
	public function service_favorit_list($i = '')
	{
		// filter input = 1
		$i = $this->db->escape_str($i);
		if ($this->input->get($this->security->get_csrf_token_name()) <> $this->security->get_csrf_hash())
			exit("No direct script access allowed");
		header('Content-Type: application/json');
		$user = user();
		$service = $this->service_favorit_model->get_service_favorit(['category_id' => $i, 'user_id' => $user]);
		if (count($service) < 1) {
			$result = ['msg' => '<option value="">Layanan tidak tersedia.</option>'];
		} else {
			$list = '<option value="">— Pilih Layanan —</option>';
			foreach ($service as $key => $value) {
				if ($value['refill'] == 1) {
					$refill = '♻️';
				} else {
					$refill = '';
				}
				$categories = $this->service_category_model->get_row(['id' => $i]);
				if ($categories->type_category == 'Instagram') {
					$icon = '<i class="fab fa-instagram"></i>';
				} else {
					$icon = '<i class="fa-solid fa-shuffle"></i>';
				}
				$list .= '<option value="' . $value['service_id'] . '">' . $value['service_id'] . ' — ' . $value['service_name'] . ' — Rp ' . number_format($value['price'], 0, ',', '.') . ' ' . $refill . '</option>';
			}
			$result = ['msg' => $list, 'cat' => $categories, 'icon' => $icon];
		}
		exit(json_encode($result, JSON_PRETTY_PRINT));
	}
	public function service_pulsa_list($i = '')
	{
		// filter input = 1
		$i = $this->db->escape_str($i);
		if ($this->input->get($this->security->get_csrf_token_name()) <> $this->security->get_csrf_hash())
			exit("No direct script access allowed");
		header('Content-Type: application/json');
		$service = $this->service_pulsa_model->get_rows(['where' => [['service_category_id' => $i, 'status' => '1']]]);
		if (count($service) < 1) {
			$result = ['msg' => '<option value="">Layanan tidak tersedia.</option>'];
		} else {
			$list = '<option value="">Pilih...</option>';
			foreach ($service as $key => $value) {
				$list .= '<option value="' . $value['id'] . '"> ' . $value['id'] . ' - ' . $value['name'] . ' - Rp ' . number_format($value['price'], 0, ',', '.') . '</option>';
			}
			$result = ['msg' => $list];
		}
		exit(json_encode($result, JSON_PRETTY_PRINT));
	}
	public function service_detail($i = '')
	{
		// filter input = 1
		$i = $this->db->escape_str($i);
		if ($this->input->get($this->security->get_csrf_token_name()) <> $this->security->get_csrf_hash())
			exit("No direct script access allowed");
		header('Content-Type: application/json');
		$service = $this->service_model->get_row(['id' => $i, 'status' => '1']);
		if ($service == false) {
			$msg = [
				'type' => 0,
				'is_custom_price' => 0,
				'price' => 0,
				'min' => 0,
				'max' => 0,
				'description' => 'Deskripsi layanan.',
				'average_time' => 'Belum ada data',
				'refill' => 0,
				'rating' => '-',
			];
			$status = false;
		} else {
			$count_review = $this->service_rating_model->get_count(['where' => [['service_id' => $service->id]]]);
			$countFive = $this->service_rating_model->get_count(['where' => [['service_id' => $service->id, 'rating' => '5']]]);
			$countFour = $this->service_rating_model->get_count(['where' => [['service_id' => $service->id, 'rating' => '4']]]);
			$countThree = $this->service_rating_model->get_count(['where' => [['service_id' => $service->id, 'rating' => '3']]]);
			$countTwo  = $this->service_rating_model->get_count(['where' => [['service_id' => $service->id, 'rating' => '2']]]);
			$countOne = $this->service_rating_model->get_count(['where' => [['service_id' => $service->id, 'rating' => '1']]]);
			if ($count_review <> 0) {
				$calculateRating = $this->lib->calculateRating($countFive, $countFour, $countThree, $countTwo, $countOne);
			} else {
				$calculateRating = 0;
			}

			$bintang = ''; // Tambahkan inisialisasi variabel di sini
			$ratings = $this->service_rating_model->get_count(['where' => [['service_id' => $service->id]]]);
			if ($ratings <> 0) {
				for ($i = 1; $i <= 5; $i++) {
					if ($i <= $calculateRating) {
						$bintang .= '<i class="fas fa-star text-warning"></i>';
					} elseif ($i - 0.5 == $calculateRating) {
						$bintang .= '<i class="fas fa-star-half-alt text-warning"></i>';
					} elseif ($i > $calculateRating && $calculateRating > $i - 1) {
						$bintang .= '<i class="fas fa-star-half-alt text-warning"></i>';
					} else {
						$bintang .= '<i class="fas fa-star text-muted"></i>';
					}
				}

				$bintang .= ' (' . $calculateRating . '/5 dari ' . currency($count_review) . ' penilaian)';
			} else {
				$bintang = '<i class="fas fa-star text-muted"></i><i class="fas fa-star text-muted"></i><i class="fas fa-star text-muted"></i><i class="fas fa-star text-muted"></i><i class="fas fa-star text-muted"></i> (0/5 dari 0 penilaian)';
			}

			$custom_price = $this->custom_price_model->get_row(['service_id' => $service->id, 'user_id' => user()]);
			$description = nl2br($service->description);
			$category = $this->service_category_model->get_row(['id' => $service->service_category_id]);
			// Mendapatkan data favorit
			$check_favorite = $this->service_favorit_model->get_service_favorit(['category_id' => $service->service_category_id, 'user_id' => user()]);

			// Memeriksa apakah data favorit ditemukan
			if ($check_favorite) {
				// Jika ada, set $favorite ke 1
				$favorite = 1;
			} else {
				// Jika tidak ada, set $favorite ke 0
				$favorite = 0;
			}

			$msg = [
				'category' => $category->name,
				'id' => $service->id,
				'name' => $service->name,
				'type' => $service->type,
				'is_custom_price' => ($custom_price == false) ? '0' : '1',
				'refill' => $service->refill,
				'formatted_price' => ($custom_price == true ? currency($custom_price->amount) : currency($service->price)),
				'price' => ($custom_price == false) ? number_format($service->price, 0, ',', '.') : number_format($custom_price->price, 0, ',', '.'),
				'min' => number_format($service->min, 0, ',', '.'),
				'max' => number_format($service->max, 0, ',', '.'),
				'description' => $description,
				'average_time' => get_service_average($service->id),
				'rating' => $bintang,
				'favorite' => $favorite
			];
			$status = true;
		}
		$result = ['msg' => $msg, 'status' => $status];
		exit(json_encode($result, JSON_PRETTY_PRINT));
	}
	public function giverating()
	{
		// filter input = 1
		if ($this->input->post($this->security->get_csrf_token_name()) <> $this->security->get_csrf_hash()) exit("No direct script access allowed");
		header('Content-Type: application/json');
		if (user() == false) {
			$msg = [
				'status' => 0,
				'text' => 'Silahkan Masuk terlebih dahulu untuk memberikan Penilaian.'
			];
		} else {
			$service_rating = $this->service_rating_model->get_row(['user_id' => user(), 'service_id' => protect($this->input->post('service'))]);
			$check_order = $this->order_model->get_row(['user_id' => user(), 'service_id' => protect($this->input->post('service'))]);
			$check_service = $this->service_model->get_row(['id' => protect($this->input->post('service'))]);
			if ($service_rating == true) {
				$msg = [
					'status' => 0,
					'text' => 'Anda sudah melakukan penilaian untuk layanan ini.'
				];
			} elseif ($check_order == false) {
				$msg = [
					'status' => 0,
					'text' => 'Anda belum melakukan pemesanan untuk layanan ini.'
				];
			} elseif (protect($this->input->post('star')) > 5 && protect($this->input->post('star')) < 1) {
				$msg = [
					'status' => 0,
					'text' => 'What do you want?????????.'
				];
			} else {
				$data = [
					'user_id' => user(),
					'service_id' => $check_service->id,
					'rating' => protect($this->input->post('star')),
					'created_at' => date('Y-m-d H:i:s')
				];
				$this->service_rating_model->insert($data);
				$msg = [
					'status' => 1,
					'text' => 'Berhasil memberikan Penilaian.'
				];
			}
		}
		$result = $msg;
		exit(json_encode($result, JSON_PRETTY_PRINT));
	}
	public function service_price($i = '')
	{
		// filter input = 1
		$i = $this->db->escape_str($i);
		if ($this->input->get($this->security->get_csrf_token_name()) <> $this->security->get_csrf_hash())
			exit("No direct script access allowed");
		if (is_numeric($this->input->get('quantity')) == false)
			exit("No direct script access allowed");
		header('Content-Type: application/json');
		$service = $this->service_model->get_by_id($i);
		if ($service == false) {
			$result = [
				'msg' => 0
			];
		} else {
			$custom_price = $this->custom_price_model->get_row(['service_id' => $i, 'user_id' => user()]);
			if ($custom_price == true) {
				if ($service->max == '1') {
					$result = [
						'msg' => currency(round($custom_price->price))
					];
				} else {
					$result = [
						'msg' => currency(round(($custom_price->price / 1000) * $this->input->get('quantity')))
					];
				}
			} else {
				if ($service->max == '1') {
					$result = [
						'msg' => currency(round($service->price))
					];
				} else {
					$result = [
						'msg' => currency(round(($service->price / 1000) * $this->input->get('quantity')))
					];
				}
			}
		}
		exit(json_encode($result, JSON_PRETTY_PRINT));
	}
	public function service_price_mass($i = '')
	{
		// filter input = 1
		$i = $this->db->escape_str($i);
		if ($this->input->get($this->security->get_csrf_token_name()) <> $this->security->get_csrf_hash())
			exit("No direct script access allowed");
		header('Content-Type: application/json');

		$target = $this->input->get('target');

		// Memecah string menjadi array berdasarkan baris baru
		$values = explode("\n", $target);

		// Inisialisasi variabel total
		$total = 0;

		// Loop untuk mengakses setiap nilai
		foreach ($values as $value) {
			// Memecah string berdasarkan karakter "|"
			$split = explode('|', $value);

			// Mengambil semua nilai berupa angka dalam baris setelah karakter "|"
			$numericValues = array_slice($split, 1);

			// Menjumlahkan nilai berupa angka dalam baris
			$total += array_sum(array_map('intval', $numericValues));
		}

		// Menampilkan total
		$quantity = $total;

		$service = $this->service_model->get_by_id($i);
		if ($service == false) {
			$result = [
				'msg' => 0
			];
		} else {
			$custom_price = $this->custom_price_model->get_row(['service_id' => $i, 'user_id' => user()]);
			if ($custom_price == true) {
				if ($service->max == '1') {
					$result = [
						'msg' => currency(round($custom_price->price) * $quantity)
					];
				} else {
					$result = [
						'msg' => currency(round(($custom_price->price / 1000) * $quantity))
					];
				}
			} else {
				if ($service->max == '1') {
					$result = [
						'msg' => currency(round($service->price) * $quantity)
					];
				} else {
					$result = [
						'msg' => currency(round(($service->price / 1000) * $quantity))
					];
				}
			}
		}
		exit(json_encode($result, JSON_PRETTY_PRINT));
	}


	/// BAGIAN PULSA ///

	public function service_pulsa_detail($i = '')
	{
		// filter input = 1
		$i = $this->db->escape_str($i);
		if ($this->input->get($this->security->get_csrf_token_name()) <> $this->security->get_csrf_hash())
			exit("No direct script access allowed");
		header('Content-Type: application/json');
		$service = $this->service_pulsa_model->get_row(['id' => $i, 'status' => '1']);
		if ($service == false) {
			$msg = [
				'type' => 0,
				'is_custom_price' => 0,
				'price' => 0,
				'description' => 'Deskripsi layanan.',
			];
		} else {
			$custom_price = $this->custom_price_model->get_row(['service_id' => $i, 'user_id' => user()]);
			$description = str_replace('\r\nd', '', $service->description);
			//$description = str_replace('\\r\\n', '', $description);
			//$description = str_replace('<br>', '', $description);
			$msg = [
				'type' => $service->type,
				'is_custom_price' => '0',
				'price' => number_format($service->price, 0, ',', '.'),
				//'description' => nl2br($service->description),
				'description' => $description
			];
		}
		$result = ['msg' => $msg];
		exit(json_encode($result, JSON_PRETTY_PRINT));
	}


	public function order_pulsa_reguler($i = '')
	{
		// filter input = 1
		if ($this->input->get($this->security->get_csrf_token_name()) <> $this->security->get_csrf_hash())
			exit("No direct script access allowed");
		header('Content-Type: application/json');
		$type = $this->db->escape_str($this->input->get('type'));

		$category = $this->service_category_model->get_row(['name' => $i, 'type' => $type]);
		if ($category == false) {
			print('<option value="">Provider tidak dikenal...</option>');
		} else {
			$service = $this->service_pulsa_model->get_rows(['where' => [['service_category_id' => $category->id, 'status' => '1']]]);
			//print_r($service); die;

			if ($service == false) {
				print('<option value="">Layanan kosong...</option>');
			} else {
				print('<option value="">-- Pilih Layanan --</option>');
				foreach ($service as $key => $value) {
					print('<option value="' . $value['id'] . '"> ' . $value['id'] . ' - ' . $value['name'] . ' - Rp ' . number_format($value['price'], 0, ',', '.') . '</option>');
				}
			}
		}
	}
	public function fav_service()
	{
		if ($this->input->post($this->security->get_csrf_token_name()) <> $this->security->get_csrf_hash())
			exit("No direct script access allowed");

		$service_id = protect($this->input->post('id'));
		$user_id = user();

		if (!$user_id) {
			exit(json_encode(['result' => false, 'msg' => 'Anda harus Masuk terlebih dahulu.']));
		}

		$check_favorit = $this->service_favorit_model->get_row(['user_id' => $user_id, 'service_id' => $service_id]);
		$check_service = $this->service_model->get_row(['id' => $service_id]);

		if (!$check_service) {
			exit(json_encode(['result' => false, 'msg' => 'Layanan tidak ditemukan.']));
		}

		if ($check_favorit) {
			exit(json_encode(['result' => false, 'msg' => 'Layanan ini sudah ditambahkan ke Favorit sebelumnya.']));
		} else {
			$data = [
				'category_id' => $check_service->service_category_id,
				'service_id' => $check_service->id,
				'user_id' => $user_id,
				'created_at' => date('Y-m-d H:i:s')
			];

			$insert = $this->service_favorit_model->insert($data);

			if (!$insert) {
				exit(json_encode(['result' => false, 'msg' => 'Layanan gagal ditambahkan ke Favorit.']));
			} else {
				exit(json_encode(['result' => true, 'msg' => 'Layanan berhasil ditambahkan ke Favorit.']));
			}
		}
	}

	public function unfav_service()
	{
		if ($this->input->post($this->security->get_csrf_token_name()) <> $this->security->get_csrf_hash())
			exit("No direct script access allowed");

		$service_id = protect($this->input->post('id'));
		$user_id = user();

		if (!$user_id) {
			exit(json_encode(['result' => false, 'msg' => 'Anda harus Masuk terlebih dahulu.']));
		}

		$check_service = $this->service_model->get_row(['id' => $service_id]);
		if (!$check_service) {
			exit(json_encode(['result' => false, 'msg' => 'Layanan tidak ditemukan.']));
		}

		$check_favorit = $this->service_favorit_model->get_row(['user_id' => $user_id, 'service_id' => $service_id]);

		if ($check_favorit !== null) {
			$this->service_favorit_model->delete(['id' => $check_favorit->id]);
			exit(json_encode(['result' => true, 'msg' => 'Layanan berhasil dihapus dari Favorit.']));
		} else {
			exit(json_encode(['result' => false, 'msg' => 'Layanan ini tidak ada di Favorit.']));
		}
	}
	public function crop()
	{
		// if ($this->input->post($this->security->get_csrf_token_name()) !== $this->security->get_csrf_hash()) {
		// 	exit(json_encode(array('status' => 'error', 'message' => 'Tidak diizinkan akses langsung ke skrip ini')));
		// }

		// Ambil data post dari tampilan views
		$tw = round($this->input->post('tw'));
		$th = round($this->input->post('th'));
		$x = round($this->input->post('x'));
		$y = round($this->input->post('y'));

		// Path file gambar yang akan di-crop
		$sourceImagePath = FCPATH . '/uploads/profil/' . user('foto');

		// Path untuk menyimpan gambar hasil crop
		$cropPath = FCPATH . '/uploads/profil/';

		// Nama file hasil crop
		$file_name = user('username') . '_' . time() . '.png';

		// Konfigurasi library Crop CodeIgniter
		$config['image_library'] = 'gd2'; // Gunakan GD Library untuk crop, sesuaikan dengan library yang tersedia di server Anda
		$config['source_image'] = $sourceImagePath;
		$config['new_image'] = $cropPath . $file_name;
		$config['maintain_ratio'] = false;
		$config['width'] = $tw; // Ambil nilai width dari data yang di-post
		$config['height'] = $th; // Ambil nilai height dari data yang di-post
		$config['x_axis'] = $x; // Ambil nilai x dari data yang di-post
		$config['y_axis'] = $y; // Ambil nilai y dari data yang di-post

		$this->load->library('image_lib', $config);

		// Lakukan crop menggunakan library CodeIgniter
		if (!$this->image_lib->crop()) {
			// Jika ada kesalahan dalam proses cropping
			$response = array(
				'status' => 'error',
				'message' => 'Gagal memotong gambar: ' . $this->image_lib->display_errors()
			);
		} else {
			// Hapus gambar asli yang diunggah
			unlink($sourceImagePath);

			// Perbarui database dengan referensi nama file yang baru
			$update_user = $this->user_model->update(['foto' => $file_name, 'crop_foto' => '1'], ['id' => user('id')]);

			if ($update_user) {
				$response = array(
					'status' => 'success',
					'message' => 'Gambar berhasil di-crop dan disimpan.'
				);
			} else {
				// Jika gagal memperbarui database
				unlink($cropPath . $file_name); // Hapus gambar hasil crop yang sudah disimpan
				$response = array(
					'status' => 'error',
					'message' => 'Gagal memperbarui data foto.'
				);
			}
		}

		// Keluar dengan respons dalam format JSON
		exit(json_encode($response));
	}
}
