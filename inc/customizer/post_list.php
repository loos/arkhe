<?php
use \Arkhe_Theme\Customizer;

$arkhe_section = 'arkhe_section_post_list';

$arkhe_thumb_ratios = array(
	'silver' => '1 : 1.414 (' . __( 'Silver ratio', 'arkhe' ) . ')',
	'golden' => '1 : 1.618 (' . __( 'Golden ratio', 'arkhe' ) . ')',
	'slr'    => '3 : 2',
	'wide'   => '16 : 9',
	'wide2'  => '2 : 1',
	'wide3'  => '5 : 2',
	'square' => '1 : 1',
);

/**
 * セクション : アーカイブ
 */
$wp_customize->add_section(
	$arkhe_section,
	array(
		'title'    => __( 'Archive', 'arkhe' ),
		'priority' => 23,
	)
);


// リストのレイアウト設定
Customizer::big_title(
	$arkhe_section,
	'post_list_layout',
	array(
		'label'     => __( 'List layout', 'arkhe' ),
	)
);

// リストレイアウト
Customizer::add(
	$arkhe_section,
	'post_list_layout',
	array(
		// 'label'       => __( 'List layout', 'arkhe' ),
		'type'        => 'select',
		'choices'     => array(
			'card'   => __( 'Card type', 'arkhe' ),
			'list'   => __( 'List type', 'arkhe' ),
			'simple' => __( 'Text type', 'arkhe' ),
		),
	)
);


// 投稿情報
Customizer::big_title(
	$arkhe_section,
	'post_list_design',
	array(
		'label'     => __( 'Post information', 'arkhe' ),
	)
);

// 公開日を表示する
Customizer::add(
	$arkhe_section,
	'show_list_date',
	array(
		'label'       => __( 'Show publication date', 'arkhe' ),
		'type'        => 'checkbox',
	)
);

// 更新日を表示する
Customizer::add(
	$arkhe_section,
	'show_list_mod',
	array(
		'label'       => __( 'Show update date', 'arkhe' ),
		'type'        => 'checkbox',
	)
);

// カテゴリーを表示する
Customizer::add(
	$arkhe_section,
	'show_list_cat',
	array(
		'label'       => __( 'Show categories', 'arkhe' ),
		'type'        => 'checkbox',
	)
);

// 著者を表示する
Customizer::add(
	$arkhe_section,
	'show_list_author',
	array(
		'label'       => __( 'Show author', 'arkhe' ),
		'type'        => 'checkbox',
	)
);

// 抜粋文の文字数
Customizer::add(
	$arkhe_section,
	'excerpt_length',
	array(
		'label'       => __( 'Number of characters in excerpt', 'arkhe' ),
		'type'        => 'number',
		'input_attrs' => array(
			'step'    => '20',
			'min'     => '0',
			'max'     => '320',
		),
		'sanitize'    => array( '\Arkhe_Theme\Customizer\Sanitize', 'int' ),
	)
);


// サムネイル画像の比率
Customizer::big_title(
	$arkhe_section,
	'thumb_ratio',
	array(
		'label'     => __( 'Thumbnail image ratio', 'arkhe' ),
	)
);

// カード型リストでの比率
Customizer::add(
	$arkhe_section,
	'thumb_ratio',
	array(
		// 'label'       => '',
		'type'        => 'select',
		'choices'     => $arkhe_thumb_ratios,
	)
);
