$(document).ready(function(){

    $('#cdt_per_page').change(function(){

        var crud_name = $(this).attr('mc-cdt-id');
        refresh_cdt(crud_name);

    }); // change => cdt_per_page

    $('#cdt_search').keyup(function(){

        var crud_name = $(this).attr('mc-cdt-id');
        refresh_cdt(crud_name);

    }); // change => cdt_search

}); // $(document).ready(function()

// Start => function refresh_cdt(crud_name=false)
function refresh_cdt(crud_name=false){

    var cdt_per_page = $('#cdt_per_page').val();
    var cdt_search = $('#cdt_search').val();

    $.ajax({

        type: "POST",
        url: "{{ route('cdt') }}",
        // processData: false,
        // contentType: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {

            'crud_name': crud_name,
            
            'cdt_per_page' : cdt_per_page,
            'cdt_search' : cdt_search

        },

        beforeSend: function(result) {
            
            //$("#overlay").removeClass("hidden");
            $('#cdt-contents').html('');

        },
        success: function(response) {

            $('#cdt-contents').html(response);

        } // success

    }); // $.ajax

} // End => function refresh_cdt(crud_name=false)