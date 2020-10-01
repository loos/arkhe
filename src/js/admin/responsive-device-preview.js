/* global jQuery */
/* exported CustomizerResponsiveDevicePreview */
/* eslint consistent-this: [ "error", "section" ], no-magic-numbers: [ "error", { "ignore": [1] } ] */
const CustomizerResponsiveDevicePreview = (function ($) {
	'use strict';

	const component = {
		api: null,
	};

	/**
	 * Add callbacks to previewUrl and previewedDevice values.
	 *
	 * @param {Object} api Instance of wp.customize.
	 * @returns {void}
	 */
	component.init = function init(api) {
		component.api = api;
		api.bind('ready', component.ready);
	};

	/**
	 * Add callbacks to previewUrl and previewedDevice values.
	 *
	 * @returns {void}
	 */
	component.ready = function ready() {
		let originalPreviewUrlValidate;
		originalPreviewUrlValidate = component.api.previewer.previewUrl.validate;
		component.api.previewer.previewUrl.validate = function validatePreviewUrl(newUrl) {
			let url = newUrl;
			if (null !== url) {
				url = component.amendUrlWithPreviewedDevice(url);
			}
			return originalPreviewUrlValidate.call(this, url);
		};
		component.api.previewedDevice.bind(function () {
			const url = component.amendUrlWithPreviewedDevice(
				component.api.previewer.previewUrl.get()
			);
			component.api.previewer.previewUrl.set(url);
		});
	};

	/**
	 * Amend the given URL with a customize_previewed_device query parameter.
	 *
	 * @param {string} url URL.
	 * @returns {string} URL with customize_previewed_device query param amended.
	 */
	component.amendUrlWithPreviewedDevice = function amendUrlWithPreviewedDevice(url) {
		let urlParser, queryParams;
		urlParser = document.createElement('a');
		urlParser.href = url;
		queryParams = component.api.utils.parseQueryString(urlParser.search.substr(1));
		queryParams.customize_previewed_device = component.api.previewedDevice.get();
		urlParser.search = $.param(queryParams);

		//アドセンスでカスタマイザーのプレビュー画面が小さくなるバグを回避(力技)

		setTimeout(function () {
			const prevFrame = document.querySelector('#customize-preview iframe');
			if (prevFrame) {
				prevFrame.style.height = '100%';
			}
		}, 100);
		setTimeout(function () {
			const prevFrame = document.querySelector('#customize-preview iframe');
			if (prevFrame) {
				prevFrame.style.height = '100%';
			}
		}, 500);
		setTimeout(function () {
			const prevFrame = document.querySelector('#customize-preview iframe');
			if (prevFrame) {
				prevFrame.style.height = '100%';
			}
		}, 1000);
		setTimeout(function () {
			const prevFrame = document.querySelector('#customize-preview iframe');
			if (prevFrame) {
				prevFrame.style.height = '100%';
			}
		}, 2000);

		return urlParser.href;
	};

	return component;
})(jQuery);
