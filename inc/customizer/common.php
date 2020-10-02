<?php
use \Arkhe_Theme\Customizer;

/**
 * セクション : 全体設定
 */
$arkhe_section = 'arkhe_section_global';
$wp_customize->add_section(
	$arkhe_section,
	array(
		'title'    => __( 'Global settings', 'arkhe' ),
		'priority' => 21,
	)
);

// カラー設定
Customizer::big_title(
	$arkhe_section,
	'colors',
	array(
		'label' => __( 'Color settings', 'arkhe' ),
	)
);

// メインカラー
Customizer::add(
	$arkhe_section,
	'color_main',
	array(
		'label'       => __( 'Main color', 'arkhe' ),
		'type'        => 'color',
	)
);

// テキストカラー
Customizer::add(
	$arkhe_section,
	'color_text',
	array(
		'label'       => __( 'Text color', 'arkhe' ),
		'type'        => 'color',
	)
);

// リンクの色
Customizer::add(
	$arkhe_section,
	'color_link',
	array(
		'label'       => __( 'Link color', 'arkhe' ),
		'type'        => 'color',
	)
);

// 背景色
Customizer::add(
	$arkhe_section,
	'color_bg',
	array(
		'label'       => __( 'Background color', 'arkhe' ),
		'type'        => 'color',
	)
);


// コンテンツ幅
Customizer::big_title(
	$arkhe_section,
	'content_width',
	array(
		'label'     => __( 'Content width', 'arkhe' ),
	)
);

// サイト幅
Customizer::add(
	$arkhe_section,
	'container_width',
	array(
		'label'       => __( 'Site width', 'arkhe' ),
		'type'        => 'number',
		'input_attrs' => array(
			'step' => '20',
			'min'  => '400',
		),
		'sanitize'    => 'absint',
	)
);

// スリム幅
Customizer::add(
	$arkhe_section,
	'slim_width',
	array(
		'label'       => __( 'Content width for 1 column (slim width)', 'arkhe' ),
		'type'        => 'number',
		'input_attrs' => array(
			'step' => '20',
			'min'  => '400',
		),
		'sanitize'    => 'absint',
	)
);

// NO-IMAGE設定
Customizer::big_title(
	$arkhe_section,
	'no_image',
	array(
		'label'     => __( 'NO-IMAGE settings', 'arkhe' ),
	)
);

// NO IMAGE画像
Customizer::add(
	$arkhe_section,
	'no_image',
	array(
		'label'       => __( '"NO-IMAGE" image', 'arkhe' ),
		'description' => __( '1600px or more recommended width.', 'arkhe' ),
		'type'        => 'media',
		'mime_type'   => 'image',
	)
);


// パンくずリスト設定
Customizer::big_title(
	$arkhe_section,
	'breadcrumb_list',
	array(
		'label'     => __( 'Breadcrumb list settings', 'arkhe' ),
	)
);

// パンくずリストの位置
Customizer::add(
	$arkhe_section,
	'breadcrumbs_pos',
	array(
		'label'       => __( 'Breadcrumbs position', 'arkhe' ),
		'type'        => 'radio',
		'choices'     => array(
			'top'    => __( 'Top of page', 'arkhe' ),
			'bottom' => __( 'Bottom of page', 'arkhe' ),
		),
	)
);

// 「ホーム」の文字列
Customizer::add(
	$arkhe_section,
	'breadcrumbs_home_text',
	array(
		'label'       => __( '"Home" string', 'arkhe' ),
		'type'        => 'text',
	)
);

// その他の設定
Customizer::sub_title(
	$arkhe_section,
	'breadcrumbs_others',
	array(
		'label'     => __( 'Other settings', 'arkhe' ),
	)
);

// 「投稿ページ」も表示する
Customizer::add(
	$arkhe_section,
	'breadcrumbs_set_home_page',
	array(
		'label'       => __( 'Display "Post page"', 'arkhe' ),
		'description' => ARKHE_NOTE . __( 'It is valid only when "Post page" is set.', 'arkhe' ),
		'type'        => 'checkbox',
	)
);
