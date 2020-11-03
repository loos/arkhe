<?php
/**
 * 検索ボタンの出力テンプレート
 */
$label      = isset( $args['label'] ) ? $args['label'] : '';
$href       = isset( $args['href'] ) ? $args['href'] : '';
$icon_class = isset( $args['icon_class'] ) ? $args['icon_class'] : '';
$is_search  = isset( $args['is_search'] ) ? $args['is_search'] : true;

?>
<div class="l-header__searchBtn">
	<?php if ( $is_search ) : ?>
		<button class="c-iconBtn u-flex--c" data-onclick="toggleSearch" aria-label="<?php esc_attr_e( 'Search button', 'arkhe' ); ?>">
			<span class="c-iconBtn__icon"><i class="__icon arkhe-icon-search" role="img" aria-hidden="true"></i></span>
			<span class="c-iconBtn__label"><?php echo esc_html( $label ); ?></span>
		</button>
	<?php else : ?>
		<a href="<?php echo esc_url( $href ); ?>" class="c-iconBtn u-flex--c">
			<span class="c-iconBtn__icon"><i class="<?php echo esc_attr( $icon_class ); ?>" role="img" aria-hidden="true"></i></span>
			<span class="c-iconBtn__label"><?php echo esc_html( $label ); ?></span>
		</a>
	<?php endif; ?>
</div>
