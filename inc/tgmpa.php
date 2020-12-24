<?php
/**
 * See details: http://tgmpluginactivation.com/configuration/
 */
namespace Arkhe_Theme;

require_once ARKHE_THEME_PATH . '/inc/tgmpa/class-tgm-plugin-activation.php';
add_action( 'tgmpa_register', '\Arkhe_Theme\register_required_plugins' );

/**
 * Register the required plugins for this theme.
 */
function register_required_plugins() {
	/*
	 * Array of plugin arrays. Required keys are name and slug.
	 */
	$plugins = array(
		array(
			'name'      => 'SEO SIMPLE PACK',
			'slug'      => 'seo-simple-pack',
			'required'  => false,
		),
		array(
			'name'      => 'Custom Block Patterns',
			'slug'      => 'custom-block-patterns',
			'required'  => false,
		),
	);

	// Pro版が有効化されている時には表示されないように
	if ( ! class_exists( 'Arkhe_Blocks' ) ) {
		array_unshift( $plugins, array(
			'name'      => 'Arkhe Blocks',
			'slug'      => 'arkhe-blocks',
			'required'  => false,
		) );
	}

	/*
	 * Array of configuration settings. Amend each line as needed.
	 *
	 * TGMPA will start providing localized text strings soon. If you already have translations of our standard
	 * strings available, please help us make TGMPA even better by giving us access to these translations or by
	 * sending in a pull-request with .po file(s) with the translations.
	 *
	 * Only uncomment the strings in the config array if you want to customize the strings.
	 */
	$config = array(
		'id'           => 'tgmpa',                 // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'parent_slug'  => 'themes.php',            // Parent menu slug.
		'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.
	);

	\tgmpa( $plugins, $config );

}
