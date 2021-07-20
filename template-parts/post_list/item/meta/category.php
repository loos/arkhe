<?php
/**
 * 投稿リストのカテゴリー
 */
$categories = get_the_category();
if ( empty( $categories ) ) return;

$the_cat = $categories[0];
?>
<div class="p-postList__category u-color-thin u-flex--aic">
	<i class="c-postMetas__icon arkhe-icon-folder" role="img" aria-hidden="true"></i>
	<span data-cat-id="<?php echo esc_attr( $the_cat->term_id ); ?>"><?php echo esc_html( $the_cat->name ); ?></span>
</div>
