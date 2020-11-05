<?php
/**
 * フロントページのコンテンツ部分
 */
// コンテンツ前フック
do_action( 'arkhe_before_front_content' );

// 本文
echo '<div class="p-front__content c-postContent">';
	the_content();
echo '</div>';

// 改ページナビゲーション
Arkhe::get_part( 'singular/pagination' );

// コンテンツ後フック
do_action( 'arkhe_after_front_content' );
