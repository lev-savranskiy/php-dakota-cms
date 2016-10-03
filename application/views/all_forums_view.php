<h2 class="title"><?= lang('dakota_forums') ?></h2>


<?php foreach($categories as $category): ?>

<div class="forum-category">
		
	<div class="forum-category-title"><?php echo $category->title; ?></div>

	<?php foreach($category->Forums as $forum): ?>
	<div class="forum-wrap">
			
		<div class="forum-title">
			<?php echo anchor('forums/display/'.$forum->id, $forum->title) ?>
			(<?php echo $forum->Threads[0]->num_threads; ?>
                <?php echo num2word($forum->Threads[0]->num_threads, $site_thread_cases) ?>
            )
		</div>
		
		<div class="forum-description">
			<?php echo $forum->description; ?>
		</div>
			
	</div>
	<?php endforeach; ?>
	
</div>
<?php endforeach; ?>