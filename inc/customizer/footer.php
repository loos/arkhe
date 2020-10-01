<?php
use \Arkhe_Theme\Customizer;

/**
 * セクション : フッター
 */
$arkhe_section = 'arkhe_section_footer';
$wp_customize->add_section(
	$arkhe_section,
	array(
		'title'    => __( 'Footer', 'arkhe' ),
		'priority' => 21,
	)
);


// 「ページトップへ」ボタン
Customizer::sub_title(
	$arkhe_section,
	'pagetop',
	array(
		'label'     => __( '"To the top" button', 'arkhe' ),
	)
);

// ボタンを表示する
Customizer::add(
	$arkhe_section,
	'show_pagetop',
	array(
		'label'       => __( 'Show button', 'arkhe' ),
		'type'        => 'checkbox',
	)
);

// コピーライトのテキスト
Customizer::add(
	$arkhe_section,
	'copyright',
	array(
		'label'       => __( 'Copyright text', 'arkhe' ),
		'type'        => 'text',
	)
);
