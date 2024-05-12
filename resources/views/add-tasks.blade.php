@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3>Add Task</h3>
                        <a href="{{ url('tasks') }}" class="btn btn-primary">List</a>
                    </div>

                    <div class="card-body">

                        <div class="alert alert-success" role="alert" id="successMessage" style="display: none;"></div>
                        <div class="alert alert-danger" role="alert" id="errorMessage" style="display: none;"></div>

                        <form action="" method="POST" id="taskForm">

                            @csrf

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">Title</label>
                                        <input type="text" name="title" class="form-control" placeholder="Title"
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Description</label>
                                        <textarea name="description" class="form-control" placeholder="Description" cols="30" rows="4"></textarea>
                                    </div>
                                    <div class="form-group mt-3">
                                        <button type="button" class="btn btn-primary" onclick="addTask(this)">Save</button>
                                    </div>
                                </div>
                            </div>


                        </form>

                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>
        function addTask(button) {

            var formData = new FormData($('#taskForm')[0]);
            $(button).text('Waiting...');

            $.ajax({
                url: "{{ url('store-tasks') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success == true) {
                        $('#taskForm')[0].reset();
                        // Display success message in a specific div
                        $('#successMessage').text(response.msg).show();
                        setTimeout(() => {
                            window.location.reload();
                        }, 1000);
                        $(button).text('Save');
                    } else {
                        // Hide any previous error messages
                        $('#errorMessage').hide().empty();
                        // Display error messages in a specific div
                        response.emsg.forEach(function(error) {
                            $('#errorMessage').append('<p>' + error + '</p>').show();
                        });
                        $(button).text('Save');
                    }

                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    toastr.error("Somthing went wrong!");
                    $(button).text('Save');
                }
            });
        }
    </script>
@endsection
