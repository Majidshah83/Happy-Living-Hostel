<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw==" crossorigin="anonymous" />

<style type="text/css">
    
    .datepicker {
        
        border: 1px solid #ddd;
        
        padding: 8px;

        z-index: 1100 !important; 

    }

</style>

<form class="custom-validation" id="mc-form">

    <div class="row d-none" id="crud_errors_div">

        <div class="col-md-12">

            <div class="alert alert-danger">

                <!-- Contain Dynamic Errors -->
                <ul class="mb-0 d-none" id="crud_errors_ul">
                </ul>

                <!-- Contain Input File Errors -->
                <ul class="mb-0 d-none" id="file_error_ul"></ul>

            </div>

        </div>

    </div>

    <div class="row">
        
        <div class="col-lg-12 mb-3">
            
            <label> Switch off particular days </label>

            <div class="input-group">

                <input type="text" class="form-control mc-multi-datepicker" id="off_dates" name="off_dates" value="{{ $service_booking_slots_off_dates_str }}" readonly="readonly" />

                <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>

            </div>

        </div> 

    </div>

    <div class="row">
        <div class="col-lg-12">

            <div class="form-group mb-0">
                
                <div>
                    
                    <input type="hidden" name="pharmacy_id" value="{{ session()->get('pharmacy_id') }}" readonly="readonly" />

                    <button type="button" class="btn btn-primary waves-effect waves-light mr-1" id="mc_frm_submit_btn">
                        Submit
                    </button>

                    <button data-dismiss="modal" class="btn btn-danger waves-effect waves-light mr-1">
                        Cancel
                    </button>

                </div>

            </div>

        </div>
    </div>

</form>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous"></script>

<script>
$(document).ready(function() {

    $('.mc-multi-datepicker').datepicker({
        
        format: 'dd/mm/yyyy',
        // startDate: new Date(),
        autoclose: true,
        multidate: true

    }).on('changeDate', function(e) {
        

    });

    $("#mc_frm_submit_btn").click(function(event) {

        event.preventDefault();

        var data = new FormData(document.getElementById("mc-form"));
        
        $.ajax({

            type: "POST",
            url: "/bookings/switch_off_dates_process",
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },

            data: data,
            beforeSend: function(result) {

                $("#loading").css("display","block");
                $('#crud_errors_div').addClass('d-none');
                $('#crud_errors_ul').html('');

            },
            success: function(response) {


                $("#loading").css("display","none");
                
                if (response.status == 'success') {
                    mc_notify('success', response.message);
                    $("#general_bootstrap_ajax_popup").modal('hide');
                      location.reload();

                }

                $('#crud_errors_div').addClass('d-none');
                $('#crud_errors_ul').html('');

                // console.log(response);
            },
            error: function(xhr, status, error) {

                $("#loading").css("display","none");

                $.each(xhr.responseJSON.errors, function(key, item) {

                    // mc_notify('danger', item);
                    
                    $('#crud_errors_div').removeClass('d-none');
                    $('#crud_errors_ul').removeClass('d-none');

                    var new_html = '<li> ' + item + ' </li>';
                    $('#crud_errors_ul').append(new_html);

                });
            }

        }); // $.ajax

    });

});
</script>