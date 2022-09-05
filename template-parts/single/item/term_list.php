<?php
/**
 * 投稿ページのタームリスト
 */
$the_id   = get_the_ID();
$the_type = get_post_type();
$is_head  = isset( $args['is_head'] ) ? $args['is_head'] : true;
$show_cat = isset( $args['show_cat'] ) ? $args['show_cat'] : true;
$show_tag = isset( $args['show_tag'] ) ? $args['show_tag'] : false;
$cat_data = $show_cat ? Arkhe::get_the_terms_data( $the_id, 'category' ) : null;
$tag_data = $show_tag ? Arkhe::get_the_terms_data( $the_id, 'post_tag' ) : null;

// データを持つかどうか
$has_cat = ! empty( $cat_data );
$has_tag = ! empty( $tag_data );

// カスタム投稿用
$has_tax = false;
if ( 'post' !== $the_type ) {
	$show_tax = isset( $args['show_tax'] ) ? $args['show_tax'] : false;
	$tax_slug = $show_tax ? Arkhe::get_tax_of_post_type( $the_type ) : '';
	$tax_data = $tax_slug ? Arkhe::get_the_terms_data( $the_id, $tax_slug ) : null;
	$has_tax  = ! empty( $tax_data );
}

// どのタームも持たない場合は何も表示しない
if ( ! $has_cat && ! $has_tag && ! $has_tax ) return;

?>
<div class="c-postTerms u-flex--aicw">
	<?php if ( $has_cat ) : ?>
		<div class="c-postTerms__item -category u-flex--aicw">
			<?php Arkhe::the_svg( 'folder', array( 'class' => 'c-postMetas__icon' ) ); ?>
			<?php foreach ( $cat_data as $data ) : ?>
				<a class="c-postTerms__link" href="<?php echo esc_url( $data['url'] ); ?>" data-cat-id="<?php echo esc_attr( $data['id'] ); ?>">
					<?php echo esc_html( $data['name'] ); ?>
				</a>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
	<?php if ( $has_tag ) : ?>
		<div class="c-postTerms__item -tag u-flex--aicw">
			<?php Arkhe::the_svg( 'tag', array( 'class' => 'c-postMetas__icon' ) ); ?>
			<?php foreach ( $tag_data as $data ) : ?>
				<a class="c-postTerms__link" href="<?php echo esc_url( $data['url'] ); ?>" data-tag-id="<?php echo esc_attr( $data['id'] ); ?>">
					<?php echo esc_html( $data['name'] ); ?>
				</a>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
	<?php if ( $has_tax ) : ?>
		<div class="c-postTerms__item -tax u-flex--aicw">
			<?php
				Arkhe::the_svg( 'tax', array(
					'class'   => 'c-postMetas__icon',
					'context' => 'tax-icon',
				) );
			?>
			<?php foreach ( $tax_data as $data ) : ?>
				<a class="c-postTerms__link" href="<?php echo esc_url( $data['url'] ); ?>" data-term-id="<?php echo esc_attr( $data['id'] ); ?>">
					<?php echo esc_html( $data['name'] ); ?>
				</a>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
</div>
