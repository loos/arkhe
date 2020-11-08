<?php
/**
 * 投稿リスト(RSS)に表示されるメタデータ
 */
$show_site   = $args['show_site'];
$show_date   = $args['show_date'];
$show_author = $args['show_author'];
$site_title  = $args['site_title'];
$favicon     = $args['favicon'];
$feed_date   = $args['feed_date'];
$feed_author = $args['feed_author'];
?>
<div class="p-postList__meta c-postMetas u-flex--aicw">
	<?php if ( $show_site ) : ?>
		<div class="p-postList__site c-rssSite u-color-thin u-flex--aic">
			<?php if ( $favicon ) : ?>
				<img class="c-rssSite__favi" width="16" height="16" src="<?php echo esc_url( $favicon ); ?>" alt="">
			<?php endif; ?>
			<span class="c-rssSite__title"><?php echo esc_html( $site_title ); ?></span>
		</div>
	<?php endif; ?>
	<?php if ( $show_date && $feed_date ) : ?>
		<div class="p-postList__times c-postTimes u-color-thin">
			<span class="c-postTimes__item -posted u-flex--aic">
				<i class="c-postMetas__icon arkhe-icon-posted" role="img" aria-hidden="true"></i>
				<?php echo esc_html( $feed_date ); ?>
			</span>
		</div>
	<?php endif; ?>
	<?php if ( $show_author && $feed_author ) : ?>
		<div class="p-postList__author c-rssAuthor u-color-thin u-flex--aic">
			<i class="c-postMetas__icon arkhe-icon-person" role="img" aria-hidden="true"></i>
			<span class="c-rssAuthor__name"><?php echo esc_html( $feed_author ); ?></span>
		</div>
	<?php endif; ?>
</div>
