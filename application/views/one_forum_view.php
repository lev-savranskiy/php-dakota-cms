
	<div class="forum-category-title"><?php echo anchor('/forums/', lang('dakota_forums_back')) .  ICON_BULL .  $forum['title'] ; ?></div>

	<div class="forum-add margin-bottom larger"><?php echo anchor('/forums/addthread/' .  $forum['id'] . '#comments', lang('dakota_forums_create_topic'))  ?></div>

<?php foreach($threads as $thread): ?>
<div class="forum-post">
	
        <div class="forum-post-title">
		<?php echo anchor('/forums/thread/'.$thread['id'], $thread['title']) ?>
		(<?php echo $thread['num_replies'] . ' ' . num2word($thread['num_replies'], $site_replies_cases)?> )
		</div>
	
        <div class="byline small">
		 <?=   lang('dakota_author'). colon() . anchor('users/id/'.$thread['user_id'],	$thread['username'] , '' ,  ' class="notranslate" ').
          nbs(3) . lang('dakota_forums_last_comment'). colon() . $thread['last_post_date'];
         ?>
	</div>
	
</div>
<?php endforeach; ?>
