<?php
use \ARKHE_THEME\Customizer;
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * セクション : フッター
 */
$section = 'arkhe_section_footer';
$wp_customize->add_section(
	$section,
	array(
		'title'    => __( 'Footer', 'arkhe' ),
		'priority' => 21,
	)
);


// 「ページトップへ」ボタン
Customizer::sub_title(
	$section,
	'pagetop',
	array(
		'label'     => __( '"To the top" button', 'arkhe' ),
	)
);

// ボタンを表示する
Customizer::add(
	$section,
	'show_pagetop',
	array(
		'label'       => __( 'Show button', 'arkhe' ),
		'type'        => 'checkbox',
	)
);

// コピーライトのテキスト
Customizer::add(
	$section,
	'copyright',
	array(
		'label'       => __( 'Copyright text', 'arkhe' ),
		'type'        => 'text',
	)
);
