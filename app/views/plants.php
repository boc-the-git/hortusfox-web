<h1>{{ $location_name }}</h1>

<div class="margin-vertical">
	<div class="is-inline-block is-action-button-margin"><a class="button is-success" href="javascript:void(0);" onclick="document.getElementById('inpLocationId').value = {{ $location }}; window.vue.bShowAddPlant = true;">{{ __('app.add_plant') }}</a></div>
	<div class="is-inline-block is-action-button-margin"><a class="button is-info" href="javascript:void(0);" onclick="window.vue.updateLastWatered({{ $location }});">{{ __('app.set_watered') }}</a></div>
	<div class="is-inline-block is-action-button-margin"><a class="button is-dark" href="javascript:void(0);" onclick="window.vue.updateLastRepotted({{ $location }});">{{ __('app.set_repotted') }}</a></div>
	<div class="is-inline-block is-action-button-margin"><a class="is-default-link is-fixed-button-link" href="{{ url('/') }}">{{ __('app.back_to_dashboard') }}</a></div>
</div>

@include('flashmsg.php')

<div class="sorting">
	<div class="sorting-control select is-rounded is-small">
		<select onchange="location.href = '{{ url('/plants/location/' . $location . '?sorting=') }}' + this.value + '{{ ((isset($_GET['direction'])) ? '&direction=' . $_GET['direction'] : '') }}';">
			@foreach ($sorting_types as $sorting_type)
				@if (strpos($sorting_type, 'history') === false)
					<option value="{{ $sorting_type }}" {{ ((isset($_GET['sorting'])) && ($_GET['sorting'] === $sorting_type)) ? 'selected' : '' }}>{{ __('app.sorting_type_' . $sorting_type) }}</option>
				@endif
			@endforeach
		</select>
	</div>

	<div class="sorting-control select is-rounded is-small">
		<select onchange="location.href = '{{ url('/plants/location/' . $location . '?sorting=' . ((isset($_GET['sorting'])) ? $_GET['sorting'] : 'name')) }}&direction=' + this.value;">
			@foreach ($sorting_dirs as $sorting_dir)
				<option value="{{ $sorting_dir }}" {{ ((isset($_GET['direction'])) && ($_GET['direction'] === $sorting_dir)) ? 'selected' : '' }}>{{ __('app.sorting_dir_' . $sorting_dir) }}</option>
			@endforeach
		</select>
	</div>

	<div class="sorting-control is-rounded is-small">
		<input type="text" id="sorting-control-filter-text" placeholder="{{ __('app.filter_by_text') }}">
	</div>
</div>

<div class="plants">
	@if (count($plants) > 0)
		@foreach ($plants as $plant)
			<a href="{{ url('/plants/details/' . $plant->get('id')) }}">
				<div class="plant-card" style="background-image: url('{{ asset('img/' . $plant->get('photo')) }}');">
					<div class="plant-card-overlay">
						<div class="plant-card-health-state">
							@if ($plant->get('health_state') === 'overwatered')
								<i class="fas fa-water plant-state-overwatered"></i>
							@elseif ($plant->get('health_state') === 'withering')
								<i class="fab fa-pagelines plant-state-withering"></i>
							@elseif ($plant->get('health_state') === 'infected')
								<i class="fas fa-biohazard plant-state-infected"></i>
							@endif
						</div>

						<div class="plant-card-title {{ ((strlen($plant->get('name')) > PlantsModel::PLANT_LONG_TEXT_THRESHOLD) ? 'plant-card-title-longtext' : '') }}">
							{{ $plant->get('name') }}
						</div>
					</div>
				</div>
			</a>
		@endforeach
	@else
		<div class="plants-empty">
			<div class="plants-empty-image">
				<img src="{{ asset('img/plantsempty.png') }}" alt="image"/>
			</div>

			<div class="plants-empty-text">{{ __('app.content_empty') }}</div>
		</div>
	@endif
</div>
