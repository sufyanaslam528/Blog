<!DOCTYPE html>
<html>

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
</head>

<body>
    <div class="container">
        <div>
            <a href="subscriber/create"><button class="btn btn-dark mt-5 mb-3">Create a Subscriber</button></a>
            <a href="/home"><button class="btn btn-primary mt-5 mb-3">Back</button></a>
        </div>
        <table class="table table-bordered data-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Username</th>
                    <th>Status</th>
                    <th width="130px">Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</body>
<script type="text/javascript">
    $(function() {
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('subscriber.index') }}",
            columns: [{
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'username',
                    name: 'username'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]
        });
        $('body').on('click', '.editsubscriber', function() {
            var id = $(this).data('id');
            $.get("{{ route('subscriber.index') }}" + '/' + id + '/edit', function(data) {})
        });
        $('body').on('click', '.deletesubscriber', function() {
            var id = $(this).data("id");
            confirm("Are You sure want to delete this Subscriber!");
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "DELETE",
                url: "{{ route('subscriber.store') }}" + '/' + id,
                success: function(data) {
                    table.draw();
                },
                error: function(data) {}
            });
        });
    });
</script>


</html>