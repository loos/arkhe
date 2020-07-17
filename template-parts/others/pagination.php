<?php if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * 投稿一覧用のページャー
 *  ※ : 現状は the_posts_pagination に置き換えたため、使ってない。
 *
 * @param $parts_args
 *   $parts_args['max_page'] : 最大ページ数
 *   $parts_args['paged'] : 現在のページ番号
 */

if ( $parts_args === null ) return;

// 引数から受け取る情報
$pages = isset( $parts_args['max_page'] ) ? (int) $parts_args['max_page'] : 0; // float型で渡ってくるので int型 へ
$paged = $parts_args['paged'] ?: 1; // get_query_var('paged')をそのまま投げても大丈夫なように

// ページ数が 0 なら（記事がない時） return
if ( $pages === 0 ) return;

// 表示テキスト
$text_first = '1';  // "«";
$text_last  = '' . $pages;  // "»";
$range      = apply_filters( 'arkhe_pager_range', 2 ); // 左右に何ページ表示するか
$show_only  = true; // 1ページしかない時に表示するかどうか

$current     = 'current';
$pager_class = 'page-numbers'; // コメントエリアのページャークラスに合わせる

$return = '';

// １ページのみでも表示する時
if ( $show_only && $pages === 1 ) {
	echo '<div class="c-pagination"><span class="' . $pager_class . ' ' . $current . ' -num">1</span></div>';
	return;
}

// １ページのみで表示しない時
if ( $pages === 1 ) return; // １ページのみで表示設定もない場合

// 複数ページある時

echo '<div class="c-pagination">';

if ( $paged > $range + 1 ) {
	// 「最初へ」 の表示
	echo '<a href="' . get_pagenum_link( 1 ) . '" class="' . $pager_class . ' -to-first">' . $text_first . '</a>';
	echo '<span class="c-pagination__dot">...</span>';
}

for ( $i = 1; $i <= $pages; $i++ ) {
	// 今のページからどれだけ離れた番号か
	$apart = abs( $i - $paged );
	// echo $apart;

	if ( $apart === 0 ) {
		echo '<span class="' . $pager_class . ' ' . $current . ' -num">' . $i . '</span>';
	} elseif ( $apart <= $range ) {
		echo '<a href="' . get_pagenum_link( $i ) . '" class="' . $pager_class . ' -num" data-apart="' . $apart . '">' . $i . '</a>';
	}
}
if ( $paged + $range < $pages ) {
	// 「最後へ」 の表示
	echo '<span class="c-pagination__dot">...</span>';
	echo '<a href="' . get_pagenum_link( $pages ) . '" class="' . $pager_class . ' -to-last">' . $text_last . '</a>';
}

echo '</div>';
