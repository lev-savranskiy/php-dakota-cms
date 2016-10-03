<?
echo '<a name ="comments"></a>';
echo ' <div class="forum-category-title"> ';
echo anchor('/forums/', lang('dakota_forums')) . ICON_BULL . $forum['title'];
echo '  </div>  ';
echo '<div  class="error">';
echo validation_errors();
echo $this->session->flashdata('validation_errors');
echo '</div>';

echo '<div style="margin: 10px 0 20px 0;">';
echo form_open('/forums/addthread/'. $forum['id'] );
echo lang('dakota_title');
echo br();
echo form_input('title', set_value('title'), ' style="width: 400px;" ');
  echo br(2);
echo lang('dakota_content');

echo br();
require_once('./templates/common/init_ed.tpl');
echo form_textarea(array(
    'name' => 'content',
    'id' => 'ed',
    'value' => set_value('content'),
    'cols' => '50',
    'rows' => '5',

));


echo '<p>';
echo lang('dakota_captcha'). nbs(2)  . img('/tools/captcha/');
echo form_input(array('name' => 'captcha', 'maxlength' => 2, 'size' => 2));
echo '</p>';


echo form_submit('submit',  lang('dakota_add'));
echo form_close();
echo '</div>';


?>

