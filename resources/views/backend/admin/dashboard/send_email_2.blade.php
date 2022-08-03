<form method="POST" id="send-email-2-form">
    
    @csrf()

    <input type="hidden" id="main_order_hash_id" name="main_order_hash_id" value="{{ !empty($order_details['order_hash_id']) ? $order_details['order_hash_id'] : '' }}" readonly="readonly" />

    @if($order_details['email2_sent_status'] == '1')

        <p>
            
            Email already sent on {{ date('d/m/Y H:i', strtotime($order_details['email2_sent_datetime'])) }}

        </p>

    @endif
    
    <div class="row mb-3">
        <div class="col-md-12">

            @php

            $selected_email_template_id = '';

            if($order_details['service_id'] == '66'){

                $selected_email_template_id = '2';

            } else if($order_details['service_id'] == '67'){

                $selected_email_template_id = '3';

            }

            @endphp

            <label> Select Email Template </label>

            <select class="form-control" id="email_template_id" name="email_template_id">
                
                <option value=""> Select </option>

                @if(!empty($email_templates_list))
                    @foreach($email_templates_list as $email_template)

                        <option {{ !empty($selected_email_template_id) && $selected_email_template_id == $email_template->id ? 'selected="selected"' : '' }} value="{{ $email_template->id }}"> {{ $email_template->email_title }} </option>

                    @endforeach
                @endif

            </select>

        </div>
    </div>

    <!-- COntains AJAX response for email-template-fields -->
    <div class="row d-none" id="email-template-fields"></div>

    <hr />

    <div class="row">
       <div class="col-md-12 text-right">
            <button class="btn btn-indigo" type="button" id="send-email-2-btn">Send Email</button>
            <button class="btn btn-light" data-dismiss="modal" type="button">Close</button>
        </div>
    </div>

</form>

<script type="text/javascript">

    $(document).ready(function(){

        $('#email_template_id').change(function(){

            var main_order_hash_id = $('#main_order_hash_id').val();

            var email_template_id = $(this).val();

            if(email_template_id == ''){

                $('#email-template-fields').addClass('d-none');
                $('#email-template-fields').html('');

                return false;

            } // if(email_template_id == '')

            $.ajax({

                type: "POST",
                url: '{{ url("orders/send-email-2/get-email-template-fields") }}',

                // processData: false,
                // contentType: false,

                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },

                data: {

                    'main_order_hash_id' : main_order_hash_id,
                    'email_template_id' : email_template_id,

                },

                beforeSend: function(result) {

                    $('#email-template-fields').addClass('d-none');
                    $('#email-template-fields').html('');

                },
                success: function(response) {

                    $('#email-template-fields').html(response);
                    $('#email-template-fields').removeClass('d-none');

                } // success

            }); // $.ajax

        }); // change => email_template_id

        $('#email_template_id').trigger('change');

        // Save
        $('#send-email-2-btn').click(function(){

            var request_data = new FormData(document.getElementById("send-email-2-form"));

            $.ajax({

                type: 'POST',

                url: '{{ url("orders/send-email-2-process") }}',

                processData: false,

                contentType: false,

                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },

                data: request_data,

                beforeSend: function(result) {
                    $("#loader").show();
                    $("#send-email-2").attr("disabled", true);
                    $('#send-email-2').html('Loading..');
                    // $("#loading").css("display","block");

                    $('#crud_errors_div').addClass('d-none');
                    $('#crud_errors_ul').html('');

                },
                success: function(response) {
                    $("#send-email-2").attr("disabled", false);
                    $('#send-email-2').html('Submit');
                    $("#loading").css("display","none");

                    // swal(response);
                    location.reload();
                    $('#loader').delay(2000).hide(100);

                },

                error: function(xhr, status, error) {
                    $('#loader').delay(2000).hide(100);
                    $("#send-email-2").attr("disabled", false);
                    $('#send-email-2').html('Submit');
                    // console.log( xhr.responseJSON.error_msg );

                    mcShowErrorsPost(xhr, status, error)
                }

                // success

            }); // $.ajax

        }); // click => #add-edit-banner-btn

        $('#email_body').summernote({
            height: 100,
        });

    }); // .ready

</script>
