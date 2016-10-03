<?
/**
 * Dakota CMS - An open source CMS
 *
 * Custom Error Pages with i18n
 *
 * @author		Lev Savranskiy
 * @copyright	Copyright (c) 2010, Dakota CMS
 * @link		http://dakota-cms.com/
 * @since		Version 0.1
 */


require('./' .  APPPATH . 'config/config.php');
$lang_file  = './' .  APPPATH . 'language/' . $config['language'] . '/dakota_lang.php';

include($lang_file);

if (isset($error_code)) {

    switch ($error_code) {
        case '404':
            $title = $message_lang = $lang['dakota_not_found'];
            break;
        case 'db':
            $title = $message_lang = $lang['dakota_error_db'];
            break;
        case 'general':
            $title = $message_lang = $lang['dakota_error_general'];
            break;
    }

}
?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title><?= $title; ?> </title>
    <link href="/<?=  TEMPLATES_FOLDER   ?>common/css/error.css" rel="stylesheet" type="text/css"/>
</head>
<body>

<body>
<div id="error_page">
    <h1> <?=  $message_lang; ?></h1>
<? if (isset($message)) {
    echo ' <h2>  ' . $message . ' </h2>';
}
?>
    <p>
        <a href="javascript:history.back()"><?= $lang['dakota_back']?></a> |
        <a href="/"><?= $lang['dakota_main']?></a> |
        <a href="/login/"><?= $lang['dakota_login']?></a>
    <? if (defined('REGISTRATION_ENABLED') && REGISTRATION_ENABLED) echo '| <a href="/register/">' . $lang['dakota_register'] . '</a>'; ?>
    </p>

    <p id="error_page_cms_link">
              <a href="<?= CMS_HOME?>" target="_blank">Powered by Dakota CMS <?= CMS_VERSION?></a>        
    </p>
</div>
</body>
</html>

<? die;