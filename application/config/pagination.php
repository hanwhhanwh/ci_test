<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Pagination Config
 * 
 * Just applying codeigniter's standard pagination config with twitter 
 * bootstrap stylings
 * 
 * @license		http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @author		Mike Funk
 * @link		http://codeigniter.com/user_guide/libraries/pagination.html
 * @email		mike@mikefunk.com
 * 
 * @file		pagination.php
 * @version		1.3.1
 * @date		03/12/2012
 * 
 * Copyright (c) 2011
 */
 
// --------------------------------------------------------------------------
 
// $config['base_url'] = '';

$config['per_page']             = PG_PER_PAGE;
$config['num_links']            = PG_NUM_LINKS;
$config['uri_segment']          = PG_URI_SEGMENT;
$config['page_query_string']    = FALSE;
$config['use_page_numbers']     = TRUE;
$config['query_string_segment'] = 'page';
$config['attributes']           = array('class' => 'page-link');

$config['full_tag_open']        = '<nav aria-label="Page navigation example"><ul class="pagination pagination-sm justify-content-center">';
$config['full_tag_close']       = '</ul></nav>';

$config['first_link']           = '◀';
$config['first_tag_open']       = '<li class="page-item">';
$config['first_tag_close']      = '</li>';

$config['last_link']            = '▶';
$config['last_tag_open']        = '<li class="page-item">';
$config['last_tag_close']       = '</li>';

$config['next_link']            = '▷';
$config['next_tag_open']        = '<li class="page-item">';
$config['next_tag_close']       = '</li>';

$config['prev_link']            = '◁';
$config['prev_tag_open']        = '<li class="page-item">';
$config['prev_tag_close']       = '</li>';

$config['cur_tag_open']         = '<li class="page-item active"><a class="page-link">';
$config['cur_tag_close']        = '</a></li>';

$config['num_tag_open']         = '<li class="page-item">';
$config['num_tag_close']        = '</li>';

// $config['display_pages'] = FALSE;
// 
$config['anchor_class'] = 'follow_link';

// --------------------------------------------------------------------------
 
/* End of file pagination.php */
/* Location: ./bookymark/application/config/pagination.php */
