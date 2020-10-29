<?php
use \Arkhe_Theme\Customizer;

$arkhe_section = 'arkhe_section_page';

/**
 * セクション : 固定ページ
 */
$wp_customize->add_section(
	$arkhe_section,
	array(
		'title'    => __( 'Pages', 'arkhe' ),
		'priority' => 22,
	)
);

// タイトル設定
Customizer::big_title(
	$arkhe_section,
	'page_title',
	array(
		'label' => __( 'Title settings', 'arkhe' ),
	)
);

Customizer::add(
	$arkhe_section,
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
	$arkhe_section,
	'page_title_bg',
	array(
		'label' => __( 'Title background settings', 'arkhe' ),
	)
);

Customizer::add(
	$arkhe_section,
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
	$arkhe_section,
	'ttlbg_overlay_color',
	array(
		'label'       => __( 'Color overlay', 'arkhe' ),
		'description' => __( 'Color', 'arkhe' ),
		'type'        => 'color',
	)
);

Customizer::add(
	$arkhe_section,
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
