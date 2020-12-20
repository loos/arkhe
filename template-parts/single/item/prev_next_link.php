<?php
/**
 * 前の記事へ & 次の記事へ
 */

$is_same_term = Arkhe::get_setting( 'pn_link_is_same_term' );

?>
<ul class="c-pnNav">
	<li class="c-pnNav__item -prev">
		<?php
			// 前の投稿
			$prev_post = get_adjacent_post( $is_same_term, '', true );
			if ( $prev_post ) :
			$prev_id    = $prev_post->ID;
			$prev_title = esc_attr( $prev_post->post_title );
		?>
			<a href="<?php echo esc_url( get_permalink( $prev_id ) ); ?>" rel="prev" class="c-pnNav__link u-flex--aic">
				<span class="c-pnNav__title"><?php echo esc_html( $prev_title ); ?></span>
			</a>
		<?php endif; ?>
	</li>
	<li class="c-pnNav__item -next">
	<?php
		// 次の投稿
		$next_post = get_adjacent_post( $is_same_term, '', false );
		if ( $next_post ) :
		$next_id    = $next_post->ID;
		$next_title = esc_attr( $next_post->post_title );
	?>
		<a href="<?php echo esc_url( get_permalink( $next_id ) ); ?>" rel="next" class="c-pnNav__link u-flex--aic">
			<span class="c-pnNav__title"><?php echo esc_html( $next_title ); ?></span>
		</a>
	<?php endif; ?>
	</li>
</ul>
