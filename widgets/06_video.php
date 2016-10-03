<?


$widget_info['active'] = 1;
$widget_info['title'] = 'Video' ;
$widget_info['description']= 'YouTube, Vimeo etc.';
$widget_info['url'] = 'http://dakota-cms.com';
$widgets_info[] = $widget_info;



if (!defined('SHOW_WIDGET_INFO') && $widget_info['active']) {
    echo '<li id="widget_video">';


/*------------------------  start your code here  ----------- */

 $videos= array(
     'http://www.youtube.com/watch?v=nCgQDjiotG0',
     'http://www.youtube.com/watch?v=GP5C3WrLx_s' ,
     'http://www.youtube.com/watch?v=iUHjDJxkcSE' ,
     'http://www.youtube.com/watch?v=gKg_QtlmZfc',
     'http://www.youtube.com/watch?v=aemXgP-2xyg'
 );


$video_url = $videos[rand(0, count($videos) - 1 )];
  //instantiate EmbeVi class
$embevi = new Embed_Video();

echo '   <h2>' . lang('dakota_video_of_the_day') . '</h2> ';
echo '  <ul class="overflow-hidden">';

// link, width, height
echo  $embevi->parseText($video_url , 280, 200);

echo '  </ul>';

/*------------------------  end your code here ----------- */

    echo '</li>';
}




