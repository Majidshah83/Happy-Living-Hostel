<form method="POST" id="add-edit-patient-form">

    @csrf()

    @if(!empty($patient_details))
        <input type="hidden" name="_method" value="PUT">
    @endif

    <input type="hidden" id="hash_id" value="{{ !empty($patient_details->hash_id) ? $patient_details->hash_id : '' }}" />

    <div class="row">

        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label">First Name <span class="text-red">*</span></label>
                <input type="text" id="first_name" class="form-control" name="first_name" value="{{ !empty($patient_details->first_name) ? $patient_details->first_name : '' }}" required>
                <span class="text-danger error-text first_name_err"></span>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label">Last Name <span class="text-red">*</span></label>
                <input type="text" id="last_name" class="form-control" name="last_name" value="{{ !empty($patient_details->last_name) ? $patient_details->last_name : '' }}" required>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label">Gender <span class="text-red">*</span></label>
                <select id="gender" name="gender" class="form-control" required>
                    <option value="">--Select--</option>
                    <option value="Male" {{ empty($patient_details) || (!empty($patient_details) && $patient_details->gender == 'Male') ? 'selected="selected"' : '' }}>Male</option>
                    <option value="Female" {{ empty($patient_details) || (!empty($patient_details) && $patient_details->gender == 'Female') ? 'selected="selected"' : '' }}>Female</option>
                     <option value="Other" {{ empty($patient_details) || (!empty($patient_details) && $patient_details->gender == 'Other') ? 'selected="selected"' : '' }}>Other</option>
                </select>
                <span class="text-danger error-text gender_err"></span>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label">Date of Birth  <span class="text-red">*</span></label>
                <div class="row ">
                    <div class="col-4">
                        <input type="hidden" id="date_b" value="{{ !empty($patient_details->dob) ? $patient_details->dob : '' }}">
                        <select id="day" name="day" class="form-control">
                            <option value="01" selected>01</option>
                            <option value="02">02</option>
                            <option value="03">03</option>
                            <option value="04">04</option>
                            <option value="05">05</option>
                            <option value="06">06</option>
                            <option value="07">07</option>
                            <option value="08">08</option>
                            <option value="09">09</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                            <option value="13">13</option>
                            <option value="14">14</option>
                            <option value="15">15</option>
                            <option value="16">16</option>
                            <option value="17">17</option>
                            <option value="18">18</option>
                            <option value="19">19</option>
                            <option value="20">20</option>
                            <option value="21">21</option>
                            <option value="22">22</option>
                            <option value="23">23</option>
                            <option value="24">24</option>
                            <option value="25">25</option>
                            <option value="26">26</option>
                            <option value="27">27</option>
                            <option value="28">28</option>
                            <option value="29">29</option>
                            <option value="30">30</option>
                            <option value="31">31</option>
                        </select>
                    </div>
                    <div class="col-4">
                        <select id="month" name="month" class="form-control" >
                            <option value="01" selected>January</option>
                            <option value="02">February</option>
                            <option value="03">March</option>
                            <option value="04">April</option>
                            <option value="05">May</option>
                            <option value="06">June</option>
                            <option value="07">July</option>
                            <option value="08">August</option>
                            <option value="09">September</option>
                            <option value="10">October</option>
                            <option value="11">November</option>
                            <option value="12">December</option>
                        </select>
                    </div>
                    <div class="col-4">
                        <select id="year" name="year" class="form-control">
                            <option value="1920">1920</option>
                            <option value="1921">1921</option>
                            <option value="1922">1922</option>
                            <option value="1923">1923</option>
                            <option value="1924">1924</option>
                            <option value="1925">1925</option>
                            <option value="1926">1926</option>
                            <option value="1927">1927</option>
                            <option value="1928">1928</option>
                            <option value="1929">1929</option>
                            <option value="1930">1930</option>
                            <option value="1931">1931</option>
                            <option value="1932">1932</option>
                            <option value="1933">1933</option>
                            <option value="1934">1934</option>
                            <option value="1935">1935</option>
                            <option value="1936">1936</option>
                            <option value="1937">1937</option>
                            <option value="1938">1938</option>
                            <option value="1939">1939</option>
                            <option value="1940">1940</option>
                            <option value="1941">1941</option>
                            <option value="1942">1942</option>
                            <option value="1943">1943</option>
                            <option value="1944">1944</option>
                            <option value="1945">1945</option>
                            <option value="1946">1946</option>
                            <option value="1947">1947</option>
                            <option value="1948">1948</option>
                            <option value="1949">1949</option>
                            <option value="1950">1950</option>
                            <option value="1951">1951</option>
                            <option value="1952">1952</option>
                            <option value="1953">1953</option>
                            <option value="1954">1954</option>
                            <option value="1955">1955</option>
                            <option value="1956">1956</option>
                            <option value="1957">1957</option>
                            <option value="1958">1958</option>
                            <option value="1959">1959</option>
                            <option value="1960">1960</option>
                            <option value="1961">1961</option>
                            <option value="1962">1962</option>
                            <option value="1963">1963</option>
                            <option value="1964">1964</option>
                            <option value="1965">1965</option>
                            <option value="1966">1966</option>
                            <option value="1967">1967</option>
                            <option value="1968">1968</option>
                            <option value="1969">1969</option>
                            <option value="1970">1970</option>
                            <option value="1971">1971</option>
                            <option value="1972">1972</option>
                            <option value="1973">1973</option>
                            <option value="1974">1974</option>
                            <option value="1975">1975</option>
                            <option value="1976">1976</option>
                            <option value="1977">1977</option>
                            <option value="1978">1978</option>
                            <option value="1979">1979</option>
                            <option value="1980">1980</option>
                            <option value="1981">1981</option>
                            <option value="1982">1982</option>
                            <option value="1983">1983</option>
                            <option value="1984">1984</option>
                            <option value="1985">1985</option>
                            <option value="1986">1986</option>
                            <option value="1987">1987</option>
                            <option value="1988">1988</option>
                            <option value="1989">1989</option>
                            <option value="1990">1990</option>
                            <option value="1991">1991</option>
                            <option value="1992">1992</option>
                            <option value="1993">1993</option>
                            <option value="1994" selected>1994</option>
                            <option value="1995">1995</option>
                            <option value="1996">1996</option>
                            <option value="1997">1997</option>
                            <option value="1998">1998</option>
                            <option value="1999">1999</option>
                            <option value="2000">2000</option>
                            <option value="2001">2001</option>
                            <option value="2002">2002</option>
                            <option value="2003">2003</option>
                            <option value="2004">2004</option>
                            <option value="2005">2005</option>
                            <option value="2006">2006</option>
                            <option value="2007">2007</option>
                            <option value="2008">2008</option>
                            <option value="2009">2009</option>
                            <option value="2010">2010</option>
                            <option value="2011">2011</option>
                            <option value="2012">2012</option>
                            <option value="2013">2013</option>
                            <option value="2014">2014</option>
                            <option value="2015">2015</option>
                            <option value="2016">2016</option>
                            <option value="2017">2017</option>
                            <option value="2018">2018</option>
                            <option value="2019">2019</option>
                            <option value="2020">2020</option>
                            <option value="2021">2021</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label">Email <span class="text-red">*</span></label>
                <input type="email" class="form-control" id="email" name="email" value="{{ !empty($patient_details->email) ? $patient_details->email : '' }}">
                <span class="text-danger error-text email_err"></span>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label">Mobile No.</label>
                <input type="text" class="form-control" id="mobile_number" name="mobile_number" value="{{ !empty($patient_details->mobile_number) ? $patient_details->mobile_number : '' }}">
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label">NHS No.</label>
                <input type="text" class="form-control" id="nsh_no" name="nsh_no" value="{{ !empty($patient_details->nsh_no) ? $patient_details->nsh_no : '' }}">
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label">Passport No<span class="text-red">*</span></label>
                <input type="text" class="form-control" id="passport_number" name="passport_number" value="{{ !empty($patient_details->passport_number) ? $patient_details->passport_number : '' }}">
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label class="form-label">Select Country</label>
                <select class="form-control" id="country_id" name="country_id">
                    @foreach($countries as $country)
                        <option value="{{$country->id}}"
                            @if(!empty($patient_details) && $patient_details->country_id == $country->id)
                              selected="selected" 
                            @elseif(empty($patient_details) && $country->id == 231))
                                 selected="selected" 
                            @endif
                        >
                        {{$country->title}}
                        </option>
                    @endforeach()
                </select>
                <div class="alert-message text-danger error-country"></div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label">Address <span class="text-red">*</span></label>
                <input type="text" class="form-control" id="address" name="address" value="{{ !empty($patient_details->address) ? $patient_details->address : '' }}">
            </div>
        </div>

    
        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label">Town/ City <span class="text-red">*</span></label>
                <input type="text" class="form-control" id="town_city" name="town_city" value="{{ !empty($patient_details->town_city) ? $patient_details->town_city : '' }}">
                <span class="text-danger error-text town_city_err"></span>
            </div>
        </div>


        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label">Postcode <span class="text-red">*</span></label>
                <input type="text" class="form-control" name="postcode" id="postcode" value="{{ !empty($patient_details->postcode) ? $patient_details->postcode : '' }}">
                <span class="text-danger error-text postcode_err"></span>
            </div>
        </div>
       
        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label">Active Status</label>
                <select class="form-control" name="status" id="status">

                    <option {{ empty($patient_details) || (!empty($patient_details) && $patient_details->status == '1') ? 'selected="selected"' : '' }} value="1" >Active</option>

                    <option {{ !empty($patient_details) && $patient_details->status == '0' ? 'selected="selected"' : '' }} value="0" >Inactive</option>

                </select>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <div class="mt-5">
                    <label class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input"  name="is_verified" value="{{ !empty($patient_details->is_verified) ? $patient_details->is_verified : '0' }}" id="is_verified"> <span class="custom-control-label">Is Verified?</span> </label>
                </div>
            </div>
        </div>
        <div class="col-md-12" id="reason_div">
            <div class="form-group">
                <div class="mt-5">
                    <label class="form-label">Reason</label>
                    <textarea rows="4" class="form-control" name="reason" id="reason" placeholder="Reason">{{ !empty($patient_details->reason) ? $patient_details->reason : '' }}</textarea>
                </div>
            </div>
        </div>

     

    </div>

    <hr />
    <div class="row">
       <div class="col-md-3 offset-9">
            <button class="btn btn-indigo" type="button" id="add-edit-patient-btn">Submit</button>
            <button class="btn btn-light" data-dismiss="modal" type="button">Close</button>
        </div>
    </div>

</form>

<script type="text/javascript">

    $(document).ready(function(){
        var dob_detail = $('#date_b').val();
        if (dob_detail) {
            $("#year").val(dob_detail.split('-')[0]);
            $("#month").val(dob_detail.split('-')[1]);
            $("#day").val(dob_detail.split('-')[2]);
        }

        $('#reason_div').hide();
        $('#reason_row').hide();
        if ($('#is_verified').val() == 1){
            $("#is_verified").click();
            $('#reason_div').show()
        }
        $('#is_verified').click(function () {
            $('#reason_div').toggle();
        });
        $('#is_verified').click(function () {
            if ($(this).is(':checked')) {
                $(this).attr('value', '1');
            } else {
                $(this).attr('value', '0');
            }
            console.log($('#is_verified').val())
            $('#reason_row').toggle();
        });

        // Save
        $('#add-edit-patient-btn').click(function(){

            var hash_id = $('#hash_id').val();

            var request_type = (hash_id != '') ? 'POST' : 'POST' ;

            var request_url = (hash_id != '') ? 'patients/'+hash_id : 'patients' ;

            var request_data = new FormData(document.getElementById("add-edit-patient-form"));

            $.ajax({

                type: request_type,

                url: request_url,

                processData: false,

                contentType: false,

                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },

                data: request_data,

                beforeSend: function(result) {
                    $("#loader").show();
                    $("#add-edit-patient-btn").attr("disabled", true);
                    $('#add-edit-patient-btn').html('Loading..');
                    $("#loading").css("display","block");

                    $('#crud_errors_div').addClass('d-none');
                    $('#crud_errors_ul').html('');

                },
                success: function(response) {
                    $("#add-edit-patient-btn").attr("disabled", false);
                    $('#add-edit-patient-btn').html('Submit');
                    $("#loading").css("display","none");

                    // swal(response);
                    location.reload();
                    $('#loader').delay(2000).hide(100);

                },

                error: function(xhr, status, error) {
                    $('#loader').delay(2000).hide(100);
                    $("#add-edit-patient-btn").attr("disabled", false);
                    $('#add-edit-patient-btn').html('Submit');
                    // console.log( xhr.responseJSON.error_msg );
                    mcShowErrorsPost(xhr, status, error);
                }

                // success

            }); // $.ajax

        }); // click => #add-edit-banner-btn


    }); // .ready

</script>
