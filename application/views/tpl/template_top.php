<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="description" content="<?= META_KEYWORDS ; ?>">
    <meta name="keywords" content="<?= META_DESCRIPTION ; ?>">
<?= META_EXTRA ; ?>
    <link rel="shortcut icon" href="<?=TEMPLATES_FOLDER . MY_TEMPLATE ?>/favicon.ico">
    <link title="" type="application/rss+xml" rel="alternate" href="/rss/">

    <title><?= $title; ?> </title>

<?


echo link_tag(TEMPLATES_FOLDER . 'common/css/common.css');

if (ADMIN_CENTER) {

    echo link_tag(TEMPLATES_FOLDER . 'common/css/admin.css');
}
else {
    echo link_tag(TEMPLATES_FOLDER . MY_TEMPLATE . '/css/style.css');

}

// PHP DATA TO JS
// SHOULD GO BEFORE common.js!

$userdata_to_js = isset($USERDATA['user']) ? $USERDATA['user'] : array('role' => 0);
echo '<script type="text/javascript">';
echo convert_to_js($userdata_to_js, 'userdata');
echo "var dakota_delete_alert = '" . lang('dakota_delete_alert') . "';";
echo '</script> ';

?>

    <script language="javascript" type="text/javascript"
            src="/<?=TEMPLATES_FOLDER?>common/js/jquery-1.4.2.min.js"></script>
    <script language="javascript" type="text/javascript" src="/<?=TEMPLATES_FOLDER?>common/js/common.js"
            charset="utf-8"></script>
<?
if (VK_API_WIDGET_CLUB_ID > 0 || VK_API_ID > 0) {
    echo '<script type="text/javascript" src="http://vkontakte.ru/js/api/openapi.js" charset="windows-1251"></script>';
}
if (VK_API_ID > 0) {
    include('./templates/common/init_vk_api.tpl');
}
?>
<script type="text/javascript" src="http://vkontakte.ru/js/api/share.js?9" charset="utf-8"></script>
</head>
<body>


<!-- start  container  -->
<div id="container">

    <div id="profile-link">


<?


if (!ADMIN_CENTER) {
      require('lang_switcher_tpl.php');

  
    if (SHOW_PROFILE_LINK) {
        echo  ICON_BULL;
        require('profile_link_tpl.php');

    }

    if (SHOW_TRANSLATION_OPTION) {

        include('./templates/common/init_google_translate.tpl');
    }


}

echo ' </div >';