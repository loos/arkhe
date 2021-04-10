<?php
/**
 * 小さなパーツを取得・生成するための関数をまとめたファイル
 */

/**
 * アイキャッチ画像を取得
 */
if ( ! function_exists( 'ark_get__thumbnail' ) ) {
	function ark_get__thumbnail( $the_id = null, $args = array() ) {
		$size        = isset( $args['size'] ) ? $args['size'] : 'full';
		$sizes       = isset( $args['sizes'] ) ? $args['sizes'] : '';
		$class       = isset( $args['class'] ) ? $args['class'] : '';
		$placeholder = isset( $args['placeholder'] ) ? $args['placeholder'] : '';

		// memo : image_downsize( $img_id, 'medium' );
		$class           = $class . ' lazyload';
		$attachment_args = array(
			'class' => $class,
		);

		$thumb = '';

		if ( has_post_thumbnail( $the_id ) ) {

			// アイキャッチ画像の設定がある場合
			$thumb = get_the_post_thumbnail( $the_id, $size, $attachment_args );

		} elseif ( ARKHE_NOIMG_ID ) {

			// まだサムネイル画像が取得できていない場合で、ARKHE_NOIMG_ID がある場合
			$thumb = wp_get_attachment_image( ARKHE_NOIMG_ID, $size, false, $attachment_args );
		}

		if ( $thumb ) {
			if ( $sizes ) {
				// 指定のサイズに書き換える
				$thumb = preg_replace( '/ sizes="([^"]*)"/', ' sizes="' . $sizes . '"', $thumb );
			}
		} else {
			$thumb = '<img src="' . esc_url( ARKHE_NOIMG_URL ) . '" class="' . esc_attr( $class ) . '">';
		}

		// 通常のフロント表示の時（Gutenberg上やRESTの時以外）
		if ( ! defined( 'REST_REQUEST' ) ) {
			$placeholder = $placeholder ?: ARKHE_PLACEHOLDER;
			$thumb       = str_replace( ' src="', ' src="' . esc_url( $placeholder ) . '" data-src="', $thumb );
			$thumb       = str_replace( ' srcset="', ' data-srcset="', $thumb );
			// loading="lazy"
		}

		return apply_filters( 'ark_get__thumbnail', $thumb, $the_id, $args );
	}
}


/**
 * タームリストを出力する
 */
if ( ! function_exists( 'ark_get__term_links' ) ) {
	function ark_get__term_links( $the_id = '', $tax_slug = '', $is_head = true ) {

		if ( 'cat' === $tax_slug ) {
			$terms = get_the_category( $the_id );
			$icon  = 'arkhe-icon-folder';
		} elseif ( 'tag' === $tax_slug ) {
			$terms = get_the_tags( $the_id );
			$icon  = 'arkhe-icon-tag';
		} else {
			$terms = get_the_terms( $the_id, $tax_slug );
			$icon  = 'arkhe-icon-' . $tax_slug;
		}

		if ( empty( $terms ) ) return '';

		// is_head なら リスト全体の前にアイコンを一つ
		$return = $is_head ? '<i class="c-postMetas__icon ' . esc_attr( $icon ) . '"></i>' : '';

		foreach ( $terms as $term ) {
			$term_link = get_term_link( $term );
			$return   .= '<a class="c-postTerms__link" href="' . esc_url( $term_link ) . '" data-' . sanitize_key( $tax_slug ) . '-id="' . esc_attr( $term->term_id ) . '">' .
				esc_html( $term->name ) .
			'</a>';
		}

		return apply_filters( 'ark_get__term_links', $return, $the_id, $tax_slug );
	}
}


/**
 * アーカイブページのデータを取得
 * ['title'] : アーカイブページのタイトルとして表示する文字列
 * ['type'] : アーカイブ種別を表す文字列。cayegory | tag | tax | etc...
 */
if ( ! function_exists( 'ark_get__archive_data' ) ) {
	function ark_get__archive_data() {

		$data = array(
			'type'  => '',
			'title' => '',
		);

		if ( is_date() ) {
			// 日付アーカイブなら

			$qv_day      = get_query_var( 'day' );
			$qv_monthnum = get_query_var( 'monthnum' );
			$qv_year     = get_query_var( 'year' );

			if ( 0 !== $qv_day ) {
				$ymd_name = $qv_year . '年' . $qv_monthnum . '月' . $qv_day . '日';
			} elseif ( 0 !== $qv_monthnum ) {
				$ymd_name = $qv_year . '年' . $qv_monthnum . '月';
			} else {
				$ymd_name = $qv_year . '年';
			}
			if ( is_post_type_archive() ) {
				// さらに、投稿タイプの日付アーカイブだった場合
				$data['title'] = $ymd_name . '(' . post_type_archive_title( '', false ) . ')';
			}
			$data['title'] = $ymd_name;
			$data['type']  = 'date';

		} elseif ( is_post_type_archive() ) {
			// 投稿タイプのアーカイブページなら

			$data['title'] = post_type_archive_title( '', false );
			$data['type']  = 'pt_archive';

		} elseif ( is_author() ) {
			// 投稿者アーカイブ

			$data['title'] = get_queried_object()->display_name;
			$data['type']  = 'author';

		} elseif ( is_category() ) {

			$data['title'] = single_term_title( '', false );
			$data['type']  = 'category';

		} elseif ( is_tag() ) {

			$data['title'] = single_term_title( '', false );
			$data['type']  = 'tag';

		} elseif ( is_tax() ) {

			$data['title'] = single_term_title( '', false );
			$data['type']  = 'tax';

		} elseif ( is_archive() ) {

			$data['title'] = single_term_title( '', false );
			$data['type']  = '';

		}

		return apply_filters( 'ark_get__archive_data', $data );
	}
}


/**
 * 日付を出力 (アーカイブと投稿ページで使われている)
 */
if ( ! function_exists( 'ark_the__postdate' ) ) {
	function ark_the__postdate( $date = null, $type = 'posted', $use_time_tag = true ) {

		if ( null === $date ) return;

		$date_format = get_option( 'date_format' );
		$time_class  = 'c-postTimes__item -' . $type . ' u-flex--aic';

		if ( $use_time_tag ) {
			echo '<time class="' . esc_attr( $time_class ) . '" datetime="' . esc_attr( $date->format( 'Y-m-d' ) ) . '">' .
				'<i class="c-postMetas__icon arkhe-icon-' . esc_attr( $type ) . '" role="img" aria-hidden="true"></i>' .
				esc_html( $date->format( $date_format ) ) .
			'</time>';
		} else {
			echo '<span class="' . esc_attr( $time_class ) . '">' .
				'<i class="c-postMetas__icon arkhe-icon-' . esc_attr( $type ) . '" role="img" aria-hidden="true"></i>' .
				esc_html( $date->format( $date_format ) ) .
			'</span>';
		}
	}
}


/**
 * 投稿リスト用の日付
 */
if ( ! function_exists( 'ark_the__post_list_times' ) ) {
	function ark_the__post_list_times( $show_date, $show_modified, $date, $modified ) {

		$date     = $show_date ? $date : null;
		$modified = $show_modified ? $modified : null;

		// どっちも非表示の場合
		if ( ! $date && ! $modified ) return;

		// 両方表示する設定の場合、更新日は公開日より遅い場合だけ表示
		if ( $date && $modified ) {
			$modified = ( $date < $modified ) ? $modified : null;
		}
	?>
		<div class="p-postList__times c-postTimes u-color-thin u-flex--aic">
			<?php
				if ( $date ) ark_the__postdate( $date, 'posted' );
				if ( $modified ) ark_the__postdate( $modified, 'modified' );
			?>
		</div>
	<?php
	}
}


/**
 * 投稿リスト用のカテゴリー
 */
if ( ! function_exists( 'ark_the__post_list_category' ) ) {
	function ark_the__post_list_category( $post_id ) {
		$categories = get_the_category( $post_id );
		if ( empty( $categories ) ) return;

		$cat = $categories[0];
	?>
		<div class="p-postList__category u-color-thin u-flex--aic">
			<i class="c-postMetas__icon arkhe-icon-folder" role="img" aria-hidden="true"></i>
			<span data-cat-id="<?php echo esc_attr( $cat->term_id ); ?>"><?php echo esc_html( $cat->name ); ?></span>
		</div>
	<?php
	}
}


/**
 * 投稿リスト用の著者情報
 */
if ( ! function_exists( 'ark_the__post_list_author' ) ) {
	function ark_the__post_list_author( $author_id ) {
		$author_data = get_userdata( $author_id );
		if ( empty( $author_data ) ) return;
	?>
		<div class="p-postList__author c-postAuthor u-flex--aic">
			<figure class="c-postAuthor__figure">
				<?php echo get_avatar( $author_id, 100, '', '' ); ?>
			</figure>
			<span class="c-postAuthor__name u-color-thin"><?php echo esc_html( $author_data->display_name ); ?></span>
		</div>
	<?php
	}
}
