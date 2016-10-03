<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

 require_once('./templates/common/init_lightbox.tpl');
 echo link_tag(TEMPLATES_FOLDER . 'common/css/gallery.css');


echo '<h2 class="title">' . lang('dakota_gallery').'</h2>';


if (isset($images) && count($images)) {
echo '<div id="gallery">   ';
    foreach ($images as $image) {

        echo '<div class="left">   ';
        echo '	<a class="lightbox" href="' . $image['url'] . ' ">  ';
        echo '	<img  src="' . $image['thumb_url'] . '" />';
        echo '	</a>';
        echo '</div> ';
    }
  echo '</div> ';
}
else{
    echo '		<div id="blank_gallery">'. lang('dakota_not_data_to_view').'</div>    ';
}








