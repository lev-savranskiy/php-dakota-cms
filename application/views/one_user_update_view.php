<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once('./templates/common/init_autocomplete_ui.tpl');


echo '<script type="text/javascript">';

echo convert_to_js_array($citieslist, 'ac_input_city');
echo convert_to_js_array($countrieslist, 'ac_input_country');




echo <<<SCRIPT
	$(function() {
		$("#ac_input_city").autocomplete({source: ac_input_city, minLength: 2  });
		$("#ac_input_country").autocomplete({source: ac_input_country , minLength: 2 });
	});
SCRIPT;

echo '</script>';






echo '<div>';


echo '<h2>' . anchor('/users', lang('dakota_users')) . ICON_BULL . lang('dakota_my_profile') . '</h2>';


echo form_open('/users/update/');

echo validation_errors('<p class="error">', '</p>');
echo '<p class="error">' . $message . '</p>';


echo '	<p class="left text-right"  ' . min_size(150) . '>' .lang('dakota_user_firstname') . colon() .'</p>';
echo form_input('firstname', set_value('firstname') ? set_value('firstname') : $user->firstname, min_size(200));
echo '	<p class="clear"></p>';


echo '	<p class="left text-right"  ' . min_size(150) .'>' .lang('dakota_user_lastname') . colon() .'</p>';
echo form_input('lastname', set_value('lastname') ? set_value('lastname') : $user->lastname, min_size(200));
echo '	<br />';

echo '	<p class="left text-right"  ' . min_size(150) .'>' .lang('dakota_country') . colon() .'</p>';
echo form_input('country', set_value('country') ? set_value('country') : $user->country, 'id="ac_input_country" class="ac_input" autocomplete="off" ' . min_size(200));
echo '	<br />';

echo '	<p class="left text-right"  ' . min_size(150) .'>' .lang('dakota_city') . colon() .'</p>';
echo form_input('city', set_value('city') ? set_value('city') : $user->city, 'id="ac_input_city" class="ac_input" autocomplete="off" ' . min_size(200));

echo '	<br />';

foreach ($site_user_settings as $s => $v) {

    $width = 300;
    $height = null;
    $label_width = 150;
    
    if ($s == 'bday' || $s == 'bmonth' || $s == 'byear') {
        $width = 20;
        $label_width = 150;
    }

    echo '	<p class="left text-right "  ' . min_size($label_width) . '>' . $v[0] . ': </p>';


    if ($s == 'about') {
        echo form_textarea(array(
            'name' => 'about',
            'id' => 'about',
            'value' => isset($this_user_settings[$s]) ? $this_user_settings[$s] : '',
            'cols' => '35',
            'rows' => '5')
        );
    }
    else {
        echo form_input($s, isset($this_user_settings[$s]) ? $this_user_settings[$s] : '', min_size($width, $height));

    }


    echo '	<br />';
}


echo form_hidden('sent', 1);
echo '	<br />';
echo form_submit('submit', 'Update');
echo form_close();


echo '</div >';





