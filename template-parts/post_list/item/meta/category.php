<?php
/**
 * 投稿リストのカテゴリー
 */
$categories = get_the_category();
if ( empty( $categories ) ) return;

$the_cat = $categories[0];
?>
<div class="p-postList__category u-color-thin u-flex--aic">
	<?php Arkhe::the_svg( 'folder', array( 'class' => 'c-postMetas__icon' ) ); ?>
	<span data-cat-id="<?php echo esc_attr( $the_cat->term_id ); ?>"><?php echo esc_html( $the_cat->name ); ?></span>
</div>
