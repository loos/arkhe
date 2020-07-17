<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> <?php ARKHE_THEME::root_attrs(); ?>>
<head>
<meta charset="utf-8">
<meta name="format-detection" content="telephone=no">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, viewport-fit=cover">
<?php
	wp_head();
	$SETTING = ARKHE_THEME::get_setting(); // SETTING取得
?>
</head>
<body <?php body_class(); ?>>
<?php if ( function_exists( 'wp_body_open' ) ) wp_body_open(); ?>
<div id="wrapper" class="l-wrapper">
	<?php
		// ヘッダー
		do_action( 'arkhe_before_header' );
		ARKHE_THEME::get_parts( 'header' );
		do_action( 'arkhe_after_header' );
	?>
	<div id="content" class="l-content">
	<?php
		// コンテンツヘッダー
		if ( ARKHE_THEME::is_show_ttltop() ) ARKHE_THEME::get_parts( 'top_area' );

		do_action( 'arkhe_content_start' );

		// パンくずリスト
		if ( 'top' === $SETTING['breadcrumbs_pos'] ) ARKHE_THEME::get_parts( 'others/breadcrumb' );
	?>
		<div class="l-content__body l-container">
