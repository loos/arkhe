<?php
/**
 * 「投稿ページ」に設定されたページ or ホームページに指定がない場合のトップページ
 */
get_header();
?>
<main id="main_content" class="<?php Arkhe::main_class(); ?>">
	<div class="<?php Arkhe::main_body_class(); ?>">
		<?php
			do_action( 'arkhe_start_home_main' );

			// ページタイトル
			if ( ! Arkhe::is_show_ttltop() ) :
				Arkhe::get_part( 'page/title' );
			endif;

			// コンテンツ
			do_action( 'arkhe_before_home_content' );
			Arkhe::get_part( 'home' );
			do_action( 'arkhe_after_home_content' );

			do_action( 'arkhe_end_home_main' );
		?>
	</div>
</main>
<?php
get_footer();
