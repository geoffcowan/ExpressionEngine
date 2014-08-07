<?php extend_template('default-nav'); ?>

<?=form_open($table['base_url'], 'class="tbl-ctrls"')?>
	<fieldset class="tbl-search right">
		<input placeholder="<?=lang('type_phrase')?>" name="search" type="text" value="<?=$table['search']?>">
		<input class="btn submit" type="submit" value="<?=lang('search_table')?>">
	</fieldset>
	<h1><?=$cp_page_title?></h1>
	<?php $this->view('_shared/table', $table);?>
</form>