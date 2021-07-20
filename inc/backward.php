<?php
/**
 * アイキャッチ画像を取得 for ~ 1.4
 */
function ark_get__thumbnail( $the_id = null, $args = array() ) {
	$args['post_id'] = $the_id;
	return ark_the__thumbnail( $args );
}


/**
 * アーカイブページのデータを取得 for ~1.4
 */
function ark_get__archive_data() {
	return \Arkhe::get_archive_data();
}


/**
 * 投稿リスト用の日付 for ~1.4
 */
function ark_the__post_list_times( $show_date, $show_modified, $date, $modified ) {
	$date     = $show_date ? $date : null;
	$modified = $show_modified ? $modified : null;
	if ( ! $date && ! $modified ) return;

	\Arkhe::get_part( 'post_list/item/meta/times', array(
		'date'     => $date,
		'modified' => $modified,
	) );
}


/**
 * 投稿リスト用のカテゴリー for ~1.4
 */
function ark_the__post_list_category() {
	\Arkhe::get_part( 'post_list/item/meta/category' );
}


/**
 * 投稿リスト用の著者情報
 */
function ark_the__post_list_author( $author_id ) {
	\Arkhe::get_part( 'post_list/item/meta/author', array( 'author_id' => $author_id ) );
}


/*
 * タームリストを出力する for ~1.4
 */
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
