<?php 
/**
 * 
 */
class Backup extends MY_Controller
{
	
	function __construct(){
		parent::__construct();
	}

	public function user(){
		$api = json_decode(file_get_contents('https://backup.ivmediashop.com/user.php'), true);
		foreach ($api['data'] as $key => $value) {
		    $value['role'] = str_replace('Developers', 'Owner', $value['role']);
		    $data_input = [
		        'id' => $value['id'],
				'username' => htmlentities($this->db->escape_str(strip_tags($value['username']))),
				'password' => $value['password'],
				'full_name' => $value['name'],
				'email' => (isset($value['email']) ? $value['email'] : 'email@kosong.com'),
				'level' => $value['role'],
				'balance' => $value['balance'],
				'pin' => '0',
				'status' => '0', // 1 ON 0 OFF
				'api_key' => $this->lib->generate_api_key(),
				'verification_key' => random_string('alnum', 200),
				'is_verif' => '1',
				'created_at' => $value['created_at']
			];
			$insert_data = $this->user_model->insert($data_input);
			if ($insert_data) {
				echo $insert_data . 'username: ' . $value['username'] . '</br>';
			} else {
				echo 'error';
			}
		}
	}
	public function category() {	
		$api = json_decode(file_get_contents('https://dolanansosmed.com/back-category'), true);
		foreach ($api['data'] as $key => $value) {
		    $data_input = [
		    	'id' => $value['id'],
				'name' => $value['name']
			];
			$insert_data = $this->service_category_model->insert($data_input);
			if ($insert_data) {
				echo $insert_data . 'Name: ' . $value['name'];
			} else {
				echo 'error';
			}
		}
	}
    public function deposit() {    
        $api = json_decode(file_get_contents('https://backup.ivmediashop.com/deposit.php'), true);
        foreach ($api['data'] as $key => $value) {
            $data_input = [
                'user_id' => $value['user_id'],
                'deposit_method_id' => '3', 
                'amount' => $value['amount'],
                'balance' => $value['quantity'],
                'status' => $value['status'],
                'created_at' => $value['created_at'],
                'updated_at' => $value['updated_at'],
            ];
            $insert_data = $this->deposit_model->insert($data_input);
            if ($insert_data) {
                echo 'success <br/>';
            } else {
                echo 'error <br/>';
            }
        }
    }
    public function req_balance() {    
        $api = json_decode(file_get_contents('https://backup.ivmediashop.com/req_balance.php'), true);
        foreach ($api['data'] as $key => $value) {
            $user = $this->db->get_where('user', ['username' => $value['username']])->row_array();
			//$api = $this->db->get_where('api', ['id' => $value['provider_id']])->row_array();
			//$service = $this->db->get_where('service', ['name' => $this->db->escape_str($value['layanan'])])->row_array();
			$deposit = $this->db->get_where('deposit', ['deposit_code' => $this->db->escape_str($value['kode'])])->num_rows();
			if ($deposit > 0) {
				echo '<b><font color="red">Data sudah ada </font></b><br/>';
			} else {
                $data_input = [
                    'deposit_code' => $value['kode'],
                    'user_id' => (isset($user['id']) ? $user['id'] : 0),
                    'deposit_method_id' => '3', 
                    'amount' => $value['quantity'],
                    'balance' => $value['quantity'],
                    'status' => ucfirst($value['status']),
                    'created_at' => $value['created_at'],
                    'updated_at' => $value['updated_at'],
                ];
                $insert_data = $this->deposit_model->insert($data_input);
                if ($insert_data) {
                    echo 'success <br/>';
                } else {
                    echo 'error <br/>';
                }
			}
        }
    }
	public function order(){
		$api = json_decode(file_get_contents('https://backup.ivmediashop.com/order.php'), true);
		foreach ($api['data'] as $key => $value) {
			$user = $this->db->get_where('user', ['username' => $value['user']])->row_array();
			//$api = $this->db->get_where('api', ['id' => $value['provider_id']])->row_array();
			//$service = $this->db->get_where('service', ['name' => $this->db->escape_str($value['layanan'])])->row_array();
			$check_order = $this->db->get_where('order_list', ['api_order_id' => $this->db->escape_str($value['poid']), 'provider' => $value['provider']])->num_rows();
			if ($check_order > 0) {
				echo '<b><font color="red">Data sudah ada </font></b><br/>';
			} else {
            //$created_at = $value['date'] . ' ';
			//$created_at .= $value['time'];
		    $data_input = [
					'user_id' => (isset($user['id']) ? $user['id'] : 0),
					'service_id' => NULL,
					'service' => $value['service'],
					'target' =>  htmlentities($this->db->escape_str(strip_tags($value['link']))),
					'quantity' => $value['quantity'],
					'price' => $value['price'], // reset
					'profit' => 0, // reset
					'status' => $value['status'],
					'is_api' =>  ($value['place_form'] <> 'WEB') ? '1' : '0' ,
					'is_refund' => $value['refund'],
					'api_id' => '1', // reset
					'provider' => $value['provider'], // reset
					'api_order_id' => $value['poid'], // reset
					'created_at' => $value['created_at'],
					'updated_at' => $value['updated_at'],
					'remains' => $value['remains'],
					'start_count' => $value['start_count']
				];
				$insert_data = $this->order_model->insert($data_input);
				if ($insert_data) {
					echo $insert_data . ' <b><font color="green">Berhasil '.$value['provider'].' | '.$value['poid'].'</font></b></br>';
				} else {
					echo 'error';
				}
			}
        }
    }
	public function order1(){
	    error_reporting(0);
		$api = json_decode(file_get_contents('https://backup.ivmediashop.com/order1.php'), true);
		foreach (@$api['data'] as $key => $value) {
			$user = $this->db->get_where('user', ['username' => $value['user']])->row_array();
			//$api = $this->db->get_where('api', ['id' => $value['provider_id']])->row_array();
			//$service = $this->db->get_where('service', ['name' => $this->db->escape_str($value['layanan'])])->row_array();
			$check_order = $this->db->get_where('order_list', ['api_order_id' => $this->db->escape_str($value['poid']), 'provider' => $value['provider']])->num_rows();
			if ($check_order > 0) {
				echo '<b><font color="red">Data sudah ada </font></b><br/>';
			} else {
            //$created_at = $value['date'] . ' ';
			//$created_at .= $value['time'];
		    $data_input = [
					'user_id' => (isset($user['id']) ? $user['id'] : 0),
					'service_id' => NULL,
					'service' => $value['service'],
					'target' =>  htmlentities($this->db->escape_str(strip_tags($value['link']))),
					'quantity' => $value['quantity'],
					'price' => $value['price'], // reset
					'profit' => 0, // reset
					'status' => $value['status'],
					'is_api' =>  ($value['place_form'] <> 'WEB') ? '1' : '0' ,
					'is_refund' => $value['refund'],
					'api_id' => '1', // reset
					'provider' => $value['provider'], // reset
					'api_order_id' => $value['poid'], // reset
					'created_at' => $value['created_at'],
					'updated_at' => $value['updated_at'],
					'remains' => $value['remains'],
					'start_count' => $value['start_count']
				];
			$insert_data = $this->order_model->insert($data_input);
			if ($insert_data) {
				echo $insert_data . ' <b><font color="green">Berhasil '.$value['provider'].' | '.$value['poid'].'</font></b></br>';
			} else {
				echo 'error';
			}
			}
        }
    }
	public function order2(){
		$api = json_decode(file_get_contents('https://backup.ivmediashop.com/order2.php'), true);
		foreach ($api['data'] as $key => $value) {
			$user = $this->db->get_where('user', ['username' => $value['user']])->row_array();
			//$api = $this->db->get_where('api', ['id' => $value['provider_id']])->row_array();
			//$service = $this->db->get_where('service', ['name' => $this->db->escape_str($value['layanan'])])->row_array();
			$check_order = $this->db->get_where('order_list', ['api_order_id' => $this->db->escape_str($value['poid']), 'provider' => $value['provider']])->num_rows();
			if ($check_order > 0) {
				echo '<b><font color="red">Data sudah ada </font></b><br/>';
			} else {
            //$created_at = $value['date'] . ' ';
			//$created_at .= $value['time'];
		    $data_input = [
					'user_id' => (isset($user['id']) ? $user['id'] : 0),
					'service_id' => NULL,
					'service' => $value['service'],
					'target' =>  htmlentities($this->db->escape_str(strip_tags($value['link']))),
					'quantity' => $value['quantity'],
					'price' => $value['price'], // reset
					'profit' => 0, // reset
					'status' => $value['status'],
					'is_api' =>  ($value['place_form'] <> 'WEB') ? '1' : '0' ,
					'is_refund' => $value['refund'],
					'api_id' => '1', // reset
					'provider' => $value['provider'], // reset
					'api_order_id' => $value['poid'], // reset
					'created_at' => $value['created_at'],
					'updated_at' => $value['updated_at'],
					'remains' => $value['remains'],
					'start_count' => $value['start_count']
				];
			$insert_data = $this->order_model->insert($data_input);
			if ($insert_data) {
				echo $insert_data . ' <b><font color="green">Berhasil '.$value['provider'].' | '.$value['poid'].'</font></b></br>';
			} else {
				echo 'error';
			}
			}
        }
    }
	public function order3(){
		$api = json_decode(file_get_contents('https://backup.ivmediashop.com/order3.php'), true);
		foreach ($api['data'] as $key => $value) {
			$user = $this->db->get_where('user', ['username' => $value['user']])->row_array();
			//$api = $this->db->get_where('api', ['id' => $value['provider_id']])->row_array();
			//$service = $this->db->get_where('service', ['name' => $this->db->escape_str($value['layanan'])])->row_array();
			$check_order = $this->db->get_where('order_list', ['api_order_id' => $this->db->escape_str($value['poid']), 'provider' => $value['provider']])->num_rows();
			if ($check_order > 0) {
				echo '<b><font color="red">Data sudah ada </font></b><br/>';
			} else {
            //$created_at = $value['date'] . ' ';
			//$created_at .= $value['time'];
		    $data_input = [
					'user_id' => (isset($user['id']) ? $user['id'] : 0),
					'service_id' => NULL,
					'service' => $value['service'],
					'target' =>  htmlentities($this->db->escape_str(strip_tags($value['link']))),
					'quantity' => $value['quantity'],
					'price' => $value['price'], // reset
					'profit' => 0, // reset
					'status' => $value['status'],
					'is_api' =>  ($value['place_form'] <> 'WEB') ? '1' : '0' ,
					'is_refund' => $value['refund'],
					'api_id' => '1', // reset
					'provider' => $value['provider'], // reset
					'api_order_id' => $value['poid'], // reset
					'created_at' => $value['created_at'],
					'updated_at' => $value['updated_at'],
					'remains' => $value['remains'],
					'start_count' => $value['start_count']
				];
			$insert_data = $this->order_model->insert($data_input);
			if ($insert_data) {
				echo $insert_data . ' <b><font color="green">Berhasil '.$value['provider'].' | '.$value['poid'].'</font></b></br>';
			} else {
				echo 'error';
			}
			}
        }
    }
	public function order4(){
		$api = json_decode(file_get_contents('https://backup.ivmediashop.com/order3.php'), true);
		foreach ($api['data'] as $key => $value) {
			$user = $this->db->get_where('user', ['username' => $value['user']])->row_array();
			//$api = $this->db->get_where('api', ['id' => $value['provider_id']])->row_array();
			//$service = $this->db->get_where('service', ['name' => $this->db->escape_str($value['layanan'])])->row_array();
			$check_order = $this->db->get_where('order_list', ['api_order_id' => $this->db->escape_str($value['poid']), 'provider' => $value['provider']])->num_rows();
			if ($check_order > 0) {
				echo '<b><font color="red">Data sudah ada </font></b><br/>';
			} else {
            //$created_at = $value['date'] . ' ';
			//$created_at .= $value['time'];
		    $data_input = [
					'user_id' => (isset($user['id']) ? $user['id'] : 0),
					'service_id' => NULL,
					'service' => $value['service'],
					'target' =>  htmlentities($this->db->escape_str(strip_tags($value['link']))),
					'quantity' => $value['quantity'],
					'price' => $value['price'], // reset
					'profit' => 0, // reset
					'status' => $value['status'],
					'is_api' =>  ($value['place_form'] <> 'WEB') ? '1' : '0' ,
					'is_refund' => $value['refund'],
					'api_id' => '1', // reset
					'provider' => $value['provider'], // reset
					'api_order_id' => $value['poid'], // reset
					'created_at' => $value['created_at'],
					'updated_at' => $value['updated_at'],
					'remains' => $value['remains'],
					'start_count' => $value['start_count']
				];
			$insert_data = $this->order_model->insert($data_input);
			if ($insert_data) {
				echo $insert_data . ' <b><font color="green">Berhasil '.$value['provider'].' | '.$value['poid'].'</font></b></br>';
			} else {
				echo 'error';
			}
			}
        }
    }
	public function order5(){
		$api = json_decode(file_get_contents('https://backup.ivmediashop.com/order3.php'), true);
		foreach ($api['data'] as $key => $value) {
			$user = $this->db->get_where('user', ['username' => $value['user']])->row_array();
			//$api = $this->db->get_where('api', ['id' => $value['provider_id']])->row_array();
			//$service = $this->db->get_where('service', ['name' => $this->db->escape_str($value['layanan'])])->row_array();
			$check_order = $this->db->get_where('order_list', ['api_order_id' => $this->db->escape_str($value['poid']), 'provider' => $value['provider']])->num_rows();
			if ($check_order > 0) {
				echo '<b><font color="red">Data sudah ada </font></b><br/>';
			} else {
            //$created_at = $value['date'] . ' ';
			//$created_at .= $value['time'];
		    $data_input = [
					'user_id' => (isset($user['id']) ? $user['id'] : 0),
					'service_id' => NULL,
					'service' => $value['service'],
					'target' =>  htmlentities($this->db->escape_str(strip_tags($value['link']))),
					'quantity' => $value['quantity'],
					'price' => $value['price'], // reset
					'profit' => 0, // reset
					'status' => $value['status'],
					'is_api' =>  ($value['place_form'] <> 'WEB') ? '1' : '0' ,
					'is_refund' => $value['refund'],
					'api_id' => '1', // reset
					'provider' => $value['provider'], // reset
					'api_order_id' => $value['poid'], // reset
					'created_at' => $value['created_at'],
					'updated_at' => $value['updated_at'],
					'remains' => $value['remains'],
					'start_count' => $value['start_count']
				];
			$insert_data = $this->order_model->insert($data_input);
			if ($insert_data) {
				echo $insert_data . ' <b><font color="green">Berhasil '.$value['provider'].' | '.$value['poid'].'</font></b></br>';
			} else {
				echo 'error';
			}
			}
        }
    }
	public function order6(){
		$api = json_decode(file_get_contents('https://backup.ivmediashop.com/order3.php'), true);
		foreach ($api['data'] as $key => $value) {
			$user = $this->db->get_where('user', ['username' => $value['user']])->row_array();
			//$api = $this->db->get_where('api', ['id' => $value['provider_id']])->row_array();
			//$service = $this->db->get_where('service', ['name' => $this->db->escape_str($value['layanan'])])->row_array();
			$check_order = $this->db->get_where('order_list', ['api_order_id' => $this->db->escape_str($value['poid']), 'provider' => $value['provider']])->num_rows();
			if ($check_order > 0) {
				echo '<b><font color="red">Data sudah ada </font></b><br/>';
			} else {
            //$created_at = $value['date'] . ' ';
			//$created_at .= $value['time'];
		    $data_input = [
					'user_id' => (isset($user['id']) ? $user['id'] : 0),
					'service_id' => NULL,
					'service' => $value['service'],
					'target' =>  htmlentities($this->db->escape_str(strip_tags($value['link']))),
					'quantity' => $value['quantity'],
					'price' => $value['price'], // reset
					'profit' => 0, // reset
					'status' => $value['status'],
					'is_api' =>  ($value['place_form'] <> 'WEB') ? '1' : '0' ,
					'is_refund' => $value['refund'],
					'api_id' => '1', // reset
					'provider' => $value['provider'], // reset
					'api_order_id' => $value['poid'], // reset
					'created_at' => $value['created_at'],
					'updated_at' => $value['updated_at'],
					'remains' => $value['remains'],
					'start_count' => $value['start_count']
				];
			$insert_data = $this->order_model->insert($data_input);
			if ($insert_data) {
				echo $insert_data . ' <b><font color="green">Berhasil '.$value['provider'].' | '.$value['poid'].'</font></b></br>';
			} else {
				echo 'error';
			}
			}
        }
    }
	public function order7(){
		$api = json_decode(file_get_contents('https://backup.ivmediashop.com/order3.php'), true);
		foreach ($api['data'] as $key => $value) {
			$user = $this->db->get_where('user', ['username' => $value['user']])->row_array();
			//$api = $this->db->get_where('api', ['id' => $value['provider_id']])->row_array();
			//$service = $this->db->get_where('service', ['name' => $this->db->escape_str($value['layanan'])])->row_array();
			$check_order = $this->db->get_where('order_list', ['api_order_id' => $this->db->escape_str($value['poid']), 'provider' => $value['provider']])->num_rows();
			if ($check_order > 0) {
				echo '<b><font color="red">Data sudah ada </font></b><br/>';
			} else {
            //$created_at = $value['date'] . ' ';
			//$created_at .= $value['time'];
		    $data_input = [
					'user_id' => (isset($user['id']) ? $user['id'] : 0),
					'service_id' => NULL,
					'service' => $value['service'],
					'target' =>  htmlentities($this->db->escape_str(strip_tags($value['link']))),
					'quantity' => $value['quantity'],
					'price' => $value['price'], // reset
					'profit' => 0, // reset
					'status' => $value['status'],
					'is_api' =>  ($value['place_form'] <> 'WEB') ? '1' : '0' ,
					'is_refund' => $value['refund'],
					'api_id' => '1', // reset
					'provider' => $value['provider'], // reset
					'api_order_id' => $value['poid'], // reset
					'created_at' => $value['created_at'],
					'updated_at' => $value['updated_at'],
					'remains' => $value['remains'],
					'start_count' => $value['start_count']
				];
			$insert_data = $this->order_model->insert($data_input);
			if ($insert_data) {
				echo $insert_data . ' <b><font color="green">Berhasil '.$value['provider'].' | '.$value['poid'].'</font></b></br>';
			} else {
				echo 'error';
			}
			}
        }
    }
	public function order8(){
		$api = json_decode(file_get_contents('https://backup.ivmediashop.com/order3.php'), true);
		foreach ($api['data'] as $key => $value) {
			$user = $this->db->get_where('user', ['username' => $value['user']])->row_array();
			//$api = $this->db->get_where('api', ['id' => $value['provider_id']])->row_array();
			//$service = $this->db->get_where('service', ['name' => $this->db->escape_str($value['layanan'])])->row_array();
			$check_order = $this->db->get_where('order_list', ['api_order_id' => $this->db->escape_str($value['poid']), 'provider' => $value['provider']])->num_rows();
			if ($check_order > 0) {
				echo '<b><font color="red">Data sudah ada </font></b><br/>';
			} else {
            //$created_at = $value['date'] . ' ';
			//$created_at .= $value['time'];
		    $data_input = [
					'user_id' => (isset($user['id']) ? $user['id'] : 0),
					'service_id' => NULL,
					'service' => $value['service'],
					'target' =>  htmlentities($this->db->escape_str(strip_tags($value['link']))),
					'quantity' => $value['quantity'],
					'price' => $value['price'], // reset
					'profit' => 0, // reset
					'status' => $value['status'],
					'is_api' =>  ($value['place_form'] <> 'WEB') ? '1' : '0' ,
					'is_refund' => $value['refund'],
					'api_id' => '1', // reset
					'provider' => $value['provider'], // reset
					'api_order_id' => $value['poid'], // reset
					'created_at' => $value['created_at'],
					'updated_at' => $value['updated_at'],
					'remains' => $value['remains'],
					'start_count' => $value['start_count']
				];
			$insert_data = $this->order_model->insert($data_input);
			if ($insert_data) {
				echo $insert_data . ' <b><font color="green">Berhasil '.$value['provider'].' | '.$value['poid'].'</font></b></br>';
			} else {
				echo 'error';
			}
			}
        }
    }
	public function order9(){
		$api = json_decode(file_get_contents('https://backup.ivmediashop.com/order9.php'), true);
		foreach ($api['data'] as $key => $value) {
			$user = $this->db->get_where('user', ['username' => $value['user']])->row_array();
			//$api = $this->db->get_where('api', ['id' => $value['provider_id']])->row_array();
			//$service = $this->db->get_where('service', ['name' => $this->db->escape_str($value['layanan'])])->row_array();
			$check_order = $this->db->get_where('order_list', ['api_order_id' => $this->db->escape_str($value['poid']), 'provider' => $value['provider']])->num_rows();
			if ($check_order > 0) {
				echo '<b><font color="red">Data sudah ada </font></b><br/>';
			} else {
            //$created_at = $value['date'] . ' ';
			//$created_at .= $value['time'];
		    $data_input = [
					'user_id' => (isset($user['id']) ? $user['id'] : 0),
					'service_id' => NULL,
					'service' => $value['service'],
					'target' =>  htmlentities($this->db->escape_str(strip_tags($value['link']))),
					'quantity' => $value['quantity'],
					'price' => $value['price'], // reset
					'profit' => 0, // reset
					'status' => $value['status'],
					'is_api' =>  ($value['place_form'] <> 'WEB') ? '1' : '0' ,
					'is_refund' => $value['refund'],
					'api_id' => '1', // reset
					'provider' => $value['provider'], // reset
					'api_order_id' => $value['poid'], // reset
					'created_at' => $value['created_at'],
					'updated_at' => $value['updated_at'],
					'remains' => $value['remains'],
					'start_count' => $value['start_count']
				];
			$insert_data = $this->order_model->insert($data_input);
			if ($insert_data) {
				echo $insert_data . ' <b><font color="green">Berhasil '.$value['provider'].' | '.$value['poid'].'</font></b></br>';
			} else {
				echo 'error'; 	
			}			    
			}
			
		}
	}
	
	public function cobaalan(){
		$api = json_decode(file_get_contents('https://backup.ivmediashop.com/orderalan.php'), true);
		foreach ($api['data'] as $key => $value) {
			$user = $this->db->get_where('user', ['username' => $value['user']])->row_array();
			//$api = $this->db->get_where('api', ['id' => $value['provider_id']])->row_array();
			//$service = $this->db->get_where('service', ['name' => $this->db->escape_str($value['layanan'])])->row_array();
			$check_order = $this->db->get_where('order_list', ['api_order_id' => $this->db->escape_str($value['api_order_id']), 'provider' => $value['provider']])->num_rows();
// 			if ($check_order > 0) {
// 				echo '<b><font color="red">Data sudah ada </font></b><br/>';
// 			} else {
            //$created_at = $value['date'] . ' ';
			//$created_at .= $value['time'];
		    $data_input = [
					'user_id' => (isset($user['id']) ? $user['id'] : 0),
					'service_id' => NULL,
					'service' => $value['service'],
					'target' =>  htmlentities($this->db->escape_str(strip_tags($value['link']))),
					'quantity' => $value['quantity'],
					'price' => $value['price'], // reset
					'profit' => 0, // reset
					'status' => $value['status'],
					'is_api' =>  ($value['place_form'] <> 'WEB') ? '1' : '0' ,
					'is_refund' => $value['refund'],
					'api_id' => '1', // reset
					'provider' => $value['provider'], // reset
					'api_order_id' => $value['poid'], // reset
					'created_at' => $value['created_at'],
					'updated_at' => $value['updated_at'],
					'remains' => $value['remains'],
					'start_count' => $value['start_count']
				];
			$insert_data = $this->order_model->insert($data_input);
			if ($insert_data) {
				echo $insert_data . ' <b><font color="green">Berhasil '.$value['provider'].' | '.$value['poid'].'</font></b></br>';
			} else {
				echo 'error'; 	
			}			    
// 			}
			
		}
	}
}
