<?php
/**
 * 投稿一覧リストの出力テンプレート（メインクエリ用）
 *   $args['list_type'] : リストタイプ
 */
$list_type = isset( $args['list_type'] ) ? $args['list_type'] : ARKHE_LIST_TYPE;

// リストスタイルによって読み込むファイル名を振り分ける
$file_name = ( 'simple' === $list_type ) ? 'simple' : 'normal';

// ループのカウント用変数
$loop_count = 0;

if ( have_posts() ) : ?>
	<ul class="p-postList -type-<?php echo esc_attr( $list_type ); ?>">
		<?php
		while ( have_posts() ) :
			the_post();
			Arkhe::get_part(
				'post_list/style/' . $file_name,
				array(
					'list_type' => $list_type,
					'count'     => $loop_count++,
				)
			);
		endwhile;
	?>
	</ul>
<?php else : ?>
	<div class="p-postList--notfound">
		<?php esc_html_e( 'No posts were found.', 'arkhe' ); ?>
	</div>
<?php
endif;
