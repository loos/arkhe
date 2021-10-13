<?php
/**
 * 投稿ページのタームリスト
 */
$the_id   = get_the_ID();
$is_head  = isset( $args['is_head'] ) ? $args['is_head'] : true;
$show_cat = isset( $args['show_cat'] ) ? $args['show_cat'] : true;
$show_tag = isset( $args['show_tag'] ) ? $args['show_tag'] : false;
$cat_data = $show_cat ? Arkhe::get_the_terms_data( $the_id, 'category' ) : null;
$tag_data = $show_tag ? Arkhe::get_the_terms_data( $the_id, 'post_tag' ) : null;

$has_cat = ! empty( $cat_data );
$has_tag = ! empty( $tag_data );

if ( ! $has_cat && ! $has_tag ) return;
?>
<div class="c-postTerms u-flex--aicw">
	<?php if ( $has_cat ) : ?>
		<div class="c-postTerms__item -category u-flex--aicw">
			<?php if ( $is_head ) : ?>
				<i class="c-postMetas__icon arkhe-icon-folder"></i>
			<?php endif; ?>
			<?php foreach ( $cat_data as $data ) : ?>
				<a class="c-postTerms__link" href="<?php echo esc_url( $data['url'] ); ?>" data-cat-id="<?php echo esc_attr( $data['id'] ); ?>">
					<?php echo esc_html( $data['name'] ); ?>
				</a>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
	<?php if ( $has_tag ) : ?>
		<div class="c-postTerms__item -tag u-flex--aicw">
			<?php if ( $is_head ) : ?>
				<i class="c-postMetas__icon arkhe-icon-tag"></i>
			<?php endif; ?>
			<?php foreach ( $tag_data as $data ) : ?>
				<a class="c-postTerms__link" href="<?php echo esc_url( $data['url'] ); ?>" data-cat-id="<?php echo esc_attr( $data['id'] ); ?>">
					<?php echo esc_html( $data['name'] ); ?>
				</a>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
</div>
