<?php
	// delete_transient( 'arkhe_informations' );
?>
<h3><?php esc_html_e( 'Information about the theme', 'arkhe' ); ?></h3>
<ul class="arkhe-info">
	<?php foreach ( \Arkhe::$arkhe_info as $date => $info ) : ?>
		<li>
			<span class="__date"><?php echo esc_html( $date ); ?></span>
			<?php if ( $info['url'] ) : ?>
				<a class="__title" href="<?php echo esc_url( $info['url'] ); ?>" target="_blank" rel="noopener">
					<?php echo esc_html( $info['text'] ); ?>
				</a>
			<?php else : ?>
				<span class="__title"><?php echo esc_html( $info['text'] ); ?></span>
			<?php endif; ?>
		</li>
	<?php endforeach; ?>
</ul>

<?php if ( \Arkhe::$is_ja ) : ?>
	<h3><?php esc_html_e( 'Arkhe plugin', 'arkhe' ); ?></h3>
	<div class="arkhe-page__plugins">
		<a class="__plugin" target="_blank" rel="noopener" href="https://arkhe-theme.com/ja/product/arkhe-toolkit/">
			<img class="__img" src="<?php echo esc_url( ARKHE_THEME_URI . '/assets/img/arkhe-toolkit.jpg' ); ?>" alt="">
			<div class="__title">Arkhe Toolkit</div>
			<div class="__desc">Arkheの機能を拡張し、便利な設定項目を追加するプラグインです。</div>
		</a>
		<a class="__plugin" target="_blank" rel="noopener" href="https://arkhe-theme.com/ja/product/arkhe-blocks-pro/">
			<img class="__img" src="<?php echo esc_url( ARKHE_THEME_URI . '/assets/img/arkhe-blocks.jpg' ); ?>" alt="">
			<div class="__title">Arkhe Blocks</div>
			<div class="__desc">Arkhe専用のブロック機能を拡張できるプラグインです。</div>
		</a>
		<a class="__plugin" target="_blank" rel="noopener" href="https://arkhe-theme.com/ja/product/arkhe-wookit/">
			<img class="__img" src="<?php echo esc_url( ARKHE_THEME_URI . '/assets/img/arkhe-wookit.jpg' ); ?>" alt="">
			<div class="__title">Arkhe Wookit</div>
			<div class="__desc">ArkheをWooCommerceへ対応させることができるプラグインです。</div>
		</a>
	</div>
<?php endif; ?>
