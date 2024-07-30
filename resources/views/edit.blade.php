@extends('layouts.layout')
@section('header')
    <style>
        div.dt-container .dt-paging .dt-paging-button {
            padding: 0 !important;
            margin: 0 !important;
        }

        div.dt-container .dt-paging .dt-paging-button:hover,
        div.dt-container .dt-paging .dt-paging-button:focus,
        div.dt-container .dt-paging .dt-paging-button:active,
        div.dt-container .dt-paging .dt-paging-button.active {
            background: transparent !important;
            border: none !important;
        }

        .card {
            border-radius: 30px !important;
        }
    </style>
@endsection
@section('content')
    <div class="container-fluid mt-5">
        <div class="card">
            <div class="card-body">
                <table class="table" id="dataTable">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">Project ID</th>
                            <th scope="col">Project Number</th>
                            <th scope="col">Home style</th>
                            <th scope="col">Home Spec</th>
                            <th scope="col">Project Address</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($projects as $data)
                            <tr data-project-id="{{ $data->project_id }}">
                                <th>{{ $data->project_id }}</th>
                                <td>{{ $data->project_number }}</td>
                                <td>{{ $data->home_style }}</td>
                                <td>{{ $data->homespec_id }}</td>
                                <td>{{ $data->project_address }}</td>
                                <td>
                                    <a type="button" class="btn btn-primary btn-sm"
                                        href="{{ route('home.edit', $data->project_id) }}" style="color: white">Edit</a>
                                </td>
                                <td>
                                    <a type="button" class="btn btn-danger btn-sm" id="btnDel" style="color: white"
                                        data-project-id="{{ $data->project_id }}">Delete</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@section('script')
    {{-- Jquery --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/2.1.2/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.2/js/dataTables.bootstrap5.min.js"></script>s

    <script>
        // $(document).ready(function() {
        //     $('#dataTable').DataTable();
        // });

        // Ajax Delete
        // $(document).on('click', '#btnDel', function(e) {
        //     e.preventDefault();
        //     let projectId = $(this).data('project-id');
        //     let token = $("meta[name='csrf-token']").attr("content");
        //     console.log('Project ID to delete:', projectId);

        //     if (confirm('Are you sure you want to delete this project?')) {
        //         $.ajax({
        //             url: `/home/delete/${projectId}`,
        //             type: 'DELETE',
        //             data: {
        //                 "_token": token,
        //             },
        //             success: function(response) {
        //                 if (response.success) {
        //                     $(`tr[data-project-id="${projectId}"]`).remove();
        //                     toastr.success('Project deleted successfully');
        //                 } else {
        //                     toastr.error(response.message || 'Failed to delete project');
        //                 }
        //             },
        //             error: function(xhr, status, error) {
        //                 toastr.error('An error occurred while deleting the project');
        //                 console.error('Delete error:', error);
        //                 console.error('Response:', xhr.responseText);
        //             }
        //         });
        //     }
        // });
    </script>
@endsection

@endsection
