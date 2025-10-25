@extends('backend.layouts.admin')
@section('title', ' All Batches')
@section('content')
<div class="app-page-title">
    <div class="page-title-wrapper">
        <div class="page-title-heading">
            <div class="page-title-icon">
                <i class="pe-7s-users icon-gradient bg-mean-fruit"> </i>
            </div>
            <div>All Batches</div>
                    <div class="d-inline-block ml-2">
                <a href="{{ route('admin.batch.create') }}" class="btn btn-success" ><i class="glyphicon glyphicon-plus"></i>
                    New Batch
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="main-card mb-3 card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="manage_all" class="align-middle mb-0 table table-borderless table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Course Name</th>
                                <th>Batch Code</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(function () {

        table = $('#manage_all').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                "url": '{!! route('admin.allBatch.batches') !!}',
                "type": "GET",
                headers: {
                    "X-CSRF-TOKEN": CSRF_TOKEN,
                },
                "dataType": 'json'
            },
            columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'batch_name', name: 'name'},
                    {data: 'course', name: 'course'},
                    {data: 'batch_code', name: 'batch_code'},
                    {data: 'action', name: 'action'}
                ],
            "autoWidth": false,
        });
        $('.dataTables_filter input[type="search"]').attr('placeholder', 'Type here to search...').css({
            'width': '220px',
            'height': '30px'
        });

    });
</script>
<script type="text/javascript">
    function create() {
        ajax_submit_create('certificates');
    }

    $(document).ready(function () {
        // View Form
        $("#manage_all").on("click", ".view", function () {
            var id = $(this).attr('id');
            ajax_submit_view('certificates', id)
        });

        // Edit Form
        $("#manage_all").on("click", ".edit", function () {
            var id = $(this).attr('id');
            ajax_submit_edit('certificates', id)
        });


        // Delete
        $("#manage_all").on("click", ".delete", function () {
            var id = $(this).attr('id');
            ajax_submit_delete('certificates', id)
        });

    });

</script>
@stop