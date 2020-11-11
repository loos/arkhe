<?php
namespace Arkhe_Theme\Data;

trait Default_Data {

	public static function get_default_settings() {
		return array(
			// Colors
			'color_main'                => '#111',
			'color_text'                => '#333',
			'color_link'                => '#3fa3ff',
			'color_bg'                  => '#fff',

			// Content width
			'container_width'           => 1200,
			'slim_width'                => 960,

			// NO IMAGE
			'no_image'                  => '',

			// Breadcrumbs
			'breadcrumbs_pos'           => 'top',
			'breadcrumbs_home_text'     => __( 'Home', 'arkhe' ),
			'breadcrumbs_set_home_page' => false,

			// Header
			// 'head_logo'              => 0,
			'head_logo_overlay'         => 0,
			'header_overlay_on_page'    => false,
			'logo_size_pc'              => '48',
			'logo_size_sp'              => '40',
			'header_overlay'            => 'off',
			'fix_header_pc'             => true,
			'fix_header_sp'             => true,
			'fix_gnav'                  => false,
			'show_search_sp'            => true,
			'show_search_pc'            => false,
			'show_drawer_sp'            => true,
			'show_drawer_pc'            => false,
			'move_gnav_under'           => false,

			// Footer
			'show_pagetop'              => true,
			'copyright'                 => '&copy; 2020 ' . esc_html( get_option( 'blogname' ) ) . '.',

			// Sidebar
			'show_sidebar_top'          => false,
			'show_sidebar_post'         => true,
			'show_sidebar_page'         => false,
			'show_sidebar_archive'      => true,

			// 投稿リスト
			'post_list_layout'          => 'card',  // card
			'excerpt_length'            => 80,

			'show_list_cat'             => true,
			'show_list_date'            => true,
			'show_list_mod'             => false,
			'show_list_author'          => false,
			'thumb_ratio'               => 'wide',

			// 固定ページ設定
			'page_title_pos'            => 'top',
			// 'show_page_thumb'           => false,
			'title_bg_filter'           => 'dot',
			'ttlbg_overlay_color'       => '#000',
			'ttlbg_overlay_opacity'     => 0.2,

			// 投稿ページ
			'show_entry_cat'            => true,
			'show_entry_tag'            => false,
			'show_entry_author'         => false,
			'show_entry_thumb'          => true,

			// 下部エリア
			'show_foot_terms'           => true,
			'show_prev_next_link'       => true,
			'show_author_box'           => true,
			'show_comments'             => true,
			'show_img_shadow'           => true,
			'show_related_posts'        => true,
			'related_posts_layout'      => 'card',
			'post_relation_type'        => 'category',
			'pn_link_is_same_term'      => false,

		);
	}
}
