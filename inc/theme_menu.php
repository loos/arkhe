<?php
namespace Arkhe_Theme;

/**
 * 管理画面へ表示するメッセージ
 */
add_action( 'admin_menu', '\Arkhe_Theme\add_theme_menu' );
function add_theme_menu() {
	$menu_title = __( 'Arkhe', 'arkhe' );
		add_theme_page(
			$menu_title,
			$menu_title,
			'edit_theme_options',
			'arkhe',
			'\Arkhe_Theme\display_theme_menu'
		);
}


function display_theme_menu() {
	?>
	<div class="wrap arkhe-page" id="arkhe-page-wrap">
		<h1 class="arkhe-page__title">
			<img class="arkhe-page__logo" src="<?php echo esc_url( ARKHE_THEME_URI . '/assets/img/arkhe_logo.png' ); ?>" alt="Arkhe">
		</h1>
		<div class="arkhe-page__header">
			<a class="button button-primary" target="_blank" rel="noopener" href="https://arkhe-theme.com/ja/update/">
				<?php esc_html_e( 'To Arkhe official website', 'arkhe' ); ?>
			</a>
			<a class="button button-primary" target="_blank" rel="noopener" href="https://arkhe-theme.com/ja/document/">
				<?php esc_html_e( 'See the manual', 'arkhe' ); ?>
			</a>
			<a class="button button-primary" target="_blank" rel="noopener" href="https://arkhe-theme.com/ja/update/">
				<?php esc_html_e( 'See update information', 'arkhe' ); ?>
			</a>
		</div>

		<?php
			// phpcs:ignore WordPress.Security.NonceVerification.Recommended
			$now_tab = isset( $_GET['tab'] ) ? sanitize_text_field( wp_unslash( $_GET['tab'] ) ) : 'info';

			// タブ
			$tabs = array(
				'info'    => _x( 'Information', 'tab', 'arkhe' ),
				'licence' => __( 'Pro Licence', 'arkhe' ),
			);

			echo '<div class="nav-tab-wrapper">';
			foreach ( $tabs as $key => $val ) :
				$tab_url   = admin_url( 'themes.php?page=arkhe' ) . '&tab=' . $key;
				$nav_class = ( $now_tab === $key ) ? 'nav-tab nav-tab-active' : 'nav-tab';
				echo '<a href="' . esc_url( $tab_url ) . '" class="' . esc_attr( $nav_class ) . '">' . esc_html( $val ) . '</a>';
			endforeach;
			echo '</div>';

			// コンテンツ
			echo '<div class="arkhe-page__body">';
			include __DIR__ . '/theme_menu/' . $now_tab . '.php';
			echo '</div>';
		?>
	</div>
	<?php
}