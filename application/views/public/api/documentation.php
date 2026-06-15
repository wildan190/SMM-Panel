<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0"><i class="fas fa-code me-2"></i>Dokumentasi API</h4>
            </div>
            <div class="card-body pb-4">
                <div class="row">
                    <div class="col-md-3 col-sm-12">
                        <ul class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                            <li>
                                <a class="nav-link active" id="v-pills-credentials-tab" data-bs-toggle="pill" href="#v-pills-credentials">Credentials</a>
                            </li>
                            <li>
                                <a class="nav-link" id="v-pills-profile-tab" data-bs-toggle="pill" href="#v-pills-profile">Profile</a>
                            </li>
                            <li>
                                <a class="nav-link" id="v-pills-services-tab" data-bs-toggle="pill" href="#v-pills-services">Service List</a>
                            </li>
                            <li>
                                <a class="nav-link" id="v-pills-neworder-tab" data-bs-toggle="pill" href="#v-pills-neworder">Create Order</a>
                            </li>
                            <li>
                                <a class="nav-link" id="v-pills-checkorder-tab" data-bs-toggle="pill" href="#v-pills-checkorder">Check Order Status</a>
                            </li>
                            <li>
                                <a class="nav-link" id="v-pills-newrefill-tab" data-bs-toggle="pill" href="#v-pills-newrefill">Create Refill</a>
                            </li>
                            <li>
                                <a class="nav-link" id="v-pills-checkrefill-tab" data-bs-toggle="pill" href="#v-pills-checkrefill">Check Refill Status</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-9 col-sm-12 mt-4 mt-md-0">
                        <div class="tab-content" id="v-pills-tabContent">
                            <div class="tab-pane fade show active pb-0" id="v-pills-credentials" role="tabpanel">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th>API ID</th>
                                            <td>
                                                <?= $this->lib->encrypt_decrypt('encrypt', user()) ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>API Key</th>
                                            <td>
                                                <div class="input-group">
                                                    <input type="text" class="form-control form-control-sm" value="<?= user('api_key') ?>" disabled>
                                                    <button type="button" class="btn btn-primary btn-sm"><a href="<?= base_url('api/regenerate') ?>" class="text-white">Buat
                                                            Ulang</a></button>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="alert alert-primary mb-0">
                                    Contoh Script PHP: <a href="<?= base_url('api.example.txt') ?>">Klik Disini</a>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="v-pills-profile">
                                <div class="accordion card" id="profile-accordion" style="box-shadow: none;">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#profileOne">Endpoint</button>
                                        </h2>
                                        <div id="profileOne" class="accordion-collapse collapse show" data-bs-parent="#profile-accordion">
                                            <div class="accordion-body">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered mb-0">
                                                        <tr>
                                                            <th>API URL</th>
                                                            <td>
                                                                <?= base_url('api/profile') ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>HTTP Method</th>
                                                            <td>POST</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Response Format</th>
                                                            <td>JSON</td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button fw-semibold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#profileTwo">Body</button>
                                        </h2>
                                        <div id="profileTwo" class="accordion-collapse collapse" data-bs-parent="#profile-accordion">
                                            <div class="accordion-body">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered mb-0">
                                                        <tr>
                                                            <th>Parameter</th>
                                                            <th>Type</th>
                                                            <th>Description</th>
                                                            <th>Mandatory</th>
                                                            <th>Example</th>
                                                        </tr>
                                                        <tr>
                                                            <td>api_id</td>
                                                            <td>int</td>
                                                            <td>Your API ID</td>
                                                            <td>Yes</td>
                                                            <td>
                                                                <?= $this->lib->encrypt_decrypt('encrypt', user()) ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>api_key</td>
                                                            <td>string</td>
                                                            <td>Your API Key</td>
                                                            <td>Yes</td>
                                                            <td>
                                                                <?= user('api_key') ?>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button fw-semibold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#profileThree">Example
                                                responses</button>
                                        </h2>
                                        <div id="profileThree" class="accordion-collapse collapse" data-bs-parent="#profile-accordion">
                                            <div class="accordion-body p-0">
                                                <div class="table-responsive">
                                                    <table class="table table-borderless m-0">
                                                        <tr>
                                                            <th width="50%" class="table-success">Success</th>
                                                            <th width="50%" class="table-danger">Fail</th>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <pre><code class="language-php"><?= json_encode([
                                                                                                    'status' => true,
                                                                                                    'data' => [
                                                                                                        'username' => user('username') ? user('username') : 'secret',
                                                                                                        'full_name' => user('full_name') ? user('full_name') : 'SECRET',
                                                                                                        'level' => user('level') ? user('level') : 'Member',
                                                                                                        'balance' => round(user('balance')) ? round(user('balance')) : '100900',
                                                                                                        'registered' => user('created_at') ? user('created_at') : '2022-11-23 00:47:20',
                                                                                                    ],
                                                                                                ], JSON_PRETTY_PRINT) ?></code></pre>
                                                            </td>
                                                            <td>
                                                                <pre><code class="language-php">{
   "status": false,
   "data": "Permintaan salah"
}</code></pre>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button fw-semibold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#profileFour">List of failed
                                                responses</button>
                                        </h2>
                                        <div id="profileFour" class="accordion-collapse collapse" data-bs-parent="#profile-accordion">
                                            <div class="accordion-body">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered mb-0">
                                                        <tr>
                                                            <td>Permintaan salah</td>
                                                        </tr>
                                                        <tr>
                                                            <td>API ID salah</td>
                                                        </tr>
                                                        <tr>
                                                            <td>API KEY salah</td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="v-pills-services">
                                <div class="accordion card" id="services-accordion" style="box-shadow: none;">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#servicesOne">Endpoint</button>
                                        </h2>
                                        <div id="servicesOne" class="accordion-collapse collapse show" data-bs-parent="#services-accordion">
                                            <div class="accordion-body">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered mb-0">
                                                        <tr>
                                                            <th>API URL</th>
                                                            <td>
                                                                <?= base_url('api/services') ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>HTTP Method</th>
                                                            <td>POST</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Response Format</th>
                                                            <td>JSON</td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button fw-semibold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#servicesTwo">Body</button>
                                        </h2>
                                        <div id="servicesTwo" class="accordion-collapse collapse" data-bs-parent="#services-accordion">
                                            <div class="accordion-body">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered mb-0">
                                                        <tr>
                                                            <th>Parameter</th>
                                                            <th>Type</th>
                                                            <th>Description</th>
                                                            <th>Mandatory</th>
                                                            <th>Example</th>
                                                        </tr>
                                                        <tr>
                                                            <td>api_id</td>
                                                            <td>int</td>
                                                            <td>Your API ID</td>
                                                            <td>Yes</td>
                                                            <td>
                                                                <?= $this->lib->encrypt_decrypt('encrypt', user()) ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>api_key</td>
                                                            <td>string</td>
                                                            <td>Your API Key</td>
                                                            <td>Yes</td>
                                                            <td>
                                                                <?= user('api_key') ?>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button fw-semibold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#servicesThree">Example
                                                responses</button>
                                        </h2>
                                        <div id="servicesThree" class="accordion-collapse collapse" data-bs-parent="#services-accordion">
                                            <div class="accordion-body p-0">
                                                <div class="table-responsive">
                                                    <table class="table table-borderless m-0">
                                                        <tr>
                                                            <th width="50%" class="table-success">Success</th>
                                                            <th width="50%" class="table-danger">Fail</th>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <pre><code class="language-php">{
    "status": true,
    "data": [
        {
            "id": 1,
            "category": "Instagram Followers",
            "name": "Instagram Followers S1",
            "price": 10000,
            "min": 100,
            "max": 10000,
            "description": "Super Fast, Input Username",
            "average_time": "41 menit",
            "status": 1, // 1 = on, 0 = off
            "refill": 1, // 1 = on, 0 = off
            "type": "primary" // custom_comments, custom_link
        },
        {
            "id": 2,
            "category": "Instagram Comments",
            "name": "Instagram Custom Comments S1",
            "price": 15000,
            "min": 10,
            "max": 5000,
            "description": "Super Fast, Input Post Url",
            "average_time": "1 jam, 15 menit",
            "status": 1, // 1 = on, 0 = off
            "refill": 0, // 1 = on, 0 = off
            "type": "custom_comments" // primary, custom_link
        },
    ]
}</code></pre>
                                                            </td>
                                                            <td>
                                                                <pre><code class="language-php">{
   "status": false, // true = success, false = fail
   "data": "Permintaan salah" // message fail
}</code></pre>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button fw-semibold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#servicesFour">List of failed
                                                responses</button>
                                        </h2>
                                        <div id="servicesFour" class="accordion-collapse collapse" data-bs-parent="#services-accordion">
                                            <div class="accordion-body">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered mb-0">
                                                        <tr>
                                                            <td>Permintaan salah</td>
                                                        </tr>
                                                        <tr>
                                                            <td>API ID salah</td>
                                                        </tr>
                                                        <tr>
                                                            <td>API KEY salah</td>
                                                        </tr>
                                                        <tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="v-pills-neworder">
                                <div class="accordion card" id="neworder-accordion" style="box-shadow: none;">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#neworderOne">Endpoint</button>
                                        </h2>
                                        <div id="neworderOne" class="accordion-collapse collapse show" data-bs-parent="#neworder-accordion">
                                            <div class="accordion-body">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered mb-0">
                                                        <tr>
                                                            <th>API URL</th>
                                                            <td>
                                                                <?= base_url('api/order') ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>HTTP Method</th>
                                                            <td>POST</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Response Format</th>
                                                            <td>JSON</td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button fw-semibold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#neworderTwo">Body</button>
                                        </h2>
                                        <div id="neworderTwo" class="accordion-collapse collapse" data-bs-parent="#neworder-accordion">
                                            <div class="accordion-body">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered mb-0">
                                                        <tr>
                                                            <th>Parameter</th>
                                                            <th>Type</th>
                                                            <th>Description</th>
                                                            <th>Mandatory</th>
                                                            <th>Example</th>
                                                        </tr>
                                                        <tr>
                                                            <td>api_id</td>
                                                            <td>int</td>
                                                            <td>Your API ID</td>
                                                            <td>Yes</td>
                                                            <td>
                                                                <?= $this->lib->encrypt_decrypt('encrypt', user()) ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>api_key</td>
                                                            <td>string</td>
                                                            <td>Your API Key</td>
                                                            <td>Yes</td>
                                                            <td>
                                                                <?= user('api_key') ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>service</td>
                                                            <td>int</td>
                                                            <td>Service ID, Check <a href="<?= base_url('page/price_list') ?>">Service
                                                                    List</a></td>
                                                            <td>Yes</td>
                                                            <td>123</td>
                                                        </tr>
                                                        <tr>
                                                            <td>target</td>
                                                            <td>string</td>
                                                            <td>Username or Link</td>
                                                            <td>Yes</td>
                                                            <td>
                                                                herusuandanaa or https://instagram.com/herusuandanaa
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>quantity</td>
                                                            <td>int</td>
                                                            <td>Needed quantity</td>
                                                            <td>Yes</td>
                                                            <td>1000</td>
                                                        </tr>
                                                        <tr>
                                                            <td>custom_comments</td>
                                                            <td>string</td>
                                                            <td>Comments list separated by \r\n or \n</td>
                                                            <td>No</td>
                                                            <td>Heru\nSuandana</td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button fw-semibold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#neworderThree">Example
                                                responses</button>
                                        </h2>
                                        <div id="neworderThree" class="accordion-collapse collapse" data-bs-parent="#neworder-accordion">
                                            <div class="accordion-body p-0">
                                                <div class="table-responsive">
                                                    <table class="table table-borderless m-0">
                                                        <tr>
                                                            <th width="50%" class="table-success">Success</th>
                                                            <th width="50%" class="table-danger">Fail</th>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <pre><code class="language-php">{
    "status": true,
    "data": {
        "id": 1107,
        "price": 10900
    }
}</code></pre>
                                                            </td>
                                                            <td>
                                                                <pre><code class="language-php">{
   "status": false,
   "data": "Permintaan salah"
}</code></pre>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button fw-semibold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#neworderFour">List of failed
                                                responses</button>
                                        </h2>
                                        <div id="neworderFour" class="accordion-collapse collapse" data-bs-parent="#neworder-accordion">
                                            <div class="accordion-body">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered mb-0">
                                                        <tr>
                                                            <td>Permintaan salah</td>
                                                        </tr>
                                                        <tr>
                                                            <td>API ID salah</td>
                                                        </tr>
                                                        <tr>
                                                            <td>API KEY salah</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Limit pesanan dengan target yang sama</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Layanan tidak tersedia</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Layanan sedang mengalami gangguan</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Jumlah pesan tidak sesuai</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Saldo tidak mencukupi</td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="v-pills-checkorder">
                                <div class="accordion card" id="checkstatus-accordion" style="box-shadow: none;">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#checkstatusOne">Endpoint</button>
                                        </h2>
                                        <div id="checkstatusOne" class="accordion-collapse collapse show" data-bs-parent="#checkstatus-accordion">
                                            <div class="accordion-body">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered mb-0">
                                                        <tr>
                                                            <th>API URL</th>
                                                            <td>
                                                                <?= base_url('api/status') ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>HTTP Method</th>
                                                            <td>POST</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Response Format</th>
                                                            <td>JSON</td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button fw-semibold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#checkstatusTwo">Body</button>
                                        </h2>
                                        <div id="checkstatusTwo" class="accordion-collapse collapse" data-bs-parent="#checkstatus-accordion">
                                            <div class="accordion-body">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered mb-0">
                                                        <tr>
                                                            <th>Parameter</th>
                                                            <th>Type</th>
                                                            <th>Description</th>
                                                            <th>Mandatory</th>
                                                            <th>Example</th>
                                                        </tr>
                                                        <tr>
                                                            <td>api_id</td>
                                                            <td>int</td>
                                                            <td>Your API ID</td>
                                                            <td>Yes</td>
                                                            <td>
                                                                <?= $this->lib->encrypt_decrypt('encrypt', user()) ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>api_key</td>
                                                            <td>string</td>
                                                            <td>Your API Key</td>
                                                            <td>Yes</td>
                                                            <td>
                                                                <?= user('api_key') ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>id</td>
                                                            <td>int</td>
                                                            <td>Order ID</td>
                                                            <td>Yes</td>
                                                            <td>12345</td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button fw-semibold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#checkstatusThree">Example
                                                responses</button>
                                        </h2>
                                        <div id="checkstatusThree" class="accordion-collapse collapse" data-bs-parent="#checkstatus-accordion">
                                            <div class="accordion-body p-0">
                                                <div class="table-responsive">
                                                    <table class="table table-borderless m-0">
                                                        <tr>
                                                            <th width="50%" class="table-success">Success</th>
                                                            <th width="50%" class="table-danger">Fail</th>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <pre><code class="language-php">{
    "status": true,
    "data": {
        "status": "Success",
        "start_count": 21451,
        "remains": 3291
    }
}</code></pre>
                                                            </td>
                                                            <td>
                                                                <pre><code class="language-php">{
   "status": false,
   "data": "Permintaan salah"
}</code></pre>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button fw-semibold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#checkstatusFour">List of
                                                failed responses</button>
                                        </h2>
                                        <div id="checkstatusFour" class="accordion-collapse collapse" data-bs-parent="#checkstatus-accordion">
                                            <div class="accordion-body">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered mb-0">
                                                        <tr>
                                                            <td>Permintaan salah</td>
                                                        </tr>
                                                        <tr>
                                                            <td>API ID salah</td>
                                                        </tr>
                                                        <tr>
                                                            <td>API KEY salah</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Pesanan tidak ditemukan</td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button fw-semibold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#checkstatusFive">List of
                                                statuses</button>
                                        </h2>
                                        <div id="checkstatusFive" class="accordion-collapse collapse" data-bs-parent="#checkstatus-accordion">
                                            <div class="accordion-body">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered mb-0">
                                                        <tr>
                                                            <td>Pending</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Processing</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Success</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Error</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Partial</td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="v-pills-newrefill">
                                <div class="accordion card" id="newrefill-accordion" style="box-shadow: none;">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#newrefillOne">Endpoint</button>
                                        </h2>
                                        <div id="newrefillOne" class="accordion-collapse collapse show" data-bs-parent="#newrefill-accordion">
                                            <div class="accordion-body">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered mb-0">
                                                        <tr>
                                                            <th>API URL</th>
                                                            <td>
                                                                <?= base_url('api/refill') ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>HTTP Method</th>
                                                            <td>POST</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Response Format</th>
                                                            <td>JSON</td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button fw-semibold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#newrefillTwo">Body</button>
                                        </h2>
                                        <div id="newrefillTwo" class="accordion-collapse collapse" data-bs-parent="#newrefill-accordion">
                                            <div class="accordion-body">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered mb-0">
                                                        <tr>
                                                            <th>Parameter</th>
                                                            <th>Type</th>
                                                            <th>Description</th>
                                                            <th>Mandatory</th>
                                                            <th>Example</th>
                                                        </tr>
                                                        <tr>
                                                            <td>api_id</td>
                                                            <td>int</td>
                                                            <td>Your API ID</td>
                                                            <td>Yes</td>
                                                            <td>
                                                                <?= $this->lib->encrypt_decrypt('encrypt', user()) ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>api_key</td>
                                                            <td>string</td>
                                                            <td>Your API Key</td>
                                                            <td>Yes</td>
                                                            <td>
                                                                <?= user('api_key') ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>id</td>
                                                            <td>int</td>
                                                            <td>Order ID</td>
                                                            <td>Yes</td>
                                                            <td>12345</td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button fw-semibold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#newrefillThree">Example
                                                responses</button>
                                        </h2>
                                        <div id="newrefillThree" class="accordion-collapse collapse" data-bs-parent="#newrefill-accordion">
                                            <div class="accordion-body p-0">
                                                <div class="table-responsive">
                                                    <table class="table table-borderless m-0">
                                                        <tr>
                                                            <th width="50%" class="table-success">Success</th>
                                                            <th width="50%" class="table-danger">Fail</th>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <pre><code class="language-php">{
    "status": true,
    "data": {
        "refill_id": 10900,
        "order_id": 21451
    }
}</code></pre>
                                                            </td>
                                                            <td>
                                                                <pre><code class="language-php">{
   "status": false,
   "data": "Permintaan salah"
}</code></pre>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button fw-semibold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#newrefillFour">List of failed
                                                responses</button>
                                        </h2>
                                        <div id="newrefillFour" class="accordion-collapse collapse" data-bs-parent="#newrefill-accordion">
                                            <div class="accordion-body">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered mb-0">
                                                        <tr>
                                                            <td>Permintaan salah</td>
                                                        </tr>
                                                        <tr>
                                                            <td>API ID salah</td>
                                                        </tr>
                                                        <tr>
                                                            <td>API KEY salah</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Pesanan tidak ditemukan</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Gagal Melakukan Permintaan Refill (Waktu Refill
                                                                Sebelumnya Belum Selesai)</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Gagal melakukan permintaan Refill.</td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="v-pills-checkrefill">
                                <div class="accordion card" id="checkrefill-accordion" style="box-shadow: none;">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#checkrefillOne">Endpoint</button>
                                        </h2>
                                        <div id="checkrefillOne" class="accordion-collapse collapse show" data-bs-parent="#checkrefill-accordion">
                                            <div class="accordion-body">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered mb-0">
                                                        <tr>
                                                            <th>API URL</th>
                                                            <td>
                                                                <?= base_url('api/status_refill') ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>HTTP Method</th>
                                                            <td>POST</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Response Format</th>
                                                            <td>JSON</td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button fw-semibold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#checkrefillTwo">Body</button>
                                        </h2>
                                        <div id="checkrefillTwo" class="accordion-collapse collapse" data-bs-parent="#checkrefill-accordion">
                                            <div class="accordion-body">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered mb-0">
                                                        <tr>
                                                            <th>Parameter</th>
                                                            <th>Type</th>
                                                            <th>Description</th>
                                                            <th>Mandatory</th>
                                                            <th>Example</th>
                                                        </tr>
                                                        <tr>
                                                            <td>api_id</td>
                                                            <td>int</td>
                                                            <td>Your API ID</td>
                                                            <td>Yes</td>
                                                            <td>
                                                                <?= $this->lib->encrypt_decrypt('encrypt', user()) ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>api_key</td>
                                                            <td>string</td>
                                                            <td>Your API Key</td>
                                                            <td>Yes</td>
                                                            <td>
                                                                <?= user('api_key') ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>id</td>
                                                            <td>int</td>
                                                            <td>Refill ID</td>
                                                            <td>Yes</td>
                                                            <td>54321</td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button fw-semibold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#checkrefillThree">Example
                                                responses</button>
                                        </h2>
                                        <div id="checkrefillThree" class="accordion-collapse collapse" data-bs-parent="#checkrefill-accordion">
                                            <div class="accordion-body p-0">
                                                <div class="table-responsive">
                                                    <table class="table table-borderless m-0">
                                                        <tr>
                                                            <th width="50%" class="table-success">Success</th>
                                                            <th width="50%" class="table-danger">Fail</th>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <pre><code class="language-php">{
    "status": true,
    "data": {
        "status": "Success"
    }
}</code></pre>
                                                            </td>
                                                            <td>
                                                                <pre><code class="language-php">{
    "status": false,
    "data": "Permintaan salah"
}</code></pre>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button fw-semibold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#checkrefillFour">List of
                                                failed responses</button>
                                        </h2>
                                        <div id="checkrefillFour" class="accordion-collapse collapse" data-bs-parent="#checkrefill-accordion">
                                            <div class="accordion-body">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered mb-0">
                                                        <tr>
                                                            <td>Permintaan salah</td>
                                                        </tr>
                                                        <tr>
                                                            <td>API ID salah</td>
                                                        </tr>
                                                        <tr>
                                                            <td>API KEY salah</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Refill tidak ditemukan</td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button fw-semibold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#checkrefillFive">List of
                                                statuses</button>
                                        </h2>
                                        <div id="checkrefillFive" class="accordion-collapse collapse" data-bs-parent="#checkrefill-accordion">
                                            <div class="accordion-body">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered mb-0">
                                                        <tr>
                                                            <td>Pending</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Processing</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Success</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Error</td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>