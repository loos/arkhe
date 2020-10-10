<?php
	// コンテンツエリアの終了タグやサイドバーなど
	Arkhe::get_parts( 'content_close' );

	// フッター
	do_action( 'arkhe_before_footer' );
	Arkhe::get_parts( 'footer' );
	do_action( 'arkhe_after_footer' );

	Arkhe::get_parts( 'footer/fix_btns' );
	Arkhe::get_parts( 'footer/modals' );
?>
</div>
<!-- End: #wrapper-->
<?php wp_footer(); ?>
</body>
</html>
