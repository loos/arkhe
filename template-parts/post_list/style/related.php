<?php
/**
 * 関連記事リストの出力テンプレート（サブループ内）
 *   $args['count'] : 現在のループカウント数 (フック用に用意)
 */

?>
<li class="p-postList__item">
	<a href="<?php the_permalink(); ?>" class="p-postList__link">
		<?php
			Arkhe::get_part( 'post_list/item/thumb', array(
				'size'  => 'medium',
				'sizes' => '(min-width: 600px) 400px, 50vw',
			) );
		?>
		<div class="p-postList__body">
			<div class="p-postList__title"><?php the_title(); ?></div>
				<?php
					Arkhe::get_part( 'post_list/item/meta', array(
						'show_date'     => Arkhe::get_setting( 'show_related_posted' ),
						'show_modified' => Arkhe::get_setting( 'show_related_modified' ),
					) );
				?>
		</div>
	</a>
</li>
