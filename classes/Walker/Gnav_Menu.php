<?php
namespace Arkhe_Theme\Walker;

/**
 * ヘッダーメニュー・ドロワーメニューの wp_nav_menu() に渡す Walker
 * see: https://developer.wordpress.org/reference/classes/walker_nav_menu/
 */
class Gnav_Menu extends \Walker {

	/**
	 * What the class handles.
	 *
	 * @see Walker_Nav_Menu::$tree_type
	 */
	public $tree_type = array( 'post_type', 'taxonomy', 'custom' );


	/**
	 * Database fields to use.
	 *
	 * @see Walker_Nav_Menu::$db_fields
	 */
	public $db_fields = array(
		'parent' => 'menu_item_parent',
		'id'     => 'db_id',
	);


	/**
	 * サブメニューの<ul>開始
	 * @see Walker_Nav_Menu::start_lvl()
	 */
	public function start_lvl( &$output, $depth = 0, $args = null ) {

		// ヘッダーgnavかどうか
		$ark_component = isset( $args->ark_component ) ? $args->ark_component : '';

		// クラス
		$classes = array( 'sub-menu' );
		// $classes = apply_filters( 'nav_menu_submenu_css_class', $classes, $args, $depth );
		// $classes[] = 'depth-' . $depth;
		if ( 'gnav' === $ark_component ) {
			$classes[] = 'c-gnav__depth' . ( $depth + 1 );
		}

		$class_names = implode( ' ', $classes );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

		$output .= "<ul$class_names>";
	}


	/**
	 * サブメニューの </ul>
	 *
	 * @see Walker_Nav_Menu::end_lvl()
	 */
	public function end_lvl( &$output, $depth = 0, $args = null ) {
		$output .= '</ul>';
	}


	/**
	 * 各 <li>
	 *
	 * @see Walker_Nav_Menu::start_el()
	 */
	public function start_el( &$output, $data_object, $depth = 0, $args = array(), $current_object_id = 0 ) {

		$menu_item     = $data_object;
		$ark_component = isset( $args->ark_component ) ? $args->ark_component : '';

		// li クラスの生成
		$classes   = empty( $menu_item->classes ) ? array() : (array) $menu_item->classes;
		$classes[] = 'menu-item-' . $menu_item->ID;
		// $classes[] = 'depth-' . $depth;

		// Filters the arguments for a single nav menu item.
		// $args = apply_filters( 'nav_menu_item_args', $args, $menu_item, $depth );

		// Filters the CSS classes applied to a menu item's list item element.
		$classes = array_filter( $classes );
		$classes = apply_filters( 'nav_menu_css_class', $classes, $menu_item, $args, $depth );

		// 直下のliにのみ、__li を付与
		if ( 0 === $depth ) {
			$classes[] = "c-{$ark_component}__li";
		}

		// サブメニューを持つかどうか
		$depth_to_have_submenu = 'gnav' === $ark_component ? 1 : 0;
		$has_child             = $args->walker->has_children;
		$has_acc_child         = $depth_to_have_submenu <= $depth && $has_child;
		if ( $has_acc_child ) {
			$classes[] = 'has-child--acc';
		}

		$output .= '<li id="' . esc_attr( $menu_item->ID ) . '" class="' . esc_attr( implode( ' ', $classes ) ) . '">';

		// <a>の属性を作成
		$atts           = array();
		$atts['title']  = ! empty( $menu_item->attr_title ) ? $menu_item->attr_title : '';
		$atts['target'] = ! empty( $menu_item->target ) ? $menu_item->target : '';
		if ( '_blank' === $menu_item->target && empty( $menu_item->xfn ) ) {
			$atts['rel'] = 'noopener';
		} else {
			$atts['rel'] = $menu_item->xfn;
		}
		$atts['href']         = ! empty( $menu_item->url ) ? $menu_item->url : '';
		$atts['aria-current'] = $menu_item->current ? 'page' : '';
		$atts['class']        = "c-{$ark_component}__a";
		// Filters the HTML attributes applied to a menu item's anchor element.
		// $atts = apply_filters( 'nav_menu_link_attributes', $atts, $menu_item, $args, $depth );

		$attributes = '';
		foreach ( $atts as $attr => $value ) {
			if ( is_scalar( $value ) && '' !== $value && false !== $value ) {
				$value       = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
				$attributes .= ' ' . $attr . '="' . $value . '"';
			}
		}

		// タイトルにthe_title フックを通す
		$title = apply_filters( 'the_title', $menu_item->title, $menu_item->ID );

		// さらに nav_menu_item_title フックも
		$title = apply_filters( 'nav_menu_item_title', $title, $menu_item, $args, $depth );

		// <a>を生成 ( before / after ) はなし
		$item_output = '<a' . $attributes . '><span class="__mainText">' . $title . '</span>';

		// サブテキストを追加
		if ( 0 === $depth && ! empty( $menu_item->description ) ) {
			$item_output .= '<small class="__subText">' . esc_html( $menu_item->description ) . '</small>';
		}

		// サブメニュー開閉ボタンを追加
		if ( $has_acc_child ) {
			$item_output .= ark_get__submenu_toggle_btn();
		}

		$item_output .= '</a>';

		/**
		 * 最後にフックを通す
		 */
		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $menu_item, $depth, $args );
	}

	/**
	 * </li>
	 *
	 * * @see Walker_Nav_Menu::end_el()
	 */
	public function end_el( &$output, $data_object, $depth = 0, $args = null ) {
		$output .= '</li>';
	}

}
