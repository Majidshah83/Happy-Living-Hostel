<select class="form-control change-status mt-3"
	name="status" mc-crud-name="{!! !empty($resource) ? $resource : '' !!}" mc-item-id="{{ $item_details->order_plain_id }}">

    <option value="P" {{ (  $item_details->order_status == 'P') ? 'selected' : '' }}>
        Pending </option>
    <option value="D" {{ (  $item_details->order_status == 'D') ? 'selected' : '' }}>
        Declined </option>
    <option value="R" {{ (  $item_details->order_status == 'R') ? 'selected' : '' }}>
        Refunded </option>
    <option value="O" {{ (  $item_details->order_status == 'O') ? 'selected' : '' }}>
        On-hold </option>
    <option value="C" {{ (  $item_details->order_status == 'C') ? 'selected' : '' }}>
        Completed </option>
    <option value="K" {{ (  $item_details->order_status == 'K') ? 'selected' : '' }}>
        Kit Assigned </option>

</select>
