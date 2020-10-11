<?php
use \Arkhe_Theme\Customizer;

$arkhe_section = 'arkhe_section_header';

/**
 * セクション : ヘッダー
 */
$wp_customize->add_section(
	$arkhe_section,
	array(
		'title'    => __( 'Header', 'arkhe' ),
		'priority' => 21,
	)
);


// ヘッダーロゴの設定
Customizer::big_title(
	$arkhe_section,
	'header_logo',
	array(
		'label'       => __( 'Header logo settings', 'arkhe' ),
		'description' => __( 'The logo image can be set from the "Site Identity" menu.', 'arkhe' ),
	)
);


// ヘッダーがブロックで管理されているかどうか
if ( \Arkhe::get_plugin_data( 'use_temlate_block' ) ) {

	// ブロック化される時に代わりに表示されるメッセージ
	do_action( 'arkhe_customizer_header_blocked_message' );

} else {

	// 画像サイズ（PC）
	Customizer::add(
		$arkhe_section,
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
			'sanitize'    => array( '\Arkhe_Theme\Customizer\Sanitize', 'int' ),
		)
	);

	// 画像サイズ（SP）
	Customizer::add(
		$arkhe_section,
		'logo_size_sp',
		array(
			'label'       => __( 'Image size', 'arkhe' ) . ' (SP)',
			'description' => '32~80px',
			'type'        => 'number',
			'input_attrs' => array(
				'step'    => '1',
				'min'     => '32',
				'max'     => '80',
			),
			'sanitize'    => array( '\Arkhe_Theme\Customizer\Sanitize', 'int' ),
		)
	);

	// レイアウト設定
	Customizer::big_title(
		$arkhe_section,
		'header_layout',
		array(
			'label' => __( 'Layout setting', 'arkhe' ),
		)
	);

	// 検索ボタン
	Customizer::sub_title(
		$arkhe_section,
		'head_search_btn',
		array(
			'label' => __( 'Search button', 'arkhe' ),
		)
	);

	// 検索ボタンをSPで表示する
	Customizer::add(
		$arkhe_section,
		'show_search_sp',
		array(
			'label'       => __( 'Show search btn on SP', 'arkhe' ),
			'type'        => 'checkbox',
		)
	);

	// 検索ボタンをPCで表示する
	Customizer::add(
		$arkhe_section,
		'show_search_pc',
		array(
			'label'       => __( 'Show search btn on PC', 'arkhe' ),
			'type'        => 'checkbox',
		)
	);

	// ドロワーメニュー
	Customizer::sub_title(
		$arkhe_section,
		'head_drawer_btn',
		array(
			'label' => __( 'Drawer button', 'arkhe' ),
		)
	);

	// ドロワーメニューをSPでも表示する
	Customizer::add(
		$arkhe_section,
		'show_drawer_sp',
		array(
			'label'       => __( 'Show drawer button on SP', 'arkhe' ),
			'type'        => 'checkbox',
		)
	);

	// ドロワーメニューをPCでも表示する
	Customizer::add(
		$arkhe_section,
		'show_drawer_pc',
		array(
			'label'       => __( 'Show drawer button on PC', 'arkhe' ),
			'type'        => 'checkbox',
		)
	);

	// グローバルナビ
	Customizer::sub_title(
		$arkhe_section,
		'head_nav',
		array(
			'label' => __( 'Global navigation', 'arkhe' ),
		)
	);

	// グローバルナビを下側に移動する
	Customizer::add(
		$arkhe_section,
		'move_gnav_under',
		array(
			'label'       => __( 'Move global navigation down', 'arkhe' ),
			'type'        => 'checkbox',
		)
	);

}


// ヘッダーの固定設定
Customizer::big_title(
	$arkhe_section,
	'fix_head',
	array(
		'label' => __( 'Fixed header setting', 'arkhe' ),
	)
);

// ヘッダーを画面上部に固定する （PC）
Customizer::add(
	$arkhe_section,
	'fix_header_pc',
	array(
		'label'       => __( 'Fixed header at top of screen', 'arkhe' ) . ' (PC)',
		'type'        => 'checkbox',
	)
);

// ヘッダーを画面上部に固定する (SP)
Customizer::add(
	$arkhe_section,
	'fix_header_sp',
	array(
		'label'       => __( 'Fixed header at top of screen', 'arkhe' ) . ' (SP)',
		'type'        => 'checkbox',
	)
);

// グローバルナビを画面上部に固定する
Customizer::add(
	$arkhe_section,
	'fix_gnav',
	array(
		'label'       => __( 'Fixed global navigation at top of screen', 'arkhe' ),
		'description' => ARKHE_NOTE . __( 'Only valid when below the header.', 'arkhe' ),
		'type'        => 'checkbox',
	)
);


// オーバーレイ設定
Customizer::big_title(
	$arkhe_section,
	'top_header',
	array(
		'label' => __( 'Overlay settings', 'arkhe' ),
	)
);
Customizer::add(
	$arkhe_section,
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
	$arkhe_section,
	'header_overlay_on_page',
	array(
		'classname'   => '-header-overlay',
		'label'       => __( 'Enable on Pages', 'arkhe' ),
		'type'        => 'checkbox',
	)
);

// オーバーレイ時のロゴ画像
Customizer::add(
	$arkhe_section,
	'head_logo_overlay',
	array(
		'classname'   => '-header-overlay',
		'label'       => __( 'Logo image when overlaying', 'arkhe' ),
		'type'        => 'media',
		'mime_type'   => 'image',
	)
);
