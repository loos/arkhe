<?php
namespace Arkhe_Theme\Dashboard;

/**
 * ダッシュボードにウィジェットボックスを追加
 */
add_action( 'wp_dashboard_setup', __NAMESPACE__ . '\dashboard_setup', 1 );
function dashboard_setup() {
	wp_add_dashboard_widget( 'custom_help_widget', __( 'Arkhe 新着情報', 'arkhe' ), __NAMESPACE__ . '\cb_info_widget' );
}

function cb_info_widget() {
	?>
	<div class="rss-widget">
		<ul class="arkhe-info">
			<?php foreach ( \Arkhe::$arkhe_info as $date => $info ) : ?>
				<li>
					<span class="__date"><?php echo esc_html( $date ); ?></span>
					<br>
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
	</div>
	<?php
}
