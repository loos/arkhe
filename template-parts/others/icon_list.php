<?php if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * SNSなどのアイコンリストを出力する
 *
 * @param $parts_args
 *   $parts_args['list_data'] : アイコンリストのデータ。 key => href がアイコンごとに入っている。
 *   $parts_args['class'] : 追加クラス名
 */

if ( null === $parts_args ) return;

// 引数から受け取る情報
$list_data = isset( $parts_args['list_data'] ) ? $parts_args['list_data'] : array();
$class     = isset( $parts_args['class'] ) ? $parts_args['class'] : '';

?>
<ul class="c-iconList <?php echo esc_attr( $class ); ?>">
	<?php
		foreach ( $list_data as $key => $href ) :
			if ( empty( $href ) ) continue;
			if ( 'home' === $key ) $key = 'link';
		?>
				<li class="c-iconList__item -<?php echo esc_attr( $key ); ?>">
					<a href="<?php echo esc_url( $href ); ?>" target="_blank" rel="noopener" class="c-iconList__link">
						<i class="c-iconList__icon arkhe-icon-<?php echo esc_attr( $key ); ?>" role="presentation"></i>
					</a>
				</li>
		<?php
		endforeach;
	?>
</ul>
