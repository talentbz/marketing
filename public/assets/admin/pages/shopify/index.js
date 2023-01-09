$(document).ready(function(){

    // create new shopify
    $('#add-modal').submit(function(e){
        e.preventDefault();
        e.stopPropagation();
        var formData = new FormData(this);
        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: store_url,
            method: 'POST',
            data: formData,
            success: function (res) {
                if(res.result == "success" ){
                    toastr["success"]("Success!!!");
                    $('#addModal').modal('hide');
                    setInterval(function(){ 
                        location.href = list_url; 
                    }, 1000);
                } 
            },
            error: function (errors){
                toastr["warning"](errors);
            },
            cache: false,
            contentType: false,
            processData: false
        })
    })

    // update the shopify data
    $('.update_data').click(function(e){
        e.preventDefault();
        e.stopPropagation();
        id=$(this).data("id");
        $('.update-id').val(id);
        $.ajax({
            url: edit_url,
            method: 'GET',
            data: {id:id},
            success: function (data){

                var result = data.result;
                console.log(result)
                $('.store-name').val(result.name)
                $('.store-url').val(result.url)
                $('.access-token').val(result.access_token)
            }
        })
    })
    $('#update-modal').submit(function(e){
        e.preventDefault();
        e.stopPropagation();
        var formData = new FormData(this);
        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: update_url,
            method: 'POST',
            data: formData,
            success: function (res) {
                if(res.result == "success" ){
                    toastr["success"]("Success!!!");
                    $('#updateModal').modal('hide');
                    setInterval(function(){ 
                        location.href = list_url; 
                    }, 1000);
                } 
            },
            error: function (errors){
                toastr["warning"](errors);
            },
            cache: false,
            contentType: false,
            processData: false
        })
    })

    // change status (switch box)
    $('.price-status').change(function(){
    	var status= $(this).prop('checked');
    	var id=$(this).val();
    	$.ajax({
    		type:'GET',
    		dataType:'JSON',
    		url:status_change,
          	data:{status:status, id:id},
          	success:function(res){
                if(res.result == "success" ){
                    toastr["success"]("Success!!!");
                }
	        }
    	})
    })

    // delte the shopify data
    $('#datatable').on('click', '.confirm_delete', function(e){
        e.preventDefault();
        e.stopPropagation();
        var id = $(this).data('id');
        $('.delete_button').click(function(){
            $.ajaxSetup({
                headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: delete_url,
                method: 'POST',
                data: {id:id},
                success: function (data){
                    toastr["success"]("Success");
                    $('#deleteModal').modal('hide');
                    location.href = list_url; 
                }
            })
        })
    })
});