
<style type="text/css">
    .mc-cdt-links-div nav{
        float: right;
    }
</style>

<div class="row">

    <div class="col-md-2 col-sm-12">

        <div class="form-group">

            <label> Per Page </label>
            <select class="form-control cdt_per_page" id="cdt_per_page" mc-parent-id="mc-cdt">
                <!-- <option {{ !empty($post_arr) && $post_arr['cdt_per_page'] == '10' ? 'selected="selected"' : '' }} value="10"> 10 </option> -->
                <option {{ !empty($post_arr) && $post_arr['cdt_per_page'] == '50' ? 'selected="selected"' : '' }} value="50"> 50 </option>
                <option {{ !empty($post_arr) && $post_arr['cdt_per_page'] == '100' ? 'selected="selected"' : '' }} value="100"> 100 </option>
                <option {{ !empty($post_arr) && $post_arr['cdt_per_page'] == '150' ? 'selected="selected"' : '' }} value="150"> 150 </option>
            </select>

        </div>

    </div>

    <div class="col-md-8 col-sm-12"></div>

    <div class="col-md-2 col-sm-12">

        <div class="form-group">

            <label> Search </label>
            <input type="text" class="form-control cdt_search" id="cdt_search" value="{{ !empty($post_arr['cdt_search']) ? $post_arr['cdt_search'] : '' }}" mc-parent-id="mc-cdt" />

        </div>

    </div>

</div>

<div class="row">
    <div class="col-sm-12 col-md-12">

        <div class="table-responsive">

            <table id="onsite-datetable" class="table table-striped table-bordered text-nowrap" style="width:100%">
                <thead>
                    <tr class="bold">
                        <th class="border-bottom-0">ID</th>
                        <th class="border-bottom-0">First Name</th>
                        <th class="border-bottom-0">Last Name</th>
                        <th class="border-bottom-0">Email</th>
                        <th class="border-bottom-0">Phone</th>
                        <th class="border-bottom-0">Test Required</th>
                        <th class="border-bottom-0">Arrival Date</th>
                        <th class="border-bottom-0" width="13%">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($list_all as $data)
                        <tr>
                            <td class="">
                                {{$data->id}}
                            </td>
                            <td class="">
                                {{$data->first_name}}
                            </td>
                            <td class="">
                                {{$data->last_name}}
                            </td>
                            <td>
                                {{$data->email}}
                            </td>
                            <td>
                                {{$data->phone}}
                            </td>
                            <td>
                                {{$data->test_required}}
                            </td>
                            <td>
                                {{$data->arrival_date}}
                            </td>
                            <td>
                                @if($data->status === 'P')
                                    Pending
                                @elseif($data->status === 'D')
                                    Declined
                                @elseif($data->status === 'C')
                                    Completed
                                @endif
                            </td>


                        </tr>
                    @endforeach()
                </tbody>
            </table>

        </div>

    </div>
</div>

<div class="row">
    <div class="col-sm-12 col-md-5">

        Showing {{ $list_all->firstItem() }} - {{ $list_all->lastItem() }} of {{ $list_all->total() }} entries

        <input type="hidden" id="cdt_pagination_page_no" value="{{ !empty($post_arr) ? $post_arr['page'] : '1' }}" readonly="readonly" />


    </div>
    <div class="col-sm-12 col-md-7 mc-cdt-links-div" mc-parent-id="mc-cdt">

        {{ $list_all->links() }}

    </div>
</div>

<script type="text/javascript">
$(document).ready(function() {



}); // click => add-edit-website-design-trigger
</script>
