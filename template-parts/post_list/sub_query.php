<?php if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * 投稿一覧リストの出力テンプレート（サブループ用）
 *   $args['query_args'] : WP_Queryに渡す引数
 *   $args['list_args'] : リストの表示に関する設定値（メインループでは 'type' しか渡されてこない）
 */
$query_args = isset( $args['query_args'] ) ? $args['query_args'] : null;
$list_args  = isset( $args['list_args'] ) ? $args['list_args'] : array();

// データが配列じゃなければ return
if ( ! is_array( $query_args ) ) return;

// WP_Query 生成
$the_query = new WP_Query( $query_args );

// リストタイプ
$list_type = isset( $list_args['list_type'] ) ? $list_args['list_type'] : ARKHE_LIST_TYPE;

// リストスタイルによって読み込むファイル名を振り分ける
$file_name = ( 'simple' === $list_type ) ? 'simple' : 'normal';

// ループのカウント用変数
$loop_count = 0;

if ( $the_query->have_posts() ) : ?>
	<ul class="p-postList -type-<?php echo esc_attr( $list_type ); ?>">
		<?php
		while ( $the_query->have_posts() ) :
			$the_query->the_post();
			$list_args['count'] = $loop_count++;
			ARKHE_THEME::get_parts( 'post_list/style/' . $file_name, $list_args );
		endwhile;
	?>
	</ul>
<?php else : ?>
	<div class="p-postList--notfound">
		<?php esc_html_e( 'No posts were found.', 'arkhe' ); ?>
	</div>
<?php
endif;

wp_reset_postdata();
