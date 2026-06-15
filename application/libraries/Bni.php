<?php
class BNI {
   const URL = "https://ibank.bni.co.id/MBAWeb/FMB";

   const DEFAULT_HEADER = [
      'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/93.0.4577.82 Safari/537.36',
      'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9',
      'Accept-Language: en-US,en;q=0.9',
   ];


   /*****************************
   *      Constructor           *
   ******************************/
   function __construct($config=[]) {
      $this->username   = @$config['username'];
      $this->password   = @$config['password'];
      $this->account    = @$config['account'];
      $this->date_start = @$config['date_start'];
      $this->date_end   = @$config['date_end'];
      $this->cookie     = null;
      $this->mbparam    = null;
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
         CURLOPT_HTTPHEADER     => $head
      );

      if(isset($par)) $options[CURLOPT_POSTFIELDS] = $par;
      curl_setopt_array($ch, $options);
         
      $response  = curl_exec($ch);
      $head_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
      $head = substr($response, 0, $head_size);
      $body = substr($response, $head_size);
      curl_close($ch);
      return array(
         "head" => $this->getHeaders($head),
         "body" => $body
      );
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
            $headers[$key] = $value;
         }
      }
      return $headers;
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



   /*****************************
   *   Fungsi Get Link Login    *
   ******************************/
   public function getLoginUrl(){
      $url = self::URL;
      $hdr = self::DEFAULT_HEADER;
      $get = $this->grab($url, null, $hdr);
      $dom = $this->dom($get['body']);
      $cut = $dom->query('//a[contains(@class,"lgnaln")]');
      $this->cookie = @$get['head']['Set-Cookie'];

      if(isset($cut[0]->attributes[2]->value)){
         return [
            'status' => 'success',
            'link'   => $cut[0]->attributes[2]->value
         ];
      }else{
         return [
            'status' => 'error',
            'link'   => 'Gagal mendapatkan link login'
         ];
      }
   }



   /********************
   *   Fungsi Login    *
   *********************/
   function login($url){
      $par  = "Num_Field_Err=%22Please+enter+digits+only%21%22&Mand_Field_Err=%22Mandatory+field+is+empty%21%22";
      $par .= "&CorpId={$this->username}&PassWord={$this->password}&__AUTHENTICATE__=Login&CancelPage=HomePage.xml";
      $par .= "&USER_TYPE=1&MBLocale=bh&language=bh&AUTHENTICATION_REQUEST=True&__JS_ENCRYPT_KEY__=&JavaScriptEnabled=N";
      $par .= "&deviceID=&machineFingerPrint=&deviceType=&browserType=&uniqueURLStatus=disabled&imc_service_page=SignOnRetRq";
      $par .= "&Alignment=LEFT&page=SignOnRetRq&locale=en&PageName=Thin_SignOnRetRq.xml&formAction={$url}&mConnectUrl=FMB&serviceType=Dynamic";

      $hdr = self::DEFAULT_HEADER;
      $hdr[] = "Cookie: {$this->cookie}";
      
      $get = $this->grab($url, $par, $hdr);
      $dom = $this->dom($get['body']);
      $cut = $dom->query('//span[contains(@class, "clsMConError")]');
      $this->cookie = @$get['head']['Set-Cookie'];

      if(substr_count($get['body'], 'Login Terakhir') > 0){
         //login sukses
         $mb = $dom->query('//input[contains(@id,"mbparam")]');
         $this->mbparam = @$mb[0]->attributes[3]->nodeValue;
      }elseif(isset($cut[0]->nodeValue)){
         $error = $cut[0]->nodeValue;
      }else{
         $error = "Login gagal";
      }

      if(!isset($error)){
         return [
            'status'  => 'success',
            'message' => 'Login sukses'
         ];
      }else{
         return [
            'status'  => 'error',
            'message' => $error
         ];
      }
   }



   /********************
   *   Fungsi Logout   *
   *********************/
   function logout($url){
      $hdr = self::DEFAULT_HEADER;
      $hdr[] = "Cookie: {$this->cookie}";
      $hdr[] = "Referer: $url";

      $par  = "Num_Field_Err=%22Please+enter+digits+only%21%22&Mand_Field_Err=%22Mandatory+field+is+empty%21%22";
      $par .= "&__LOGOUT__=Keluar&mbparam={$this->mbparam}&uniqueURLStatus=disabled&imc_service_page=SignOffUrlRq";
      $par .= "&Alignment=LEFT&page=SignOffUrlRq&locale=bh&PageName=LoginRs&formAction={$url}&mConnectUrl=FMB&serviceType=Dynamic";
      $get  = $this->grab($url, $par, $hdr);

      if(substr_count($get['body'], 'Anda telah berhasil keluar')){
         return [
            'status'  => 'success',
            'message' => 'Anda berhasil logout'
         ];
      }else{
         return [
            'status'  => 'error',
            'message' => 'Mengalami masalah saat lgout'
         ];
      }
   }



   /********************************
   *   Mendapatkan List Rekening   *
   *********************************/
   public function getAccountList($url){
      $hdr = self::DEFAULT_HEADER;
      $hdr[] = "Cookie: {$this->cookie}";
      $hdr[] = "Referer: $url";
      
      $url1 = "$url?page=BalanceInqRq&BBIDN=MM&mbparam={$this->mbparam}";
      $get1 = $this->grab($url1, null, $hdr);

      $dom1 = $this->dom($get1['body']);
      $mbp1 = $dom1->query('//input[contains(@id,"mbparam")]');
      $this->cookie = @$get1['head']['Set-Cookie'];

      if(isset($mbp1[0]->attributes[3]->nodeValue)){
         $this->mbparam = $mbp1[0]->attributes[3]->nodeValue;
         $par  = "Num_Field_Err=%22Please+enter+digits+only%21%22&Mand_Field_Err=%22Mandatory+field+is+empty%21%22";
         $par .= "&MAIN_ACCOUNT_TYPE=OPR&AccountIDSelectRq=Lanjut&AccountRequestType=ViewBalance&mbparam={$this->mbparam}";
         $par .= "&uniqueURLStatus=disabled&imc_service_page=AccountTypeSelectRq&Alignment=LEFT&page=AccountTypeSelectRq&locale=bh";
         $par .= "&PageName=BalanceInqRq&formAction={$url}&mConnectUrl=FMB&serviceType=Dynamic";

         $hdr[] = "Referer: $url1";
         $get = $this->grab($url, $par, $hdr);
         $dom = $this->dom($get['body']);
         $mbp = $dom->query('//input[contains(@id,"mbparam")]');
         $this->cookie = @$get['head']['Set-Cookie'];

         if(isset($mbp[0]->attributes[3]->nodeValue)){
            $this->mbparam = $mbp1[0]->attributes[3]->nodeValue;

            $dom = $this->dom($get['body']);
            $mbp = $dom->query('//input[contains(@id,"mbparam")]');
            if(isset($mbp[0]->attributes[3]->nodeValue)){
               $mbp1 = $dom->query('//input[contains(@name,"acc1")]');
               if($mbp1->length > 0){
                  $list = [];
                  foreach($mbp1 as $data){
                     $list[] = $data->attributes[3]->textContent;
                  }  
               }else{
                  $error =  'Gagal mendapatkan nomor rekening';
               }
            }else{
               $error = 'Gagal mendapatkan mbparam';
            }

         }else{
            $error = 'Gagal mendapatkan list no rekening';
         }
         
      }else{
         $error = 'Gagal mendapatkan mbparam';
      }

      if(!isset($error)){
         return [
            'status' => 'success',
            'data' => $list
         ];
      }else{
         return [
            'status'  => 'error',
            'message' => $error
         ];
      }
   }



   /********************************
   *  Mendapatkan informasi saldo  *
   *********************************/
   public function getBalance($url, $accountCode){
      $hdr = self::DEFAULT_HEADER;
      $hdr[] = "Cookie: {$this->cookie}";
      $hdr[] = "Referer: $url";

      $par  = "Num_Field_Err=%22Please+enter+digits+only%21%22&Mand_Field_Err=%22Mandatory+field+is+empty%21%22";
      $par .= "&acc1={$accountCode}&BalInqRq=Lanjut&MAIN_ACCOUNT_TYPE=OPR&mbparam={$this->mbparam}";
      $par .= "&uniqueURLStatus=disabled&imc_service_page=AccountIDSelectRq&Alignment=LEFT&page=AccountIDSelectRq";
      $par .= "&locale=bh&PageName=AccountTypeSelectRq&formAction={$url}&mConnectUrl=FMB&serviceType=Dynamic";
      $get  = $this->grab($url, $par, $hdr);
      $dom  = $this->dom($get['body']);
      $mbp  = $dom->query('//input[contains(@id,"mbparam")]');
      $this->cookie = @$get['head']['Set-Cookie'];

      if(isset($mbp[0]->attributes[3]->nodeValue)){
         $this->mbparam = $mbp[0]->attributes[3]->nodeValue;

         // get nomor rekening
         $mbp1 = $dom->query('//tr[contains(@id,"Row1_1")]');
         $exp1 = explode("\n", $mbp1[0]->nodeValue);

         //get nama pemilik rekening
         $mbp2 = $dom->query('//tr[contains(@id,"Row3_3")]');
         $exp2 = explode("\n", $mbp2[0]->nodeValue);

         //get total saldo
         $mbp3 = $dom->query('//tr[contains(@id,"Row5_5")]');
         $exp3 = explode("\n", $mbp3[1]->nodeValue);

         return [
            'status'  => 'success',
            'account' => trim($exp1[2]),
            'holder'  => trim($exp2[2]),
            'balance' => $this->formatBalance(trim($exp3[2]))
         ];

      }else{
         return [
            'status'  => 'error',
            'message' => 'Gagal mendapatkan saldo'
         ];
      }
      return $get;
   }



   /**********************************
   *  Format ulang penulisan nominal *
   ***********************************/ 
   public function formatBalance($balance){
      $balance = str_replace(".", "", $balance);
      $balance = str_replace(",", ".", $balance);
      $balance = str_replace("IDR ", "", $balance);
      return $balance;
   }



   /*******************************************************
   *   Fungsi untuk mendapatkan mutasi dalam bentuk raw   *
   ********************************************************/
   public function getRawMutation($url, $accountCode){
      $hdr = self::DEFAULT_HEADER;
      $hdr[] = "Cookie: {$this->cookie}";
      $hdr[] = "Referer: $url";

      $date_start = date("d-M-Y", strtotime($this->date_start));
      $date_end   = date("d-M-Y", strtotime($this->date_end));
      
      $par  = "Num_Field_Err=%22Please+enter+digits+only%21%22&Mand_Field_Err=%22Mandatory+field+is+empty%21%22";
      $par .= "&acc1={$accountCode}&TxnPeriod=-1&Search_Option=Date&txnSrcFromDate={$date_start}&txnSrcToDate={$date_end}";
      $par .= "&FullStmtInqRq=Lanjut&MAIN_ACCOUNT_TYPE=OPR&mbparam={$this->mbparam}&uniqueURLStatus=disabled";
      $par .= "&imc_service_page=AccountIDSelectRq&Alignment=LEFT&page=AccountIDSelectRq&locale=bh&PageName=AccountTypeSelectRq";
      $par .= "&formAction={$url}&mConnectUrl=FMB&serviceType=Dynamic";
      $get  = $this->grab($url, $par, $hdr);
      $dom  = $this->dom($get['body']);
      $mbp  = $dom->query('//input[contains(@id,"mbparam")]');

      $this->cookie = @$get['head']['Set-Cookie'];

      if(isset($mbp[0]->attributes[3]->nodeValue)){
         $this->mbparam = $mbp[0]->attributes[3]->nodeValue;

         if(substr_count($get['body'], 'Tanggal Transaksi')){
            $mbp = $dom->query('//table[contains(@class,"CommonTableClass")]');

            $temp_amount = [];
            $temp_date   = [];
            $temp_desc   = [];
            $temp_type   = [];

            $list = [];
            foreach($mbp as $data){
               $text = trim($data->nodeValue);
               if(substr($text, 0, 17) == "Tanggal Transaksi"){
                  $value = substr($text, 17, 50);
                  $value = date("Y/m/d", strtotime($value));
                  $temp_date[] = $value;
               }elseif(substr($text, 0, 16) == "Uraian Transaksi"){
                  $value = substr($text, 16, 200);
                  $temp_desc[] = $value;
               }elseif(substr($text, 0, 4) == "Tipe"){
                  $value = substr($text, 4, 10);
                  $temp_type[] = $value == "Db" ? "Debit" : "Credit";
               }elseif(substr($text, 0, 7) == "Tagihan"){
                  $value = substr($text, 7, 20);
                  $temp_amount[] = $value;
               }
            }

            for($i=0; $i<count($temp_date); $i++){
               $list[] = [
                  'amount' => $this->formatBalance($temp_amount[$i]),
                  'type'   => $temp_type[$i],
                  'date'   => $temp_date[$i],
                  'desc'   => $temp_desc[$i]
               ];
            }
         }else{
            $mbp = $dom->query('//span[contains(@class,"clsMConError")]');
            if($mbp->length == 0){
               $error = 'Gagal mendapatkan mutasi';
            }else{
               $text = trim($mbp[0]->nodeValue);
               if(substr_count($text, 'Tidak ada transaksi pada rekening dengan kriteria yang diberikan')){
                  $list = [];
               }else{
                  $error = $text;
               }  
            }
         }
      }else{
         $error = 'Gagal mendapatan mutasi';
      }

      if(!isset($error)){
         return [
            'status' => 'success',
            'data'   => $list
         ];
      }else{
         return [
            'status'  => 'error',
            'message' => $error
         ];
      }
   }



   /**************************************
   *   Fungsi untuk mendapatkan mutasi   *
   ***************************************/
   public function getMutation(){
      $valid = $this->paramValidation();
      if($valid['status'] == 'success'){
         $getLoginUrl = $this->getLoginUrl();
         if($getLoginUrl['status'] == 'success'){
            $parse  = parse_url($getLoginUrl['link']);
            $newUrl = "{$parse['scheme']}://{$parse['host']}{$parse['path']}";
            $login  = $this->login($newUrl);

            if($login['status'] == 'success'){
               $accounts = $this->getAccountList($newUrl);
               if($accounts['status'] = 'success'){
                  foreach($accounts['data'] as $account){
                     if(substr_count($account, $this->account)){
                        $selected_accont = $account;
                     }
                  }
                  if(isset($selected_accont)){
                     $balance = $this->getBalance($newUrl, $selected_accont);
                     if($balance['status'] == 'success'){
                        $mutation = $this->getRawMutation($newUrl, $selected_accont);
                        if($mutation['status'] == 'success'){
                           //success
                           $data = [
                              'summary' => [
                                 'account_holder' => $balance['holder'],
                                 'account_number' => $this->account,
                                 'balance' => $balance['balance']
                              ],
                              'transactions' => $mutation['data']
                           ];
                        }else{
                           $error = $mutation['message'];
                        }
                     }else{
                        $error = $balance['message'];
                     }
                  }else{
                     $error = 'Rekening tidak ditemukan';
                  }
               }else{
                  $error = $accounts['message'];
               }
            }else{
               $error = $login['message'];
            }

            $this->logout($newUrl);
         }else{
            $error = $getLoginUrl['message'];
         }
      }else{
         $error = $valid['message'];
      }

      if(!isset($error)){
         return [
            'status'  => 'success',
            'message' => 'berhasil mendapatkan data mutasi',
            'data' => $data
         ];
      }else{
         return [
            'status'  => 'error',
            'message' => $error
         ];
      }
   }


}

/*
CARA PENGGUNAAN:

$conf = [
   'username' => '<USERNAME>',
   'password' => '<PASSWORD>',
   'account'  => '<NOMOR REKENING>',
   'date_start' => '2021/08/01',
   'date_end' => '2021/08/25'
];

$bni = new BNI($conf);
$mut = $bni->getMutation();

print_r($mut);
*/
