<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


require_once('./templates/common/init_storage.tpl');

echo '<script language="javascript" type="text/javascript" src="/templates/common/js/copyToClipboard.js"></script>  ';


echo '<div id="admin-main">';

require_once('dash_menu.php');

echo '<h2 class="left"> ' .lang('dakota_files') .'</h2>'  ;
echo '<h3 class="right help-button">' . img(ICON_HELP) . nbs(1) . anchor_help('files').' </h3>';

echo '<div class ="error clear">' . $error . '</div>';

echo form_open_multipart('/admin/files/do_upload');
echo form_upload('userfile');
echo form_submit('submit',  lang('dakota_upload'));
echo form_close();

echo '<ul>';

if (@require(APPPATH . 'config/mimes' . EXT)) {
   echo '<li>'  .  lang('dakota_files') . nbs()  .  lang('dakota_not_allowed'). colon() . implode(',', $bad_mimes) . nbs() .  '</li>';
}

 echo '<li>' .   lang('dakota_files_max_size').' = ' .  UPLOAD_MAX_SIZE. 'b  ' .   lang('dakota_in_line').' <b>upload_max_filesize</b> php.ini <i>' .anchor_help('phpinfo') . '</i></li>';
 echo '<li>' .   lang('dakota_path_to').'  <i>php.ini</i>  - ' .   lang('dakota_in_line').' <b>Loaded Configuration File</b>  '. anchor('/admin/phpinfo/' , 'phpinfo') .'</li>';
 echo '<li>' .   lang('dakota_ask_for_support') .'</li>';

echo '</ul>';


echo '<div class="bold" style="margin: 10px 0;">' .lang('dakota_files') .': ' . $files_count . nbs(3) . lang('dakota_size') . ': ' .$files_total_size. '</div>';


echo<<<FILES
<ul id="menu">
         <li><a href="">All files</a></li>
        <li><a href="">Documents</a></li>
        <li><a href="">Images</a></li>
        <li><a href="">Archives</a></li>
        <li><a href="">Music</a></li>
        <li><a href="">Video</a></li>
 </ul>
FILES;


echo '<ul id="files">  ';

echo $files;

echo '</ul>';


echo '</div>';

?>



