(function($) {

	var mapConf = {};
	var map_id;

	var map;

	var updateMapConf = function() {

		// layers
		mapConf.layers = getLayers();
		mapConf.filteringLayers = getFilteringLayers();
		
		// server
		if($('input[name="map_data[server]"]:checked').val() === 'custom') {
			mapConf.server = $('input[name="map_data[custom_server]"]').val();
		}

		// center
		if($('.centerzoom.map-setting input.center-lat').val()) {
			var $centerInputs = $('.centerzoom.map-setting');
			mapConf.center = [
				parseFloat($centerInputs.find('input.center-lat').val()),
				parseFloat($centerInputs.find('input.center-lon').val())
			]
		}

		// zoom
		if($('.centerzoom.map-setting input.zoom').val())
			mapConf.zoom = parseInt($('.centerzoom.map-setting input.zoom').val());
		// min zoom
		if($('#min-zoom-input').val())
			mapConf.minZoom = parseInt($('#min-zoom-input').val());
		// max zoom
		if($('#max-zoom-input').val())
			mapConf.maxZoom = parseInt($('#max-zoom-input').val());


		// pan limits
		if($('.pan-limits.map-setting input.east').val()) {
			mapConf.panLimits =	[
				[
					$('.pan-limits.map-setting input.south').val(),
					$('.pan-limits.map-setting input.west').val()
				],
				[
					$('.pan-limits.map-setting input.north').val(),
					$('.pan-limits.map-setting input.east').val()
				]
			];
		}

		// geocode
	 	if($('#mapbox-metabox .enable-geocode').is(':checked'))
	 		mapConf.geocode = true;
	 	else
	 		mapConf.geocode = false;

	 	// handlers
	 	mapConf.disableHandlers = {};
		// mousewheel
	 	if($('#mapbox-metabox .disable-mousewheel').is(':checked'))
	 		mapConf.disableHandlers.mousewheel = true;
	 	else
	 		mapConf.disableHandlers.mousewheel = false;

	 	if($('#mapbox-metabox .toggle-preview-mode').is(':checked'))
	 		mapConf.preview = true;
	 	else
	 		mapConf.preview = false;

	 	// legend
	 	if($('#mapbox-legend-metabox').length) {
	 		if($('#mapbox-legend-textarea').val())
	 			mapConf.legend = $('#mapbox-legend-textarea').val();
	 		else if(mapConf.legend)
	 			delete mapConf.legend;
	 	}

	 	// don't show full legend
	 	mapConf.legend_full = false;

	 	mapConf.admin = true;

		// save mapConf
		storeConf(mapConf);

		return mapConf;
	}

	function storeConf(conf) {
		var storable = $.extend({}, conf);
		delete storable.callbacks;
		delete storable.preview;
		delete storable.admin;
		$('input[name=map_conf]').val(JSON.stringify(storable));
	}

	function updateMap() {
		updateMapConf();
		if(typeof map === 'object')
			mapConf.fitBounds = map.getBounds();

		map.remove();

		map = jeo.build(mapConf);
	}

	function updateMapData() {
		if(typeof map === 'object') {
			var bounds = map.getBounds();
			var center = map.getCenter();
			var zoom = map.getZoom();
			$('.current.map-setting .east').text(bounds.getEast());
			$('.current.map-setting .north').text(bounds.getNorth());
			$('.current.map-setting .south').text(bounds.getSouth());
			$('.current.map-setting .west').text(bounds.getWest());
			$('.current.map-setting .center').text(center);
			$('.current.map-setting .zoom').text(zoom);
		}
	}

	mapConf.callbacks = function(map) {
		map.on('load', function() {
			updateMapData();
		});
		map.on('zoomend', function() {
			updateMapData();
		});
		map.on('dragend', function() {
			updateMapData();
		});
	}

	$(document).ready(function() {

		if(!$('#mapbox-metabox').length)
			return;

		var postID = $('input[name=post_ID]').val();

		updateBaseLayerURLBox();

		// load map
		$('.map-container > .map').attr('id', 'map_' + postID);
		mapConf.containerID = map_id = 'map_' + postID;
		mapConf.postID = postID;

		var layersList = $('#mapbox-metabox .layers-list');
		layersList.sortable();

		updateMapConf();

		map = jeo.build(mapConf);
		updateMapData();

		/*
		 * Layer management
		 */
				
		$('#mapbox-metabox .add-layer').click(function() {
			addLayer($(this).data('layertype'));
			return false;
		});

		$('#mapbox-metabox .remove-layer').live('click', function() {
			removeLayer($(this).parents('li'));
			return false;
		});

		// update base layer select and set change listener
		$('#baselayer_drop_down').change(updateBaseLayerURLBox);

		// filtering layers opts
		$('#mapbox-metabox .filtering-opts').hide();
		$('#mapbox-metabox .layers-list input.filtering-opt').live('change', function() {
			var optInput = $(this).parent().find(':checked');
			var filteringOpts = optInput.parents('.filter-opts').find('.filtering-opts');
			var opt = optInput.val();
			if(opt != 'fixed') {
				filteringOpts.show();
				if(opt == 'switch') {
					filteringOpts.find('.switch-opts').show();
					filteringOpts.find('.swap-opts').hide();
				} else if(opt == 'swap') {
					filteringOpts.find('.switch-opts').hide();
					filteringOpts.find('.swap-opts').show();
				}
			} else {
				filteringOpts.hide();
			}
		}).change();

		// update swap layer id
		$('#mapbox-metabox .layers-list input.swap_first_layer').live('change', function() {
			$(this).val($(this).parents('li').find('.layer_id').val());
		}).change();

		/*
		 * Map preview button
		 */
		$('#mapbox-metabox .preview-map').click(function() {
			updateMap();
			return false;
		});

		/*
		 * Manage map confs
		 */
		$('#mapbox-metabox .set-map-centerzoom').click(function() {
			updateCenterZoom();
			return false;
		});
		$('#mapbox-metabox .set-map-pan').click(function() {
			updatePanLimits();
			return false;
		});
		$('#mapbox-metabox .set-max-zoom').click(function() {
			updateMaxZoom();
			return false;
		});
		$('#mapbox-metabox .set-min-zoom').click(function() {
			updateMinZoom();
			return false;
		});

		/*
		 * Toggle preview mode
		 */
		 $('#mapbox-metabox .toggle-preview-mode').change(function() {
		 	if($(this).is(':checked'))
		 		mapConf.preview = true;
		 	else
		 		mapConf.preview = false;

		 	updateMap();
		 });

		 $('#mapbox-metabox .enable-geocode').change(function() {
		 	if($(this).is(':checked'))
		 		mapConf.geocode = true;
		 	else
		 		mapConf.geocode = false;

		 	updateMap();
		 });

		function updateCenterZoom() {
			var center = map.getCenter();
			var zoom = map.getZoom();
			$('.centerzoom.map-setting span.center').text(center);
			$('.centerzoom.map-setting span.zoom').text(zoom);

			// update inputs
			$('.centerzoom.map-setting input.center-lat').val(center.lat);
			$('.centerzoom.map-setting input.center-lon').val(center.lng);
			$('.centerzoom.map-setting input.zoom').val(zoom);
		}

		function updatePanLimits() {
			var bounds = map.getBounds();
			$('.pan-limits.map-setting span.east').text(bounds.getEast());
			$('.pan-limits.map-setting span.north').text(bounds.getNorth());
			$('.pan-limits.map-setting span.south').text(bounds.getSouth());
			$('.pan-limits.map-setting span.west').text(bounds.getWest());

			// update inputs
			$('.pan-limits.map-setting input.east').val(bounds.getEast());
			$('.pan-limits.map-setting input.north').val(bounds.getNorth());
			$('.pan-limits.map-setting input.south').val(bounds.getSouth());
			$('.pan-limits.map-setting input.west').val(bounds.getWest());
		}

		function updateMaxZoom() {
			var zoom = map.getZoom();
			$('#max-zoom-input').val(zoom);
		}

		function updateMinZoom() {
			var zoom = map.getZoom();
			$('#min-zoom-input').val(zoom);
		}

	});

  // Add an entry to the layer list.
	function addLayer(type) {

		var layersList = $('#mapbox-metabox .layers-list');
		var layerItem = $(mapbox_metabox_localization.layer_item);
		var layerLength = layersList.find('li').length + 1;
		var layerTypeCaption = layerItem.find('.layer_type');
		var layerID = layerItem.find('.layer_id');

		layerID.attr('name', 'map_data[layers][' + layerLength + '][id]');
		layerItem.find('.fixed_layer, .switch_layer, .swap_layer').attr('name', 'map_data[layers][' + layerLength + '][opts][filtering]');
		layerItem.find('.layer_title').attr('name', 'map_data[layers][' + layerLength + '][title]');
		layerItem.find('.layer_type').attr('name', 'map_data[layers][' + layerLength + '][type]');
		layerItem.find('.layer_type').attr('value', type);
		layerItem.find('.layer_hidden').attr('name', 'map_data[layers][' + layerLength + '][switch_hidden]');

		layerItem.find('.filtering-opts').hide();


		layersList.append(layerItem);
	}

	function removeLayer(layer) {
		layer.remove();
	}

	function getLayers() {
		var layers = [];
		
		// add base layer url
		base_layer_url = $('#baselayer_url_box').val();
		if (base_layer_url) 
			layers.push(base_layer_url);
		
		// add other layers
		$('#mapbox-metabox .layers-list li').each(function() {
			layers.push({
				layerID: $(this).find('input.layer_id').val(),
				layerType: $(this).find('input.layer_type').val()
			});
		});

		return layers;
	}

	function getFilteringLayers() {
		var filtering = {};
		filtering.switchLayers = [];
		filtering.swapLayers = [];
		$('#mapbox-metabox .layers-list li').each(function() {
			var id = $(this).find('input.layer_id').val();
			var filteringOpt = $(this).find('.filtering-opt:checked').val();
			if(filteringOpt == 'switch') {

				var layer = {
					id: id,
					title: $(this).find('input.layer_title').val()
				}
				if($(this).find('input.layer_hidden:checked').length)
					layer.hidden = true;

				filtering.switchLayers.push(layer);

			} else if(filteringOpt == 'swap') {

				var layer = {
					id: id,
					title: $(this).find('input.layer_title').val()
				}
				if($('#mapbox .layers-list .swap_first_layer:checked').val() == id)
					layer.first = true;

				filtering.swapLayers.push(layer);

			}
		});
		return filtering;
	}

	function updateBaseLayerURLBox() {

		base_layer_url_box = $('#baselayer_url_box');

		switch ( $('#baselayer_drop_down').val() ){
			case 'openstreetmap':
				base_layer_url_box.val('http://a.tile.openstreetmap.org/{z}/{x}/{y}.png');
				base_layer_url_box.attr('readonly', true);
				break;
		    case 'mapquest_osm':
			    base_layer_url_box.val('http://otile1.mqcdn.com/tiles/1.0.0/map/{z}/{x}/{y}.jpg');
			    base_layer_url_box.attr('readonly', true);
			    break;
		    case 'mapquest_sat':
			    base_layer_url_box.val('http://otile1.mqcdn.com/tiles/1.0.0/sat/{z}/{x}/{y}.jpg');
			    base_layer_url_box.attr('readonly', true);
			    break;
		    case 'stamen_toner':
			    base_layer_url_box.val('http://{s}.tile.stamen.com/toner/{z}/{x}/{y}.png');
			    base_layer_url_box.attr('readonly', true);
			    break;
		    case 'stamen_watercolor':
			    base_layer_url_box.val('http://{s}.tile.stamen.com/watercolor/{z}/{x}/{y}.jpg');
			    base_layer_url_box.attr('readonly', true);
			    break;		  
		    case 'stamen_terrain':
			    base_layer_url_box.val('http://{s}.tile.stamen.com/terrain/{z}/{x}/{y}.jpg');
			    base_layer_url_box.attr('readonly', true);
			    break;
		    case 'none':
			    base_layer_url_box.val('');
			    base_layer_url_box.attr('readonly', true);
			    break;
			case 'custom': 
				base_layer_url_box.attr('readonly', false);
				break;
		}
		return false;
	}

})(jQuery);