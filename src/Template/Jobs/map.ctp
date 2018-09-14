 <script>
	var jobs = <?= json_encode($jobs->toArray()); ?>;
	var leaders = <?= json_encode( $leaders->toArray() ) ?>;
	var current_user_role = <?= json_encode( $AuthUser['role'] ) ?>;
	var map;
	var geocoder;

	let colors = [
		'blue',
		'brown',
		'darkgreen',
		'green',
		'orange',
		'paleblue',
		'pink',
		'purple',
		'red',
		'yellow'
	];
	let letters = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
	let indexedColors = [];

	for( let letter of letters) {
		for( let color of colors ) {
			indexedColors.push(`${color}_Marker${letter}.png`);
		}
	}

	console.log({indexedColors});

	let getIconByUserId = function(user_id) {
		if( user_id > 0)
			return `/img/markers/${ indexedColors[ user_id % indexedColors.length ]}`
		else
			return '/img/markers/red_Marker.png';
	}

	function Tag(label, atts, children, context) {

		return $( document.createElement(label) )
			.attr( atts )
			.append(children)
			.data('context', Object.assign({}, context) )
			;
	}

	function Strong(text, context) {
		return Tag('strong', {}, [ document.createTextNode(text) ], context);
	}

	function Text(text) {
		return document.createTextNode(text)
	}

	function H4(text, context) {
		return Tag('h4', {}, [ Text(text) ], context);
	}

	function P(text, context) {
		return Tag('p', {}, [ Text(text) ], context);
	}

	function A(text, href, attrs, context) {
		return Tag('a', Object.assign({ href: href }, attrs), [ Text(text) ], context);
	}

	function Component(name, attrs, children, context) {
		return Tag('div', Object.assign({}, attrs), children, context)
			.addClass('component')
			.data('component-name', name)
	}

	function Br() {
		return Tag('br', {}, [], null);
	}


	function Option(value, label, selected) {
		return Tag('option', {
			value: value,
			selected: selected,
		}, [
			Text(label)
		]);
	}

	function Throbber() {
		return Tag('p', {'class': 'component__throbber'}, [
			Tag('span', {}, ['&nbsp;']),
			Tag('span', {'class': 'is-saving'}, [ Text('saving...') ]),
			Tag('span', {'class': 'is-saved'}, [Text('saved!') ]),
			Tag('span', {'class': 'is-error'}, [Text['error!']])
		])
	}

	let nullableLeaders = Object.assign({
		"-1": "(unassigned)"
	}, leaders);

	console.log(leaders);

	$('body').on('change', '.component > .job__site-leader-id', function(e) {
		console.log("saving site leader");

		let $control = $(this);
		let $component = $control
			.parent('.component');

		$component
			.removeClass('component--saved')
			.addClass('component--saving');

		$.ajax({
			type: 'POST',
			url: "/" + ['jobs', 'leader', $control.data('job-id'), $control.val()].join('/'),
			data: {},
			success: function(){
				console.info('site leader successfully updated', arguments);
				$component
					.addClass('component--saved')
					.removeClass("component--saving")
			},
			dataType: 'json'
		});
	}).on('change', '.component > .todo__user-id', function(e) {
		console.log("saving todo owner");

		let $control = $(this);
		let $component = $control
			.parent('.component');

		$component
			.removeClass('component--saved')
			.addClass('component--saving');

		$.ajax({
			type: 'POST',
			url: "/" + ['jobs', 'todo', $control.data('job-id'), $control.val()].join('/'),
			data: {},
			success: function(){
				console.info('todos successfully updated', arguments);

				$jobInfoWindow = $component.parent();

				marker = $jobInfoWindow.data('context').marker;

				marker.setIcon( getIconByUserId( $control.val() ) );

				console.log('job info', $jobInfoWindow.data() );

				$component
					.addClass('component--saved')
					.removeClass("component--saving")

			},
			dataType: 'json'
		});
	});

	function initJobMap() {
		geocoder = new google.maps.Geocoder();
        map = new google.maps.Map(document.getElementById('jobMap'), {
          center: {lat: 41.3, lng: -105.6},
          zoom: 13

        });
        let legend = $( document.getElementById('jobMapLegend') );

        Object
        	.keys(nullableLeaders)
        	.forEach( user_id => {
        		let fullname = nullableLeaders[user_id]
        		legend.append( Tag("div", {}, [
        			Tag('img', {
        				src: getIconByUserId(user_id),
        				alt: `Icon for ${fullname}`
        			}, []),
        			" ",
        			Text(fullname)
        		]))
        	});

		let markers = [];

		let jobPromises = jobs.reduce( function(result, job){
			return result.then(function(success){
				return getLatLng(job).then(function(jobTuple) {

					let Job = jobTuple[0];

					let siteLeaderDropdown = Tag('select', { 
						'data-job-id': Job.job_id
					}, 
						$.map(nullableLeaders, function(user_full_name, leader_id){
							return Option(
								leader_id, 
								user_full_name, 
								leader_id === Job.site_leader_id.toString()
							)
						})
					)
					.data('job_id', Job.job_id)
					.addClass('job__site-leader-id');

					let currentTodoOwner = Job.todos.every( (todo, idx, arr) => todo.user_id === arr[0].user_id)
						? Job.todos[0].user_id
						: -1;

					let todoUserDropdown = Tag('select', {
						'data-job-id': Job.job_id
					 }, 
						$.map(nullableLeaders, function(user_full_name, user_id){
							return Option(
								user_id, 
								user_full_name, 
								user_id === currentTodoOwner.toString()
							)
						})
					)
					.addClass('todo__user-id');

					let marker = new google.maps.Marker({
						position: jobTuple[1],
						map: map,
						title: 'Job ' + Job.job_id,
						icon: getIconByUserId(currentTodoOwner)
					});

					let Content = Component('JobWindow', {
						"data-job-id": Job.job_id
					}, [
						H4(`Job ${Job.job_id}`),
						Tag("p", {}, [
							Strong(Job.contact_first_name + " " + Job.contact_last_name),
							Br(),
							Text(Job.contact_address_1),
							Br(),
							...(
								Job.contact_address_2 === "" 
									? [] 
									: [ Text(Job.contact_address_2), Br() ]
							),
							Text(Job.contact_city + ', ' + Job.contact_state + ' ' + Job.contact_zip)
						]),
						P(Job.contact_phone),
						Tag("p", {}, [
							A('Go to Job', '/' +['jobs', 'edit', Job.job_id].join('/'), {
								'class': 'tiny button-uwyo-gold button',
								'target': "_blank"
							} )
						]),
						H4('Site Leader'),
						Component( 'SiteLeaderDropDown', {}, [
							siteLeaderDropdown,
							Throbber()
						]),
						H4('Assign All Todos'),
						Component( 'TodoUserDropDown', {}, [
							todoUserDropdown,
							Throbber()
						])
					], {job: Job, marker: marker});
						
					// Content is a jQuery object.
					// Content.get(0) is a DOM element
					let infowindow = new google.maps.InfoWindow({
						content: Content.get(0)
					});

					marker.addListener('click', function(event){
						infowindow.open(map, marker);
					});

					markers.push(marker);

					return $.when(jobTuple);
				})
			});
		} , $.when());


      }

	  function saveLatLng(ll, job) {
		  return $.ajax({
			  url: "/" + ['jobs', 'meta', job.job_id].join('/'),
			  data: JSON.stringify([
				  {
					'meta_key': 'latitude',
					'meta_value': ll.lat()
				  },
				  {
					  'meta_key': 'longitude',
					  'meta_value': ll.lng()
				  }				
			  ]),
			  contentType: 'application/json',
			  dataType: 'json',
			  type: 'POST'
		  }).then(function(success){
			  return $.when(ll);
		  }, function(error){});
	  }

	  function getLatLng(job) {
		  return $
		  	.when()
			.then(function(success) {

				let lats = job.meta.filter(function(m){ return m.meta_key === 'latitude' });
				let lngs = job.meta.filter(function(m){ return m.meta_key === 'longitude' });

				if( lats.length === 1 && lngs.length === 1) {
					return $.when( [ job, new google.maps.LatLng(
							parseFloat( lats[0].meta_value ), 
							parseFloat( lngs[0].meta_value )
						)]
					);
				} else {
					return [job, codeAddress(job)];
				}
		  });
	  }

function codeAddress(job) {
	let deferred = $.Deferred();
	var address = job.contact_address_1  + "; " + job.contact_city + ", " + job.contact_state + " " + job.contact_zip;

	geocoder.geocode({
		'address': address
	}, function(results, status) {
		deferred.notify({
			evt: 'geocodeComplete',
			status: status,
			address: address,
			results: results
		});

		if (status === google.maps.GeocoderStatus.OK) {
			saveLatLng(results[0].geometry.location, job).then(function(success) {
				deferred.resolve( results[0].geometry.location );
			});
		} else {
			deferred.reject({
				job: job,
				address: address,
				results: results
			})
		}
	})

	return deferred.promise();


  }
</script>

<?php $googleMapsSrcUrl = $this->Url->build([
	'https://maps.googleapis.com/maps/api/js',
	'?' => [
		'key' => Configure::read('Google.Maps.api_key'),
		'callback' => 'initJobMap'
	]
]); ?>

<script src="<?= $googleMapsSrcUrl ?>" async defer></script>

<style type="text/css">
	.job {
		position: relative;
	}
	.job .legend {
		position: absolute;
		padding: 20px;
		top: 20px;
		right: 20px;
		z-index: 5000;
		background: rgba(255,255,255,0.65);
	}
	.job .map {
		position: absolute;
		width: 100%;
		height: 100%;
	}
</style>

<div class="job">
	<div id="jobMapLegend" class="legend"></div>
	<div class="map" id="jobMap" style="width: 100%; height: 950px;"></div>
</div>