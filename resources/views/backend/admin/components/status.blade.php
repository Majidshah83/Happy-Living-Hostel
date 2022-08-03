<select class="form-control change-status {{ (  $item_details->status == '1') ? '' : 'bg-danger text-white' }}"
	name="status" mc-crud-name="{!! !empty($resource) ? $resource : '' !!}" mc-item-id="{{ $item_details->id }}">

	<option value="1" {{ (  $item_details->status == '1') ? 'selected' : '' }}>
		Active </option>
	<option value="0" {{ (  $item_details->status == '0') ? 'selected' : '' }}>
		InActive </option>

</select>