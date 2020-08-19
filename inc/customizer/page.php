<?php
use \ARKHE_THEME\Customizer;
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'arkhe_section_page';

/**
 * セクション : 固定ページ
 */
$wp_customize->add_section(
	$section,
	array(
		'title'    => __( 'Pages', 'arkhe' ),
		'priority' => 22,
	)
);

// タイトル設定
Customizer::big_title(
	$section,
	'page_title',
	array(
		'label' => __( 'Title settings', 'arkhe' ),
	)
);

Customizer::add(
	$section,
	'page_title_pos',
	array(
		'label'       => __( 'Position of title', 'arkhe' ),
		'type'        => 'radio',
		'choices'     => array(
			'top'   => __( 'Top of content', 'arkhe' ),
			'inner' => __( 'Inside the content', 'arkhe' ),
		),
	)
);

// タイトル設定
Customizer::big_title(
	$section,
	'page_title_bg',
	array(
		'label' => __( 'Title background settings', 'arkhe' ),
	)
);

Customizer::add(
	$section,
	'title_bg_filter',
	array(
		'label'       => __( 'Image filtering', 'arkhe' ),
		'type'        => 'select',
		'choices'     => array(
			'none' => __( 'None', 'arkhe' ),
			'dot'  => __( 'Dot', 'arkhe' ),
		),
	)
);

Customizer::add(
	$section,
	'ttlbg_overlay_color',
	array(
		'label'       => __( 'Color overlay', 'arkhe' ),
		'description' => __( 'Color', 'arkhe' ),
		'type'        => 'color',
	)
);

Customizer::add(
	$section,
	'ttlbg_overlay_opacity',
	array(
		// 'label'       => '不透明度',
		'description' => __( 'Opacity', 'arkhe' ),
		'type'        => 'number',
		'input_attrs' => array(
			'step' => '0.1',
			'min'  => '0',
			'max'  => '1',
		),
	)
);


// アイキャッチ画像の設定
Customizer::big_title(
	$section,
	'page_thumb',
	array(
		'label' => __( 'Featured image', 'arkhe' ),
	)
);

Customizer::add(
	$section,
	'show_page_thumb',
	array(
		'label'       => __( 'Show featured image', 'arkhe' ),
		'description' => ARKHE_NOTE . __( 'It is valid only when the position of the title is "Inside the content".', 'arkhe' ),
		'type'        => 'checkbox',
	)
);
