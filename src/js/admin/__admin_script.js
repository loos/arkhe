(function ($) {
	$(function () {
		//スイッチタイプのcheckboxの動作
		const $switchBox = $('.switch_checkbox');
		$switchBox.click(function (e) {
			const labelFor = $(this).attr('for');
			const p = $(this).closest('tr');
			setTimeout(function () {
				const val = $('#' + labelFor).prop('checked');
				$('input[name="' + labelFor + '"]').val(Number(val));

				if (p.attr('data-disable') !== undefined) {
					p.attr('data-disable', Number(val));
				}
			}, 10);
		});
	});
})(window.jQuery);
