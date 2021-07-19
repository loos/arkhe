<?php
/**
 * アイキャッチ画像を取得
 */
if ( ! function_exists( 'ark_part__thumbnail' ) ) {
	function ark_part__thumbnail( $args ) {
		$the_id           = isset( $args['post_id'] ) ? $args['post_id'] : '';
		$size             = isset( $args['size'] ) ? $args['size'] : 'full';
		$sizes            = isset( $args['sizes'] ) ? $args['sizes'] : '';
		$class            = isset( $args['class'] ) ? $args['class'] : '';
		$placeholder      = isset( $args['placeholder'] ) ? $args['placeholder'] : '';
		$placeholder_size = isset( $args['placeholder_size'] ) ? $args['placeholder_size'] : '';
		$use_lazyload     = isset( $args['use_lazyload'] ) ? $args['use_lazyload'] : true;

		// memo : image_downsize( $img_id, 'medium' );
		$attachment_args = array(
			'class' => $class,
		);

		$thumb = '';

		if ( has_post_thumbnail( $the_id ) ) {
			// アイキャッチ画像の設定がある場合

			$thumb = get_the_post_thumbnail( $the_id, $size, $attachment_args );
			if ( $placeholder_size ) {
				$placeholder = get_the_post_thumbnail_url( $the_id, $placeholder_size );
			}
		} elseif ( ARKHE_NOIMG_ID ) {
			// ARKHE_NOIMG_ID がある場合

			$thumb = wp_get_attachment_image( ARKHE_NOIMG_ID, $size, false, $attachment_args );
			if ( $placeholder_size ) {
				$placeholder = wp_get_attachment_image_url( ARKHE_NOIMG_ID, $placeholder_size ) ?: '';
			}
		} else {
			$thumb = '<img src="' . esc_url( ARKHE_NOIMG_URL ) . '" class="' . esc_attr( $class ) . '">';
		}

		// 指定のサイズがあれば書き換える
		if ( $sizes ) {
			$thumb = preg_replace( '/ sizes="([^"]*)"/', ' sizes="' . $sizes . '"', $thumb );
		}

		// 通常のフロント表示の時（Gutenberg上やRESTの時以外）
		if ( $use_lazyload && ! Arkhe::is_rest() && ! Arkhe::is_iframe() ) {
			$placeholder = $placeholder ? esc_url( $placeholder ) : ARKHE_PLACEHOLDER;
			$thumb       = str_replace( ' src="', ' src="' . $placeholder . '" data-src="', $thumb );
			$thumb       = str_replace( ' srcset="', ' data-srcset="', $thumb );
			$thumb       = str_replace( ' class="', ' class="lazyload ', $thumb );
			// loading="lazy"
		}

		return $thumb;
	}
}


/**
 * 投稿の日付データを出力 (アーカイブと投稿ページで使用)
 * date: DateTime object
 */
if ( ! function_exists( 'ark_part__post_time' ) ) {
	function ark_part__post_time( $args ) {

		$date = isset( $args['date'] ) ? $args['date'] : null;
		$type = isset( $args['type'] ) ? $args['type'] : 'posted';
		$tag  = isset( $args['tag'] ) ? $args['tag'] : 'time';

		if ( null === $date ) return;

		$date_format = get_option( 'date_format' );
		$icon_class  = 'c-postMetas__icon arkhe-icon-' . $type;
		$time_class  = 'c-postTimes__item u-flex--aic -' . $type;

		$return = '';
		if ( 'time' === $tag ) {
			$return .= '<time class="' . esc_attr( $time_class ) . '" datetime="' . esc_attr( $date->format( 'Y-m-d' ) ) . '">' .
				'<i class="' . esc_attr( $icon_class ) . '" role="img" aria-hidden="true"></i>' .
				esc_html( $date->format( $date_format ) ) .
			'</time>';
		} else {
			$return .= '<span class="' . esc_attr( $time_class ) . '">' .
				'<i class="' . esc_attr( $icon_class ) . '" role="img" aria-hidden="true"></i>' .
				esc_html( $date->format( $date_format ) ) .
			'</span>';
		}
		return $return;
	}
}



/**
 * 投稿リスト用の日付
 */
if ( ! function_exists( 'ark_part__post_list_times' ) ) {
	function ark_part__post_list_times( $args ) {

		$date     = isset( $args['date'] ) ? $args['date'] : null;
		$modified = isset( $args['modified'] ) ? $args['modified'] : null;

		// まだ文字列の場合はDateTime化 ( is_stringチェックは後方互換用 )
		if ( is_string( $date ) ) $date         = new DateTime( $date );
		if ( is_string( $modified ) ) $modified = new DateTime( $modified );

		// 両方表示する設定の場合、更新日は公開日より遅い場合だけ表示
		if ( $date && $modified ) {
			$modified = ( $date < $modified ) ? $modified : null;
		}

		$date_html = '';
		if ( $date ) {
			$date_html .= ark_part__post_time( array(
				'date' => $date,
				'type' => 'posted',
				'tag'  => 'time',
			) );
		}
		if ( $modified ) {
			$date_html .= ark_part__post_time( array(
				'date' => $modified,
				'type' => 'modified',
				'tag'  => 'time',
			) );
		}

		if ( ! $date_html ) return '';
		return '<div class="p-postList__times c-postTimes u-color-thin u-flex--aic">' . $date_html . '</div>';
	}
}


/**
 * 投稿リスト用のカテゴリー
 */
if ( ! function_exists( 'ark_part__post_list_category' ) ) {
	function ark_part__post_list_category( $args ) {

		$post_id    = isset( $args['post_id'] ) ? $args['post_id'] : 0;
		$categories = get_the_category( $post_id );

		if ( empty( $categories ) ) return;

		$cat = $categories[0];
		return '<div class="p-postList__category u-color-thin u-flex--aic">' .
			'<i class="c-postMetas__icon arkhe-icon-folder" role="img" aria-hidden="true"></i>' .
			'<span data-cat-id="' . esc_attr( $cat->term_id ) . '">' . esc_html( $cat->name ) . '</span>' .
		'</div>';
	}
}


/**
 * 投稿リスト用の著者情報
 */
if ( ! function_exists( 'ark_part__post_list_author' ) ) {
	function ark_part__post_list_author( $args ) {
		$author_id   = isset( $args['author_id'] ) ? $args['author_id'] : 0;
		$author_data = Arkhe::get_author_icon_data( $author_id );

		return '<div class="p-postList__author c-postAuthor u-flex--aic">' .
			'<figure class="c-postAuthor__figure">' . wp_kses( $author_data['avatar'], Arkhe::$allowed_img_html ) . '</figure>' .
			'<span class="c-postAuthor__name u-color-thin">' . esc_html( $author_data['name'] ) . '</span>' .
		'</div>';
	}
}
