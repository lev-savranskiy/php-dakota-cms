<?

 if (Auth::is_admin() && ! ADMIN_CENTER){

echo ' <div id="benchmark">' . lang('dakota_page_loaded') . nbs(2) . $CI->benchmark->elapsed_time() . 's';
echo '<br />' . lang('dakota_bd_requests') . nbs(2) . count($CI->db->queries) ;
echo ' </div>';

 }

?>
<!-- end container  -->      </div>
</body>
</html> 


