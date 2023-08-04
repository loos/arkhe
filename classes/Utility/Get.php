<?php
namespace Arkhe_Theme\Utility;

trait Get {

	/**
	 * データをサニタイズ
	 */
	public static function get_cleaned_data( $var ) {
		if ( is_array( $var ) ) {
			return array_map( array( __CLASS__, 'get_cleaned_data' ), $var );
		} else {
			return is_scalar( $var ) ? sanitize_text_field( wp_unslash( $var ) ) : $var;
		}
	}


	/**
	 * 投稿のタームデータから必要なものを取得
	 */
	public static function get_the_terms_data( $post_id, $tax ) {

		$cache_key = "the_terms_data_{$post_id}_{$tax}";

		// キャッシュ取得
		$cache_data = wp_cache_get( $cache_key, 'arkhe' );
		if ( $cache_data ) return $cache_data;

		$return_data = array();
		$terms       = get_the_terms( $post_id, $tax );

		if ( ! $terms ) return null;

		// 階層を保つ場合は親から順に並べる
		if ( is_taxonomy_hierarchical( $tax ) ) {
			$term_tree = array();
			foreach ( $terms as $term ) {
				$self_id   = $term->term_id;
				$parent_id = $term->parent;

				$term_data = array(
					'id'   => $term->term_id,
					'slug' => $term->slug,
					'name' => $term->name,
					'url'  => get_term_link( $term ),
				);

				$acts_ct    = 0;
				$top_act_id = $self_id;
				if ( $parent_id ) {
					// 先祖リストを取得
					$ancestors  = array_reverse( get_ancestors( $term->term_id, 'category' ) );
					$acts_ct    = count( $ancestors );
					$top_act_id = $ancestors[0];
				}

				// 必要な配列を用意
				if ( ! isset( $term_tree[ $top_act_id ] ) ) {
					$term_tree[ $top_act_id ] = array();
				}
				if ( ! isset( $term_tree[ $top_act_id ] ) ) {
					$term_tree[ $top_act_id ][ $acts_ct ] = array();
				}

				// treeに格納
				$term_tree[ $top_act_id ][ $acts_ct ][] = $term_data;
			}

			if ( ! empty( $term_tree ) ) {
				foreach ( $term_tree as $tree ) {
					ksort( $tree );
					foreach ( $tree as $terms_data ) {
						$return_data = array_merge( $return_data, $terms_data );
					}
				}
			}
		} elseif ( ! empty( $terms ) ) {
			// 階層のないタグなどのタクソノミー
			foreach ( $terms as $term ) {
				$return_data[] = array(
					'id'   => $term->term_id,
					'slug' => $term->slug,
					'name' => $term->name,
					'url'  => get_term_link( $term ),
				);
			}
		}

		$return_data = apply_filters( 'arkhe_get_the_terms_data', $return_data );

		wp_cache_set( $cache_key, $return_data, 'arkhe' );
		return $return_data;
	}


	/**
	 * 投稿のタームデータから必要なものを取得
	 */
	public static function get_author_icon_data( $author_id ) {

		if ( ! $author_id ) return null;

		// cache
		$cache_key  = "post_author_icon_{$author_id}";
		$cache_data = wp_cache_get( $cache_key, 'arkhe' );
		if ( $cache_data ) return $cache_data;

		$author_data = get_userdata( $author_id );
		if ( empty( $author_data ) ) return;

		$data = array(
			'name'   => $author_data->display_name,
			'url'    => get_author_posts_url( $author_id ),
			'avatar' => get_avatar( $author_id, 24, '', '', array( 'class' => 'u-obf-cover' ) ),
		);
		$data = apply_filters( 'arkhe_get_author_icon_data', $data );

		wp_cache_set( $cache_key, $data, 'arkhe' );
		return $data;
	}


	/**
	 * アーカイブページのデータを取得
	 */
	public static function get_archive_data( $key = '' ) {

		// キャッシュ取得
		$cache_data = wp_cache_get( 'archive_data', 'arkhe' );
		if ( $cache_data ) {
			return $key ? $cache_data[ $key ] : $cache_data;
		}

		$data = array(
			'type'  => '',
			'title' => '',
		);

		// wp_get_document_title() の条件分岐に合わせて post_type > term > author の順
		// ※ クエリオブジェクトの取得優先度は WP_Term > WP_Post_Type > WP_User
		if ( is_post_type_archive() ) {
			$data['title'] = post_type_archive_title( '', false );
			$data['type']  = 'pt_archive';

		} elseif ( is_category() ) {

			$data['title'] = single_term_title( '', false );
			$data['type']  = 'category';

		} elseif ( is_tag() ) {

			$data['title'] = single_term_title( '', false );
			$data['type']  = 'tag';

		} elseif ( is_tax() ) {

			$data['title'] = single_term_title( '', false );
			$data['type']  = 'tax';

		} elseif ( is_author() ) {

			$obj = get_queried_object();
			if ( isset( $wp_obj->display_name ) ) {
				$data['title'] = $wp_obj->display_name;
				$data['type']  = 'author';
			}
		} elseif ( is_date() ) {
			// 日付アーカイブ

			// phpcs:disable WordPress.WP.I18n.MissingArgDomain
			if ( is_year() ) {
				$title = get_the_date( _x( 'Y', 'yearly archives date format' ) );
			} elseif ( is_month() ) {
				$title = get_the_date( _x( 'F Y', 'monthly archives date format' ) );
			} elseif ( is_day() ) {
				$title = get_the_date( _x( 'F j, Y', 'daily archives date format' ) );
			}
			// phpcs:enable WordPress.WP.I18n.MissingArgDomain

			$data['title'] = $title;
			$data['type']  = 'date';

		} elseif ( is_archive() ) {

			$data['title'] = 'Archives';
			$data['type']  = '';

		}

		$data = apply_filters( 'arkhe_get_archive_data', $data );

		wp_cache_set( 'archive_data', $data, 'arkhe' );
		return $key ? $data[ $key ] : $data;
	}


	/**
	 * リストレイアウトのリストを取得
	 */
	public static function get_list_layouts( $targets = array() ) {

		$layouts = self::$list_layouts;

		// 一部だけ返す場合
		if ( ! empty( $targets ) ) {
			foreach ( $layouts as $key => $val ) {
				if ( ! in_array( $key, $targets, true ) ) {
					unset( $layouts[ $key ] );
				}
			}
		}

		return $layouts;
	}


	/**
	 * ツールバー拡張用データ
	 */
	public static function get_toolbar_data( $key, $title = '' ) {
		if ( 'licence' === $key ) {
			$title = $title ?: __( 'Licence registration', 'arkhe' );
			$title = '<span class="ab-icon -arkhe">' . self::get_svg( 'arkhe-logo' ) . '</span><span class="ab-label">' . $title . '</span>';

			// arkheアイコン用CSS
			$style = '<style>' .
				'#wpadminbar .ab-icon.-arkhe {display: flex;align-items: center;box-sizing: border-box;height: 100%;}' .
				'.ab-icon.-arkhe svg { width: 20px !important; fill: currentColor; }' .
			'</style>';

			return array(
				'id'     => 'arkhe_licence_check',
				'meta'   => array( 'class' => 'arkhe-menu-licence' ),
				'title'  => $style . $title,
				'href'   => admin_url( 'themes.php?page=arkhe&tab=licence' ),
			);
		}
	}


	/**
	 * カスタム投稿タイプに紐付いたタクソノミーを一つだけ取得する
	 */
	public static function get_tax_of_post_type( $the_post_type = '' ) {
		$the_post_type = $the_post_type ?: get_post_type();
		$the_tax       = 'category';

		// カスタム投稿タイプの場合
		if ( 'post' !== $the_post_type ) {

			// キャッシュ取得
			$cache_key = 'tax_of_' . $the_post_type;
			$the_tax   = wp_cache_get( $cache_key, 'arkhe' ) ?: '';

			if ( ! $the_tax ) {
				// 投稿タイプに紐づいたタクソノミーを取得
				$tax_array = get_object_taxonomies( $the_post_type, 'names' );
				$core_tax  = array( 'category', 'post_tag', 'post_format' );
				foreach ( $tax_array as $tax_name ) {
					// コアの標準タクソノミーを除いて1つ目を取得
					if ( ! in_array( $tax_name, $core_tax, true ) ) {
						$the_tax = $tax_name;
						break;
					}
				}
				wp_cache_set( $cache_key, $the_tax, 'arkhe' );
			}
		}

		return apply_filters( 'arkhe_get_tax_of_post_type', $the_tax, $the_post_type );
	}


	/**
	 * 投稿リストに表示するカテゴリーを１つ取得
	 */
	public static function get_a_catgory_for_list( $categories = null ) {

		if ( null === $categories ) {
			$categories = get_the_category();
		}

		if ( empty( $categories ) ) {
			return null;
		}

		// １つしかなければそれを返す
		// if ( 1 === count( $categories ) ) {return $categories[0];}

		// 一番親を返すか、子を返すか
		$p_or_c             = \Arkhe::get_setting( 'cat_priority_on_list' );
		$lineage_catergoies = array(); // カテゴリーアーカイブのときに、同じ系列のカテゴリーを取得するためのもの

		// 現在のページがカテゴリーアーカイブの時にそのカテゴリー名で表示するかどうか。
		if ( is_category() ) {
			$cat_priority_on_cat_page = \Arkhe::get_setting( 'cat_priority_on_cat_page' );

			// 強制的に表示名を現在のアーカイブに合わせる時 (子カテゴリーしか持ってなくても表示を揃えれる)
			if ( 'self' === $cat_priority_on_cat_page ) {
				return get_queried_object();
			}

			// 子孫カテゴリーを優先表示する場合
			if ( 'child' === $cat_priority_on_cat_page ) {
				$p_or_c = 'child';
			}

			// 現在のカテゴリーの同じ系統のものを取得
			$ancestors          = get_ancestors( get_queried_object_id(), 'category' );
			$descendants        = get_term_children( get_queried_object_id(), 'category' );
			$lineage_catergoies = array_merge( $ancestors, array( get_queried_object_id() ), $descendants );

			// 無関係な親カテゴリーは表示しないように除外しておく.
			// 例: A, B-child のカテゴリーを持つ投稿があった時、Bのカテゴリーページでは Aを表示しないようにする
			$categories_ct = count( $categories );
			for ( $i = 0; $i < $categories_ct; $i++ ) {
				$the_cat = $categories[ $i ];
				if ( ! in_array( $the_cat->term_id, $lineage_catergoies, true ) ) {
					unset( $categories[ $i ] );
				}
			}
		}

		if ( 'parent' === $p_or_c ) {
			$_cat     = null;
			$_acts_ct = 0;
			foreach ( $categories as $the_cat ) {
				// 一番親のカテゴリーであればすぐにそれを返す
				if ( 0 === $the_cat->parent ) {
					return $the_cat;
				}

				$ancestors = get_ancestors( $the_cat->term_id, 'category' );

				// 投稿と親カテゴリーを直接紐付いてなくても、一番親のカテゴリー名で表示する
				$force_get_top_cat = \Arkhe::get_setting( 'force_get_top_cat' );
				if ( $force_get_top_cat ) {
					return get_category( $ancestors[ count( $ancestors ) - 1 ] );
				}

				// まだ1度もセットされていない時はまず記憶させる
				if ( 0 === $_acts_ct ) {
					$_cat     = $the_cat;
					$_acts_ct = count( $ancestors );
					continue;
				}

				// 親の数がより少なければ上書き
				if ( $_acts_ct > count( $ancestors ) ) {
					$_cat = $the_cat;
				}
			}
			return $_cat;

		} elseif ( 'child' === $p_or_c ) {
			$_cat     = null;
			$_acts_ct = 0;
			foreach ( $categories as $the_cat ) {
				$ancestors = get_ancestors( $the_cat->term_id, 'category' );

				// まだ1度もセットされていない時はまず記憶させる
				if ( 0 === $_acts_ct ) {
					$_cat     = $the_cat;
					$_acts_ct = count( $ancestors );
					continue;
				}

				// 親の数がより「多ければ」上書き
				if ( $_acts_ct < count( $ancestors ) ) {
					$_cat = $the_cat;
				}
			}
			return $_cat;
		}

		// 特に条件のヒットがなければ最初のカテゴリーを返す
		return $categories[0] ?? null;
	}
}
