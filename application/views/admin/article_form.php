<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');


echo '<script type="text/javascript">';
echo convert_to_js_array($availableTags, 'availableTags');
echo '$(function() {$(".tag").autocomplete({source: availableTags  ,    minLength: 2   });});';
echo '</script>';


require_once('./templates/common/init_autocomplete_ui.tpl');


echo '	<label for="title">' .lang('dakota_title') .': </label>';
echo form_input('title', $form_data['title'] , ' style="width: 400px;" ');
echo '	<br />';

echo '	<label for="text">' .lang('dakota_content') .': </label>';

$link = '/admin/articles/add';

if ($this->uri->segment(3) == 'update') {
$link = '/admin/articles/update/' . $this->uri->segment(4) ;
}


if ($type == 'wysiwyg' ){
 echo  ' [' . lang('dakota_tags') . nbs() . lang('dakota_not_allowed') . '] ' .  ICON_BULL .   anchor($link . '/html/', lang('dakota_switch_editor')) ;
}
else{
 echo ' [' . lang('dakota_tags') . nbs() . lang('dakota_allowed') . '] ' . ICON_BULL .   anchor($link .  '/wysiwyg/', lang('dakota_switch_editor_wysiwyg')) ;

}

echo '<br/>';
echo form_textarea('text' ,  $form_data['text'] , ' id="'. $type .'" ' );

 echo '<ul>';
echo '	<li>' . lang('dakota_articles_info_1') .'</li>';
 echo '<li>' . lang('dakota_articles_info_2') .' ' .  anchor('/admin/files/', lang('dakota_files')   )  . '</li>';

  echo '</ul>';
   echo '<br />';
echo '	<label for="url">' . lang('dakota_hru') .nbs() . lang('dakota_link')  .' </label>';
echo '<span class = "prim"></span>	<br />';
echo form_input('url', $form_data['url'], ' style="width: 400px;" ');



echo '	<br /><br /><label for="tags">' . lang('dakota_tags') .'  - ' . lang('dakota_articles_info_3') .'</label>';
echo '<span class = "prim"></span>	<br />';
echo form_input('tag1', $form_data['tag1'], '  class="tag" autocomplete="off" ');
echo form_input('tag2', $form_data['tag2'], '  class="tag" autocomplete="off" ');
echo form_input('tag3', $form_data['tag3'], '  class="tag" autocomplete="off" ');
echo form_input('tag4', $form_data['tag4'], '  class="tag" autocomplete="off" ');
echo form_input('tag5', $form_data['tag5'], '   class="tag" autocomplete="off" ');



  $data = array(
    'name'        => 'is_visible',
    'id'          => 'is_visible',
    'style'       => 'margin:10px',
    'checked'     => $form_data['is_visible'],
    'value'       => 1
    );

echo '<br /><br />	<label for="is_visible">' . lang('dakota_show_on_site') .'</label>';
echo form_checkbox($data);
echo '<span class = "prim"></span>	';




  $data = array(
    'name'        => 'is_main',
    'id'          => 'is_main',
    'style'       => 'margin:10px',
     'checked'     => $form_data['is_main'],
    'value'       => 1
    );


echo '<br /><label for="is_main">' . lang('dakota_article_is_main') .'</label>';
echo form_checkbox($data);
echo '<span class = "prim"></span>	';


$data = array(
   'name'        => 'is_page',
   'id'          => 'is_page',
   'style'       => 'margin:10px',
    'checked'     => $form_data['is_page'],
   'value'       => 1
   );


   echo '<br /><label for="is_page">' . lang('dakota_article_is_not_news') .' </label>';
   echo form_checkbox($data);
   echo '<span class = "prim"></span>	';




$data = array(
   'name'        => 'can_be_commented',
   'id'          => 'can_be_commented',
   'style'       => 'margin:10px',
    'checked'     => $form_data['can_be_commented'],
   'value'       => 1
   );


   echo '<br /><label for="can_be_commented">' . lang('dakota_comments') .nbs() . lang('dakota_allowed') .' </label>';
   echo form_checkbox($data);
   echo '<br />';
 //  echo anchor_img('/user_guide_dakota/articles.html' , '' , ICON_HELP) . '<br />';