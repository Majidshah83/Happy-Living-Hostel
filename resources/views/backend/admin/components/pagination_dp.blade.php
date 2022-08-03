<div class="col-md-2 text-left">
    <select class="form-control bg-white cdt_per_page" id="cdt_per_page" mc-parent-id="mc-cdt">
        <option {{ !empty($post_arr) && $post_arr['cdt_per_page'] == '10' ? 'selected="selected"' : '' }} value="10"> Show 10 Records </option>
        <option {{ !empty($post_arr) && $post_arr['cdt_per_page'] == '50' ? 'selected="selected"' : '' }} value="50"> Show 50 Records </option>
        <option {{ !empty($post_arr) && $post_arr['cdt_per_page'] == '100' ? 'selected="selected"' : '' }} value="100"> Show 100 Records </option>
    </select>
</div>
