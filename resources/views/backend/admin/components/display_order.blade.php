<select class="form-control change-display-order" mc-crud-name="{!! !empty($resource) ? $resource : '' !!}" mc-item-id="{{ $item_details->id }}">

    @for ($i = 1; $i <= 50; $i++) 
		<option value="{{ $i }}" {{ ( $item_details->display_order == $i) ? 'selected' : '' }}>
		{{ $i }}
        </option>
    @endfor

</select>