<!-- start header -->
<div id="header">
	<div id="logo">
		<h1><a href="/" name="top">Новый сайт / New site</a></h1>

	</div>
	<div id="search">
		<form method="post" action="/search/">
			<fieldset>
			<legend>Поиск / Search</legend>
			<input type="text" name="q" id="search-text" size="15" value="<?=lang('dakota_search')?>..." />
			<input type="submit" id="search-submit" value="ok" />
			</fieldset>
		</form>
	</div>
	<div id="menu">
  <?= MENU ?>
	</div>
</div>
<!-- end header -->