<?php
use \Arkhe_Theme\Customizer;

/**
 * セクション : 投稿ページ
 */
$arkhe_section = 'arkhe_section_single';
$wp_customize->add_section(
	$arkhe_section,
	array(
		'title'    => __( 'Posts', 'arkhe' ),
		'priority' => 22,
	)
);


// タイトル下の情報
Customizer::big_title(
	$arkhe_section,
	'post_around_title',
	array(
		'label' => __( 'Information under the title', 'arkhe' ),
	)
);

// カテゴリーを表示する
Customizer::add(
	$arkhe_section,
	'show_entry_cat',
	array(
		'label'       => __( 'Show categories', 'arkhe' ),
		'type'        => 'checkbox',
	)
);

// タグを表示する
Customizer::add(
	$arkhe_section,
	'show_entry_tag',
	array(
		'label'       => __( 'Show tags', 'arkhe' ),
		'type'        => 'checkbox',
	)
);

// 著者を表示する
Customizer::add(
	$arkhe_section,
	'show_entry_author',
	array(
		'label'       => __( 'Show author', 'arkhe' ),
		'type'        => 'checkbox',
	)
);

// アイキャッチ画像を表示する
Customizer::add(
	$arkhe_section,
	'show_entry_thumb',
	array(
		'label'       => __( 'Show featured image', 'arkhe' ),
		'type'        => 'checkbox',
	)
);

// 本文下のターム情報
Customizer::big_title(
	$arkhe_section,
	'foot_terms',
	array(
		'label' => __( 'Term information below the content', 'arkhe' ),
	)
);

// ターム情報を表示
Customizer::add(
	$arkhe_section,
	'show_foot_terms',
	array(
		'label'       => __( 'Show terms', 'arkhe' ),
		'type'        => 'checkbox',
	)
);

// 前の記事・次の記事へのリンク
Customizer::big_title(
	$arkhe_section,
	'pn_links',
	array(
		'label' => __( 'Link to previous/next article', 'arkhe' ),
	)
);

// リンクを表示する
Customizer::add(
	$arkhe_section,
	'show_prev_next_link',
	array(
		'label'       => __( 'Show link', 'arkhe' ),
		'type'        => 'checkbox',
	)
);

// 同じカテゴリーの記事だけを取得する
Customizer::add(
	$arkhe_section,
	'pn_link_is_same_term',
	array(
		'label'       => __( 'Get only articles in the same category', 'arkhe' ),
		'type'        => 'checkbox',
	)
);

// 著者情報エリア
Customizer::big_title(
	$arkhe_section,
	'post_author',
	array(
		'label' => __( 'Author information area', 'arkhe' ),
	)
);

// 著者の情報を表示する
Customizer::add(
	$arkhe_section,
	'show_author_box',
	array(
		'label'       => __( 'Show author information', 'arkhe' ),
		'type'        => 'checkbox',
	)
);

// 関連記事エリア
Customizer::big_title(
	$arkhe_section,
	'related_posts',
	array(
		'label' => __( 'Related posts area', 'arkhe' ),
	)
);

// 関連記事を表示する
Customizer::add(
	$arkhe_section,
	'show_related_posts',
	array(
		'label'       => __( 'Show related posts', 'arkhe' ),
		'type'        => 'checkbox',
	)
);

// 関連記事のレイアウト
Customizer::add(
	$arkhe_section,
	'related_posts_layout',
	array(
		'label'       => __( 'List layout', 'arkhe' ),
		'type'        => 'select',
		'choices'     => array(
			'card' => __( 'Card type', 'arkhe' ),
			'list' => __( 'List type', 'arkhe' ),
		),
	)
);

// 関連記事の取得方法
Customizer::add(
	$arkhe_section,
	'post_relation_type',
	array(
		'classname'   => '-radio-button -related-post',
		'label'       => __( 'How to get related posts', 'arkhe' ),
		'type'        => 'radio',
		'choices'     => array(
			'category' => __( 'Category', 'arkhe' ),
			'tag'      => __( 'Tag', 'arkhe' ),
		),
	)
);


// コメントエリア
Customizer::big_title(
	$arkhe_section,
	'comment_area',
	array(
		'label' => __( 'Comment area', 'arkhe' ),
	)
);

// コメントエリアを表示する
Customizer::add(
	$arkhe_section,
	'show_comments',
	array(
		'label'       => __( 'Show comment area', 'arkhe' ),
		'type'        => 'checkbox',
	)
);
