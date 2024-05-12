@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3>Task List</h3>
                        <a class="btn btn-primary" href="{{ url('add-tasks') }}">Add Task</a>
                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif


                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($tasks) > 0)
                                    @foreach ($tasks as $task)
                                        <tr>
                                            <td>{{ $task->title }}</td>
                                            <td>{{ $task->description }}</td>
                                            <td colspan="2">
                                                <a href="{{ url('edit-task/' . $task->id) }}"
                                                    class="btn btn-success btn-sm">Edit</a>
                                                <button class="btn btn-danger btn-sm"
                                                    onclick="deleteTask({{ $task->id }});">Delete</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>



    <script>
        function deleteTask(task_id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to delete this data!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "GET",
                        url: "{{ url('delete-task') }}",
                        data: {
                            id: task_id,
                        },
                        dataType: "json",
                        success: function(response) {
                            if (response.success == true) {
                                    window.location.reload();
                            } else {
                                // toastr.error(response.emsg);
                            }
                        },
                        error: function(xhr, status, error) {
                            toastr.error('Error occurred while deleting data');
                            console.error(xhr.responseText);
                        }
                    });
                } else {
                    // Handle cancellation if needed
                }
            });
        }
    </script>



@endsection
