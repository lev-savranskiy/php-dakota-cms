<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
header('Content-Type: text/html; charset=utf-8');
$CI = & get_instance();

require_once('template_top.php');

$this->load->external_tpl('header');


//echo '<div id="loader"><img src="/templates/common/img/loader.gif" alt="Dakota is loading..."></div>';

echo '<!-- start page --><div id="page">';


echo '<!-- start content --><div id="content"> ';
$this->load->view($content_view);

if (isset($pagination)) {
    echo ' <div class="pagination">';
    echo lang('dakota_all_pages') . colon() . $pagination;
    echo '</div>';
}

echo '<!-- end content --></div>';


if (!defined('HIDE_SIDEBAR')) {


    echo ' <!-- start sidebar -->';
    echo ' <div id="sidebar" class="overflow-hidden"><ul>';
    $Widgets = new Widget();
    $Widgets->build();
    echo '</ul></div>';
    echo '<!-- end sidebar -->';
}

echo '<!-- end page --></div>';

$this->load->external_tpl('footer');

require_once('template_bottom.php');
