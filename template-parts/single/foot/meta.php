<?php
/**
 * 投稿メタ（foot）
 */
?>
<div class="c-postMetas u-flex--aicw">
	<?php
		Arkhe::get_part( 'single/item/term_list', array(
			'show_cat' => true,
			'show_tag' => true,
			'is_head'  => false,
		) );
	?>
</div>
