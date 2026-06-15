<?php
defined('BASEPATH') or exit('No direct script access allowed');
if (!function_exists('text_gradient')) {
    function text_gradient($input)
    {
        // Array yang berisi aturan replace
        $replace_rules = array(
            '[ST_GRADIENT]' => '<span class="hero-text-gradient">',
            '[CL_GRADIENT]' => '</span>',
            '[ST_PRIMARY]'  => '<span class="text-primary">',
            '[CL_PRIMARY]'  => '</span>',
        );

        // Lakukan replace berdasarkan aturan yang telah ditentukan
        $output = str_replace(array_keys($replace_rules), array_values($replace_rules), $input);

        return $output;
    }
}
if (!function_exists('switch_status')) {
    function switch_status($i = '', $status = '')
    {
        if ($status == '1') {
            $labels = "<div class=\"form-check form-switch\">
                <input type=\"checkbox\" class=\"form-check-input\" id=\"switch-status-$i\" value=\"0\" onclick=\"switchStatus(this, $i, '" . base_url('admin/' . get_instance()->uri->segment(2) . '/status/' . $i . '/0') . "')\" checked>
                <label class=\"form-check-label\" for=\"switch-status-$i\"></label>
            </div>";
        } elseif ($status == '0') {
            $labels = "<div class=\"form-check form-switch\">
                <input type=\"checkbox\" class=\"form-check-input\" id=\"switch-status-$i\" value=\"1\" onclick=\"switchStatus(this, $i, '" . base_url('admin/' . get_instance()->uri->segment(2) . '/status/' . $i . '/1') . "')\" >
                <label class=\"form-check-label\" for=\"switch-status-$i\"></label>
            </div>";
        } else {
            $labels = '<span class="badge badge-info badge-sm">ERROR</span>';
        }
        return $labels;
    }
}

if (!function_exists('protect')) {
    function protect($str)
    {
        $str = htmlentities($str, ENT_QUOTES, 'UTF-8');
        return $str;
    }
}
if (!function_exists('get_service_average')) {
    function get_service_average($service_id = null)
    {
        get_instance()->load->model('order_model');

        $orders = get_instance()->order_model->get_rows([
            'select' => 'TIMESTAMPDIFF(SECOND, created_at, updated_at) AS average',
            'where' => [
                [
                    'service_id' => $service_id,
                    'status' => 'Success'
                ]
            ],
            'order_by' => 'id DESC',
            'limit' => 10
        ]);

        if (empty($orders)) {
            return 'Belum ada data';
        }

        $totalSeconds = array_sum(array_column($orders, 'average'));
        $averageSeconds = round($totalSeconds / count($orders));

        if ($averageSeconds <= 0) {
            return '0 detik';
        } else {
            return formatTime($averageSeconds);
        }
    }
}

function formatTime($seconds)
{
    $timeUnits = [
        "tahun" => floor($seconds / (365 * 24 * 60 * 60)),
        "bulan" => floor(($seconds % (365 * 24 * 60 * 60)) / (30 * 24 * 60 * 60)),
        "hari" => floor(($seconds % (30 * 24 * 60 * 60)) / (24 * 60 * 60)),
        "jam" => floor(($seconds % (24 * 60 * 60)) / (60 * 60)),
        "menit" => floor(($seconds % (60 * 60)) / 60),
        "detik" => $seconds % 60
    ];

    $resultArray = [];
    foreach ($timeUnits as $unit => $value) {
        if ($value > 0) {
            if ($unit !== 'detik' || ($unit === 'detik' && $seconds <= 60)) {
                $resultArray[] = "$value $unit";
            }
        }
    }

    $result = implode(", ", $resultArray);

    return $result;
}

if (!function_exists('user')) {
    function user($i = 'id')
    {
        if (!get_instance()->session->userdata('login')) return false;
        $user = get_instance()->user_model->get_row(['id' => get_instance()->session->userdata('login'), 'status' => '1', 'is_verif' => '1']);
        if ($user == false) return false;
        return $user->$i;
    }
}

if (!function_exists('admin')) {
    function admin($i = 'id')
    {
        if (!get_instance()->session->userdata('login_admin')) return false;
        $admin = get_instance()->admin_model->get_by_id(get_instance()->session->userdata('login_admin'));
        if ($admin == false) return false;
        return $admin->$i;
    }
}
if (!function_exists('cekMutasi')) {
    function cekMutasi($saldo, $mutasi)
    {
        return (strpos($mutasi, $saldo) !== false) ? true : false;
    }
}

if (!function_exists('check_cookie')) {
    function check_cookie($i = '')
    {
        $CI = &get_instance();

        // Cek apakah ada data cookie sesuai dengan nilai $i
        $cookie = $CI->cookie_model->get_row(['cookie' => $i]);

        // Jika tidak ada data cookie, hapus userdata login
        if (!$cookie) {
            $CI->session->unset_userdata('login');
            return false;
        }

        // Periksa apakah cookie telah kadaluarsa
        if ($CI->cookie_model->isCookieExpired($cookie->expired_at)) {

            // Hapus userdata login
            $CI->session->unset_userdata('login');

            // Hapus cookie dari database
            $CI->cookie_model->delete(['id' => $cookie->id]);

            // Hapus cookie 'smm_login'
            delete_cookie('smm_login');


            // Set flashdata dengan pesan sesi kadaluarsa
            $CI->session->set_flashdata('result', [
                'alert' => 'danger',
                'title' => 'Gagal',
                'msg'   => 'Sesi Anda telah kadaluarsa.'
            ]);

            redirect(base_url('auth/login'));

            // Redirect ke halaman logout jika sedang login
            if ($CI->session->userdata('login')) {
                redirect(base_url('auth/login'));
            }

            return false;
        }

        // Perbarui last_activity jika ada aktivitas browser
        if (strtotime($cookie->last_activity) < time()) {
            $CI->cookie_model->update(['last_activity' => date('Y-m-d H:i:s')], ['id' => $cookie->id]);
        }

        // Cek apakah ada data pengguna berdasarkan ID dari cookie
        $user = $CI->user_model->get_by_id($cookie->user_id);

        // Jika tidak ada data pengguna, hapus userdata login
        if (!$user) {
            $CI->session->unset_userdata('login');
            return false;
        }

        // Set userdata login dengan ID pengguna
        $CI->session->set_userdata('login', $user->id);

        return true;
    }
}

if (!function_exists('check_cookie_admin')) {
    function check_cookie_admin($i = '')
    {
        $CI = &get_instance();

        // Cek apakah ada data cookie sesuai dengan nilai $i
        $cookie = $CI->cookie_model->get_row(['cookie' => $i]);

        // Jika tidak ada data cookie, hapus userdata login_admin
        if (!$cookie) {
            $CI->session->unset_userdata('login_admin');
            return false;
        }

        // Periksa apakah cookie telah kadaluarsa
        if ($CI->cookie_model->isCookieExpired($cookie->expired_at)) {

            // Hapus userdata login_admin
            $CI->session->unset_userdata('login_admin');

            // Hapus cookie dari database
            $CI->cookie_model->delete(['id' => $cookie->id]);

            // Hapus cookie 'admin_login'
            delete_cookie('admin_login');

            // Set flashdata dengan pesan sesi kadaluarsa
            $CI->session->set_flashdata('result', [
                'alert' => 'danger',
                'title' => 'Gagal',
                'msg'   => 'Sesi Anda telah kadaluarsa.'
            ]);

            redirect(base_url('admin/auth/login'));

            // Redirect ke halaman logout jika sedang login
            if ($CI->session->userdata('login_admin')) {
                redirect(base_url('admin/auth/login'));
            }

            return false;
        }

        // Perbarui last_activity jika ada aktivitas browser
        if (strtotime($cookie->last_activity) < time()) {
            $CI->cookie_model->update(['last_activity' => date('Y-m-d H:i:s')], ['id' => $cookie->id]);
        }

        // Cek apakah ada data pengguna berdasarkan ID dari cookie
        $admin = $CI->admin_model->get_by_id($cookie->user_id);

        // Jika tidak ada data pengguna, hapus userdata login_admin
        if (!$admin) {
            $CI->session->unset_userdata('login_admin');
            return false;
        }

        // Set userdata login dengan ID pengguna
        $CI->session->set_userdata('login_admin', $admin->id);

        return true;
    }
}

if (!function_exists('benefit')) {
    function benefit($i = '', $type = '')
    {
        $config = get_instance()->benefit_model->get_row(['name' => $i, 'type' => $type]);
        if ($config == false) return false;
        return $config->value;
    }
}

if (!function_exists('set_benefit')) {
    function set_benefit($name, $value, $type)
    {
        $CI = &get_instance();
        $config = $CI->benefit_model->get_name_type(['name' => $name, 'type' => $type]);
        if ($config) {
            // Jika konfigurasi sudah ada, lakukan update
            return $CI->benefit_model->update(['value' => $value], ['name' => $name, 'type' => $type]);
        } else {
            // Jika konfigurasi belum ada, lakukan insert
            return $CI->benefit_model->insert(['name' => $name, 'value' => $value, 'type' => $type]);
        }
    }
}


if (!function_exists('custom_statistic')) {
    function custom_statistic($i = '')
    {
        $config = get_instance()->custom_statistic_model->get_row(['name' => $i]);
        if ($config == false) return false;
        return $config->value;
    }
}
if (!function_exists('set_custom_statistic')) {
    function set_custom_statistic($name, $value, $type)
    {
        $config = get_instance()->custom_statistic_model->get_row(['name' => $name, 'type' => $type]);
        if ($config == true) {
            return get_instance()->custom_statistic_model->update(['value' => $value], ['name' => $name], ['type' => $type]);
        } else {
            return get_instance()->custom_statistic_model->insert(['name' => $name, 'value' => $value, 'type' => $type]);
        }
    }
}

if (!function_exists('website_config')) {
    function website_config($i = '')
    {
        $config = get_instance()->website_config_model->get_row(['name' => $i]);
        if ($config == false) return false;
        return $config->value;
    }
}
if (!function_exists('web_settings')) {
    function web_settings($i = '')
    {
        $config = get_instance()->web_settings_model->get_row(['name' => $i]);
        if ($config == false) return false;
        return $config->value;
    }
}

if (!function_exists('currency')) {
    function currency($value)
    {
        $currency = number_format($value, 0, ".", ".");
        return $currency;
    }
}

if (!function_exists('convert_percent')) {
    function convert_percent($value)
    {
        $number = $value / 100;
        return $number;
    }
}

if (!function_exists('dd')) {
    function dd($i = '')
    {
        print_r('<pre>');
        print_r($i);
        print_r('</pre>');
        die;
    }
}
if (!function_exists('role')) {
    function role($role, $access)
    {
        $checkAccess = get_instance()->role_access_model->get_row(['access' => $access, 'role_id' => $role]);
        if ($checkAccess == false) return false;
        return true;
    }
}

if (!function_exists('check_role')) {
    function check_role($access, $role_id)
    {
        $checkAccess = get_instance()->role_access_model->get_row(['access' => $access, 'role_id' => $role_id]);
        if ($checkAccess == false) {
            return '';
        } else {
            return 'checked';
        }
    }
}

if (!function_exists('menu_role')) {
    function menu_role($access, $role_id)
    {
        $checkAccess = get_instance()->role_access_model->get_row(['access' => $access, 'role_id' => $role_id]);
        if ($checkAccess == false) {
            return 'hide';
        } else {
            return '';
        }
    }
}

if (!function_exists('set_website_config')) {
    function set_website_config($name, $value)
    {
        $config = get_instance()->website_config_model->get_row(['name' => $name]);
        if ($config == true) {
            return get_instance()->website_config_model->update(['value' => $value], ['name' => $name]);
        } else {
            return get_instance()->website_config_model->insert(['name' => $name, 'value' => $value]);
        }
    }
}

if (!function_exists('remove_emoji')) {
    function remove_emoji($string)
    {
        // Match Emoticons
        $regex_emoticons = '/[\x{1F600}-\x{1F64F}]/u';
        $clear_string = preg_replace($regex_emoticons, '', $string);

        // Match Miscellaneous Symbols and Pictographs
        $regex_symbols = '/[\x{1F300}-\x{1F5FF}]/u';
        $clear_string = preg_replace($regex_symbols, '', $clear_string);

        // Match Transport And Map Symbols
        $regex_transport = '/[\x{1F680}-\x{1F6FF}]/u';
        $clear_string = preg_replace($regex_transport, '', $clear_string);

        // Match Miscellaneous Symbols
        $regex_misc = '/[\x{2600}-\x{26FF}]/u';
        $clear_string = preg_replace($regex_misc, '', $clear_string);

        // Match Dingbats
        $regex_dingbats = '/[\x{2700}-\x{27BF}]/u';
        $clear_string = preg_replace($regex_dingbats, '', $clear_string);

        return $clear_string;
    }
}
if (!function_exists('search_key')) {
    function search_key($array = [], $search = '')
    {
        if (!is_array($array)) return false;
        foreach ($array as $key => $val) {
            if ($key === $search) {
                return $val;
            } else if (is_array($val)) {
                $find = search_key($val, $search);
                if ($find !== false) return $find;
            }
        }
        return false;
    }
}

if (!function_exists('array_diff_key_recursive')) :
    function array_diff_key_recursive($a1, $a2)
    {
        $r = array();

        foreach ($a1 as $k => $v) {
            if (is_array($v)) {
                if (!isset($a2[$k]) || !is_array($a2[$k])) {
                    $r[$k] = $a1[$k];
                } else {
                    if ($diff = array_diff_key_recursive($a1[$k], $a2[$k])) {
                        $r[$k] = $diff;
                    }
                }
            } else {
                if (!isset($a2[$k]) || is_array($a2[$k])) {
                    $r[$k] = $v;
                }
            }
        }

        return $r;
    }
endif;

if (!function_exists('array_cast_recursive')) :
    function array_cast_recursive($array)
    {
        if (is_array($array)) {
            foreach ($array as $key => $value) {
                if (is_array($value)) {
                    $array[$key] = array_cast_Recursive($value);
                }
                if ($value instanceof stdClass) {
                    $array[$key] = array_cast_Recursive((array)$value);
                }
            }
        }
        if ($array instanceof stdClass) {
            return array_cast_Recursive((array)$array);
        }
        return $array;
    }
endif;
