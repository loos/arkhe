<?php
/**
 * 投稿アイキャッチ画像
 */
$caption = isset( $args['caption'] ) ? $args['caption'] : '';
?>
<figure class="p-entry__thumb">
	<?php
		ark_the__thumbnail( array(
			'class' => 'p-entry__thumb__img',
			'sizes' => '(min-width: 800px) 800px, 100vw',
		) );
	?>
	<?php if ( $caption ) : ?>
		<figcaption class="p-entry__thumb__figcaption"><?php echo wp_kses( $caption, Arkhe::$allowed_text_html ); ?></figcaption>
	<?php endif; ?>
</figure>
