<?php
/**
 * 関連記事
 */
$the_post_id = isset( $args['post_id'] ) ? $args['post_id'] : get_the_ID();

$setting = Arkhe::get_setting();

// レイアウト
$list_type      = $setting['related_posts_layout'];
$posts_per_page = 'card' === $list_type ? 6 : 4;

$related_args = array(
	'post__not_in'        => array( $the_post_id ),
	'post_type'           => 'post',
	'post_status'         => 'publish',
	'no_found_rows'       => true,
	'ignore_sticky_posts' => true,
	'posts_per_page'      => $posts_per_page,
	'orderby'             => 'rand',
);

if ( 'category' === $setting['post_relation_type'] ) {
	// カテゴリ情報から関連記事を呼び出す

	$categories = get_the_category( $the_post_id );
	$cat_array  = array();

	foreach ( $categories as $the_cat ) {
		array_push( $cat_array, $the_cat->cat_ID );
	}
	if ( ! empty( $cat_array ) ) {
		$related_args['category__in'] = $cat_array;
	}
} else {
	// タグ情報から関連記事を呼び出す

	$tags      = wp_get_post_tags( $the_post_id );
	$tag_array = array();
	foreach ( $tags as $the_tag ) {
		array_push( $tag_array, $the_tag->term_id );
	}
	if ( ! empty( $tag_array ) ) {
		$related_args['tag__in'] = $tag_array;
	}
}

// WP_Query生成
$related_query = new WP_Query( apply_filters( 'arkhe_related_posts_args', $related_args ) );

// ループのカウント用変数
$loop_count = 0;
?>
<section class="p-entry__related c-bottomSection">
	<h2 class="c-bottomSection__title">
		<?php
			echo wp_kses(
				apply_filters( 'arkhe_related_area_title', __( 'Related posts', 'arkhe' ) ),
				\Arkhe::$allowed_text_html
			);
		?>
	</h2>
	<?php if ( $related_query->have_posts() ) : ?>
		<ul class="p-postList -type-<?php echo esc_attr( $list_type ); ?> -related">
			<?php
				while ( $related_query->have_posts() ) :
					$related_query->the_post();
					Arkhe::get_part( 'post_list/style/related', array( 'count' => $loop_count++ ) );
				endwhile;
			?>
		</ul>
		<?php else : ?>
			<div class="p-postList--notfound">
				<?php esc_html_e( 'No related posts were found.', 'arkhe' ); ?>
			</div>
		<?php
		endif;
		wp_reset_postdata();
	?>
</section>
