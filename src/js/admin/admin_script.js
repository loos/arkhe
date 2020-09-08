(function($) {
	$(function() {
		//スイッチタイプのcheckboxの動作
		$switchBox = $('.switch_checkbox');
		$switchBox.click(function(e) {
			let labelFor = $(this).attr('for');
			let p = $(this).closest('tr');
			setTimeout(function() {
				let val = $('#' + labelFor).prop('checked');
				$('input[name="' + labelFor + '"]').val(Number(val));

				if (p.attr('data-disable') !== undefined) {
					p.attr('data-disable', Number(val));
				}
			}, 10);
		});
	});
})(jQuery);
