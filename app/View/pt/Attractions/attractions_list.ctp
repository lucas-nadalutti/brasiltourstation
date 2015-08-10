<h1 id="attractions-list-title">
	Atrações <span id="chosen-distance-filter" ></span><span id="chosen-tag-filters"></span>
</h1>

<div class="col-md-12 filter-buttons-box">

	<div class="col-md-7">
		<div class="sorters-box">
			<h2 class="filter-buttons-box-title">Ordenação</h2>
			<?php
				echo '<div class="filter-button attraction-filter-button">';
				echo $this->Html->link(
					'<span>Alfabética<i class="fa fa-sort-alpha-asc"></i></span>',
					'javascript:void(0)',
					array('class' => 'sort-criterium-button set-sort-criterium chosen-sort-criterium', 'data-sort-criterium' => 'alphabetic', 'escape' => false)
				);
				echo '</div>';
				echo '<div class="filter-button attraction-filter-button">';
				echo $this->Html->link(
					'<span>Distância<i class="fa fa-map-marker"></i></span>',
					'javascript:void(0)',
					array('class' => 'sort-criterium-button set-sort-criterium', 'data-sort-criterium' => 'distance', 'escape' => false)
				);
				echo '</div>';
				echo '<div class="filter-button attraction-filter-button">';
				echo $this->Html->link(
					'<span>Popularidade<i class="fa fa-line-chart"></i></span>',
					'javascript:void(0)',
					array('class' => 'sort-criterium-button set-sort-criterium', 'data-sort-criterium' => 'popularity', 'escape' => false)
				);
				echo '</div>';
			?>
		</div>
	</div>

	<div class="col-md-5">
		<div class="filters-box">
			<h2 class="filter-buttons-box-title">Filtros</h2>
			<div class="filter-button attraction-filter-button">
				<a href="javascript:void(0)" id="open-attraction-distance-filter-tooltip" class="distance-filter-button">
					<span>Distância<i class="fa fa-map-marker"></i></span>
				</a>
			</div>
			<?php
				echo '<div id="attraction-distance-filter-tooltip" hidden>';

				echo '<div>';
				echo $this->Html->link(
					'Qualquer',
					'javascript:void(0)',
					array('class' => 'set-distance-filter', 'style')
				);
				echo '</div>';
				echo '<div>';
				echo $this->Html->link(
					'Até 1km',
					'javascript:void(0)',
					array('class' => 'set-distance-filter', 'data-distance' => '1000')
				);
				echo '</div>';
				echo '<div>';
				echo $this->Html->link(
					'Até 3km',
					'javascript:void(0)',
					array('class' => 'set-distance-filter', 'data-distance' => '3000')
				);
				echo '</div>';
				echo '<div>';
				echo $this->Html->link(
					'Até 5km',
					'javascript:void(0)',
					array('class' => 'set-distance-filter', 'data-distance' => '5000')
				);
				echo '</div>';
				echo '<div>';
				echo $this->Html->link(
					'Até 10km',
					'javascript:void(0)',
					array('class' => 'set-distance-filter', 'data-distance' => '10000')
				);
				echo '</div>';
				echo '<div>';
				echo $this->Html->link(
					'Até 20km',
					'javascript:void(0)',
					array('class' => 'set-distance-filter', 'data-distance' => '20000')
				);
				echo '</div>';

				echo '</div>';
			?>

			<div class="filter-button attraction-filter-button">
				<a href="javascript:void(0)" id="open-attraction-tag-filter-tooltip" class="tags-filter-button">
					<span>Tags<i class="fa fa-tag"></i></span>
				</a>
			</div>
			<?php
				echo '<div id="attraction-tag-filter-tooltip" hidden>';

				echo '<div id="attraction-tags">';

				// TODO: Find a cleaner way to have X tags per div
				if ($tags) {
					foreach ($tags as $index => $tag) {
						if ($index % 2 == 0) {
							if ($index != 0) {
								echo '</div>';
							}
							echo '<div class="tag-section-box">';
						}
						echo '<div>';
						echo $this->Html->link(
							$tag['Tag']['name_pt'],
							'javascript:void(0)',
							array(
								'class' => 'add-tag-filter',
								'data-tag-id' => $tag['Tag']['id'],
								'data-tag-name' => $tag['Tag']['name_pt'],
							)
						);
						echo '</div>';
					}
					echo '</div>';
				}

				echo '</div>';

				echo '<div id="qtip-tags-arrows" class="attraction-qtip-arrows"></div>';
				
				echo '</div>';
			?>
		</div>
	</div>

</div>

<div id="attractions-list" class="col-md-12">

	<div id="attractions-box">
		<div id="loading-attractions" hidden><!-- TODO: use an icon -->Carregando...</div>
		<table id="attractions-table" hidden></table>
	</div>

</div>

<script id="attractions-json-info" type="application/json">
	{"total": <?php echo $attractionsTotal ?> }
</script>

<script>
	
	$(document).ready(function() {

		// Retrieve attractions that will appear as soon as page loads
		getAttractions();

		// Configure distance tooltip
		$('#open-attraction-distance-filter-tooltip').qtip({
			content: {
				text: $('#attraction-distance-filter-tooltip'),
				button: 'close'
			},
			style: {
				classes: 'attraction-qtip qtip-distance',
				def: false
			},
		    position: {
		        my: 'top left',
		        at: 'bottom left',
		        target: $('#open-attraction-distance-filter-tooltip'),
		        adjust: {
		        	y: 10
		        }
		    },
		    show: {
		        event: 'click',
		        solo: true
		    },
		    hide: {
		        event: 'unfocus'
		    }
		});

		// Configure tag tooltip
		$('#open-attraction-tag-filter-tooltip').qtip({
			content: {
				text: $('#attraction-tag-filter-tooltip'),
				button: 'close'
			},
			style: {
				classes: 'attraction-qtip qtip-tags',
				def: false
			},
		    position: {
		        my: 'top left',
		        at: 'bottom left',
		        target: $('#open-attraction-tag-filter-tooltip'),
		        adjust: {
		        	y: 10
		        }
		    },
		    show: {
		        event: 'click',
		        solo: true
		    },
		    hide: {
		        event: 'unfocus'
		    },
		    events: {
		    	visible: function(event, api) {
			    	$('#attraction-tags').slick({
						autoplay: false,
						slidesToShow: 1,
						slidesToScroll: 1,
						arrows: true,
						appendArrows: '#qtip-tags-arrows',
						prevArrow: '<a class="btn btn-sm slick-prev"><i class="fa fa-angle-double-left"></i></a>',
						nextArrow: '<a class="btn btn-sm slick-next"><i class="fa fa-angle-double-right"></i></a>',
			    	});
		    	}
	    	}
		});

    	// Events for sorting/filter modifications
    	$('.set-sort-criterium').click(function() {
    		$('.set-sort-criterium').removeClass('chosen-sort-criterium');
    		$(this).addClass('chosen-sort-criterium');
    		// Keep user in the current page when changing sorting criterium
    		getAttractions($('.pagination.bootpag li.active').data('lp'));
    	});

    	$('.set-distance-filter').click(function() {
    		setDistanceFilter($(this).data('distance'));
    	})

    	$('.add-tag-filter').click(function() {
    		var $tag = $(this);
    		addTagToFilter($tag.data('tag-id'), $tag.data('tag-name'));
    	});

    	$('#attractions-list-title').on('click', '.remove-distance-filter', function() {
    		setDistanceFilter(0);
    		$(this).parent().remove();
    		getAttractions();
    	});

    	$('#attractions-list-title').on('click', '.remove-tag-filter', function() {
    		$(this).parent().remove();
    		getAttractions();
    	});

    	// Event that is fired when user goes to another attractions page
		$('#attractions-list').on('page', function(event, page) {
	         getAttractions(page);
	    });

	});

	function getAttractions(page) {
		startLoading();

		// If page is not passed, set to 1
		page = typeof page !== 'undefined' ? page : 1;
		$('#attractions-list').bootpag({page: page});

		var attractionsPerPage = 10;

		requestParams = {
			attractionCategory: 'Attraction',
			start: attractionsPerPage * (page - 1),
			limit: attractionsPerPage
		};

		// Set params for sorting/filtering
		requestParams.sortCriterium = $('.chosen-sort-criterium').data('sort-criterium');

		var distance = $('#chosen-distance-filter').find('.attraction-distance-filter').data('distance');
		requestParams.distance = distance ? distance : 0;

		requestParams.tags = [];
		$('#chosen-tag-filters').find('.attraction-tag-filter').each(function() {
			requestParams.tags.push($(this).data('tag-id'));
		});

		$.get(wr+'attractions/getAttractions', requestParams, function(data) {
			var data = $.parseJSON(data);
			var attractions = data.attractions;

			fillTable($('#attractions-table'), attractions, attractionsPerPage);

	    	var bootpagProperties = {
	            maxVisible: 5,
	            leaps: false,
	            firstLastUse: true,
		        first: '<<',
		        prev: '<',
		        next: '>',
		        last: '>>'
		    };

    		var total = Math.ceil(data.total / attractionsPerPage);

    		// Show at least 1 page
    		bootpagProperties.total = Math.max(total, 1);
	    	$('#attractions-list').bootpag(bootpagProperties)
			endLoading();
		});
	}

	function fillTable($table, attractions, attractionsPerPage) {
		$table.empty();
		// TODO: Fill table in a smarter and cleaner way
		var rows = Math.ceil(attractionsPerPage / 2);
		var html = '';
		var rightSideIndex;
		for (var i = 0; i < rows; i++) {
			rightSideIndex = i + rows;
			if (i >= attractions.length) {
				// No attractions left. Abort loop
				break;
			}
			html += '<tr>';
			html += '<td>';
			html += createAttractionLeftDiv(attractions[i]);
			html += '</td>';
			html += '<td>';
			if (rightSideIndex < attractions.length) {
				html += createAttractionRightDiv(attractions[rightSideIndex]);
			}
			html += '</td>';
			html += '</tr>';
		}
		$table.html(html);
	}

	function createAttractionLeftDiv(attraction) {
		var div = '<div class="attraction-info-box attraction-attraction-info-box">';

		div += createButtonBox(attraction);
		div += createAttractionInfoBox(attraction);
		div += createDistanceBox(attraction);

		div += '</div>';
		return div;
	}

	function createAttractionRightDiv(attraction) {
		var div = '<div class="attraction-info-box attraction-attraction-info-box">';

		div += createDistanceBox(attraction);
		div += createAttractionInfoBox(attraction);
		div += createButtonBox(attraction);

		div += '</div>';
		return div;
	}

	function createButtonBox(attraction) {
		var attractionShow = wr+'attractions/show/'+attraction['Attraction']['id'];
		var div = '';

		div += '<a href="'+attractionShow+'" class="attraction-button attraction-attraction-button">';
		div += '<i class="fa fa-search"></i>';
		div += '</a>';

		return div;
	}

	function createAttractionInfoBox(attraction) {
		var tags = attraction['AttractionTag'];
		var div = '';

		div += '<div class="attraction-info">';
		div += '<div class="attraction-name">';
		div += attraction['Attraction']['name'];
		div += '</div>';
		div += '<div class="attraction-tags-box">';
		for (var i = 0; i < tags.length; i++) {
			div += '<span class="attraction-tag">' + tags[i]['Tag']['name_pt'] + '</span> ';
		}
		div += '</div>';
		div += '</div>';

		return div;
	}

	function createDistanceBox(attraction) {
		var div = '';
		var distance = parseInt(attraction['Attraction']['distance']);

		if (distance) {
			// Convert to km, one decimal place
			distance = (distance / 1000).toFixed(1).replace('.', ',');
		}

		div += '<div class="attraction-distance-box">';
		div += '<div class="attraction-distance-icon">';
		div += '<img src="'+wr+'img/icone-distancia.png" />';
		div += '</div>';
		div += '<div class="attraction-distance">';
		div += distance + 'km';
		div += '</div>';
		div += '</div>';

		return div;
	}

	function startLoading() {
		$('#loading-attractions').show();
		$('#attractions-table').hide();
	}

	function endLoading() {
		$('#loading-attractions').hide();
		$('#attractions-table').show();
	}

	function setDistanceFilter(distance) {
		var $chosenDistanceFilter = $('#chosen-distance-filter');
		$chosenDistanceFilter.empty();
		if (distance) {
			// Convert to km, no decimal places
			kmDistance = parseInt(distance / 1000);
			
			var span = '<span class="chosen-filter attraction-filter attraction-distance-filter" data-distance="'+distance+'">';
			span += '<i class="fa fa-map-marker"></i> Até '+kmDistance+'km';
			span += '<span class="remove-filter remove-attraction-filter remove-distance-filter"><i class="fa fa-times"></i></span>';
			span += '</span>';
			$chosenDistanceFilter.append(span);
		}
		getAttractions();
	}

	function addTagToFilter(id, name) {
		$chosenTagFilters = $('#chosen-tag-filters');
		// Add tag only if it isn't already in the filter
		if ($chosenTagFilters.find('.attraction-tag-filter[data-tag-id="'+id+'"]').length == 0) {
			var span = '<span class="chosen-filter attraction-filter attraction-tag-filter" data-tag-id="'+id+'">';
			span += '<i class="fa fa-tag"></i> ' + name;
			span += '<span class="remove-filter remove-attraction-filter remove-tag-filter"><i class="fa fa-times"></i></span>';
			span += '</span>';
			$chosenTagFilters.append(span);
			getAttractions();
		}
	}

</script>