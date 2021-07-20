<?php
/**
 * 投稿アイキャッチ画像
 */
?>
<figure class="p-entry__thumb">
	<?php
		ark_the__thumbnail( array(
			'sizes'            => '(min-width: 800px) 800px, 100vw',
			'class'            => 'p-entry__thumb__img',
			'placeholder_size' => 'medium',
		) );
	?>
</figure>
