<?php

/**
 * CodeIgniter
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2019 - 2022, CodeIgniter Foundation
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package	CodeIgniter
 * @author	EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc. (https://ellislab.com/)
 * @copyright	Copyright (c) 2014 - 2019, British Columbia Institute of Technology (https://bcit.ca/)
 * @copyright	Copyright (c) 2019 - 2022, CodeIgniter Foundation (https://codeigniter.com/)
 * @license	https://opensource.org/licenses/MIT	MIT License
 * @link	https://codeigniter.com
 * @since	Version 1.0.0
 * @filesource
 */
defined('BASEPATH') or exit('No direct script access allowed');

$lang['db_invalid_connection_str'] = 'Tidak dapat menentukan pengaturan database berdasarkan string koneksi yang Anda kirimkan.';
$lang['db_unable_to_connect'] = 'Tidak dapat terhubung ke server database menggunakan pengaturan yang diberikan.';
$lang['db_unable_to_select'] = 'Tidak dapat memilih database yang ditentukan: %s';
$lang['db_unable_to_create'] = 'Tidak dapat membuat database yang ditentukan: %s';
$lang['db_invalid_query'] = 'Query yang Anda kirimkan tidak valid.';
$lang['db_must_set_table'] = 'Anda harus mengatur tabel database yang akan digunakan dengan query Anda.';
$lang['db_must_use_set'] = 'Anda harus menggunakan metode "set" untuk memperbarui entri.';
$lang['db_must_use_index'] = 'Anda harus menentukan indeks untuk cocok pada pembaruan batch.';
$lang['db_batch_missing_index'] = 'Satu atau lebih baris yang dikirimkan untuk pembaruan batch tidak memiliki indeks yang ditentukan.';
$lang['db_must_use_where'] = 'Pembaruan tidak diizinkan kecuali mengandung klausa "where".';
$lang['db_del_must_use_where'] = 'Hapus tidak diizinkan kecuali mengandung klausa "where" atau "like".';
$lang['db_field_param_missing'] = 'Untuk mengambil kolom diperlukan nama tabel sebagai parameter.';
$lang['db_unsupported_function'] = 'Fitur ini tidak tersedia untuk database yang Anda gunakan.';
$lang['db_transaction_failure'] = 'Gagal transaksi: Rollback dilakukan.';
$lang['db_unable_to_drop'] = 'Tidak dapat menghapus database yang ditentukan.';
$lang['db_unsupported_feature'] = 'Fitur tidak didukung oleh platform database yang Anda gunakan.';
$lang['db_unsupported_compression'] = 'Format kompresi file yang Anda pilih tidak didukung oleh server Anda.';
$lang['db_filepath_error'] = 'Tidak dapat menulis data ke jalur file yang Anda kirimkan.';
$lang['db_invalid_cache_path'] = 'Jalur cache yang Anda kirimkan tidak valid atau dapat ditulis.';
$lang['db_table_name_required'] = 'Diperlukan nama tabel untuk operasi tersebut.';
$lang['db_column_name_required'] = 'Diperlukan nama kolom untuk operasi tersebut.';
$lang['db_column_definition_required'] = 'Diperlukan definisi kolom untuk operasi tersebut.';
$lang['db_unable_to_set_charset'] = 'Tidak dapat mengatur set karakter koneksi klien: %s';
$lang['db_error_heading'] = 'Terjadi Kesalahan Database';
