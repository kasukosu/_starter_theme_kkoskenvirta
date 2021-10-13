wp.domReady(() => {

	/*
	// count all

	console.log(wp.blocks.getBlockTypes().length);

	// list all

	wp.blocks.getBlockTypes().forEach(
		function(blockType) {
			console.log(blockType.name);
		}
	);

	if (window.console.table) {
		console.table(wp.blocks.getBlockTypes());
	}
	*/

	// remove block styles

	wp.blocks.unregisterBlockStyle('core/button', [
		'default',
		'outline',
		'squared',
		'fill',
	]);

	wp.blocks.registerBlockStyle('core/button', {
		name: 'primary',
		label: 'Primary',
		isDefault: true,
	});

	wp.blocks.registerBlockStyle('core/button', {
		name: 'secondary',
		label: 'Secondary',
		isDefault: false,
	});

	wp.blocks.unregisterBlockStyle('core/image', [
		'default',
		'circle-mask',
	]);

	wp.blocks.unregisterBlockStyle('core/quote', [
		'default',
		'large',
	]);

	// whitelist

	var allowedBlocks = [
		'core/paragraph',
		'core/image',
		'core/heading',
		'core/list',
		'core/quote',
		'core/buttons',
		'core/button',
		'core/more',
		'core/html',
		'core/shortcode',
		'core/columns',
		'core/column',
		'core/embed',
		'core/gallery',
		'core/cover',
	];

	wp.blocks.getBlockTypes().forEach(function(blockType) {
		if (blockType.name.startsWith('core') && (allowedBlocks.indexOf(blockType.name) === -1)) {
			wp.blocks.unregisterBlockType(blockType.name);
		}
	});

});
