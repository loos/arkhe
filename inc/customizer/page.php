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

// タイトルエリア設定
Customizer::big_title(
	$section,
	'page_title',
	array(
		'label' => 'タイトルエリア設定',
	)
);

Customizer::add(
	$section,
	'page_title_pos',
	array(
		'label'       => 'タイトルの表示位置',
		'type'        => 'radio',
		'choices'     => array(
			'top'    => 'コンテンツ上',
			'inner'  => 'コンテンツ内',
		),
	)
);

Customizer::add(
	$section,
	'title_bg_filter',
	array(
		'label'       => '画像フィルター',
		'description' => 'タイトル表示位置が「コンテンツ上」の時の背景画像へのフィルター処理',
		'type'        => 'select',
		'choices'     => array(
			'none' => 'なし',
			'dot'  => 'ドット',
		),
	)
);

Customizer::add(
	$section,
	'ttlbg_overlay_color',
	array(
		'label'       => 'カラーオーバーレイの設定',
		'description' => 'タイトル背景画像に被せるカラーレイヤーの色',
		'type'        => 'color',
	)
);

Customizer::add(
	$section,
	'ttlbg_overlay_opacity',
	array(
		// 'label'       => 'オーバレイカラーの不透明度',
		'description' => 'オーバレイカラーの不透明度<br>（CSSの opacity プロパティの値）',
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
		'label' => 'アイキャッチ画像の設定',
	)
);

Customizer::add(
	$section,
	'show_page_thumb',
	array(
		'label'       => '本文の始めにアイキャッチ画像を表示',
		'description' => '※ タイトルの表示位置が「コンテンツ内」の時のみ有効です。',
		'type'        => 'checkbox',
	)
);
