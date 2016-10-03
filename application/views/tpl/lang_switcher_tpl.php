

<?


echo '<span id="lang_switcher">';

if ( LANG == 'english'){
     echo  img(ICON_EN)  . ' English &harr; ' . '  <a href="/ru/">Русский</a> ';

}
else{
    echo  img(ICON_RU). ' Русский &harr; <a href="/en/">English</a>'  ;
}

echo '</span>';

