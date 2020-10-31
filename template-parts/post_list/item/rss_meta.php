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
<div class="p-postList__meta c-postMetas">
	<?php if ( $show_site ) : ?>
		<div class="p-postList__site c-rssSite u-color-thin">
			<?php if ( $favicon ) : ?>
				<img class="c-rssSite__favi" width="16" height="16" src="<?php echo esc_url( $favicon ); ?>" alt="">
			<?php endif; ?>
			<span class="c-rssSite__title"><?php echo esc_html( $site_title ); ?></span>
		</div>
	<?php endif; ?>
	<?php if ( $show_date ) : ?>
		<div class="p-postList__times c-postTimes u-color-thin">
			<?php if ( $show_date && $feed_date ) : ?>
				<span class="c-postTimes__item -posted"><?php echo esc_html( $feed_date ); ?></span>
			<?php endif; ?>
		</div>
	<?php endif; ?>
	<?php if ( $show_author && $feed_author ) : ?>
		<div class="p-postList__author c-rssAuthor u-color-thin">
			<?php
				// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				echo \Arkhe::svg( 'person', 'c-postMetas__icon' );
			?>
			<span class="c-rssAuthor__name"><?php echo esc_html( $feed_author ); ?></span>
		</div>
	<?php endif; ?>
</div>
