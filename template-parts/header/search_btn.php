<?php
/**
 * 検索ボタンの出力テンプレート
 *   $args['label'] : ボタン下のラベル
 */
$label = isset( $args['label'] ) ? $args['label'] : '';
?>
<div class="l-header__searchBtn">
	<button class="c-iconBtn u-flex--c" data-onclick="toggleSearch" aria-label="<?php esc_attr_e( 'Search button', 'arkhe' ); ?>">
		<span class="c-iconBtn__icon"><i class="arkhe-icon-search" role="img" aria-hidden="true"></i></span>
		<?php if ( $label ) : ?>
			<span class="c-iconBtn__label"><?php echo esc_html( $label ); ?></span>
		<?php endif; ?>
	</button>
</div>
