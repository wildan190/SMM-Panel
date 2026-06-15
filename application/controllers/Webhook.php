<?php
defined('BASEPATH') or exit('No direct script access allowed');

#[AllowDynamicProperties]
class Webhook extends MY_Controller
{
    private $token = 'TOKEN_BOT_TELEGRAM';
    private $target_channel = 'ID_CHANNEL_TELEGRAM';

    public function __construct()
    {
        parent::__construct();
        // Load model yang dibutuhkan
        $this->load->model(['service_model', 'user_model', 'service_category_model', 'deposit_model']);
    }

    public function tele()
    {
        header('content-type: application/json; charset=utf-8');
        $data = json_decode(file_get_contents('php://input'), true);
        if (!$data) {
            die('Ngapain kesini bossku. Hanya Telegram yang bisa akses ');
        }

        file_put_contents('telegram.txt', '[' . date('Y-m-d H:i:s') . "]\n" . json_encode($data) . "\n\n", FILE_APPEND);
        $message = strtolower((string) ($data['message']['text'] ?? ''));
        $chat_id = strtolower((string) ($data['message']['chat']['id'] ?? ''));
        $username = isset($data['message']['from']['username']) ? $data['message']['from']['username'] : 'Tidak ada username';
        $first_name = isset($data['message']['from']['first_name']) ? $data['message']['from']['first_name'] : 'Tidak ada nama depan';
        $user_id = $data['message']['from']['id'];
        $last_name = isset($data['message']['from']['last_name']) ? $data['message']['from']['last_name'] : '';

        $pecahPesan = explode(' ', $message);
        $checkService = null; // Inisialisasi variabel di luar blok if
        $checkOrder = null; // Inisialisasi variabel di luar blok if
        $keyboard = null; // Inisialisasi variabel di luar blok if

        // Mengecek ID layanan
        if (array_key_exists(1, $pecahPesan)) {
            $checkOrder = $this->order_model->get_row(['id' => $pecahPesan[1]]);
            $checkService = $this->service_model->get_row(['id' => $pecahPesan[1]]);
            $order_check = $this->order_model->get_row(['service_id' => $pecahPesan[1], 'status' => 'Success']);
            $checkCategory = $this->service_category_model->get_row(['id' => $checkService->service_category_id]);
            if ($checkService !== false && $checkService !== null) {
                $average = get_service_average($checkService->id);
            }
        } else {
            // Lakukan tindakan yang sesuai jika indeks tidak terdefinisi
            // Misalnya memberikan pesan kesalahan atau tindakan lainnya.
        }

        if ($checkService) {
            $status = ($checkService->status == '1') ? 'Aktif' : 'Nonaktif';
        }
        if ($checkOrder) {
            $refund = ($checkOrder->is_refund == '0') ? 'Tidak' : 'Ya';
            $melalui = ($checkOrder->is_api == '0') ? 'WEB' : 'API';
            $checkUser = $this->user_model->get_row(['id' => $checkOrder->user_id]);
        }
        $checkAdmin = $this->user_model->get_row(['telegram' => $username, 'level' => 'Owner']);
        $checkProfile = $this->user_model->get_row(['telegram' => $username]);

        // Persiapan pesan balasan
        $response = '';

        if (isset($data['message']['new_chat_members'])) {
            // Mendapatkan informasi anggota baru
            $new_members = $data['message']['new_chat_members'];
            foreach ($new_members as $member) {
                $member_id = $member['id'];
                $member_username = isset($member['username']) ? $member['username'] : 'Tidak ada username';
                $member_first_name = isset($member['first_name']) ? $member['first_name'] : 'Tidak ada nama depan';

                // Pesan selamat datang
                $welcome_message = 'Selamat datang, <a href="tg://user?id=' . $member_id . '">' . $member_first_name . '</a> (@' . $member_username . ') di grup <a href="https://flaxspedia.com">Flaxs Pedia</a>.';

                // Kirim pesan selamat datang
                $this->sendTelegramMessage($data['message']['chat']['id'], $welcome_message);
            }
        }

        if (in_array($pecahPesan[0], ['/start', '/status', '/profil', '/layanan', '/order'])) {
            if ($pecahPesan[0] == '/start') {
                $response = 'Halo <a href="tg://user?id=' . $user_id . '">' . $first_name . ' ' . $last_name . '</a>
Ada yang bisa saya bantu?

Berikut daftar command yang bisa kamu gunakan:

<pre>/profil</pre>
<blockquote>Command ini berfungsi untuk menampilkan data profil Anda.</blockquote>

<pre>/layanan [id layanan]</pre>
<blockquote>Command ini befungsi untuk menampilkan data Layanan Flaxs Pedia.
Contoh penerapan:
<b>/layanan 1</b>
Pada contoh diatas, bot akan mengirim detail layanan dengan ID 1.</blockquote>

<pre>/status [id pesanan]</pre>
<blockquote>Command ini befungsi untuk menampilkan data pesanan Anda.
Contoh penerapan:
<b>/status 1234</b>
Pada contoh diatas, bot akan mengirim detail pesanan Anda dengan ID 1234.
Pastikan ID tersebut adalah pesanan Anda.</blockquote>';
            } elseif ($pecahPesan[0] == '/status') {
                if ($pecahPesan[0] == '/status' && $checkOrder == false) {
                    $response = "ID Pesanan tidak ditemukan.";
                } elseif ($pecahPesan[0] == '/status' && $checkUser->telegram <> $username) {
                    // Tombol "Flaxs Pedia" dengan URL https://flaxspedia.com
                    $keyboard = json_encode([
                        'inline_keyboard' => [[['text' => 'Tautkan Username Telegram', 'url' => 'https://flaxspedia.com/user/setting']]],
                        'resize_keyboard' => true
                    ]);
                    $response = '<b>GAGAL!</b>
Pesanan dengan ID <b>' . $pecahPesan[1] . '</b> bukan punya kamu
Pastikan data username telegram kamu @' . $username . ' sudah tertaut di data akun Flaxs Pedia
Klik tombol button dibawah untuk mengubah.';
                } else {
                    $response = 'Halo <a href="tg://user?id=' . $user_id . '">' . $first_name . ' ' . $last_name . '</a>
Berikut data pesanan kamu:
        
<b>• ID</b>: ' . $checkOrder->id . '
<b>• Layanan</b>: ' . $checkOrder->service . '
<b>• Target</b>: ' . $checkOrder->target . '
<b>• Harga</b>: Rp ' . currency($checkOrder->price) . '
<b>• Jumlah Pesanan</b>: ' . currency($checkOrder->quantity) . '
<b>• Jumlah Awal</b>: ' . currency($checkOrder->start_count) . '
<b>• Jumlah Kurang</b>: ' . currency($checkOrder->remains) . '
<b>• Status</b>: ' . $checkOrder->status . '
<b>• Penggembalian Dana</b>: ' . $refund . '
<b>• Pesan Melalui</b>: ' . $melalui . '
<b>• Tgl. Pesanan</b>: ' . $this->lib->tanggal_indonesia($checkOrder->created_at) . '
<b>• Tgl. Pembaruan</b>: ' . $this->lib->tanggal_indonesia($checkOrder->updated_at) . '
<b>• Waktu Proses</b>: ' . $this->lib->timeProcess($checkOrder->created_at, $checkOrder->updated_at) . '
                    ';
                }
            } elseif ($pecahPesan[0] == '/order') {
                if ($pecahPesan[0] == '/order' && $checkOrder == false) {
                    $response = "ID Pesanan tidak ditemukan.";
                } elseif ($pecahPesan[0] == '/order' && ($checkAdmin->telegram != $username && 'GroupAnonymousBot' != $username)) {
                    $response = '<b>GAGAL!</b>
Anda bukan Admin <a href="https://flaxspedia.com">' . website_config('title') . '</a>.';
                } else {

                    // Tombol "Flaxs Pedia" dengan URL https://flaxspedia.com
                    $keyboard = json_encode([
                        'inline_keyboard' => [[['text' => 'Flaxs Pedia', 'url' => 'https://flaxspedia.com']]],
                        'resize_keyboard' => true
                    ]);
                    $response = 'Halo <a href="tg://user?id=' . $user_id . '">' . $first_name . ' ' . $last_name . '</a>
Berikut data pesanan dengan ID <b>' . $checkOrder->id . '</b>:
                
<b>• Pengguna</b>: ' . $checkUser->username . '
<b>• Layanan</b>: ' . $checkOrder->service . '
<b>• Target</b>: ' . $checkOrder->target . '
<b>• Harga</b>: Rp ' . currency($checkOrder->price) . '
<b>• Jumlah Pesanan</b>: ' . currency($checkOrder->quantity) . '
<b>• Jumlah Awal</b>: ' . currency($checkOrder->start_count) . '
<b>• Jumlah Kurang</b>: ' . currency($checkOrder->remains) . '
<b>• Status</b>: ' . $checkOrder->status . '
<b>• Refund</b>: ' . $refund . '
<b>• Pesan Melalui</b>: ' . $melalui . '
<b>• Tgl. Pesanan</b>: ' . $this->lib->tanggal_indonesia($checkOrder->created_at) . '
<b>• Tgl. Pembaruan</b>: ' . $this->lib->tanggal_indonesia($checkOrder->updated_at) . '
<b>• Waktu Proses</b>: ' . $this->lib->timeProcess($checkOrder->created_at, $checkOrder->updated_at) . '
    ';
                }
            } elseif ($pecahPesan[0] == '/layanan') {
                if ($pecahPesan[0] == '/layanan' && $checkService == false) {
                    $response = "ID Layanan tidak ditemukan.";
                } else {
                    // Tombol "Judul" dengan URL
                    $keyboard = json_encode([
                        'inline_keyboard' => [[
                            [
                                'text' => 'Pesan Sekarang',
                                'url' => base_url('order/single?id=' . $checkService->id)
                            ]
                        ]],
                        'resize_keyboard' => true
                    ]);

                    $response = 'Berikut detail Layanan ID <b>' . $checkService->id . '</b> :
            
<b>• Kategori</b>: ' . $checkCategory->name . '
<b>• Nama</b>: ' . $checkService->name . '
<b>• Harga</b>: Rp ' . currency($checkService->price) . '
<b>• Minimal</b>: ' . currency($checkService->min) . '
<b>• Maksimal</b>: ' . currency($checkService->max) . '
<b>• Status</b>: ' . $status . '
<b>• Rata-rata Proses</b>: ' . $average . '';
                }
            } elseif ($pecahPesan[0] == '/profil') {
                if ($checkProfile == false) {
                    $response = '<b>GAGAL!</b>
Username telegram kamu tidak tertaut di data pengguna ' . website_config('title') . '.';
                } else {

                    // Tombol "Flaxs Pedia" dengan URL https://flaxspedia.com
                    $keyboard = json_encode([
                        'inline_keyboard' => [[['text' => 'Flaxs Pedia', 'url' => 'https://flaxspedia.com']]],
                        'resize_keyboard' => true
                    ]);
                    $response = 'Halo <a href="tg://user?id=' . $user_id . '">' . $first_name . ' ' . $last_name . '</a>
Berikut data profil kamu:
                        
<b>• Username</b>: ' . $checkProfile->username . '
<b>• Nama</b>: ' . $checkProfile->full_name . '
<b>• Saldo</b>: Rp ' . currency($checkProfile->balance) . '
<b>• Terdaftar</b>: ' . $this->lib->tanggal_indonesia($checkProfile->created_at) . '';
                }
            } else {
                $response = "Pesan tidak valid. Silakan gunakan command yang benar.
ketik <code>/start</code> untuk melihat daftar list command yang tersedia.";
            }
        }

        // Kirim pesan balasan
        $this->sendTelegramMessage($chat_id, $response, $keyboard);
    }

    public function cron_update_service()
{
    // Ambil 10 log yang belum terkirim
    $logs = $this->db->get_where('service_logs', ['is_sent' => 0], 10)->result_array();

    if (empty($logs)) die("Tidak ada log baru.");

    foreach ($logs as $log) {
        $header = "🔔 <b>UPDATE LAYANAN</b>";
        
        // Menampilkan ID dan Nama Layanan secara sejajar (tanpa \n tambahan dan <code>)
        $body = "<b>ID Layanan:</b> " . $log['service_id'] . "\n";
        $body .= "<b>Layanan:</b> " . $log['service_name'] . "\n";
        
        switch ($log['type']) {
            case 'insert':
                $header = "🆕 <b>LAYANAN BARU DITAMBAHKAN!</b>";
                $body .= "<b>Status:</b> Layanan baru tersedia";
                break;
            case 'price_increased':
                $body .= "<b>Status:</b> Kenaikan Harga dari Rp " . number_format($log['before_update'], 0, ',', '.') . " menjadi Rp " . number_format($log['after_update'], 0, ',', '.');
                break;
            case 'price_decreased':
                $body .= "<b>Status:</b> Penurunan Harga dari Rp " . number_format($log['before_update'], 0, ',', '.') . " menjadi Rp " . number_format($log['after_update'], 0, ',', '.');
                break;
            case 'update_min':
                $body .= "<b>Status:</b> Perubahan Minimal Order dari " . number_format($log['before_update'], 0, ',', '.') . " menjadi " . number_format($log['after_update'], 0, ',', '.');
                break;
            case 'update_max':
                $body .= "<b>Status:</b> Perubahan Maksimal Order dari " . number_format($log['before_update'], 0, ',', '.') . " menjadi " . number_format($log['after_update'], 0, ',', '.');
                break;
            case 'enabled':
                $body .= "<b>Status:</b> Layanan Aktif Kembali";
                break;
            case 'disabled':
                $body .= "<b>Status:</b> Maintenance (Nonaktif)";
                break;
        }

        $footer = "\n━━━━━━━━━━━━━━━━━━\n";
        $footer .= "🚀 Order sekarang di: flaxspedia.com";
        
        $full_message = $header . "\n━━━━━━━━━━━━━━━━━━\n" . $body . $footer;
        
        // Kirim ke ID Channel Anda (Pastikan parse_mode adalah HTML)
        $send = $this->sendTelegramMessage($this->target_channel, $full_message);
        
        if ($send) {
            $this->db->update('service_logs', ['is_sent' => 1], ['id' => $log['id']]);
        }
        usleep(500000); // Jeda 0.5 detik agar tidak terkena spam limit Telegram
    }
    echo "Berhasil mengirim update.";
}

    public function midtrans()
    {
        $this->load->library('midtrans');
        $server_key = $this->midtrans->getServerKey();
        $data = json_decode(file_get_contents('php://input'), true);

        if (!$data) {
            die('No data');
        }

        $order_id = $data['order_id'];
        $status_code = $data['status_code'];
        $gross_amount = $data['gross_amount'];
        $signature_key = $data['signature_key'];

        // Verifikasi Signature dengan format gross_amount yang tepat
        $signature = hash("sha512", $order_id . $status_code . $gross_amount . $server_key);

        if ($signature !== $signature_key) {
            log_message('error', 'Midtrans Webhook: Invalid Signature. Expected: ' . $signature . ' got: ' . $signature_key);
            die('Invalid signature');
        }

        $transaction_status = $data['transaction_status'];
        $payment_type = $data['payment_type'];

        $deposit = $this->deposit_model->get_row(['reference' => $order_id]);

        if ($deposit && $deposit->status == 'Pending') {
            if ($transaction_status == 'settlement' || $transaction_status == 'capture') {
                // UPDATE OTOMATIS: Langsung sukseskan tanpa admin
                $this->db->trans_start();

                // 1. Update status deposit
                $this->deposit_model->update([
                    'status' => 'Success',
                    'updated_at' => date('Y-m-d H:i:s'),
                ], ['id' => $deposit->id]);

                // 2. Update saldo user
                $user = $this->user_model->get_by_id($deposit->user_id);
                if ($user) {
                    $this->user_model->update([
                        'balance' => $user->balance + $deposit->balance,
                    ], ['id' => $user->id]);

                    // 3. Log penggunaan saldo
                    $this->load->model('log_balance_usage_model');
                    $this->log_balance_usage_model->insert([
                        'user_id' => $user->id,
                        'type' => 'plus',
                        'category' => 'deposit',
                        'amount' => $deposit->balance,
                        'description' => 'Deposit #' . $deposit->id . ' via Midtrans (Auto-Webhook).',
                        'before' => $user->balance,
                        'after' => $user->balance + $deposit->balance,
                        'created_at' => date('Y-m-d H:i:s')
                    ]);
                }
                
                $this->db->trans_complete();
                log_message('info', 'Midtrans Webhook: Deposit #' . $deposit->id . ' sukses otomatis.');
            } else if ($transaction_status == 'cancel' || $transaction_status == 'deny' || $transaction_status == 'expire') {
                 $this->deposit_model->update([
                     'status' => 'Canceled',
                     'updated_at' => date('Y-m-d H:i:s'),
                 ], ['id' => $deposit->id]);
            } else if ($transaction_status == 'refund') {
                 $this->deposit_model->update([
                     'status' => 'Refunded',
                     'updated_at' => date('Y-m-d H:i:s'),
                 ], ['id' => $deposit->id]);
            }
        }

        echo "OK";
    }

    private function sendTelegramMessage($chat_id, $message)
    {
        $url = "https://api.telegram.org/bot" . $this->token . "/sendMessage";
        $data = [
            'chat_id' => $chat_id,
            'text' => $message,
            'parse_mode' => 'html',
            'disable_web_page_preview' => true
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
    
    private function sendWhatsAppMessage($message)
{
    $token = "ic4mgwLnwS6fEYenwySR"; // Dapatkan dari fonnte.com
    $target = "120363247900216085@g.us"; // Contoh: 12036302345678@g.us

    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.fonnte.com/send',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => array(
            'target' => $target,
            'message' => $message,
        ),
        CURLOPT_HTTPHEADER => array("Authorization: $token"),
    ));
    curl_exec($curl);
    curl_close($curl);
}

    public function whatsapp()
    {
        header('Content-Type: application/json; charset=utf-8');
        $data = json_decode(file_get_contents('php://input'), true);

        if (!$data) {
            die('This URL is for webhook.');
        }

        file_put_contents('whatsapp.txt', '[' . date('Y-m-d H:i:s') . "]\n" . json_encode($data) . "\n\n", FILE_APPEND);
        $message = strtolower((string) ($data['payload']['conversation'] ?? ''));
        $from = strtolower((string) ($data['sender'] ?? ''));

        $pecahPesan = explode(' ', $message);

        $header = array(
            'Content-Type: application/json',
        );

        if ($pecahPesan[0] == '#profil') {
            $this->handleProfilCommand($pecahPesan, $from);
        } elseif ($pecahPesan[0] == '#layanan') {
            $this->handleLayananCommand($pecahPesan, $from);
        } elseif ($pecahPesan[0] == '#status') {
            $this->handleStatusCommand($pecahPesan, $from);
        } elseif ($pecahPesan[0] == '#order') {
            $this->handleOrderCommand($pecahPesan, $from);
        } else {
            $this->handleInvalidCommand($from);
        }
    }

    private function handleProfilCommand($pecahPesan, $from)
    {
        // Implementasi fungsi #profil di sini
        $checkProfile = $this->user_model->get_row(['whatsapp' => $from]);
        if ($checkProfile) {
            $message = 'Halo *_' . $checkProfile->username . '_*,
Berikut adalah data profil Anda:
        
*Username*: ' . $checkProfile->username . '
*Nama Lengkap*: ' . $checkProfile->full_name . '
*Saldo*: Rp ' . currency($checkProfile->balance) . '
*Terdaftar*: ' . $this->lib->format_date($checkProfile->created_at) . '

Terimakasih telah menggunakan *' . website_config('title') . '*';
        } else {
            $message = 'No Whatsapp Anda tidak ada di Data User ' . website_config('title') . '.';
        }

        $this->lib->sendMessage($from, $message);
    }

    private function handleLayananCommand($pecahPesan, $from)
    {
        // Implementasi fungsi #layanan di sini

        $checkService = $this->service_model->get_row(['id' => $pecahPesan[1]]);
        $status = ($checkService->status == '1') ? 'Aktif' : 'Nonaktif';
        $checkCategory = $this->service_category_model->get_row(['id' => $checkService->service_category_id]);
        $order_check = $this->order_model->get_row(['service_id' => $pecahPesan[1], 'status' => 'Success']);
        if ($order_check == false) {
            $average = 'Belum ada data';
        } else {
            $average = $checkService->average_time;
        }

        if ($pecahPesan[0] == '#layanan' && $checkService == false) {
            $message = '*GAGAL!*
ID Layanan tidak ditemukan.';
        } else {
            $message = 'Berikut adalah detail Layanan ID *' . $checkService->id . '* :
            
*Kategori*: ' . $checkCategory->name . '
*Nama*: ' . $checkService->name . '
*Harga*: Rp ' . currency($checkService->price) . '
*Minimal*: ' . currency($checkService->min) . '
*Maksimal*: ' . currency($checkService->max) . '
*Status*: ' . $status . '
*Rata-rata Proses*: ' . $average . '

Pesan sekarang:
' . base_url('order/single?id=' . $checkService->id . '') . '

Terimakasih telah menggunakan *' . website_config('title') . '*';
        }
        $this->lib->sendMessage($from, $message);
    }

    private function handleStatusCommand($pecahPesan, $from)
    {
        // Implementasi fungsi #status di sini

        $checkOrder = $this->order_model->get_row(['id' => $pecahPesan[1]]);
        $checkUser = $this->user_model->get_row(['id' => $checkOrder->user_id]);
        $refund = ($checkOrder->is_refund == '0') ? 'Tidak' : 'Ya';
        $melalui = ($checkOrder->is_api == '0') ? 'WEB' : 'API';

        if ($pecahPesan[0] == '#status' && $checkOrder == false) {
            $message = '*GAGAL!*
ID Pesanan tidak ditemukan.';
        } elseif ($pecahPesan[0] == '#status' && $checkUser->whatsapp <> $from) {
            $message = '*GAGAL!*
Silahkan melakukan request cek status pesanan dengan nomor hp yg tertaut oleh akun Anda.';
        } else {
            $message = 'Halo *_' . $checkUser->username . '_*,
Berikut adalah data pesanan Anda:
                
*ID*: ' . $checkOrder->id . '
*Target*: ' . $checkOrder->target . '
*Jumlah Pesanan*: ' . currency($checkOrder->quantity) . '
*Jumlah Awal*: ' . currency($checkOrder->start_count) . '
*Jumlah Kurang*: ' . currency($checkOrder->remains) . '
*Status*: ' . $checkOrder->status . '
*Refund*: ' . $refund . '
*Pesan Melalui*: ' . $melalui . '
*Tanggal*: ' . $this->lib->format_date($checkOrder->created_at) . '
*Pembaruan*: ' . $this->lib->format_date($checkOrder->updated_at) . '
*Waktu Proses*: ' . $this->lib->timeProcess($checkOrder->created_at, $checkOrder->updated_at) . '

Terimakasih telah menggunakan *' . website_config('title') . '*';
        }
        $this->lib->sendMessage($from, $message);
    }

    private function handleOrderCommand($pecahPesan, $from)
    {
        // Implementasi fungsi #order di sini
        $checkAdmin = $this->user_model->get_row(['whatsapp' => $from, 'level' => 'Owner']);
        $checkOrder = $this->order_model->get_row(['id' => $pecahPesan[1]]);
        $refund = ($checkOrder->is_refund == '0') ? 'Tidak' : 'Ya';
        $melalui = ($checkOrder->is_api == '0') ? 'WEB' : 'API';
        $checkUser = $this->user_model->get_row(['id' => $checkOrder->user_id]);

        if ($pecahPesan[0] == '#order' && $checkAdmin->whatsapp <> $from) {
            $message = '*GAGAL!*
Anda bukan Admin ' . website_config('title') . '.';
        } elseif ($pecahPesan[0] == '#order' && $checkOrder == false) {
            $message = '*GAGAL!*
ID Pesanan tidak ditemukan.';
        } else {
            $message = 'Halo *_' . $checkAdmin->full_name . '_*,
Berikut adalah data pesanan _' . $checkUser->username . '_:
            
*ID*: ' . $checkOrder->id . '
*Target*: ' . $checkOrder->target . '
*Jumlah Pesanan*: ' . currency($checkOrder->quantity) . '
*Jumlah Awal*: ' . currency($checkOrder->start_count) . '
*Jumlah Kurang*: ' . currency($checkOrder->remains) . '
*Status*: ' . $checkOrder->status . '
*Refund*: ' . $refund . '
*Pesan Melalui*: ' . $melalui . '
*Tanggal*: ' . $this->lib->format_date($checkOrder->created_at) . '
*Pembaruan*: ' . $this->lib->format_date($checkOrder->updated_at) . '
*Waktu Proses*: ' . $this->lib->timeProcess($checkOrder->created_at, $checkOrder->updated_at) . '

Terimakasih telah menggunakan *' . website_config('title') . '*';
        }
        $this->lib->sendMessage($from, $message);
    }

    private function handleInvalidCommand($from)
    {
        $message = '*GAGAL!*
Silahkan isi command dengan benar.

Berikut Command yang bisa Anda gunakan:
#layanan [id layanan]
#status [id pesanan]
#profil

*Keterangan:*
#layanan = Untuk check detail Layanan
#status = Untuk check detail Pesanan Anda
#profil = Untuk check detail Akun Anda';

        $this->lib->sendMessage($from, $message);
    }
    public function dana()
    {
        log_message('error', date('Y-m-d H:i:s'));

        if (!empty($_GET)) {
            log_message('error', print_r($_GET, true));

            $name = trim($_GET['name'] ?? '');
            $package = trim($_GET['pkg'] ?? '');
            $message = trim($_GET['text'] ?? '');
            $signature = trim($_GET['sign'] ?? '');

            if (!$name || !$package || !$message || !$signature) {
                echo "Gagal Parameter";
            } else {
                $private_signature = "h3ruc0d3";
                if (strtolower($name) != "dana" || strtolower($package) != "id.dana") {
                    echo "Gagal Package";
                } else if ($signature != $private_signature) {
                    echo "Gagal Signature";
                } else {
                    // Perbarui ekspresi reguler untuk sesuai dengan format pesan yang diberikan
                    if (preg_match("/baru saja Kirim DANA ke kamu Rp/i", $message)) {

                        // Lanjutkan dengan proses pengolahan deposit
                        $data_deposit = $this->deposit_model->get_rows(['where' => [['deposit_method_id' => '33', 'status' => 'Pending']]]);
                        if ($data_deposit) {
                            foreach ($data_deposit as $key => $deposit) {
                                $saldo_awal = $this->user_model->get_by_id($deposit['user_id']);
                                $jumlah_deposit = currency($deposit['amount']);
                                $cek_deposit = number_format($jumlah_deposit, 0, ',', '');
                                if (preg_match("/baru saja Kirim DANA ke kamu Rp$jumlah_deposit/i", $message)) {
                                    if ($deposit['status'] == 'Pending') {
                                        $this->deposit_model->update([
                                            'status' => 'Success',
                                            'updated_at' => date('Y-m-d H:i:s'),
                                        ], ['amount' => $deposit['amount']]);
                                        $user = $this->user_model->get_by_id($deposit['user_id']);
                                        if ($user) {
                                            $this->user_model->update([
                                                'balance' => $user->balance + $deposit['balance'],
                                            ], ['id' => $user->id]);
                                            $this->log_balance_usage_model->insert([
                                                'user_id' => $user->id,
                                                'type' => 'plus',
                                                'category' => 'deposit',
                                                'amount' => $deposit['balance'],
                                                'description' => 'Deposit #' . $deposit['id'] . '.',
                                                'before' => $saldo_awal->balance,
                                                'after' => $saldo_awal->balance + $deposit['balance'],
                                                'created_at' => date('Y-m-d H:i:s')
                                            ]);
                                            echo "Berhasil. Deposit #" . $deposit['id'] . " - Rp " . $jumlah_deposit . " di konfirmasi";
                                        } else {
                                            echo "Gagal mendapatkan data pengguna";
                                        }
                                    } else {
                                        echo "Gagal, status deposit bukan Pending";
                                    }
                                } else {
                                    echo "Deposit tidak dapat ditemukan";
                                }
                            }
                        } else {
                            echo "Gagal mendapatkan data deposit";
                        }
                    } else {
                        echo "Pesan tidak dapat ditemukan";
                    }
                }
            }
        } else {
            echo "Gagal, tidak ada data GET";
        }
    }


    public function ovo()
    {
        log_message('error', date('Y-m-d H:i:s'));

        if ($_GET) {
            log_message('error', print_r($_GET, true));

            $name = trim($_GET['name'] ?? '');
            $package = trim($_GET['pkg'] ?? '');
            $message = trim($_GET['text'] ?? '');
            $signature = trim($_GET['sign'] ?? '');

            if (!$name || !$package || !$message || !$signature) {
                echo "Gagal Parameter";
            } else {
                $private_signature = "h3ruc0d3";
                if (strtolower($name) != "ovo" || strtolower($package) != "ovo.id") {
                    echo "Gagal Package";
                } else if ($signature != $private_signature) {
                    echo "Gagal Signature";
                } else {
                    // Perbarui ekspresi reguler untuk sesuai dengan format pesan yang diberikan
                    if (preg_match("/mengirimkan dana sebesar Rp/i", $message)) {

                        // Lanjutkan dengan proses pengolahan deposit
                        // $deposit = $this->deposit_model->get_row(['deposit_method_id' => '37', 'status' => 'Pending']);
                        $data_deposit = $this->deposit_model->get_rows(['where' => [['deposit_method_id' => '37', 'status' => 'Pending']]]);
                        if ($data_deposit) {
                            foreach ($data_deposit as $key => $deposit) {
                                $saldo_awal = $this->user_model->get_by_id($deposit['user_id']);
                                $jumlah_deposit = currency($deposit['amount']);

                                $cekpesan = preg_match("/mengirimkan dana sebesar Rp$jumlah_deposit/i", $message);
                                $cekpesan2 = preg_match("/mengirimkan dana sebesar Rp $jumlah_deposit/i", $message);
                                if ($cekpesan || $cekpesan2) {
                                    if ($deposit['status'] == 'Pending') {
                                        $this->deposit_model->update([
                                            'status' => 'Success',
                                            'updated_at' => date('Y-m-d H:i:s'),
                                        ], ['amount' => $deposit['amount']]);
                                        $user = $this->user_model->get_by_id($deposit['user_id']);
                                        if ($user) {
                                            $this->user_model->update([
                                                'balance' => $user->balance + $deposit['amount'],
                                            ], ['id' => $user->id]);
                                            $this->log_balance_usage_model->insert([
                                                'user_id' => $user->id,
                                                'type' => 'plus',
                                                'category' => 'deposit',
                                                'amount' => $deposit['amount'],
                                                'description' => 'Deposit #' . $deposit['id'] . '.',
                                                'before' => $saldo_awal->balance,
                                                'after' => $saldo_awal->balance + $deposit['amount'],
                                                'created_at' => date('Y-m-d H:i:s')
                                            ]);
                                            echo "Berhasil. Deposit #" . $deposit['id'] . " - Rp " . $jumlah_deposit . " di konfirmasi";
                                        } else {
                                            echo "Gagal mendapatkan data pengguna";
                                        }
                                    } else {
                                        echo "Gagal, status deposit bukan Pending";
                                    }
                                } else {
                                    echo "Deposit tidak dapat ditemukan";
                                }
                            }
                        } else {
                            echo "Gagal mendapatkan data deposit";
                        }
                    } else {
                        echo "Pesan tidak dapat ditemukan";
                    }
                }
            }
        } else {
            echo "Gagal, tidak ada data GET";
        }
    }

    public function gopay()
    {
        log_message('error', date('Y-m-d H:i:s'));

        if ($_GET) {
            log_message('error', print_r($_GET, true));

            $name = trim($_GET['name'] ?? '');
            $package = trim($_GET['pkg'] ?? '');
            $message = trim($_GET['text'] ?? '');
            $signature = trim($_GET['sign'] ?? '');

            if (!$name || !$package || !$message || !$signature) {
                echo "Gagal Parameter";
            } else {
                $private_signature = "h3ruc0d3";
                if (strtolower($name) != "gopay" || strtolower($package) != "com.gojek.gopay") {
                    echo "Gagal Package";
                } else if ($signature != $private_signature) {
                    echo "Gagal Signature";
                } else {
                    // Perbarui ekspresi reguler untuk sesuai dengan format pesan yang diberikan
                    if (preg_match("/transfer Rp/i", $message)) {

                        // Lanjutkan dengan proses pengolahan deposit
                        // $deposit = $this->deposit_model->get_row(['deposit_method_id' => '36', 'status' => 'Pending']);
                        $data_deposit = $this->deposit_model->get_rows(['where' => [['deposit_method_id' => '36', 'status' => 'Pending']]]);
                        if ($data_deposit) {
                            foreach ($data_deposit as $key => $deposit) {
                                $saldo_awal = $this->user_model->get_by_id($deposit['user_id']);
                                $jumlah_deposit = currency($deposit['amount']);
                                $cekpesan = strtolower(preg_match("/transfer Rp$jumlah_deposit/i", $message));
                                if ($cekpesan) {
                                    if ($deposit['status'] == 'Pending') {
                                        $this->deposit_model->update([
                                            'status' => 'Success',
                                            'updated_at' => date('Y-m-d H:i:s'),
                                        ], ['amount' => $deposit['amount']]);
                                        $user = $this->user_model->get_by_id($deposit['user_id']);
                                        if ($user) {
                                            $this->user_model->update([
                                                'balance' => $user->balance + $deposit['balance'],
                                            ], ['id' => $user->id]);
                                            $this->log_balance_usage_model->insert([
                                                'user_id' => $user->id,
                                                'type' => 'plus',
                                                'category' => 'deposit',
                                                'amount' => $deposit['balance'],
                                                'description' => 'Deposit #' . $deposit['id'] . '.',
                                                'before' => $saldo_awal->balance,
                                                'after' => $saldo_awal->balance + $deposit['balance'],
                                                'created_at' => date('Y-m-d H:i:s')
                                            ]);
                                            echo "Berhasil. Deposit #" . $deposit['id'] . " - Rp " . $jumlah_deposit . "di konfirmasi";
                                        } else {
                                            echo "Gagal mendapatkan data pengguna";
                                        }
                                    } else {
                                        echo "Gagal, status deposit bukan Pending";
                                    }
                                } else {
                                    echo "Deposit tidak dapat ditemukan";
                                }
                            }
                        } else {
                            echo "Gagal mendapatkan data deposit";
                        }
                    } else {
                        echo "Pesan tidak dapat ditemukan";
                    }
                }
            }
        } else {
            echo "Gagal, tidak ada data GET";
        }
    }
    public function seabank()
    {
        log_message('error', date('Y-m-d H:i:s'));

        if ($_GET) {
            log_message('error', print_r($_GET, true));

            $name = trim($_GET['name'] ?? '');
            $package = trim($_GET['pkg'] ?? '');
            $message = trim($_GET['text'] ?? '');
            $signature = trim($_GET['sign'] ?? '');

            if (!$name || !$package || !$message || !$signature) {
                echo "Gagal Parameter";
            } else {
                $private_signature = "h3ruc0d3";
                if (strtolower($name) != "seabank" || strtolower($package) != "id.co.bankbkemobile.digitalbank") {
                    echo "Gagal Package";
                } else if ($signature != $private_signature) {
                    echo "Gagal Signature";
                } else {
                    // Perbarui ekspresi reguler untuk sesuai dengan format pesan yang diberikan
                    if (preg_match("/Kamu menerima transfer saldo senilai Rp/i", $message)) {

                        // Lanjutkan dengan proses pengolahan deposit
                        // $deposit = $this->deposit_model->get_row(['deposit_method_id' => '36', 'status' => 'Pending']);
                        $data_deposit = $this->deposit_model->get_rows(['where' => [['deposit_method_id' => '55', 'status' => 'Pending']]]);
                        if ($data_deposit) {
                            foreach ($data_deposit as $key => $deposit) {
                                $saldo_awal = $this->user_model->get_by_id($deposit['user_id']);
                                $jumlah_deposit = currency($deposit['amount']);
                                $cekpesan = strtolower(preg_match("/Kamu menerima transfer saldo senilai Rp$jumlah_deposit/i", $message));
                                if ($cekpesan) {
                                    if ($deposit['status'] == 'Pending') {
                                        $this->deposit_model->update([
                                            'status' => 'Success',
                                            'updated_at' => date('Y-m-d H:i:s'),
                                        ], ['amount' => $deposit['amount']]);
                                        $user = $this->user_model->get_by_id($deposit['user_id']);
                                        if ($user) {
                                            $this->user_model->update([
                                                'balance' => $user->balance + $deposit['balance'],
                                            ], ['id' => $user->id]);
                                            $this->log_balance_usage_model->insert([
                                                'user_id' => $user->id,
                                                'type' => 'plus',
                                                'category' => 'deposit',
                                                'amount' => $deposit['balance'],
                                                'description' => 'Deposit #' . $deposit['id'] . '.',
                                                'before' => $saldo_awal->balance,
                                                'after' => $saldo_awal->balance + $deposit['balance'],
                                                'created_at' => date('Y-m-d H:i:s')
                                            ]);
                                            echo "Berhasil. Deposit #" . $deposit['id'] . " - Rp " . $jumlah_deposit . "di konfirmasi";
                                        } else {
                                            echo "Gagal mendapatkan data pengguna";
                                        }
                                    } else {
                                        echo "Gagal, status deposit bukan Pending";
                                    }
                                } else {
                                    echo "Deposit tidak dapat ditemukan";
                                }
                            }
                        } else {
                            echo "Gagal mendapatkan data deposit";
                        }
                    } else {
                        echo "Pesan tidak dapat ditemukan";
                    }
                }
            }
        } else {
            echo "Gagal, tidak ada data GET";
        }
    }
    public function moota()
    {
        // Ambil data yang diterima dari body POST
        $payload = file_get_contents('php://input');

        // Ambil header
        $headers = getallheaders();

        // Ambil signature yang dikirimkan oleh Moota
        $signature = $headers['Signature'];

        // Secret yang digunakan untuk membuat signature
        $secret = 'W8QJGioB'; // Ganti dengan secret key yang Anda miliki

        // Hitung ulang signature menggunakan payload dan secret yang sama
        $calculatedSignature = hash_hmac('sha256', $payload, $secret);

        // Verifikasi signature
        if ($calculatedSignature === $signature) {
            // Signature valid, lanjutkan pemrosesan data
            $data = json_decode($payload, true);

            // Ambil nilai amount dari data
            $check_deposit = round($data[0]['amount']); // Mengambil jumlah deposit dari webhook moota

            $deposit = $this->deposit_model->get_row(['amount' => $check_deposit, 'status' => 'Pending', 'deposit_method_id' => '57']);
            if ($deposit) {

                // Cek saldo user sebelum ditambah
                $saldo_awal = $this->user_model->get_by_id($deposit->user_id);

                $this->deposit_model->update([
                    'status' => 'Success',
                    'updated_at' => date('Y-m-d H:i:s'),
                    'result_moota' => json_encode($data), // Ubah menjadi JSON untuk menyimpannya dalam database
                ], ['amount' => $deposit->amount]);

                $user = $this->user_model->get_by_id($deposit->user_id);
                if ($user !== false) {
                    $this->user_model->update([
                        'balance' => $user->balance + $deposit->balance,
                    ], ['id' => $user->id]);

                    $this->log_balance_usage_model->insert([
                        'user_id' => $user->id,
                        'type' => 'plus',
                        'category' => 'deposit',
                        'amount' => $deposit->balance,
                        'description' => 'Deposit #' . $deposit->id . '.',
                        'before' => $saldo_awal->balance,
                        'after' => $saldo_awal->balance + $deposit->balance,
                        'created_at' => date('Y-m-d H:i:s')
                    ]);

                    // Echo jika status deposit berhasil dengan keterangan ID deposit
                    echo "Status deposit dengan ID #" . $deposit->id . " berhasil diperbarui.";
                }
            }
            // Balas dengan status OK
            http_response_code(200);
            echo "Webhook berhasil diterima dan diverifikasi.";
        } else {
            // Signature tidak valid, abaikan atau tangani sesuai kebutuhan
            http_response_code(403); // Forbidden
            echo "Signature tidak valid.";
        }
    }
}
