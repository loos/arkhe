<?php
/**
 * パンくずリスト
 */
if ( is_front_page() ) return false;

$wp_obj      = get_queried_object();  // そのページのWPオブジェクトを取得
$wp_obj_type = '';
if ( null !== $wp_obj && is_object( $wp_obj ) ) {
	$wp_obj_type = get_class( $wp_obj );
};


$list_data = array();

// 「投稿ページ」をリストに入れる場合
$home_data = null;
if ( Arkhe::get_setting( 'breadcrumbs_set_home_page' ) ) {
	$home_page_id = (int) get_option( 'page_for_posts' );
	if ( $home_page_id ) {
		$home_data = array(
			'url'  => get_permalink( $home_page_id ),
			'name' => get_the_title( $home_page_id ),
		);
	}
}

/**
 * リスト生成処理
 * アーカイブ系の分岐順は Arkhe::get_archive_data() に合わせる
 */
if ( is_search() ) {
	// 検索結果ページ  memo: is_archive() 等もtrueになる場合があるので先に分岐

	$list_data[] = array(
		'url'  => '',
		'name' => __( 'Search results', 'arkhe' ),
	);

} elseif ( is_attachment() ) {
	// 添付ファイルページ  memo: is_single() もtrueになるので先に分岐

	$list_data[] = array(
		'url'  => '',
		'name' => single_post_title( '', false ),
	);


} elseif ( is_single() && 'WP_Post' === $wp_obj_type ) {
	// 投稿ページ

	$the_id        = $wp_obj->ID;
	$the_title     = get_the_title( $the_id );
	$the_post_type = isset( $wp_obj->post_type ) ? $wp_obj->post_type : 'post';


	// 「投稿ページ」をパンくずリストに入れる場合
	if ( 'post' === $the_post_type && $home_data ) {
		$list_data[] = $home_data;
	}


	// カスタム投稿タイプの場合
	if ( 'post' !== $the_post_type ) {
		$list_data[] = array(
			'url'  => get_post_type_archive_link( $the_post_type ) ?: '',
			'name' => get_post_type_object( $the_post_type )->label,
		);
	}

	// 投稿タイプに紐づくタクソノミー名を取得
	$the_tax   = \Arkhe::get_tax_of_post_type( $the_post_type );
	$the_terms = get_the_terms( $the_id, $the_tax );

	// タームーが紐づいていれば表示
	if ( false !== $the_terms ) {

		// 子を持たないタームだけを集めた配列
		$child_terms = array();

		// 子を持つタームだけを集めた配列
		$parents_list = array();

		// 全タームの親IDを取得
		foreach ( $the_terms as $the_term ) {
			if ( 0 !== $the_term->parent ) {
				$parents_list[] = $the_term->parent;
			}
		}

		// 親リストに含まれないタームのみ取得
		foreach ( $the_terms as $the_term ) {
			if ( ! in_array( $the_term->term_id, $parents_list, true ) ) {
				$child_terms[] = $the_term;
			}
		}

		// 最下層のターム配列から一つだけ取得
		$the_term = $child_terms[0];

		if ( 0 !== $the_term->parent ) {

			// 親タームのIDリストを取得
			$parent_array = array_reverse( get_ancestors( $the_term->term_id, $the_tax ) );

			foreach ( $parent_array as $parent_id ) {
				$parent_term = get_term( $parent_id, $the_tax );
				$parent_link = get_term_link( $parent_id, $the_tax );
				$parent_name = $parent_term->name;

				$list_data[] = array(
					'url'  => $parent_link,
					'name' => $parent_name,
				);
			}
		}

		// 最下層のタームを表示
		$term_link = get_term_link( $the_term->term_id, $the_tax );
		$term_name = $the_term->name;

		$list_data[] = array(
			'url'  => $term_link,
			'name' => $term_name,
		);
	}

	// 投稿自身の表示
	$list_data[] = array(
		'url'  => '',
		'name' => $the_title,
	);


} elseif ( is_page() || is_home() && 'WP_Post' === $wp_obj_type ) {
	// 固定ページ

	$page_id    = $wp_obj->ID;
	$page_title = get_the_title( $page_id );

	// 親ページがあれば順番に表示
	if ( 0 !== $wp_obj->post_parent ) {
		$parent_array = array_reverse( get_post_ancestors( $page_id ) );
		foreach ( $parent_array as $parent_id ) {
			$parent_link = get_permalink( $parent_id );
			$parent_name = get_the_title( $parent_id );

			$list_data[] = array(
				'url'  => $parent_link,
				'name' => $parent_name,
			);
		}
	}
	// 投稿自身の表示
	$list_data[] = array(
		'url'  => '',
		'name' => $page_title,
	);

} elseif ( is_post_type_archive() ) {
	// 投稿タイプアーカイブページ
	// 'WP_Post_Type' === $wp_obj_type でもチェックしたいが、コアの吐き出す<title>と齟齬が生じるのでチェックしない。
	// $wp_obj が WP_Term のケースがあるため、$wp_obj->label は使用しない。

	$list_data[] = array(
		'url'  => '',
		'name' => post_type_archive_title( '', false ),
	);

} elseif ( is_category() || is_tag() || is_tax() && 'WP_Term' === $wp_obj_type ) {
	// ターム系アーカイブ

	$term_id   = $wp_obj->term_id;
	$term_name = $wp_obj->name;
	$tax_name  = $wp_obj->taxonomy;

	// 「投稿ページ」をパンくずリストに入れる場合
	if ( $home_data && ( is_category() || is_tag() ) ) {
		$list_data[] = $home_data;
	}

	// カスタムタクソノミーに投稿タイプが紐付いているかチェック
	if ( is_tax() ) {

		$tax_parent_types = get_taxonomy( $tax_name )->object_type;
		if ( ! empty( $tax_parent_types ) ) {
			$tax_parent_type_slug = $tax_parent_types[0];
			$tax_parent_type      = get_post_type_object( $tax_parent_type_slug );
			$list_data[]          = array(
				'url'  => get_post_type_archive_link( $tax_parent_type_slug ) ?: '',
				'name' => $tax_parent_type->label,
			);
		}
	}

	// 親タームがあれば順番に表示
	if ( 0 !== $wp_obj->parent ) {

		$parent_array = array_reverse( get_ancestors( $term_id, $tax_name ) );
		foreach ( $parent_array as $parent_id ) {
			$parent_term = get_term( $parent_id, $tax_name );
			$parent_link = get_term_link( $parent_id, $tax_name );
			$parent_name = $parent_term->name;

			$list_data[] = array(
				'url'  => $parent_link,
				'name' => $parent_name,
			);
		}
	}

	// ターム自身の表示
	$list_data[] = array(
		'url'  => '',
		'name' => $term_name,
	);

} elseif ( is_author() && 'WP_User' === $wp_obj_type ) {
	// 投稿者アーカイブ

	$list_data[] = array(
		'url'  => '',
		'name' => $wp_obj->display_name,
	);

} elseif ( is_date() ) {
	// 日付アーカイブ  memo: $wp_obj = null になる

	$the_year  = get_query_var( 'year' );
	$the_month = get_query_var( 'monthnum' );
	$the_day   = get_query_var( 'day' );
	$the_m     = get_query_var( 'm' );

	if ( $the_m ) {
		// パーマリンクが「基本」時、/?m=yyyymmdd のURLになる。
		$the_year  = substr( $the_m, 0, 4 ) ?: 0;
		$the_month = substr( $the_m, 4, 2 ) ?: 0;
		$the_day   = substr( $the_m, 6, 2 ) ?: 0;
	}
	// phpcs:ignore WordPress.WP.I18n.MissingArgDomain
	$y_title = get_the_date( _x( 'Y', 'yearly archives date format' ) );
	$m_title = get_the_date( 'F' );
	$d_title = get_the_date( _x( 'j', 'daily archives date format', 'arkhe' ) );

	if ( 0 !== $the_day ) {
		// 日別アーカイブ
		$list_data[] = array(
			'url'  => get_year_link( $the_year ),
			'name' => $y_title,
		);
		$list_data[] = array(
			'url'  => get_month_link( $the_year, $the_month ),
			'name' => $m_title,
		);
		$list_data[] = array(
			'url'  => '',
			'name' => $d_title,
		);

	} elseif ( 0 !== $the_month ) {
		// 月別アーカイブ
		$list_data[] = array(
			'url'  => get_year_link( $the_year ),
			'name' => $y_title,
		);
		$list_data[] = array(
			'url'  => '',
			'name' => $m_title,
		);

	} else {
		// 年別アーカイブ
		$list_data[] = array(
			'url'  => '',
			'name' => $y_title,
		);
	}
} elseif ( is_404() ) {
	// 404ページ

	$list_data[] = array(
		'url'  => '',
		'name' => __( 'The page was not found.', 'arkhe' ),
	);

} else {
	$list_data[] = array(
		'url'  => '',
		'name' => '',
	);
}


/**
 * 出力処理
 */
$list_html  = '';
$json_array = array(); // JSON-LD用の配列
$list_data  = apply_filters( 'arkhe_breadcrumbs_data', $list_data );
foreach ( $list_data as $data ) {

	// urlの有無で処理を分ける
	if ( $data['url'] ) {

		// JSON LD用の配列にも追加
		$json_array[] = $data;

		$list_html .= '<li class="p-breadcrumb__item">' .
			'<a href="' . esc_url( $data['url'] ) . '" class="p-breadcrumb__text">' .
				'<span>' . esc_html( wp_strip_all_tags( $data['name'] ) ) . '</span>' .
			'</a>' .
		'</li>';

	} else {

		$list_html .= '<li class="p-breadcrumb__item">' .
			'<span class="p-breadcrumb__text u-color-thin">' . esc_html( wp_strip_all_tags( $data['name'] ) ) . '</span>' .
		'</li>';

	}
}

// JSON-LDデータの受け渡し
\Arkhe::$bread_json_data = $json_array;

// HTMLの出力
?>
<div id="breadcrumb" class="p-breadcrumb">
	<ol class="p-breadcrumb__list l-container">
		<li class="p-breadcrumb__item">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="p-breadcrumb__text">
				<?php Arkhe::the_svg( 'home' ); ?>
				<span><?php echo esc_html( Arkhe::get_setting( 'breadcrumbs_home_text' ) ); ?></span>
			</a>
		</li>
		<?php echo $list_html; // phpcs:ignore WordPress.Security.EscapeOutput ?>
	</ol>
</div>
