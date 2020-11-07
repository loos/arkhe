<?php
/**
 * 「この記事を書いた人」
 * $args['author_id'] : 著者IDが渡ってくる
 */
$author_id = isset( $args['author_id'] ) ? $args['author_id'] : 0;
?>
<section class="p-entry__author c-bottomSection">
	<h2 class="c-bottomSection__title">
		<?php
			echo wp_kses(
				apply_filters( 'arkhe_author_area_title', __( 'Author of this article', 'arkhe' ) ),
				\Arkhe::$allowed_text_html
			);
		?>
	</h2>
	<?php Arkhe::get_part( 'others/author_box', array( 'author_id' => $author_id ) ); ?>
</section>
