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
    <div class="container-xxl mt-5">
        <div class="card">
            <div class="card-body table-responsive">
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
                                    <button type="button" class="btn btn-primary btn-sm" style="color: white"
                                        data-project-id="{{ $data->project_id }}" id="btnEdit" data-bs-toggle="modal"
                                        data-bs-target="#editModal">Edit</button>
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

    {{-- ! Edit Modal --}}
    <!-- Modal -->
    <div class="modal fade" id="editModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Edit</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card mb-6">
                        <h5 class="card-header" id="projectId"></h5>
                        <div class="card-body">
                            <div class="mb-4 row">
                                <label for="html5-text-input" class="col-md-3 col-form-label">Project Number</label>
                                <div class="col-md-9">
                                    <input class="form-control" type="text" value="" id="projectNumber">
                                </div>
                            </div>
                            <div class="mb-4 row">
                                <label for="html5-search-input" class="col-md-3 col-form-label">Home Style</label>
                                <div class="col-md-9">
                                    <input class="form-control" type="search" value="" id="homeStyle">
                                </div>
                            </div>
                            <div class="mb-4 row">
                                <label for="html5-email-input" class="col-md-3 col-form-label">Home Spec</label>
                                <div class="col-md-9">
                                    <input class="form-control" type="email" value="" id="homeSpec">
                                </div>
                            </div>
                            <div class="mb-4 row">
                                <label for="html5-url-input" class="col-md-3 col-form-label">Project Address</label>
                                <div class="col-md-9">
                                    <textarea class="form-control" id="projectAddress" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
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
        $(document).ready(function() {
            $('#dataTable').DataTable();
        });

        // Ajax Delete
        $(document).on('click', '#btnDel', function(e) {
            e.preventDefault();
            let projectId = $(this).data('project-id');
            let token = $("meta[name='csrf-token']").attr("content");
            console.log('Project ID to delete:', projectId);

            if (confirm('Are you sure you want to delete this project?')) {
                $.ajax({
                    url: `/home/delete/${projectId}`,
                    type: 'DELETE',
                    data: {
                        "_token": token,
                    },
                    success: function(response) {
                        if (response.success) {
                            $(`tr[data-project-id="${projectId}"]`).remove();
                            toastr.success('Project deleted successfully');
                        } else {
                            toastr.error(response.message || 'Failed to delete project');
                        }
                    },
                    error: function(xhr, status, error) {
                        toastr.error('An error occurred while deleting the project');
                        console.error('Delete error:', error);
                        console.error('Response:', xhr.responseText);
                    }
                });
            }
        });

        // Edit Modal
        $(document).on('click', '#btnEdit', function(e) {
            e.preventDefault();
            let projectId = $(this).data('project-id');
            let token = $("meta[name='csrf-token']").attr("content");
            console.log('Project ID to delete:', projectId);

            $.ajax({
                url: `/home/edit/${projectId}`,
                type: 'GET',
                data: {
                    "_token": token,
                },
                success: function(response) {
                    if (response.success) {
                        // console.log('Response:', response.data);
                        document.getElementById('projectId').innerHTML = "Project ID: "+response.data.project['project_id'];
                        document.getElementById('projectNumber').value = response.data.project['project_number'];
                        document.getElementById('homeStyle').value = response.data.project['home_style'];
                        document.getElementById('homeSpec').value = response.data.project['homespec_id'];
                        document.getElementById('projectAddress').value = response.data.project['project_address'];
                    } else {
                        toastr.error(response.message || 'Failed to delete project');
                    }
                },
                error: function(xhr, status, error) {
                    toastr.error('An error occurred while deleting the project');
                    console.error('Delete error:', error);
                    console.error('Response:', xhr.responseText);
                }
            });
        })
    </script>
@endsection

@endsection
