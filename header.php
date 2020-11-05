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
	Arkhe::get_part( 'header_content' );
	do_action( 'arkhe_after_header' );
?>
	<div id="content" class="l-content">
		<?php do_action( 'arkhe_start_content' ); // テーマ側でも使用 ?>
		<div class="l-content__body l-container">
