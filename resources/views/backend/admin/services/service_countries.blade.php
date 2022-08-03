<form action="{{ url('/services/update-service-countries') }}" method="POST" id="add-edit-service-form">

    @csrf()

    <input type="hidden" id="hash_id" name="hash_id" value="{{ !empty($service_details->hash_id) ? $service_details->hash_id : '' }}" readonly="readonly" />

    <div class="row">
        <div class="col-md-12">

            <div class="form-group">

                <label class="font-weight-bold">
                    
                    <input type="checkbox" id="check_all" name="check_all" value="1" />
                    Check All

                </label>

            </div>

        </div>
    </div>

    <div class="row">
        <div class="col-md-12" style="max-height: 250px; overflow-y: scroll;">

            @if(!empty($countries))

                @php

                $service_country_ids = explode(',', $service_details['country_ids']);
                
                @endphp

                @foreach($countries as $country)

                    <div class="form-group">

                        <label>

                            <input type="checkbox" class="country-item" id="country_id_{{ $country->id }}" name="country_ids[]" {{ !empty($service_country_ids) && in_array($country->id, $service_country_ids) ? 'checked="checked"' : '' }} value="{{ $country->id }}" />

                            {{ $country->title }}

                        </label>

                    </div>

                @endforeach
            @endif

        </div>
    </div>
    
    <hr />

    <div class="row">
       <div class="col-md-6 offset-7">

            <button type="submit" class="btn btn-indigo">Submit</button>

            <button class="btn btn-light" data-dismiss="modal" type="button">Close</button>
        
        </div>
    </div>

</form>

<script type="text/javascript">
    
    $(document).ready(function(){

        $('#check_all').change(function(){

            var check_all = $(this).prop('checked');
            if(check_all == true){

                $('.country-item').prop('checked', true);

            } else {

                $('.country-item').prop('checked', false);

            } // if(check_all == true)

        }); // change => #check_all

    }); // ready

</script>