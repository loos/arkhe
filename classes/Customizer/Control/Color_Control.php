<?php
namespace Arkhe_Theme\Customizer\Control;

/**
 * カスタマイザーの li に好きなクラス名を付与できるようににしたもの
 */
class Color_Control extends \WP_Customize_Color_Control {

	public $classname = ''; // 追加したメンバ変数

	protected function render() {
		$id    = 'customize-control-' . str_replace( array( '[', ']' ), array( '-', '' ), $this->id );
		$class = 'customize-control customize-control-' . $this->type;

		if ( isset( $this->classname ) ) {
			$class .= ' ' . $this->classname; // 追加した処理
		}

		printf( '<li id="%s" class="%s">', esc_attr( $id ), esc_attr( $class ) );
		$this->render_content();
		echo '</li>';
	}
}
