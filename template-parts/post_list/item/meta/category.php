<?php
/**
 * 投稿リストのカテゴリー
 */
$the_cat = \Arkhe::get_a_catgory_for_list();
if ( empty( $the_cat ) ) return;
?>
<div class="p-postList__category u-color-thin u-flex--aic">
	<?php Arkhe::the_svg( 'folder', array( 'class' => 'c-postMetas__icon' ) ); ?>
	<span data-cat-id="<?php echo esc_attr( $the_cat->term_id ); ?>"><?php echo esc_html( $the_cat->name ); ?></span>
</div>
