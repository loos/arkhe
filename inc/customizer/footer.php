<?php
use \Arkhe_Theme\Customizer;

/**
 * セクション : フッター
 */
$arkhe_section = 'arkhe_section_footer';
$wp_customize->add_section( $arkhe_section,
	array(
		'title'    => __( 'Footer', 'arkhe' ),
		'priority' => 21,
	)
);

// カラー設定
Customizer::big_title( $arkhe_section, 'footer_logo',
	array(
		'label' => __( 'Color settings', 'arkhe' ),
	)
);

// ヘッダーの背景色
Customizer::add( $arkhe_section, 'footer_color_bg',
	array(
		'label' => __( 'Footer background color', 'arkhe' ),
		'type'  => 'color',
	)
);

// ヘッダーの文字色
Customizer::add( $arkhe_section, 'footer_color_txt',
	array(
		'label' => __( 'Footer text color', 'arkhe' ),
		'type'  => 'color',
	)
);


// カラー設定
Customizer::big_title( $arkhe_section, 'footer_others',
	array(
		'label' => __( 'Other settings', 'arkhe' ),
	)
);


// 「ページトップへ」ボタン
Customizer::sub_title( $arkhe_section, 'pagetop',
	array(
		'label' => __( '"To the top" button', 'arkhe' ),
	)
);

// ボタンを表示する
Customizer::add( $arkhe_section, 'show_pagetop',
	array(
		'label' => __( 'Show button', 'arkhe' ),
		'type'  => 'checkbox',
	)
);

// コピーライトのテキスト
Customizer::add( $arkhe_section, 'copyright',
	array(
		'label' => __( 'Copyright text', 'arkhe' ),
		'type'  => 'text',
	)
);
