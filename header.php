<?php ?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> <?php Arkhe_Theme::root_attrs(); ?>>
<head>
<meta charset="utf-8">
<meta name="format-detection" content="telephone=no">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, viewport-fit=cover">
<?php
	wp_head();
	$setting = Arkhe_Theme::get_setting(); // SETTING取得
?>
</head>
<body <?php body_class(); ?>>
<?php if ( function_exists( 'wp_body_open' ) ) wp_body_open(); ?>
<div id="wrapper" class="l-wrapper">
	<?php
		// ヘッダー
		do_action( 'arkhe_before_header' );
		Arkhe_Theme::get_parts( 'header' );
		do_action( 'arkhe_after_header' );
	?>
	<div id="content" class="l-content">
	<?php
		// コンテンツヘッダー
		if ( Arkhe_Theme::is_show_ttltop() ) Arkhe_Theme::get_parts( 'top_area' );

		do_action( 'arkhe_content_start' );

		// パンくずリスト
		if ( 'top' === $setting['breadcrumbs_pos'] ) Arkhe_Theme::get_parts( 'others/breadcrumb' );
	?>
		<div class="l-content__body l-container">
