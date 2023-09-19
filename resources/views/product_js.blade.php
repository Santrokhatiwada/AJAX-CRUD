<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
<script>
    $(document).ready(function() {
        $(document).on('click', '.add_product', function(e) {
            e.preventDefault();
            let name = $('#name').val();
            let price = $('#price').val();

            $.ajax({
                url: "{{ route('add.product') }}",
                method: 'post',
                data: {
                    name: name,
                    price: price
                },
                success: function(res) {
                    if (res.status == 'success') {
                        $('#addModal').modal('hide');
                        $('# addProductForm')[0].reset();
                        $('.table').load(location.href + ' .table');

                    }
                },
                error: function(err) {
                    let error = err.responseJSON;
                    $('.errMsgContainer').empty(); // Clear previous error messages

                    // Check if the error object contains "errors" property
                    if (error.hasOwnProperty('errors')) {
                        $.each(error.errors, function(index, value) {
                            $('.errMsgContainer').append('<span class="text-danger">' + value + '</span>' + '<br>');
                        });
                    } else {
                        // Handle other types of errors here
                        $('.errMsgContainer').append('<span class="text-danger">An error occurred.</span>');
                    }
                }
            });
        });

        //show data in update form
        $(document).on('click', '.update_product_form', function() {
            let id = $(this).data('id');
            let name = $(this).data('name');
            let price = $(this).data('price');

            $('#up_id').val(id);
            $('#up_name').val(name);
            $('#up_price').val(price);
        });


        //update product data
        $(document).on('click', '.update_product', function(e) {
            e.preventDefault();
            let up_id = $('#up_id').val();
            let up_name = $('#up_name').val();
            let up_price = $('#up_price').val();

            $.ajax({
                url: "{{ route('update.product') }}",
                method: 'post',
                data: {
                    up_id: up_id,
                    up_name: up_name,
                    up_price: up_price
                },
                success: function(res) {
                    if (res.status == 'success') {
                        $('#updateModal').modal('hide');
                        $('#updateProductForm')[0].reset();
                        $('.table').load(location.href + ' .table');

                    }
                },
                error: function(err) {
                    let error = err.responseJSON;
                    $('.errMsgContainer').empty(); // Clear previous error messages

                    // Check if the error object contains "errors" property
                    if (error.hasOwnProperty('errors')) {
                        $.each(error.errors, function(index, value) {
                            $('.errMsgContainer').append('<span class="text-danger">' + value + '</span>' + '<br>');
                        });
                    } else {
                        // Handle other types of errors here
                        $('.errMsgContainer').append('<span class="text-danger">An error occurred.</span>');
                    }
                }
            });
        });


        //delete product
        $(document).on('click', '.delete_product', function (e) {
    e.preventDefault();
    let product_id = $(this).data('id'); // Use data('id') to get the 'id' attribute value
    if (confirm('Are you sure to delete the product?')) {
        $.ajax({
            url: "{{ route('delete.product') }}",
            method: 'post',
            data: {
                product_id: product_id
            },
            success: function (res) {
                if (res.status == 'success') {
                    $('.table').load(location.href + ' .table');
                }
            },
            error: function (err) {
                let error = err.responseJSON;
                // Handle errors if needed
            }
        });
    }
});




    });
</script>