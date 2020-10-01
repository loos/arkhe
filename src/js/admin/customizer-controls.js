(function ($) {
	// Wait until the customizer has finished loading.

	wp.customize.bind('ready', function () {
		// トップヘッダー
		function headerOverlay(val) {
			if ('off' !== val) {
				$('.customize-control.-header-overlay').removeClass('-hide');
			} else {
				$('.customize-control.-header-overlay').addClass('-hide');
			}
		}
		wp.customize('arkhe_settings[header_overlay]', function (value) {
			headerOverlay(value.get());
			value.bind(function (to) {
				headerOverlay(to);
			});
		});
	});
})(window.jQuery);
