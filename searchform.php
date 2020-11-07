<form role="search" method="get" class="c-searchForm" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search">
	<input type="text" value="" name="s" class="c-searchForm__s s" placeholder="<?php esc_attr_e( 'Search', 'arkhe' ); ?>..." aria-label="<?php esc_attr_e( 'Search word', 'arkhe' ); ?>">
	<button type="submit" class="c-searchForm__submit u-flex--c" value="search" aria-label="<?php esc_attr_e( 'Search button', 'arkhe' ); ?>">
		<i class="arkhe-icon-search" role="img" aria-hidden="true"></i>
	</button>
</form>
