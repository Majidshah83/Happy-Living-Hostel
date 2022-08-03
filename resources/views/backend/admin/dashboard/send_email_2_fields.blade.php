
    <div class="col-md-12">
        <div class="form-group">
            <label class="form-label">To Email Address</label>
            <input type="text" class="form-control" id="to_email_address" name="to_email_address" value="{{ !empty($order_details['passengers_email']) ? $order_details['passengers_email'] : '' }}" required />
        </div>
    </div>

    <div class="col-md-12">
        <div class="form-group">
            <label class="form-label">Email Subject</label>
            <input type="text" class="form-control" id="email_subject" name="email_subject" value="{{ !empty($email_template_details->email_subject) ? $email_template_details->email_subject : '' }}" required />
        </div>
    </div>

    <div class="col-md-12">
        <div class="form-group">
            
            <label class="form-label">

                Description

                <br />

                <small> You can use the following veriables into the email body template. [PLF_CODE], [DAY_2_BARCODE], [DAY_2_PIN], [DAY_8_BARCODE], [DAY_8_PIN] </small>

            </label>
            
            @include('backend.admin.components.editor', ['item_details' => !empty($email_template_details->email_body) ? $email_template_details->email_body : '','resource' => 'email_body'])

        </div>
    </div>
    
    <script type="text/javascript">
        
        $(document).ready(function(){

            $('#email_body').summernote({
                height: 100,
            });

        }); // ready

    </script>