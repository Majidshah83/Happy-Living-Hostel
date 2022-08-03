$(document).ready(function(){
    
    // GOES HERE

}); // $(document).ready(function()

// Start => function get_table_row(table_name=false, item_id=false)
function get_table_row(table_name=false, item_id=false){
    
    var ajax_response = function () {

        var response_data = null;

        $.ajax({

            type: "POST",
            url: "/common_operations/get_table_row",
            'global': false,
            'async': false,
            // processData: false,
            // contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },

            data: { 'table_name' : table_name, 'item_id' : item_id },
            beforeSend: function(result) {

                // $("#loading").css("display","block");
                
            },
            success: function(response) {

                // console.log(response);

                response_data = response.data;

            },

            error: function(xhr, status, error) {

                // $("#loading").css("display","none");

            }

        }); // $.ajax

        return response_data;

    }();

    return ajax_response;

} // End => function get_table_row(table_name=false, item_id=false)