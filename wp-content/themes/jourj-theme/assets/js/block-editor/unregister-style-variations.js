wp.domReady(function () {
	wp.blocks.unregisterBlockStyle('core/button', ['fill', 'outline']);
	wp.blocks.unregisterBlockStyle('core/image', 'rounded');
	wp.blocks.unregisterBlockStyle('core/quote', 'plain');
	wp.blocks.unregisterBlockStyle('core/site-logo', 'rounded');
	wp.blocks.unregisterBlockStyle('core/social-links', ['logo-only', 'pill-shape']);
	wp.blocks.unregisterBlockStyle('core/separator', 'dots');
	wp.blocks.unregisterBlockStyle('core/table', 'stripes');
	wp.blocks.unregisterBlockStyle('core/tag-cloud', 'outline');
});
