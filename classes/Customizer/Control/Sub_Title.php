<?php
namespace Arkhe_Theme\Customizer\Control;

/**
 * 大タイトル出力用
 */
class Sub_Title extends \WP_Customize_Control {

	public $classname = ''; // 追加したメンバ変数

	// 出力するコンテンツ
	public function render_content() {
		if ( isset( $this->label ) ) {
			echo '<span class="customize-control-title -sub">' . esc_html( $this->label ) . '</span>';
		}
		if ( isset( $this->description ) ) {
			echo '<span class="description customize-control-description">' . wp_kses_post( $this->description ) . '</span>';
		}
	}

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
