<?php
/**
 * コメント用テンプレート
 */
$comments_num = get_comments_number();
?>
<aside id="comments" class="p-comments c-bottomSection">
	<h2 class="p-comments__title c-bottomSection__title">
		<?php esc_html_e( 'Comments', 'arkhe' ); ?>
		<?php if ( $comments_num ) : ?>
			<span class="p-comments__num">(<?php echo esc_html( $comments_num ); ?>)</span>
		<?php endif; ?>
	</h2>
	<div class="p-comments__body">
		<?php if ( have_comments() ) : ?>
			<ul class="c-commentList">
				<?php wp_list_comments( 'avatar_size=48' ); ?>
			</ul>
		<?php else : ?>
			<p class="p-comments__none">
				<?php esc_html_e( 'There are no comments for this post yet.', 'arkhe' ); ?>
			</p>
		<?php endif; ?>
		<?php if ( get_comment_pages_count() > 1 ) : ?>
			<nav class="pagination" role="navigation">
				<?php
					paginate_comments_links(
						array(
							'mid_size'  => 1,
						)
					);
				?>
			</nav>
		<?php endif; ?>
		<?php
			// コメントフォーム呼び出し
			comment_form();
		?>
	</div>
</aside>
