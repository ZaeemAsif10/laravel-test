@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3>Edit Task</h3>
                        <a href="{{ url('tasks') }}" class="btn btn-primary">List</a>
                    </div>

                    <div class="card-body">

                        <div class="alert alert-success" role="alert" id="successMessage" style="display: none;"></div>
                        <div class="alert alert-danger" role="alert" id="errorMessage" style="display: none;"></div>

                        <form action="" method="POST" id="taskUpdateForm">

                            @csrf

                            <input type="hidden" name="task_id" value="{{ $task->id }}">

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">Title</label>
                                        <input type="text" name="title" value="{{ $task->title ?? '' }}"
                                            class="form-control" placeholder="Title" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Description</label>
                                        <textarea name="description" class="form-control" placeholder="Description" cols="30" rows="4">{{ $task->description ?? '' }}</textarea>
                                    </div>
                                    <div class="form-group mt-3">
                                        <button type="button" class="btn btn-primary"
                                            onclick="updateTask(this)">Update</button>
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
        function updateTask(button) {

            var formData = new FormData($('#taskUpdateForm')[0]);
            $(button).text('Waiting...');

            $.ajax({
                url: "{{ url('update-tasks') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    console.log(response);
                    if (response.success == true) {
                        $('#taskUpdateForm')[0].reset();
                        // Display success message in a specific div
                        $('#successMessage').text(response.msg).show();
                        setTimeout(() => {
                            window.location.reload();
                        }, 1000);
                        $(button).text('Update');
                    } else {
                        // Hide any previous error messages
                        $('#errorMessage').hide().empty();
                        // Display error messages in a specific div
                        response.emsg.forEach(function(error) {
                            $('#errorMessage').append('<p>' + error + '</p>').show();
                        });
                        $(button).text('Update');
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    toastr.error("Somthing went wrong!");
                    $(button).text('Update');
                }
            });
        }
    </script>
@endsection
