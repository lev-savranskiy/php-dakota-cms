<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');


require_once('./templates/common/init_lightbox.tpl');
echo '<div id="admin-main">';

require_once('dash_menu.php');

echo '<h2 class="left">' .lang('dakota_templates') . '</h2>'  ;
echo '<h3 class="right help-button">' . img(ICON_HELP) . nbs(1) . anchor_help('templates').' </h3>';


echo '<p class="clear">' . lang('dakota_templates_in_folder'). nbs() .TEMPLATES_FOLDER  . '  -  ' . safe_count($templates) .'  </p>';

if (safe_count($templates) > 0) {


    foreach ($templates as $template) {

        $template_chosen = $template == MY_TEMPLATE ? true : false;
        $template_chosen_word = $template_chosen?  '[' . lang('dakota_chosen').'] ': anchor('/admin/templates/set/' .$template . '/' . TOKEN , '[' . lang('dakota_set').']' )   ;

        echo '<div class="left" style="padding: 20px;">';
        echo '<p  class="text-center">' . $template .  '</p>';

        echo '<p class="text-center" ><a href ="/' . TEMPLATES_FOLDER . $template . '/img/full.png" class="lightbox"><img src="/' . TEMPLATES_FOLDER . $template . '/img/thumb.png" width="128" /></a></p>';
        echo '<p  class="text-center"><a target="_blank" href="/templates/' . $template .'/dummy.html">[HTML]</a> </p>';
       echo '<p  class="text-center">'. $template_chosen_word .'</p>';
        echo '</div>';

    }


}
else {

    echo '<p class="error">' . lang('dakota_not_data_to_view'). '<p>';
}


echo '</div>';



