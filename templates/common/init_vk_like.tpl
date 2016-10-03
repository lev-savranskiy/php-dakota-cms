<?

echo '
<span id="vk_like"></span>
<script type="text/javascript">
VK.Widgets.Like("vk_like",
  {
     width:  "140" ,
     pageTitle:  "' . $title . '",
     pageDescription:  "' . META_DESCRIPTION . '"
   })
</script>  ';