<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');




     if (Auth::has_role()) {
        echo  '<span class="notranslate">' . $USERDATA['user']['firstname'] . ' ' . $USERDATA['user']['lastname'] . nbs(3) . '</span>' ;

         if (Auth::is_admin()) {
             echo anchor('/admin/', lang('dakota_admin_center'), array('target' => '_blank'));
             echo ICON_BULL;
         }


         echo anchor('/users/id/' . $USERDATA['user']['id'],  lang('dakota_my_profile'));
         echo ICON_BULL;

         echo   anchor('logout', lang('dakota_exit'));
     }
     else {

         echo  anchor('login', lang('dakota_enter')) . ICON_BULL;
         echo  anchor('register', lang('dakota_reg'));


     }

 //echo nbs(3)  . LANG;

//
//if (SHOW_TRANSLATION_OPTION){
// echo  nbs(3);
// include('./templates/common/init_google_translate.tpl');
//}



?>


