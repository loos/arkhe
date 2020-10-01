/**
 * wrap()関数 jQueryなしで
 */
export default function wrap(element, wrapper) {
	element.parentNode.insertBefore(wrapper, element);
	wrapper.appendChild(element);
}
