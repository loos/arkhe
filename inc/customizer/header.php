<?php
use \ARKHE_THEME\Customizer;
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'arkhe_section_header';

/**
 * セクション : ヘッダー
 */
$wp_customize->add_section(
	$section,
	array(
		'title'    => __( 'Header', 'arkhe' ),
		'priority' => 21,
	)
);


// ヘッダーロゴの設定
Customizer::big_title(
	$section,
	'header_logo',
	array(
		'label' => __( 'Header logo settings', 'arkhe' ),
	)
);

// ロゴ画像
Customizer::add(
	$section,
	'head_logo',
	array(
		'label'       => __( 'Logo image', 'arkhe' ),
		// 'description' => 'ロゴ画像を設定してください。',
		'type'        => 'image',
		'partial'     => array(
			'selector'            => '.l-header__logo',
			'container_inclusive' => false, // 中身だけ書き換える
			'render_callback'     => array( '\ARKHE_THEME\Customizer\Partial', 'head_logo' ),
		),
	)
);

// 画像サイズ（PC）
Customizer::add(
	$section,
	'logo_size_pc',
	array(
		'label'       => __( 'Image size', 'arkhe' ) . ' (PC)',
		'description' => '32~120px',
		'type'        => 'number',
		'input_attrs' => array(
			'step'    => '1',
			'min'     => '32',
			'max'     => '120',
		),
		'sanitize'    => array( '\ARKHE_THEME\Customizer\Sanitize', 'int' ),
	)
);

// 画像サイズ（SP）
Customizer::add(
	$section,
	'logo_size_sp',
	array(
		'label'       => __( 'Image size', 'arkhe' ) . ' (SP)',
		'description' => '40~80px',
		'type'        => 'number',
		'input_attrs' => array(
			'step'    => '1',
			'min'     => '40',
			'max'     => '80',
		),
		'sanitize'    => array( '\ARKHE_THEME\Customizer\Sanitize', 'int' ),
	)
);



// オーバーレイ設定
Customizer::big_title(
	$section,
	'top_header',
	array(
		'label' => __( 'Overlay settings', 'arkhe' ),
	// 'description' => '※ この設定を使う場合、PCのヘッダーレイアウトは横並びにしてください。',
	)
);

Customizer::add(
	$section,
	'header_overlay',
	array(
		'type'        => 'select',
		'choices'     => array(
			'off' => 'OFF',
			'on'  => 'ON',
		),
	)
);

// 固定ページでも有効化する
Customizer::add(
	$section,
	'header_overlay_on_page',
	array(
		'classname'   => '-header-overlay',
		'label'       => __( 'Enable on Pages', 'arkhe' ),
		'type'        => 'checkbox',
	)
);

// オーバーレイ時のロゴ画像
Customizer::add(
	$section,
	'head_logo_overlay',
	array(
		'classname'   => '-header-overlay',
		'label'       => __( 'Logo image when overlaying', 'arkhe' ),
		'type'        => 'image',
	)
);


// ヘッダーの固定設定
Customizer::big_title(
	$section,
	'fix_head',
	array(
		'label' => __( 'Fixed header setting', 'arkhe' ),
	)
);

// ヘッダーを画面上部に固定する （PC）
Customizer::add(
	$section,
	'fix_header_pc',
	array(
		'label'       => __( 'Fixed header at top of screen', 'arkhe' ) . ' (PC)',
		'type'        => 'checkbox',
	)
);

// ヘッダーを画面上部に固定する (SP)
Customizer::add(
	$section,
	'fix_header_sp',
	array(
		'label'       => __( 'Fixed header at top of screen', 'arkhe' ) . ' (SP)',
		'type'        => 'checkbox',
	)
);
