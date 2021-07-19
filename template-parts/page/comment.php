<?php
/**
 * 固定ページのコメント
 */
$the_id = get_the_ID();
if ( comments_open( $the_id ) && ! post_password_required( $the_id ) ) :
	comments_template();
endif;
