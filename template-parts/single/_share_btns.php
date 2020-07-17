<?php if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * 記事のシェアボタン
 */

// 設定取得
$SETTEING = ARKHE_THEME::get_setting();

// 投稿データ
$the_id      = isset( $parts_args['post_id'] ) ? $parts_args['post_id'] : get_the_ID();
$share_title = get_the_title( $the_id );
$share_url   = get_permalink( $the_id );
?>
<div class="c-shareBtns" data-sharebtn="<?php echo esc_attr( $SETTEING['share_btn_style'] ); ?>">
	<ul class="c-shareBtns__list">
		<?php
			// Facebook
			if ( $SETTEING['show_share_btn_fb'] ) :
			$href = 'https://www.facebook.com/sharer/sharer.php?u=' . urlencode( $share_url );
		?>
			<li class="c-shareBtns__item -facebook">
				<a class="c-shareBtns__btn" href="<?php echo esc_url( $href ); ?>" title="Facebookでシェア" onclick="javascript:window.open(this.href, '_blank', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=800,width=600');return false;">
					<i class="snsicon c-shareBtns__icon arkhe-icon-facebook"></i>
				</a>
			</li>
		<?php
			endif;

			// Twitter
			if ( $SETTEING['show_share_btn_tw'] ) :
			$querys = array(
				'url'  => $share_url,
				'text' => $share_title,
			);
			if ( $hashtags = $SETTEING['share_hashtags'] ) $querys['hashtags'] = $hashtags;
			if ( $via = $SETTEING['share_via'] ) $querys['via'] = $via;
			$href = 'https://twitter.com/share?' . http_build_query( $querys, '', '&' );
		 ?>
			<li class="c-shareBtns__item -twitter">
				<a class="c-shareBtns__btn" href="<?php echo esc_url( $href ); ?>" title="Twitterでシェア" onclick="javascript:window.open(this.href, '_blank', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=400,width=600');return false;"
				>
					<i class="snsicon c-shareBtns__icon arkhe-icon-twitter"></i>
				</a>
			</li>
		<?php
			endif;

			// はてぶ
			if ( $SETTEING['show_share_btn_hatebu'] ) :
			$href = '//b.hatena.ne.jp/add?mode=confirm&url=' . urlencode( $share_url );
		?>
			<li class="c-shareBtns__item -hatebu">
				<a class="c-shareBtns__btn" href="<?php echo esc_url( $href ); ?>" title="はてなブックマークに登録" onclick="javascript:window.open(this.href, '_blank', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=1000');return false;">
					<i class="snsicon c-shareBtns__icon arkhe-icon-hatebu"></i>
				</a>
			</li>
		<?php
			endif;

			// ポケット
			if ( $SETTEING['show_share_btn_pocket'] ) :
			$querys = array(
				'url'   => $share_url,
				'title' => $share_title,
			);
			$href   = 'https://getpocket.com/edit?' . http_build_query( $querys, '', '&' );
		?>
			<li class="c-shareBtns__item -pocket">
				<a class="c-shareBtns__btn" href="<?php echo esc_url( $href ); ?>" target="_blank" title="Pocketに保存する">
					<i class="snsicon c-shareBtns__icon arkhe-icon-pocket"></i>
				</a>
			</li>
		<?php
			endif;

			// Pinterest
			if ( $SETTEING['show_share_btn_pin'] ) :
		?>
			<li class="c-shareBtns__item -pinterest">
				<a class="c-shareBtns__btn" data-pin-do="buttonBookmark" data-pin-custom="true" data-pin-lang="ja" href="https://jp.pinterest.com/pin/create/button/">
					<i class="snsicon c-shareBtns__icon arkhe-icon-pinterest"></i>
				</a>
			</li>
			<script async defer src="//assets.pinterest.com/js/pinit.js"></script>
		<?php
			endif;

			// LINE
			if ( $SETTEING['show_share_btn_line'] ) :
			$querys = array(
				'url'  => $share_url,
				'text' => $share_title,
			);
			$href   = 'https://social-plugins.line.me/lineit/share?' . http_build_query( $querys, '', '&' );
		?>
			<li class="c-shareBtns__item -line">
				<a class="c-shareBtns__btn" href="<?php echo esc_url( $href ); ?>" target="_blank" title="LINEに送る">
					<i class="snsicon c-shareBtns__icon arkhe-icon-line"></i>
				</a>
			</li>
		<?php endif; ?>
	</ul>
</div>
