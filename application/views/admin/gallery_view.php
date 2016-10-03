<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


echo '<div id="admin-main">';



require_once('./templates/common/init_lightbox.tpl');

require_once('dash_menu.php');

echo '<h2 class="left">' .lang('dakota_gallery') .'</h2>'  ;
echo '<h3 class="right help-button">' . img(ICON_HELP) . nbs(1) . anchor_help('gallery').' </h3>';

echo '<div class ="error clear">' . $error . '</div>';

if (isset($gallery_config) && safe_count($gallery_config)) {

    echo  lang('dakota_max_size') . colon() . $gallery_config['max_size'] . ' kB';
    echo br();
    echo lang('dakota_max_w') . colon() . $gallery_config['max_width']. ' px';
    echo br();
    echo lang('dakota_max_h') . colon() . $gallery_config['max_height']. ' px';
    echo br();
    echo lang('dakota_files') . nbs() . str_replace('|', ',' ,$gallery_config['allowed_types']) . nbs(). lang('dakota_allowed');
   echo br(2);

}

echo '<div id="upload"> ';

echo form_open_multipart('/admin/gallery');
echo lang('dakota_files_select');
echo form_upload('userfile');
echo br();
echo  lang('dakota_files_select_preview_type'); 
echo form_dropdown('thumb_type', $thumb_types_prepared);
echo br();
echo form_submit('upload', lang('dakota_upload'));
echo form_close();

echo '	</div>     ';

echo '<div id="gallery">   ';

if (isset($images) && safe_count($images)) {
       echo '<div id="blank_gallery">' .lang('dakota_files') . colon() . count($images) . '</div>    '; 

    foreach ($images as $image) {

        echo '<div class="left padded"  >   ';
        echo '	<a class="lightbox" href="' . $image['url'] . ' ">  ';
        echo '	<img   src="' . $image['thumb_url'] . '" />';
        echo '	</a>';
       echo br();
        echo  anchor($image['url'], ' link' ) ;
        echo ICON_BULL;
        echo  anchor('/admin/gallery/delete/' . $image['filename'] . '/' . TOKEN, 'delete') ;
        echo '</div> ';
    }

}
else{
    echo '		<div id="blank_gallery">' . lang('dakota_not_data_to_view'). '</div>    ';
}

echo '	</div>  ';

 echo '	<div class="clear"></div>    ';

echo '</div>';

?>



