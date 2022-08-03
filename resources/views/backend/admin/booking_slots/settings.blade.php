
  <form method="POST" id="add-settings-process-form">

    @csrf()

    <div class="row mt-3">
      <div class="col-md-12">

        <div class="form-group">

            <label class="custom-switch">

                <span class="mr-2"> Off </span>

                <input type="checkbox" id="calendar_is_off" name="calendar_is_off" class="custom-switch-input" value="N" {{ empty($settings) || (!empty($settings->calendar_is_off) && $settings->calendar_is_off == 'N') ? 'checked' : '' }} />

                <span class="custom-switch-indicator">

                </span>

                <span class="ml-2"> On </span>

            </label>

        </div>

      </div>
    </div>

    <div class="row mt-3">
      <div class="col-md-12">

        <label> Booking Start Date </label>

        <div class="input-group">

          <div class="input-group-prepend">
            <div class="input-group-text">

              <svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" height="18" viewBox="0 0 24 24" width="18">

                <path d="M0 0h24v24H0V0z" fill="none"/><path d="M20 3h-1V1h-2v2H7V1H5v2H4c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 2v3H4V5h16zM4 21V10h16v11H4z"/><path d="M4 5.01h16V8H4z" opacity=".3"/></svg>

            </div>
          </div>
            <input type="text" id="booking_start_date" name="booking_start_date" data-toggle="datepicker" class="form-control mc-single-datepicker" value="{{ !empty($settings->booking_start_date) ? date('d/m/Y', strtotime($settings->booking_start_date)) : '' }}" autocomplete="off" />

        </div>

      </div>
    </div>

    <div class="row mt-3">
      <div class="col-md-12">

        <label> Switch off particular days </label>

        <div class="input-group">

          <div class="input-group-prepend">
            <div class="input-group-text">

              <svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" height="18" viewBox="0 0 24 24" width="18">

                <path d="M0 0h24v24H0V0z" fill="none"/><path d="M20 3h-1V1h-2v2H7V1H5v2H4c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 2v3H4V5h16zM4 21V10h16v11H4z"/><path d="M4 5.01h16V8H4z" opacity=".3"/></svg>

            </div>
          </div><input class="form-control mc-multi-datepicker" placeholder="" type="text" id="off_dates" name="off_dates" value="{{ !empty($comma_saperated_off_dates) ? $comma_saperated_off_dates : '' }}" autocomplete="off" />
        </div>

      </div>
    </div>

    <div class="row mt-3">
      <div class="col-md-12">

        <label> Switch on particular days </label>

        <div class="input-group">

          <div class="input-group-prepend">
            <div class="input-group-text">

              <svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" height="18" viewBox="0 0 24 24" width="18">

                <path d="M0 0h24v24H0V0z" fill="none"/><path d="M20 3h-1V1h-2v2H7V1H5v2H4c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 2v3H4V5h16zM4 21V10h16v11H4z"/><path d="M4 5.01h16V8H4z" opacity=".3"/></svg>

            </div>
          </div><input class="form-control mc-multi-datepicker" placeholder="" type="text" id="on_dates" name="on_dates" value="{{ !empty($comma_saperated_on_dates) ? $comma_saperated_on_dates : '' }}" autocomplete="off" />
        </div>

      </div>
    </div>

    <hr class="mb-4" />

    <div class="row">
      <div class="col-md-12 text-right">
        <button class="btn btn-indigo" type="button" id="add-settings-process-btn">Submit</button>
        <button class="btn btn-light" data-dismiss="modal" type="button">Close</button>
      </div>
    </div>

  </form>

    <script>
    $(document).ready(function() {

        $('.mc-single-datepicker').datepicker({
            
            format: 'dd/mm/yyyy',
            // startDate: new Date(),
            autoclose: true,
            // multidate: true

        }).on('changeDate', function(e) {
            

        });

        $('.mc-multi-datepicker').datepicker({
            
            format: 'dd/mm/yyyy',
            // startDate: new Date(),
            autoclose: true,
            multidate: true

        }).on('changeDate', function(e) {
            

        });

    }); // ready

    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#add-settings-process-btn').click(function () {

                var hash_id = "";

                // var request_type = (hash_id != '') ? 'POST' : 'POST';

                var request_data = new FormData(document.getElementById("add-settings-process-form"));

                $.ajax({

                    type: 'POST',

                    url: "{{ url('/booking_slots/settings_process') }}",

                    processData: false,

                    contentType: false,

                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },

                    data: request_data,

                    beforeSend: function (result) {

                        $("#loader").show();
                        $("#add-settings-process-btn").attr("disabled", true);
                        $('#add-settings-process-btn').html('Loading..');

                        $('#crud_errors_div').addClass('d-none');
                        $('#crud_errors_ul').html('');

                    },
                    success: function (response) {

                        $("#add-settings-process-btn").attr("disabled", false);
                        $('#add-settings-process-btn').html('Submit');
                        $("#loading").css("display", "none");
                        // swal(response);
                        // location.reload();
                        // $('#loader').delay(2000).hide(100);
                        $('#loader').hide();

                        location.reload();


                    },

                    error: function (xhr, status, error) {
                        $('#loader').delay(2000).hide(100);
                        $("#add-settings-process-btn").attr("disabled", false);
                        $('#add-settings-process-btn').html('Submit');
                        mcShowErrorsPost(xhr, status, error);
                    }

                    // success

                }); // $.ajax

            });
        });
        $(function() {
            $('[data-toggle="datepicker"]').datepicker({
                autoHide: true,
                zIndex: 99999999,
            });
            $('[data-toggle="datepicker"]').css('z-index','99999999');
        });
    </script>

