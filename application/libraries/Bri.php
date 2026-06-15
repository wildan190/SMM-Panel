<?php
class BRI {
   const URL = "https://ib.bri.co.id/ib-bri/";

   /*****************************
   *      Constructor           *
   ******************************/
   function __construct($config=[]) {
      $this->username   = @$config['username'];
      $this->password   = @$config['password'];
      $this->account    = @$config['account'];
      $this->date_start = @$config['date_start'];
      $this->date_end   = @$config['date_end'];
   }
   


   /*****************************
   *      Fungsi Grab URL       *
   ******************************/
   public function grab($url, $par=null, $head=[]){
      $ch = curl_init();
      $options = array(
         CURLOPT_URL            => $url,
         CURLOPT_USERAGENT      => "okhttp/3.11.0",
         CURLOPT_RETURNTRANSFER => 1,
         CURLOPT_FOLLOWLOCATION => 1,
         CURLOPT_HEADER         => 1,
         CURLOPT_SSL_VERIFYPEER => 0,
         CURLOPT_TIMEOUT        => "30",
         CURLOPT_HTTPHEADER     => $head,
         CURLOPT_COOKIEFILE     => dirname(__FILE__)."/bri_".md5($this->username).".txt",
         CURLOPT_COOKIEJAR      => dirname(__FILE__)."/bri_".md5($this->username).".txt"
      );

      if(isset($par)) $options[CURLOPT_POSTFIELDS] = $par;
      curl_setopt_array($ch, $options);
         
      $response  = curl_exec($ch);
      $head_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
      $head = substr($response, 0, $head_size);
      $body = substr($response, $head_size);
      $head = $this->getHeaders($head);
      curl_close($ch);

      return array(
         "head" => $head,
         "body" => $body
      );
   }



   /*****************************
   *   Get Text diantara Text   *
   ******************************/
   public function get_area($content, $start, $end){
      $exp = @explode($start, $content);
      $exp = @explode($end, $exp[1]);
      $exp = @$exp[0];
      return $exp;
   }



   /*****************************
   *    Fungsi Get Headers      *
   ******************************/
   public function getHeaders($respHeaders) {
      $headers = array();
      $headerText = substr($respHeaders, 0, strpos($respHeaders, "\r\n\r\n"));
      foreach (explode("\r\n", $headerText) as $i => $line) {
         if($i === 0){
            $headers['http_code'] = $line;
         }else{
            list ($key, $value) = explode(': ', $line);
            if(!isset($headers[$key])){
               $headers[$key] = $value;
            }else{
               $headers[$key] .= ";$value";
            }
         }
      }
      return $headers;
   }



   /*********************************
   *  Validasi data sebelum dikirim *
   *********************************/
   function paramValidation(){
      if($this->username == ""){
         $error = "Username harus diisi";
      }elseif($this->password == ""){
         $error = "Password harus diisi";
      }elseif($this->account == ""){
         $error = "Nomor rekening harus diisi";
      }elseif($this->date_start == ""){
         $error = "Tanggal mulai harus diisi";
      }elseif($this->date_end == ""){
         $error = "Tanggal akhir harus diisi";
      }else{
         $time_start = strtotime($this->date_start);
         $time_end   = strtotime($this->date_end);
         $time_limit = time()-31*24*60*60;

         if($time_start > $time_end){
            $error = "Tanggal mulai tidak boleh melebihi tanggal akhir";
         }
      }

      if(!isset($error)){
         return [
            'status'  => 'success',
            'message' => 'Parameter valid'
         ];
      }else{
         return [
            'status'  => 'error',
            'message' => $error
         ];
      }
   }


   
   /***************************
   *    HTML Dom & Xpath      *
   ****************************/
   public function dom($html){
      @$dom = new domDocument;
      @$dom->loadHTML($html);
      @$dom->preserveWhiteSpace = false;
      $xpath = new DomXpath($dom);
      return $xpath;
   }



   /***************************
   *  Mendapatkan CSRF token  *
   ****************************/
   function getCSRF(){
      $url = self::URL."Login.html";
      $get = $this->grab($url);
      $dom = $this->dom($get['body']);
      $sel = $dom->query('//input[contains(@name,"csrf_token_newib")]');

      if($sel->length == 1){
         return [
            'status' => 'success',
            'token'  => $sel[0]->attributes[2]->value
         ];
      }else{
         return [
            'status'  => 'error',
            'message' => 'Gagal mendapatkan CSRF token'.$get['body']
         ];
      }  
   }



   /***************************
   *  Get & Bypass Captcha  *
   ****************************/
   function getCaptcha(){
      $url = self::URL."login/captcha";
      $get = $this->grab($url);
      $ocr = new imageOCR;

      $bypass = $ocr->bypass("string", $get['body']);
      return $bypass;
   }



   /******************
   *  Fungsi Logout  *
   *******************/
   function logout(){
      $url = self::URL."Logout.html";
      $this->grab($url);
      return;
   }



   /*****************
   *  Fungsi login  *
   ******************/
   function login(){
      $csrf = $this->getCSRF();
      if($csrf['status'] == 'error'){
         $error = $csrf['message'];
      }else{
         $captcha = $this->getCaptcha();
         if($captcha['status'] == 'error'){
            $error = $captcha['reason'];
         }
      }



      if(isset($captcha['result'])){
         $url = self::URL."Homepage.html";
         $par = [
            'csrf_token_newib' => $csrf['token'],
            'j_password'       => $this->password,
            'j_username'       => $this->username,   
            'preventAutoPass'  => '',
            'j_code'           => $captcha['result'],
            'j_language'       => 'in_ID'
         ];
         $get = $this->grab($url, http_build_query($par));

         if(!substr_count($get['body'], 'Logout.html')){
            $dom = $this->dom($get['body']);
            $sel = $dom->query('//h2[contains(@class,"errorresp")]');

            if($sel->length > 0){
               $error = $sel[0]->nodeValue;
            }else{
               $error = "Login gagal";
            } 
         }
      }
      
      if(!isset($error)){
         return[
            'status'  => 'success',
            'message' => 'Login berhasil'
         ];
      }else{
         return[
            'status'  => 'error',
            'message' => $error
         ];
      }
   }



   /********************************
   *   Mendapatkan List Rekening   *
   *********************************/
   public function getAccountList(){
      $url = self::URL.'AccountStatement.html';
      $get = $this->grab($url);
      $dom = $this->dom($get['body']);
      $sel = $dom->query('//select[contains(@id,"ACCOUNT_NO")]');

      if($sel->length == "1"){
         $accounts = [];
         foreach($sel[0]->childNodes as $acc){
            if(isset($acc->tagName)){
               if($acc->tagName == 'option'){
                  if($acc->attributes[0]->value != ""){
                     $accounts[] = $acc->attributes[0]->value;
                  }
               }
            }
         }
         if(count($accounts) == 0){
            $error = "Gagal mendapatkan list rekening";
         }
      }else{
         $error = "Gagal mendapatkan list rekening";
      }

      if(!isset($error)){
         $sel = $dom->query('//input[contains(@name,"csrf_token_newib")]');
         if($sel->length == 1){
            $token = $sel[0]->attributes[2]->value;
         }else{
            $error = "Gagal mendapatkan CSRF token #2";
         }
      }

      if(!isset($error)){
         return[
            'status' => 'success',
            'token' => $token,
            'accounts' => $accounts
         ];
      }else{
         return[
            'status'  => 'error',
            'message' => $error
         ];
      }     
   }



   /*******************************************************
   *   Fungsi untuk mendapatkan mutasi dalam bentuk raw   *
   ********************************************************/
   public function getRawMutation($csrf){
      $url = self::URL.'Br11600d.html';
      $par = [
         'csrf_token_newib' => $csrf,
         'FROM_DATE' => date('Y-m-d', strtotime($this->date_start)),
         'TO_DATE'	=> date('Y-m-d', strtotime($this->date_end)),
         'download'	=> '',
         'ACCOUNT_NO' => $this->account,
         'VIEW_TYPE'	=> '2',
         'DDAY1'  => date('d', strtotime($this->date_start)),
         'DMON1'  => date('m', strtotime($this->date_start)),
         'DYEAR1' => date('Y', strtotime($this->date_start)),
         'DDAY2'  => date('d', strtotime($this->date_end)),
         'DMON2'  => date('d', strtotime($this->date_end)),
         'DYEAR2'	=> date('Y', strtotime($this->date_end)),
         'MONTH'  => date('m'),
         'YEAR'	=> date('Y'),
         'submitButton' =>	'Tampilkan'
      ];
      $get = $this->grab($url, http_build_query($par));
      $dom = $this->dom(str_replace('&nbsp;', '', $get['body']));
      $sel = $dom->query('//table[contains(@id,"tabel-saldo")]');
      if($sel->length != 0){
         $list = [];
         foreach($sel[0]->childNodes[3]->childNodes as $key => $trx){
            if($key > 2 AND $key){
               if(isset($trx->tagName)){
                  if(trim($trx->childNodes[1]->nodeValue) != ""){
                     $date   = @trim($trx->childNodes[1]->nodeValue);
                     $desc   = @trim($trx->childNodes[3]->nodeValue);
                     $debit  = @trim($trx->childNodes[5]->nodeValue);
                     $credit = @trim($trx->childNodes[7]->nodeValue);

                     //reformat date
                     $date_d = substr($date, 0, 2);
                     $date_m = substr($date, 3, 2);
                     $date_y = substr($date, 6, 2);
                     $date   = "20{$date_y}/{$date_m}/{$date_d}";
                    
                     $list[] = [
                        'amount' => $debit != "" ? $this->formatBalance($debit) : $this->formatBalance($credit),
                        'type'   => $debit != "" ? "Debit" : "Credit",
                        'date'   => $date,
                        'desc'   => $desc,
                     ];
                  }
               }
            }
         }
         $dom2 = $this->dom($get['body']);
         $sel2 = $dom2->query('//table[contains(@class,"info1 rekkor")]');
         $holder = @trim($sel2[0]->childNodes[1]->childNodes[3]->nodeValue);
      }else{
         $sel = $dom->query('//h2[contains(@class,"errorresp")]');
         if($sel->length > 0){
            $error = $sel[0]->nodeValue;
         }else{
            $error = "Gagal mendapatkan mutasi";
         } 
      }

      if(!isset($error)){
         return[
            'status' => 'success',
            'holder' => $holder,
            'data' => $list
         ];

      }else{
         return[
            'status'  => 'error',
            'message' => $error
         ];
      }  
   }

   /*********************************
   *   Mendapatkan informasi saldo  *
   **********************************/
   public function getBalance(){
      $url = self::URL."BalanceInquiry.html";
      $get = $this->grab($url);
      $dom = $this->dom($get['body']);
      $sel = $dom->query('//tbody');
      foreach($sel[0]->childNodes as $data){
         if(substr_count($data->textContent, $this->account)){
            $balance = trim($data->childNodes[11]->textContent);
            $balance = str_replace("\u{00a0}", '', $balance);
         }
      }

      if(isset($balance)){
         return[
            'status' => 'success',
            'balance' => $this->formatBalance($balance)
         ];

      }else{
         return[
            'status'  => 'error',
            'message' => 'Gagal cek saldo, nomor rekening tidak ditemukan'
         ];
      }  
   }



   /**********************************
   *  Format ulang penulisan nominal *
   ***********************************/ 
   public function formatBalance($balance){
      $balance = str_replace(".", "", $balance);
      $balance = str_replace(",", ".", $balance);
      return $balance;
   }



   /**************************************
   *   Fungsi untuk mendapatkan mutasi   *
   ***************************************/
   function getMutation(){
      $valid = $this->paramValidation();
      if($valid['status'] == 'success'){
         $login = $this->login();
         if($login['status'] == 'success'){
            $balance = $this->getBalance();
            if($balance['status'] == "success"){
               $accounts = $this->getAccountList();
               if($accounts['status'] == 'success'){
                  if(in_array($this->account, $accounts['accounts'])){
                     $mutation = $this->getRawMutation($accounts['token']);
                        if($mutation['status'] == 'success'){
                           //success
                        }else{
                           $error = $mutation['message'];
                        }
                  }else{
                     $error = "Nomor rekening tidak ditemukan";
                  }
               }else{
                  $error = $accounts['message'];
               }
            }else{
               $error = $balance['message'];
            }
            $this->logout();
         }else{
            $error = $login['message'];
         }
      }else{
         $error = $valid['message'];
      }

      if(!isset($error)){
         return [
            'status'  => 'success',
            'message' => 'berhasil mendapatkan data mutasi',
            'data' => [
               'summary' => [
                  'account_holder' => $mutation['holder'],
                  'account_number' => $this->account,
                  'balance' => $balance['balance']
               ],
               'transactions' => $mutation['data']
            ]
         ];
      }else{
         return [
            'status'  => 'error',
            'message' => $error
         ];
      }
   }

   

}



include('imageOCR.php');

