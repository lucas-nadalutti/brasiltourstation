<h1 id="attractions-list-title">
	Pacotes <span id="chosen-distance-filter" ></span><span id="chosen-tag-filters"></span>
</h1>

<div class="col-md-12 filter-buttons-box">

	<div class="col-md-7">
		<div class="sorters-box">
			<h2 class="filter-buttons-box-title">Ordenação</h2>
			<?php
				echo '<div class="filter-button package-filter-button">';
				echo $this->Html->link(
					'<span>Alfabética<i class="fa fa-sort-alpha-asc"></i></span>',
					'javascript:void(0)',
					array('class' => 'sort-criterium-button set-sort-criterium chosen-sort-criterium', 'data-sort-criterium' => 'alphabetic', 'escape' => false)
				);
				echo '</div>';
				echo '<div class="filter-button package-filter-button">';
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
			<div class="filter-button package-filter-button">
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

				echo '<div id="qtip-tags-arrows" class="package-qtip-arrows"></div>';
				
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

<div id="package-reservation-form-box" hidden>
	<?php
		echo $this->Form->create('Package', array('id' => 'package-reservation-form'));
		echo $this->Form->input('Package.id', array('id' => 'reservation-form-package-id', 'type' => 'hidden'));
		echo $this->Form->input('PackageReservation.0.name');
		echo $this->Form->input('PackageReservation.0.email');
		echo $this->Form->input('PackageReservation.0.phone');
		echo $this->Form->submit('Reservar');
		echo $this->Form->end();
	?>
</div>

<script>
	
	$(document).ready(function() {

		// Retrieve attractions that will appear as soon as page loads
		getPackages();

		// Configure tag tooltip
		$('#open-attraction-tag-filter-tooltip').qtip({
			content: {
				text: $('#attraction-tag-filter-tooltip'),
				button: 'close'
			},
			style: {
				classes: 'package-qtip qtip-tags',
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
    		getPackages($('.pagination.bootpag li.active').data('lp'));
    	});

    	$('.add-tag-filter').click(function() {
    		var $tag = $(this);
    		addTagToFilter($tag.data('tag-id'), $tag.data('tag-name'));
    	});

    	$('#attractions-list-title').on('click', '.remove-tag-filter', function() {
    		$(this).parent().remove();
    		getPackages();
    	});

    	// Event that is fired when user goes to another attractions page
		$('#attractions-list').on('page', function(event, page) {
	         getPackages(page);
	    });

	});

	function getPackages(page) {
		startLoading();

		// If page is not passed, set to 1
		page = typeof page !== 'undefined' ? page : 1;
		$('#attractions-list').bootpag({page: page});

		var packagesPerPage = 10;

		requestParams = {
			start: packagesPerPage * (page - 1),
			limit: packagesPerPage
		};

		// Set params for sorting/filtering
		requestParams.sortCriterium = $('.chosen-sort-criterium').data('sort-criterium');

		requestParams.tags = [];
		$('#chosen-tag-filters').find('.attraction-tag-filter').each(function() {
			requestParams.tags.push($(this).data('tag-id'));
		});

		$.get(wr+'packages/getPackages', requestParams, function(data) {
			var data = $.parseJSON(data);
			var packages = data.packages;

			fillTable($('#attractions-table'), packages, packagesPerPage);

	    	var bootpagProperties = {
	            maxVisible: 5,
	            leaps: false,
	            firstLastUse: true,
		        first: '<<',
		        prev: '<',
		        next: '>',
		        last: '>>'
		    };

    		var total = Math.ceil(data.total / packagesPerPage);

    		// Show at least 1 page
    		bootpagProperties.total = Math.max(total, 1);
	    	$('#attractions-list').bootpag(bootpagProperties)
			endLoading();
		});
	}

	function fillTable($table, packages, packagesPerPage) {
		$table.empty();
		// TODO: Fill table in a smarter and cleaner way
		var rows = Math.ceil(packagesPerPage / 2);
		var html = '';
		var rightSideIndex;
		for (var i = 0; i < rows; i++) {
			rightSideIndex = i + rows;
			if (i >= packages.length) {
				// No packages left. Abort loop
				break;
			}
			html += '<tr>';
			html += '<td>';
			html += createPackageLeftDiv(packages[i]);
			html += '</td>';
			html += '<td>';
			if (rightSideIndex < packages.length) {
				html += createPackageRightDiv(packages[rightSideIndex]);
			}
			html += '</td>';
			html += '</tr>';
		}
		$table.html(html);

		// Add qtip to each reservation button
		$('.package-reservation').each(function() {
			$(this).qtip({
				content: {
					text: $('#package-reservation-form-box').clone(),
					button: 'close'
				},
				style: {
					classes: 'package-qtip',
					def: false
				},
			    position: {
			        my: 'top left',
			        at: 'top right',
			        adjust: {
			        	x: 5
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
			    	show: function(event, api) {
			    		var packageId = api.target.data('package-id');
			    		var $form = api.tooltip.find('#package-reservation-form');
			    		$form[0].reset();

			    		// Remove old messages, if any
			    		$form.find('.reservation-message').remove();

			    		$form.find('#reservation-form-package-id').val(packageId);

			    		// Form must be submitted via AJAX
			    		$form.submit(function() {
			    			$.post(
			    				wr+'packages/createReservation',
			    				$form.serialize(),
			    				function(message) {
			    					$form.append('<div class="reservation-message">'+message+'</div>');
			    				}
			    			)
			    			return false;
			    		});
			    	}
			    }
			});
		});
	}

	function createPackageLeftDiv(package) {
		var div = '<div class="attraction-info-box attraction-package-info-box">';

		div += createButtonBox(package);
		div += createPackageInfoBox(package);
		div += createReservationBox(package);

		div += '</div>';
		return div;
	}

	function createPackageRightDiv(package) {
		var div = '<div class="attraction-info-box attraction-package-info-box">';

		div += createReservationBox(package);
		div += createPackageInfoBox(package);
		div += createButtonBox(package);

		div += '</div>';
		return div;
	}

	function createButtonBox(package) {
		var packageShow = wr+'packages/show/'+package['Package']['id'];
		var div = '';

		div += '<a href="'+packageShow+'" class="attraction-button attraction-package-button">';
		div += '<i class="fa fa-search"></i>';
		div += '</a>';

		return div;
	}

	function createPackageInfoBox(package) {
		var tagNames = [];
		var attractionPackages = package['AttractionPackage'];
		var attractionTags;
		var tag;
		for (var i = 0; i < attractionPackages.length; i++) {
			attractionTags = attractionPackages[i]['Attraction']['AttractionTag'];
			for (var j = 0; j < attractionTags.length; j++) {
				tag = attractionTags[j]['Tag']['name_pt'];
				// Add tag only if it wasn't added before
				if (tagNames.indexOf(tag) == -1) {
					tagNames.push(tag);
				}
			}
		} 
		var div = '';

		div += '<div class="attraction-info">';
		div += '<div class="attraction-name">';
		div += package['Package']['name'];
		div += '</div>';
		div += '<div class="attraction-tags-box">';
		for (var i = 0; i < tagNames.length; i++) {
			div += '<span class="package-tag">' + tagNames[i] + '</span> ';
		}
		div += '</div>';
		div += '</div>';

		return div;
	}

	function createReservationBox(package) {
		var packageId = package['Package']['id'];
		var div = '';

		div += '<div class="package-reservation-box">';
		div += '<a href="javascript:void(0)" class="package-reservation" data-package-id="'+packageId+'">';
		div += '<i class="fa fa-calendar-plus-o"></i><br>Reservar';
		div += '</a>';
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

	function addTagToFilter(id, name) {
		$chosenTagFilters = $('#chosen-tag-filters');
		// Add tag only if it isn't already in the filter
		if ($chosenTagFilters.find('.attraction-tag-filter[data-tag-id="'+id+'"]').length == 0) {
			var span = '<span class="chosen-filter package-filter attraction-tag-filter" data-tag-id="'+id+'">';
			span += '<i class="fa fa-tag"></i> ' + name;
			span += '<span class="remove-filter remove-package-filter remove-tag-filter"><i class="fa fa-times"></i></span>';
			span += '</span>';
			$chosenTagFilters.append(span);
			getPackages();
		}
	}

</script>