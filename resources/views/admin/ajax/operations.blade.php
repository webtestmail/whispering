<script>
    function change_visibility(model, sno, encrypted_id) {
        $("#visibility_error" + sno).html("");
        if (sno == "" || sno == 0 || sno == undefined || sno == null) {
            $("#visibility_error" + sno).html("Visibility is required!");
            return false;
        }

        let token = '{{ csrf_token() }}';
        let visibility = $("#visibility" + sno).val();
        $("#visibility" + sno).attr('disabled', true);
        $.ajax({
            url: "{{ route('change.visibility') }}",
            data: {
                '_token': token,
                'model': model,
                'visibility': visibility,
                'encrypted_id': encrypted_id
            },
            type: "POST",
            dataType: 'json',
            success: function(result) {
                if (result.status == 'done') {
                    Swal.fire({
                        icon: "success",
                        title: result.message,
                        showConfirmButton: false,
                        timer: 1500
                    });
                    setTimeout(function() {
                        $("#visibility" + sno).attr('disabled', false);
                    }, 1500);
                } else {
                    Swal.fire({
                        icon: "error",
                        title: result.message,
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            }
        });
    }

    function change_status(model, sno, encrypted_id) {
        let token = '{{ csrf_token() }}';
        $("#status" + sno).attr('disabled', true);
        $.ajax({
            url: "{{ route('change.status') }}",
            data: {
                '_token': token,
                'model': model,
                'encrypted_id': encrypted_id
            },
            type: "POST",
            dataType: 'json',
            success: function(result) {
                if (result.status == 'done') {
                    Swal.fire({
                        icon: "success",
                        title: result.message,
                        showConfirmButton: false,
                        timer: 1500
                    });
                    setTimeout(function() {
                        $("#status" + sno).attr('disabled', false);
                    }, 1500);
                } else {
                    Swal.fire({
                        icon: "error",
                        title: result.message,
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            }
        });
    }

    function delete_item(model, encrypted_id) {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: "btn btn-success ms-2",
                cancelButton: "btn btn-danger"
            },
            buttonsStyling: false
        });

        swalWithBootstrapButtons.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, Delete it!",
            cancelButtonText: "No, Cancel!",
            reverseButtons: true
        }).then((willDelete) => {
             if (willDelete) {

                let token = '{{ csrf_token() }}';
                $.ajax({
                    url: "{{ route('delete.item') }}",
                    data: {
                        '_token': token,
                        'model': model,
                        'encrypted_id': encrypted_id
                    },
                    type: "POST",
                    success: function(result) {
                        if (result.status == 'done') {
                            swalWithBootstrapButtons.fire({
                                title: result.title,
                                text: result.message,
                                icon: "success",
                                showConfirmButton: false,
                                timer: 1500
                            });
                            setTimeout(function() {
                                window.location.reload();
                            }, 1500);
                        } else {
                            swalWithBootstrapButtons.fire({
                                title: result.title,
                                text: result.message,
                                icon: "error",
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }
                    }
                });
            } else if (
                result.dismiss === Swal.DismissReason.cancel
            ) {
                swalWithBootstrapButtons.fire({
                    title: "Cancelled",
                    text: "Your data is safe :)",
                    icon: "error",
                    showConfirmButton: false,
                    timer: 1500
                });
            }
        });
    }

    function change_header_footer_visibility(model, sno, encrypted_id) {
        $("#header_footer_visibility_error" + sno).html("");
        if (sno == "" || sno == 0 || sno == undefined || sno == null) {
            $("#header_footer_visibility_error" + sno).html("Header-Footer Visibility is required!");
            return false;
        }

        let token = '{{ csrf_token() }}';
        let header_footer_visibility = $("#header_footer_visibility" + sno).val();
        $("#header_footer_visibility" + sno).attr('disabled', true);
        $.ajax({
            url: "{{ route('change.header.footer.visibility') }}",
            data: {
                '_token': token,
                'model': model,
                'header_footer_visibility': header_footer_visibility,
                'encrypted_id': encrypted_id
            },
            type: "POST",
            dataType: 'json',
            success: function(result) {
                if (result.status == 'done') {
                    Swal.fire({
                        icon: "success",
                        title: result.message,
                        showConfirmButton: false,
                        timer: 1500
                    });
                    setTimeout(function() {
                        $("#header_footer_visibility" + sno).attr('disabled', false);
                    }, 1500);
                } else {
                    Swal.fire({
                        icon: "error",
                        title: result.message,
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            }
        });
    }
</script>
