<?php
/**
 * 投稿アイキャッチ画像
 */
?>
<figure class="p-entry__thumb">
	<?php
		Arkhe::the_pluggable_part( 'thumbnail', array(
			'post_id'          => get_the_ID(),
			'sizes'            => '(min-width: 800px) 800px, 100vw',
			'class'            => 'p-entry__thumb__img',
			'placeholder_size' => 'medium',
		) );
	?>
</figure>
