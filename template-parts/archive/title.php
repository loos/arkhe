<?php if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * アーカイブタイトルを出力する
 *   $parts_args['title'] : アーカイブタイトル
 *   $parts_args['type'] : アーカイブ種別 (フック用)
 */
// 引数から受け取る情報
$the_title = isset( $parts_args['title'] ) ? $parts_args['title'] : '';
?>
<h1 class="p-archive__title c-pageTitle"><?php echo esc_html( $the_title ); ?></h1>
