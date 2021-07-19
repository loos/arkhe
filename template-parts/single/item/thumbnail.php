<?php
/**
 * 投稿ページのタイトル部分
 * $args['post_id'] : 投稿IDが渡ってくる
 * $args['post_title'] : 投稿タイトルが渡ってくる
 */
$the_id = isset( $args['post_id'] ) ? $args['post_id'] : get_the_ID();

// アイキャッチがあれば
if ( has_post_thumbnail( $the_id ) ) : ?>
	<figure class="p-entry__thumb">
		<?php
			Arkhe::the_pluggable_part( 'thumbnail', array(
				'post_id'          => $the_id,
				'sizes'            => '(min-width: 800px) 800px, 100vw',
				'class'            => 'p-entry__thumb__img',
				'placeholder_size' => 'medium',
			) );
		?>
	</figure>
<?php
endif;
