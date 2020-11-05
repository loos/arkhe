<?php
/**
 * フッターテンプレート
 */
	if ( Arkhe::is_show_sidebar() ) get_sidebar(); // サイドバー
?>
	</div><!-- End: l-content__body -->
	<?php do_action( 'arkhe_end_content' ); ?>
</div><!-- End: l-content -->
<?php
	// フッター
	do_action( 'arkhe_before_footer' ); // テーマ側でも使用
	Arkhe::get_part( 'footer_content' );
	do_action( 'arkhe_after_footer' );

	// モーダルや固定ボタンなど
	Arkhe::get_part( 'footer/fix_btns' );
	Arkhe::get_part( 'footer/modals' );
?>
</div>
<!-- End: #wrapper-->
<?php wp_footer(); ?>
</body>
</html>
