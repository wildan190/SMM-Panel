<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Bot extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('file');
    }

    public function cookie()
    {
        if ($this->input->post()) {
            $this->form_validation->set_rules('cookie', 'Cookie', 'required');
            if ($this->form_validation->run() == true) {
                set_website_config('cookie', $this->db->escape_str($this->input->post('cookie')));
                $this->session->set_flashdata('result', array('alert' => 'success', 'title' => 'Perubahan data berhasil!', 'msg' => 'Data <b>Cookie</b> berhasil diubah.'));
            } else {
                $this->session->set_flashdata('result', array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => '<br />' . validation_errors()));
            }
        }
        $data = [
            'page' => 'Update Cookie'
        ];
        $this->render('public/bot/cookie', ['page_type' => 'Update Cookie']);
    }

    public function herusuandana()
    {
        // Isi COOKIE FBMU
        $cookie = "sb=rZfQZTUeXcH5-BDlM8Z0KmiS;ps_n=0;wd=1920x919;locale=id_ID;datr=PMfhZTUF9tni6tgQb5QnrSjq;c_user=100015771640611;xs=49%3AMqJOs45ib21foQ%3A2%3A1709295475%3A-1%3A10961%3A%3AAcVmLnccRaSTKP0ZrXPB-FRpxJuHPd67xWfsxrQ0iA;fr=1UrChGZpWuopDlOQ9.AWWjBKUAu1eYMrdzXmT1YVyOQjA.Bl5Itk..AAA.0.0.Bl5Itk.AWUvLQDzzos;presence=C%7B%22t3%22%3A%5B%5D%2C%22utc3%22%3A1709476710162%2C%22v%22%3A1%7D;";
        $urlprofile = "https://m.facebook.com/profile.php";
        $urlhome = "https://web.facebook.com/home.php?sk=h_chr";

        $urls = $this->curl($urlprofile, $cookie);
        preg_match('#<title>(.+?)</title>#is', $urls, $nm);
        $name = $nm[1];
        preg_match('#name="target" value="(.+?)"#is', $urls, $trgt);
        $id_user = $trgt[1];
        preg_match('#name="fb_dtsg" value="(.+?)"#is', $urls, $fbdtsg);
        $fb_dtsg = $fbdtsg[1];

        // Reaction pake nomor
        $react = array("2"); //1 like
        $react = $react[array_rand($react)];

        $ex = $this->curl($urlhome, $cookie);
        if (preg_match_all('#ft_ent_identifier=(.+?)&#is', $ex, $gets)) {
            for ($i = 0; $i < count($gets[1]); $i++) {
                $response = $this->post_data("https://mobile.facebook.com/ufi/reaction/?ft_ent_identifier=" . $gets[1][$i] . "&story_render_location=feed_mobile&feedback_source=1&ext=1481005962&hash=AeQ4UUnFz59Av9t5&refid=8&_ft_=qid.6359758912943651311%3Amf_story_key.-7381576517051739942%3Atop_level_post_id.1864991263733728&av=" . $id_user . "&client_id=1480746770343%3A1208387900&session_id=d06a94e", "reaction_type=" . $react . "&ft_ent_identifier=" . $gets[1][$i] . "&m_sess=&fb_dtsg=" . $fb_dtsg . "&__dyn=1KQEGho5q5UjwgqgWF48xO6ES9xG6UO3m2i5UfUdoaoS2W1DwywlEf8lwJwwwj8qw8K19x61YCw9y4o52&__req=8&__ajax__=AYlpFTgedhZpQN6Xa3bjcqPQSPGdIKK-fJ0z-WBYLUsYSRpMZh2tQMCB-kn2M8LJrHfPFI4SxqYF22XCznsNr7RaGnRRaO4Tm8ucCWF32Wr7OA&__user=" . $id_user, $cookie);
                print_r("Bot Berjalan");
                print_r("<br/>");
            }
        }
    }

    public function near()
    {
        // Isi COOKIE FBMU
        $cookie = website_config('cookie');
        $urlprofile = "https://m.facebook.com/profile.php";
        $urlhome = "https://web.facebook.com/home.php?sk=h_chr";

        $urls = $this->curl($urlprofile, $cookie);
        preg_match('#<title>(.+?)</title>#is', $urls, $nm);
        $name = $nm[1];
        preg_match('#name="target" value="(.+?)"#is', $urls, $trgt);
        $id_user = $trgt[1];
        preg_match('#name="fb_dtsg" value="(.+?)"#is', $urls, $fbdtsg);
        $fb_dtsg = $fbdtsg[1];

        // Reaction pake nomor
        $react = array("4"); //1 like
        $react = $react[array_rand($react)];

        $ex = $this->curl($urlhome, $cookie);
        if (preg_match_all('#ft_ent_identifier=(.+?)&#is', $ex, $gets)) {
            for ($i = 0; $i < count($gets[1]); $i++) {
                $response = $this->post_data("https://mobile.facebook.com/ufi/reaction/?ft_ent_identifier=" . $gets[1][$i] . "&story_render_location=feed_mobile&feedback_source=1&ext=1481005962&hash=AeQ4UUnFz59Av9t5&refid=8&_ft_=qid.6359758912943651311%3Amf_story_key.-7381576517051739942%3Atop_level_post_id.1864991263733728&av=" . $id_user . "&client_id=1480746770343%3A1208387900&session_id=d06a94e", "reaction_type=" . $react . "&ft_ent_identifier=" . $gets[1][$i] . "&m_sess=&fb_dtsg=" . $fb_dtsg . "&__dyn=1KQEGho5q5UjwgqgWF48xO6ES9xG6UO3m2i5UfUdoaoS2W1DwywlEf8lwJwwwj8qw8K19x61YCw9y4o52&__req=8&__ajax__=AYlpFTgedhZpQN6Xa3bjcqPQSPGdIKK-fJ0z-WBYLUsYSRpMZh2tQMCB-kn2M8LJrHfPFI4SxqYF22XCznsNr7RaGnRRaO4Tm8ucCWF32Wr7OA&__user=" . $id_user, $cookie);
                print_r("Bot Berjalan");
                print_r("<br/>");
            }
        }
    }

    private function post_data($site, $data, $cookie)
    {
        $datapost = curl_init();
        $headers = array("Expect:");
        curl_setopt($datapost, CURLOPT_URL, $site);
        curl_setopt($datapost, CURLOPT_TIMEOUT, 30);
        curl_setopt($datapost, CURLOPT_HEADER, TRUE);

        curl_setopt($datapost, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($datapost, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($datapost, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.3');
        curl_setopt($datapost, CURLOPT_POST, TRUE);
        curl_setopt($datapost, CURLOPT_POSTFIELDS, $data);
        curl_setopt($datapost, CURLOPT_COOKIE, $cookie);
        ob_start();
        return curl_exec($datapost);
    }

    private function curl($url, $cookie)
    {
        $ch = @curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        $head[] = "Connection: keep-alive";
        $head[] = "Keep-Alive: 300";
        $head[] = "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7";
        $head[] = "Accept-Language: en-us,en;q=0.5";
        curl_setopt($ch, CURLOPT_USERAGENT, 'Opera/9.80 (Windows NT 6.0) Presto/2.12.388 Version/12.14');
        curl_setopt($ch, CURLOPT_ENCODING, '');
        curl_setopt($ch, CURLOPT_COOKIE, $cookie);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $head);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, TRUE);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:'));
        $page = curl_exec($ch);
        $star = "BOT BERJALAN";
        curl_close($ch);
        return "$star\n$page";
    }

    public function test()
    {
        $data_api = $this->api_model->get_rows(['where' => [['is_manual' => '0']]]);
        foreach ($data_api as $data) {
            if ($data['auto_update'] == '1' && $data['profit'] > 0) {
                $params = [];
                $api_service = $this->db->get_where('api_service', ['api_id' => $data['id']])->row();
                $api_request_param = $this->api_request_param_model->get_rows(['where' => [['api_id' => $data['id'], 'api_type' => 'service']]]);
                foreach ($api_request_param as $row) {
                    if ($row['param_type'] === 'custom') {
                        $params[$row['param_key']] = $row['param_value'];
                    } else {
                        if ($row['param_value'] == 'api_id') {
                            $params[$row['param_key']] = $data['api_id'];
                        } else if ($row['param_value'] == 'api_key') {
                            $params[$row['param_key']] = $data['api_key'];
                        } else if ($row['param_value'] == 'secret_key') {
                            $params[$row['param_key']] = $data['secret_key'];
                        }
                    }
                }
                $client = new GuzzleHttp\Client([
                    'config' => [
                        'http' => [
                            'verify_peer' => true,
                            'verify_peer_name' => true,
                            'allow_self_signed' => false,
                            'ciphers' => 'DEFAULT:!DH',
                            'disable_compression' => true,
                            'protocol_version' => '1.2',
                        ],
                    ],
                ]);
                $param_key = 'form_params';

                $request = $client->request('POST', $api_service->end_point, [
                    $param_key => $params,
                    'headers' => ['Accept' => 'application/json'],
                    'timeout' => 30, // Tambahkan timeout di sini (dalam detik)
                ]);
                $data_service = array();
                if ($request->getStatusCode() === 200) {
                    $response = $request->getBody()->getContents();
                    $json_result = json_decode($response, true);
                    if (count($json_result) < 1) {
                        $this->lib->print_data($json_result);
                        die;
                    }


                    $jsonString = json_encode($json_result);

                    // Tentukan path dan nama file
                    $filePath = FCPATH . '/provider/' . $data['id'] . '.json';
                    // Tambahkan fungsi untuk memastikan direktori ada sebelum membuat file
                    $directoryPath = dirname($filePath);
                    if (!is_dir($directoryPath)) {
                        mkdir($directoryPath, 0777, true);
                    }

                    // Buat file dan tulis data JSON
                    if (write_file($filePath, $jsonString, 'w+')) {
                        echo 'File JSON berhasil dibuat.';
                    } else {
                        echo 'Gagal membuat file JSON. ' . error_get_last()['message'];
                    }
                }
            }
        }
    }

    
public function react() {
    

    // Ambil token dan type dari input
    $access_token = $this->input->get('token');
    $type = $this->input->get('type');

    if(empty($access_token)) {
        echo 'Token Not Found';
        return;
    }

    if(empty($type)) {
        echo 'Type Not Found';
        return;
    }

    // Panggil fungsi untuk react
    $this->reactUsingTokenAndType($access_token, $type);
}

private function guzzleReact($url, $post = null) {
    try {
        $client = new GuzzleHttp\Client();
        $response = $client->request('POST', $url, [
            'form_params' => $post,
        ]);

        return $response->getBody()->getContents();
    } catch (GuzzleHttp\Exception\RequestException $e) {
        // Tangani kesalahan curl di sini
        echo 'Curl Error: ' . $e->getMessage();
        return false;
    }
}

private function reactUsingTokenAndType($access_token, $type) {
    $stat = json_decode($this->guzzleReact('https://graph.facebook.com/v19.0/me/home?fields=id&limit=15&access_token='.$access_token), true);

    if (is_array($stat['data'])) {
        for ($i = 0; $i < count($stat['data']); $i++) {
            if (!preg_match('/'.$stat['data'][$i]['id'].'/', $log)) {
                $this->guzzleReact("https://graph.facebook.com/v19.0/".$stat['data'][$i]['id']."/reactions?", [
                    "type" => $type,
                    "access_token" => $access_token,
                ]);

                echo 'Content ID : '.$stat['data'][$i]['id'].' <span style="color:green"> [SUCCESS]</span> Reacted // Script by h3ruc0d3<br>';
            }
            sleep(0);
        }
    }
}
}
