<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

echo "<link rel='stylesheet' type='text/css' media='all' href= '/".TEMPLATES_FOLDER . "common/css/notepad.css' />";

echo '<div id="admin-main">';

require_once('dash_menu.php');


echo '<h2 class="left">'. lang('dakota_notepad')   ;

if (count($notes) > 0) {

echo ICON_BULL . anchor('/admin/notepad/clear/' . TOKEN, lang('dakota_clear'))   ;

}
echo '</h2>'  ;
echo '<h3 class="right help-button">' . img(ICON_HELP) . nbs(1) . anchor_help('notepad').' </h3>';

echo '<div class="clear">';
echo validation_errors('<span class="error">', '</span>');
echo '</div>';


echo '<div class="left" style="margin:0 auto;" >';
echo '<strong>'. lang('dakota_create') . ' </strong>';

echo form_open('admin/notepad/create/');

$data = array(
    'name' => 'text',
    'id' => 'text',
    'cols' => '40',
    'rows' => '5',
);

echo form_textarea($data);
echo '	<br />';


echo form_submit('submit', 'OK');
echo form_close();
echo '</div>';

echo '<div class="left" style="padding-left: 100px; margin:0 auto;" >';


echo '<div class="nheader"></div>';

echo '<div class="ntext">';
echo '<div class="ninner_text">';

if (count($notes) > 0) {
    foreach ($notes as $note) {

        echo '<div><small>' . $note['created_at'] . '</small> ';

        if ($note['author_id'] == ID) {
            echo  lang('dakota_you') . colon();
        } else {

            echo  $note->User->firstname . ' ' . $note->User->lastname . ': ';
        }

        echo nl2br($note['text']);
        echo ' </div>';


    }
}else{
    echo lang('dakota_not_data_to_view'); 
}

echo '</div>';
echo '</div>';
echo '<div class="nfooter"></div>';
echo '</div>';

echo '<div class="clear" ></div >';


echo '</div >';




