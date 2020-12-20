<?php
/**
 * フロントページのコンテンツ
 */
echo '<div class="' . esc_attr( Arkhe::get_post_content_class() ) . '">';
	the_content();
echo '</div>';

// 改ページナビゲーション
Arkhe::get_part( 'other/pagination' );
