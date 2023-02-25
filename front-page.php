<?php
/**
 * フロントページテンプレート
 */
get_header(); ?>

<main <?php Arkhe::main_attrs(); ?>>
	<div <?php Arkhe::main_body_attrs(); ?>>
		<?php
			do_action( 'arkhe_start_front_main' );

			if ( is_home() ) :
				do_action( 'arkhe_before_home_content' );
				Arkhe::get_part( 'home' );
				do_action( 'arkhe_after_home_content' );
			else :
				do_action( 'arkhe_before_front_content' );
				while ( have_posts() ) :
					the_post();
					Arkhe::get_part( 'front' );
				endwhile;
				do_action( 'arkhe_after_front_content' );
			endif;

			do_action( 'arkhe_end_front_main' );
		?>
	</div>
</main>
<?php
get_footer();
