<?

$widget_info['active'] = 1;
$widget_info['title'] = lang('dakota_gallery');
$widget_info['description'] = lang('dakota_slideshow') . colon() . lang('dakota_folder') . GALLERY_FOLDER ;
$widget_info['url'] = 'http://dakota-cms.com';

$widgets_info[] = $widget_info;

// path to images
$slideshow_images_path = GALLERY_FOLDER . 'thumbs/' ;
// images width
$slideshow_images_width = 100 ;




if (!defined('SHOW_WIDGET_INFO') && $widget_info['active'] && $CI->uri->segment(1) != 'gallery' ) {
  // start your code here
 ?>


<script type="text/javascript" src="/templates/common/js/jquery.cycle.lite.min.js"></script>

 <script type="text/javascript">
 $(function() {
     $('#slideshow').cycle({
         fx:     'turnDown',
         timeout: 3000,
         random: 10,
         slideExpr: 'img'

     });
     $('#slideshow').show();
     $('#slideshow-load').hide();
 });
 </script>
 <style type="text/css">
 #slideshow { margin: 0px auto; width: <?=$slideshow_images_width?>px; height: <?=$slideshow_images_width + 20?>px; }
 #slideshow img {width: <?=$slideshow_images_width?>px; border: none;}
 </style>



<?
        echo '<li class="widget_slideshow">';
/*------------------------  start your code here  ----------- */
    $slideshow_images = get_filenames($slideshow_images_path);


    echo '   <h2>' . lang('dakota_gallery') .'</h2> ';
    echo '  <ul id="slideshow-load">loading...</ul>';
    echo '  <ul id="slideshow" style="display:none; margin: 10px auto;">';
        if (safe_count($slideshow_images) > 0) {
            foreach ($slideshow_images as $slideshow_image) {
         echo '    <a href="/gallery/" title="'. lang('dakota_see_full').'"> <img src="/'.$slideshow_images_path . $slideshow_image .'"  /></a>';
            }
        }
         else{
              echo lang('dakota_not_data_to_view') . colon() .$slideshow_images_path ;
         }

    echo '  </ul>';

/*------------------------  end your code here ----------- */
           echo '</li>';
}

