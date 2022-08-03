<form method="POST" id="add-edit-banner-form">

  @csrf()

    @if(!empty($edit_details))
        <input type="hidden" name="_method" value="PUT">
    @endif

    <input type="hidden" id="hash_id" value="{{ !empty($edit_details->hash_id) ? $edit_details->hash_id : '' }}" />

    <div class="row">
        <div class="col-md-12">
          <p> <strong>Expense Charges</strong> </p>
        </div>
    </div>

    <div class="row mt-4">

        <div class="col-md-4">
          <div class="form-group">
               <label class="form-label">Salary</label>
               <input type="number" class="form-control expense" id="salary" name="salary"  @if(!empty($edit_details)) value="{{$edit_details->salary}}"  @else value="0" @endif />
          </div>
        </div>

        <div class="col-md-4">
          <div class="form-group">
               <label class="form-label">Electricty Bill</label>
               <input type="number"  class="form-control expense" id="electricty_bill" name="electricty_bill" @if(!empty($edit_details)) value="{{$edit_details->electricty_bill}}"  @else value="0" @endif/>
          </div>
        </div>

        <div class="col-md-4">
          <div class="form-group">
               <label class="form-label">Net Bill</label>
                <input type="number"  class="form-control expense" id="net_bill" name="net_bill"  @if(!empty($edit_details)) value="{{$edit_details->net_bill}}" @else value="0" @endif />
          </div>
        </div>

        <div class="col-md-4">
          <div class="form-group">
                <label class="form-label">Gas Bill</label>
                <input type="number" class="form-control expense"  id="gas_bill" name="gas_bill"  @if(!empty($edit_details)) value="{{$edit_details->gas_bill}}"  @else value="0" @endif />
          </div>
        </div>

        <div class="col-md-4">
          <div class="form-group">
              <label class="form-label">Rent</label>
              <input type="number"  class="form-control expense" id="rent" name="rent"  @if(!empty($edit_details)) value="{{$edit_details->rent}}"  @else value="0" @endif />
          </div>
        </div>

        <div class="col-md-4">
          <div class="form-group">
               <label class="form-label">Sabzi</label>
               <input type="number"  class="form-control expense" id="sabzi" name="sabzi"  @if(!empty($edit_details)) value="{{$edit_details->sabzi}}"  @else value="0" @endif />
          </div>
        </div>


        <div class="col-md-4">
          <div class="form-group">
               <label class="form-label">Daily Expense</label>
               <input type="number"  class="form-control expense" id="daily_expense" name="daily_expense"  @if(!empty($edit_details)) value="{{$edit_details->daily_expense}}"  @else value="0" @endif />
          </div>
        </div>

        <div class="col-md-4">
          <div class="form-group">
               <label class="form-label">Misc</label>
               <input type="number"  class="form-control expense" id="misc" name="misc"  @if(!empty($edit_details)) value="{{$edit_details->misc}}"  @else value="0" @endif />
          </div>
        </div>

   </div>

  <hr>

  <div class="row">
      <div class="col-md-6">
          <?php
             $months = ['01' => 'January','02' => 'February','03' => 'March','04' => 'April' ,'05' => 'May','06' => 'June','07' => 'July','08' => 'August','09' => 'September','10' => 'October','11' => 'November','12' => 'December'];
             $current_month = date('m');
         $sumOfTotalAmount=\App\Models\Expense::where('month_fee',$current_month)->sum('total_amount');
        //  $profileloss=\App\Models\Expense::where('month_fee',$current_month)->sum('remaining_amount');

          ?>


          <div class="form-group">
             <label class="form-label">Select Month</label>
             <select name="month_fee" class="form-control monthexpense" id="month_fee">
                @if(!empty($edit_details) )
                <option value="{{$edit_details->month_fee}}">{{$months[$edit_details->month_fee]}}</option>
                @endif
                @foreach($months as $key => $month)
                  <option value="{{$key}}" @if(empty($edit_details) && $key == $current_month) selected @endif>{{$month}}</option>
                @endforeach()
             </select>
          </div>
       </div>
        <div class="col-md-6">
          <?php
             $current_year = date('Y');
          ?>
          <div class="form-group">
             <label class="form-label">Select Year</label>
             <select name="year_fee" class="form-control yearexpense" id="year_fee">
                  {{ $last= date('Y')-60 }}
                  {{ $now = date('Y') }}
                  @if(!empty($edit_details))
                  <option value="{{$edit_details->year_fee}}">{{$edit_details->year_fee}}</option>                  @endif
                  @for ($i = $now; $i >= $last; $i--)
                      <option value="{{ $i }}" >{{ $i }}</option>
                  @endfor
             </select>
          </div>
       </div>
  </div>
   <hr>
  <div class="row">
      <div class="col-md-12">
        <div class="form-group">
             <label class="form-label">Total Expense:</label>
             <input type="text" value="0" class="form-control total_amount " readonly id="total_amount" name="total_amount"  required />
        </div>
        <div class="form-group" id="totalmonth">
             <label class="form-label">Total Amount Received:</label>
             <input type="text" id="collected_rent" name="total_rent" value="{{$sumOfTotalAmount}}" class="form-control total" readonly id="total" />
        </div>
         <div class="form-group" id="profitloss">
             <label class="form-label">Profit and Loss:</label>
             <input type="text" value="0" class="form-control"
             readonly id="profit_loss" name="remaining_amount"/>
        </div>
      </div>
  </div>
{{--   <hr>
  <div class="row">

      <div class="col-md-12">
        <div class="form-group">
             <label class="form-label">Total Amount Expense</label>
             <input type="text" class="form-control total_amount" readonly id="total_amount" name="total_amount" @if(!empty($amount)) value="{{$amount}}" @else value="0" @endif />
        </div>
      </div>

      <div class="col-md-12">
        <div class="form-group">
             <label class="form-label">Total Amount Rent</label>
             <input type="text" class="form-control" id="total_rent" name="total_rent"  @if(!empty($edit_details)) value="{{$edit_details->total_rent}}"  @else value="0" @endif />
        </div>
      </div>

      <div class="col-md-12">
        <div class="form-group">
             <label class="form-label">Remaining Amount</label>
             <input type="text" class="form-control" id="remaining_amount" name="remaining_amount"  @if(!empty($edit_details)) value="{{$edit_details->remaining_amount}}"  @else value="0" @endif />
        </div>
      </div>

  </div> --}}

  <hr />

  <div class="row">
    <div class="col-md-3 offset-9">
      <button class="btn btn-indigo" type="button" id="add-edit-banner-btn">Submit</button>
      <button class="btn btn-light" data-dismiss="modal" type="button">Close</button>
    </div>
  </div>
   <input type="hidden" id="totalamounte" value="{{$sumOfTotalAmount}}"

</form>

<script type="text/javascript">

    $(document).ready(function(){

       let salary = $('#salary').val();


       let electricty_bill = $('#electricty_bill').val();
       let net_bill = $('#net_bill').val();
       let gas_bill = $('#gas_bill').val();
       let rent = $('#rent').val();
       let sabzi = $('#sabzi').val();
       let daily_expense = $('#daily_expense').val();
       let misc = $('#misc').val();


       let total_amount = parseInt(salary) + parseInt(electricty_bill) + parseInt(net_bill)
       +parseInt(gas_bill)+parseInt(rent)+parseInt(sabzi)
       +parseInt(daily_expense)+parseInt(misc);

       $('.expense').change(function(){
          let profitloss=$('#total').val();

           let salary = $('#salary').val();
           let electricty_bill = $('#electricty_bill').val();
           let net_bill = $('#net_bill').val();
           let gas_bill = $('#gas_bill').val();
           let rent = $('#rent').val();
           let sabzi = $('#sabzi').val();
           let daily_expense = $('#daily_expense').val();
           let misc = $('#misc').val();
           let total_amount = parseInt(salary) + parseInt(electricty_bill) + parseInt(net_bill)
           +parseInt(gas_bill)+parseInt(rent)+parseInt(sabzi)
           +parseInt(daily_expense)+parseInt(misc);

           //total amount
    //    let total=parseInt(amount)-parseInt(total_amount);
           $('.total_amount').val(total_amount);
           let collected_rent = $('#collected_rent').val();
           let profit_loss = total_amount - collected_rent;
           $('#profit_loss').val(profit_loss);

    //    $('.total').val(total);
    //    //profile loss
    //    $('.profitlosss').val(profitloss);
       });

        // Save
        $('#add-edit-banner-btn').click(function(){

            var hash_id = $('#hash_id').val();

            var request_type = (hash_id != '') ? 'POST' : 'POST' ;

            var request_url = (hash_id != '') ? 'expense/'+hash_id : 'expense' ;

            var request_data = new FormData(document.getElementById("add-edit-banner-form"));

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
                    $("#add-edit-banner-btn").attr("disabled", true);
                    $('#add-edit-banner-btn').html('Loading..');

                    $('#crud_errors_div').addClass('d-none');
                    $('#crud_errors_ul').html('');

                },
                success: function(response) {

                    $("#add-edit-banner-btn").attr("disabled", false);
                    $('#add-edit-banner-btn').html('Submit');
                    $("#loading").css("display","none");
                    // swal(response);
                    location.reload();
                    $('#loader').delay(2000).hide(100);


                },

                error: function(xhr, status, error) {
                    $('#loader').delay(2000).hide(100);
                    $("#add-edit-banner-btn").attr("disabled", false);
                    $('#add-edit-banner-btn').html('Submit');
                    mcShowErrorsPost(xhr, status, error);
                }

                // success

            }); // $.ajax

        }); // click => #add-edit-banner-btn

        $('#description').summernote({
              height: 100,
        });

         // onchange on month
       $('.monthexpense').change(function(){
         var month = $(this).val();
         var year=$('#year_fee').val();
        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
         $.ajax({
           type:'POST',
           url:"{{route('monthExpense') }}",
           data:{month:month, year:year},
           success:function(data){
            if(data.total_amount > 0){
                $('#total_amount').val(data.total_amount);
                $('#profit_loss').val(data.remaining_amount);
                $('#collected_rent').val(data.total_rent);
            }else{
                $('#total_amount').val('0');
                $('#profit_loss').val('0');
                $('#collected_rent').val('0');
            }

           }
        });
       });




    }); // .ready

</script>
