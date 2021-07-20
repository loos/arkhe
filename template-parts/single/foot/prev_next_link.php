<?php
/**
 * 前の記事へ & 次の記事へ
 */
$is_same_term = Arkhe::get_setting( 'pn_link_is_same_term' );

$prev_post = get_adjacent_post( $is_same_term, '', true );
$next_post = get_adjacent_post( $is_same_term, '', false );
?>
<ul class="c-pnNav">
	<li class="c-pnNav__item -prev">
		<?php
			if ( $prev_post ) :
				ark_the__pnlink( array(
					'type'  => 'prev',
					'id'    => $prev_post->ID,
					'title' => $prev_post->post_title,
				) );
			endif;
		?>
	</li>
	<li class="c-pnNav__item -next">
		<?php
			if ( $next_post ) :
				ark_the__pnlink( array(
					'type'  => 'next',
					'id'    => $next_post->ID,
					'title' => $next_post->post_title,
				) );
			endif;
		?>
	</li>
</ul>
