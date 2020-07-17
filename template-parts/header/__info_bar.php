<?php
if ( ! defined( 'ABSPATH' ) ) exit;
$SETTING = ARKHE_THEME::get_setting();

$flowing_class = ( $SETTING['info_flowing'] === 'flow' ) ? '-flow-on' : '-flow-off';


$info_data = array(
	'url'      => $SETTING['info_url'],
	'text'     => $SETTING['info_text'],
	'btn_text' => $SETTING['info_btn_text'],
);
$info_data = apply_filters( 'arkhe_infobar_data', $info_data );

// 外部リンクかどうか
$target = ( strpos( $info_data['url'], home_url() ) !== false ) ? '' : ' rel="noopener" target="_blank"';
?>
<div class="c-infoBar -bg-<?php echo $SETTING['info_bar_effect']; ?>">
	<?php if ( $SETTING['info_flowing'] === 'btn' ) : // ボタン設置する場合 ?>

		<span class="c-infoBar__text <?php echo $flowing_class; ?>">
			<?php echo $info_data['text']; ?>
			<a href="<?php echo $info_data['url']; ?>" class="c-infoBar__btn"<?php echo $target; ?>>
				<?php echo $info_data['btn_text']; ?>
			</a>
		</span>
	
	<?php elseif ( empty( $info_data['url'] ) ) : // リンクがない場合はaタグなし ?>

		<span class="c-infoBar__text <?php echo $flowing_class; ?>"><?php echo $info_data['text']; ?></span>
	
	<?php else : ?>

		<a href="<?php echo $info_data['url']; ?>" class="c-infoBar__link"<?php echo $target; ?>>
			<span class="c-infoBar__text <?php echo $flowing_class; ?>"><?php echo $info_data['text']; ?></span>
		</a>

	<?php endif; ?>
</div>
