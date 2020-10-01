<?php
use \Arkhe_Theme\Customizer;

$arkhe_section = 'arkhe_section_sidebar';

/**
 * セクション : サイドバー
 */
$wp_customize->add_section(
	$arkhe_section,
	array(
		'title'    => __( 'Sidebar', 'arkhe' ),
		'priority' => 21,
	)
);

// サイドバーを表示するかどうか
Customizer::sub_title(
	$arkhe_section,
	'is_show_sidebar',
	array(
		'label'       => __( 'Whether to show the sidebar', 'arkhe' ),
		'description' => ARKHE_NOTE . __( 'It is reflected in "Default template".', 'arkhe' ),
	)
);

// トップページに表示する
Customizer::add(
	$arkhe_section,
	'show_sidebar_top',
	array(
		'label'       => __( 'Display on homepage', 'arkhe' ),
		'type'        => 'checkbox',
	)
);

// 投稿ページに表示する
Customizer::add(
	$arkhe_section,
	'show_sidebar_post',
	array(
		'label'       => __( 'Display on posts', 'arkhe' ),
		'type'        => 'checkbox',
	)
);

// 固定ページに表示する
Customizer::add(
	$arkhe_section,
	'show_sidebar_page',
	array(
		'label'       => __( 'Display on pages', 'arkhe' ),
		'type'        => 'checkbox',
	)
);

// アーカイブページに表示する
Customizer::add(
	$arkhe_section,
	'show_sidebar_archive',
	array(
		'label'       => __( 'Display on archive pages', 'arkhe' ),
		'type'        => 'checkbox',
	)
);
