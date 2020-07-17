<?php if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * 投稿ページのフッター部分
 * $parts_args['tw_id'] : TwitterのユーザーID
 * $parts_args['fb_url'] : FacebookページのURL
 */
$tw_id  = isset( $parts_args['tw_id'] ) ? $parts_args['tw_id'] : '';
$fb_url = isset( $parts_args['fb_url'] ) ? $parts_args['fb_url'] : '';

$cta_message = '';
if ( $tw_id && $fb_url ) {
	$cta_message = 'いいね または フォロー';
} elseif ( $fb_url ) {
	$cta_message = 'いいね';
} elseif ( $tw_id ) {
	$cta_message = 'フォロー';
}
?>
<div class="c-followBox">
	<?php
	if ( $fb_url ) : // FBのscript
		$fb_appID       = ARKHE_THEME::get_setting( 'fb_like_appID' ) ?: '';
		$fb_appID_query = $fb_appID ? '&appId=' . $fb_appID . '&autoLogAppEvents=1' : '';
	?>
		<div id="fb-root"></div>
		<script class="fb_like_script">
			(function(d, s, id) {
				var js, fjs = d.getElementsByTagName(s)[0];
				if (d.getElementById(id)) return;
				js = d.createElement(s); js.id = id;
				js.async = true;
				js.src = "https://connect.facebook.net/ja_JP/sdk.js#xfbml=1&version=v4.0<?php echo esc_js( $fb_appID_query ); ?>";
				fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));
		</script>
	<?php endif; ?>
	<figure class="c-followBox__figure">
		<?php // @codingStandardsIgnoreStart
			echo ARKHE_THEME::get_thumbnail(
				get_the_ID(),
				array(
					'size' => 'large',
					'sizes'       => '(min-width: 600px) 450px, 50vw',
					'class'       => 'c-followBox__img',
				)
			);
		// @codingStandardsIgnoreEnd ?>
	</figure>
	<div class="c-followBox__body">
		<p class="c-followBox__message u-lh-15">
			この記事が気に入ったら<br>
			<i class="arkhe-icon-thumb_up"></i> <?php echo esc_html( $cta_message ); ?>してね！
		</p>
		<div class="c-followBox__btns">
			<?php if ( $fb_url ) : ?>
				<div class="fb-like" data-href="<?php echo esc_attr( $fb_url ); ?>" data-layout="button" data-action="like" data-show-faces="false" data-share="false"></div>
			<?php endif; ?>
			<?php if ( $tw_id ) : ?>
				<a href="https://twitter.com/<?php echo esc_attr( $tw_id ); ?>?ref_src=twsrc%5Etfw" class="twitter-follow-button" data-show-screen-name="false" data-lang="ja" data-show-count="false">Follow @<?php echo esc_html( $tw_id ); ?></a>
				<script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
			<?php endif; ?>
		</div>
	</div>
</div>
