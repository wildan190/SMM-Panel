<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['full_tag_open'] = '<ul class="pagination pagination-sm text-nowrap mb-1 mt-3">';
$config['full_tag_close'] = '</ul>';

$config['first_tag_open'] = '<li class="page-item">';
$config['first_tag_close'] = '</li>';

$config['last_tag_open'] = '<li class="page-item">';
$config['last_tag_close'] = '</li>';

$config['next_link'] = '<span aria-hidden="true">&raquo;</span><span class="sr-only">Next</span>';
$config['next_tag_open'] = '<li class="page-item">';
$config['next_tag_close'] = '</li>';

$config['prev_link'] = '<span aria-hidden="true">&laquo;</span><span class="sr-only">Previous</span>';
$config['prev_tag_open'] = '<li class="page-item">';
$config['prev_tag_close'] = '</li>';

$config['cur_tag_open'] = '<li class="page-item active primary"><a class="page-link" href="#">';
$config['cur_tag_close'] = '</a></li>';

$config['num_tag_open'] = '<li class="page-item">';
$config['num_tag_close'] = '</li>';

$config['attributes'] = ['class' => 'page-link'];

$config['reuse_query_string'] = true;