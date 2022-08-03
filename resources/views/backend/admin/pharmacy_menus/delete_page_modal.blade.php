<form id="page-template-form" enctype="multipart/form-data">

    <div class="row">

        <div class="col-12">

            <div class="form-group has-error">

                <label> Title <span class="text-danger">*</span> </label>
                <input type="text" class="form-control" id="title" name="title" value="" />
                <div class="invalid-feedback">
                    Please provide a valid email.
                </div>

            </div>

            <div class="form-group">

                <label> URL Slug <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="url_slug" name="url_slug" value="" />

            </div>

            <div class="form-group">

                <label> Image <span class="text-danger">*</span></label>
                <input type="file" class="form-control" id="doc" name="doc" value="" />

            </div>

            <div class="form-group">

                <label> Meta Title </label>
                <input type="text" class="form-control" id="meta_title" name="meta_title" value="" />

            </div>

            <div class="form-group">

                <label> Discription </label>
                <textarea class="mc-html-editor" id="page_body" name="discription"></textarea>

            </div>

            <div class="form-group">

                <label> Status <span class="text-danger">*</span> </label>
                <select class="form-control" id="new_status" name="status">

                    <option value="1"> Active </option>
                    <option value="0"> InActive </option>

                </select>

            </div>

        </div>

    </div>

    <hr />

    <!-- Modal footer -->
    <div class="custom-footer">

        <div class="mt-4">

            <button type="submit" id="mc_frm_submit_btn" class="btn btn-primary waves-effect waves-light mr-1">
                Submit
            </button>

            <button type="button" class="btn btn-danger general_bootstrap_ajax_popup_close_btn"
                data-dismiss="modal">Close</button>

        </div>

    </div>

</form>

<script>
$(document).ready(function() {

    // CKEDITOR INSTANCE
    ClassicEditor

        .create(document.querySelector('.mc-html-editor'), {

            // editor.ui.view.editable.element.style.height = '200px';

        })

        .then(editor => {

            editor.ui.view.editable.element.style.minHeight = '200px';

            // console.log( editor );

        })

        .catch(error => {
            console.error(error);
        });


    $("#mc_frm_submit_btn").click(function(event) {


        event.preventDefault();
        // $("#page-template-form").validate();

        var title = $("#title").val();
        var meta_title = $("meta_title").val();
        var discription = $("#page_body").val();
        var url_slug = $("#url_slug").val();
        var status = $("#new_status").val();



        if (title == "" || title == null) {
            alert("please enter title");
            return false;
        }

        if (url_slug == "" || url_slug == null) {
            alert("please enter URL Slug");
            return false;
        }


        var _token = $('meta[name="csrf-token"]').attr('content');

        var data = new FormData();
        var form_data = $('#page-template-form').serializeArray();
        $.each(form_data, function(key, input) {
            data.append(input.name, input.value);
        });




        //File data

        var file_data = $('input[name="doc"]')[0].files;

        for (var i = 0; i < file_data.length; i++) {
            data.append("doc", file_data[i]);
        }

        var check = $('#mc_frm_submit_btn').attr('edit_button');
        if (check == 'yes') {
         
            var item_id = $("#item_id").val();
            data.append("item_id", item_id);
        }

        //Custom data
        // data.append('key', 'value');




        $.ajax({

            type: "POST",
            url: "/pages",
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: data,

            beforeSend: function(result) {
                //$("#overlay").removeClass("hidden");
            },
            success: function(response) {

                swal(response.msg);

                location.reload();
            },
            error: function(request, status, error) {

                swal(request.responseText);
            }

        }); // $.ajax



    });


});
</script>