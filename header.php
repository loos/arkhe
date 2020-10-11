<!DOCTYPE html>
<html <?php language_attributes(); ?> <?php Arkhe::root_attrs(); ?>>
<head>
<meta charset="utf-8">
<meta name="format-detection" content="telephone=no">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, viewport-fit=cover">
<?php
	wp_head();
	$setting = Arkhe::get_setting(); // SETTING取得
?>
</head>
<body <?php body_class(); ?>>
<?php if ( function_exists( 'wp_body_open' ) ) wp_body_open(); ?>
<!-- Start: #wrapper -->
<div id="wrapper" class="l-wrapper">
<?php
	// ヘッダー
	do_action( 'arkhe_before_header' );
	Arkhe::get_parts( 'header' );
	do_action( 'arkhe_after_header' );

	// コンテンツエリアの開始タグなど
	Arkhe::get_parts( 'content_open' );
