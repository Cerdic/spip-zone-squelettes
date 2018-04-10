var instance = null;
var gbks = gbks || {};

$('.pin_mb').wookmark({
	align: 'center',
	autoResize: true,
	container: $('#pins_mb'),
	itemWidth: 236,
	offset: 14,
	resizeDelay: 50,
	flexibleWidth: 0,
	onLayoutChanged: undefined,
	fillEmptySpace: false
});