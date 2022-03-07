<!DOCTYPE html>
<html>
<head>
    <title>Laravel 5.8 Datatables Tutorial - ItSolutionStuff.com</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
</head>
<body>

<div class="container">
    <h1>Employees</h1>
    <div>
        <div class="table">
            <tr>
                <td>
                    <select data-column="4" class="form-control filter-select">
                        <option value="">Select position</option>
                        @foreach ($position_names as $position_name)
                        <option value="{{ $position_name }}">{{ $position_name }}</option>
                        @endforeach
                    </select>
                </td>
            </tr>
            <tr>
                <td>
                    <select data-column="5" class="form-control filter-select">
                        <option value="">Select skills</option>
                        @foreach ($skill_names as $skill_name)
                        <option value="{{ $skill_name }}">{{ $skill_name }}</option>
                        @endforeach
                    </select>
                </td>
            </tr>
        </div>
    </div>
    <table class="table table-bordered data-table table-responsive table-hover">
        <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col">Last name</th>
                <th scope="col">First name</th>
                <th scope="col">Middle name</th>
                <th scope="col">Position</th>
                <th scope="col">Skills</th>
                <th scope="col">Email</th>
                <th scope="col">Phone</th>
                <th scope="col">Creating date</th>
                <th scope="col">Online</th>
                <th scope="col" width="150" class="text-center text-nowrap">Actions</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

</body>

<script type="text/javascript">
  $(document).ready(function () {

    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,

        ajax: "{{ route('users.index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'last_name', name: 'last_name'},
            {data: 'first_name', name: 'first_name'},
            {data: 'middle_name', name: 'middle_name'},
            {data: 'position_name', name: 'position_name'},
            {data: 'skills', name: 'skills'},
            {data: 'email', name: 'email'},
            {data: 'phone', name: 'phone'},
            {data: 'created_at', name: 'created_at'},
            {data: 'online', name: 'online', sClass:'text-center'},
            {data: 'action', name: 'action', orderable: false, searchable: false, sClass:'text-center text-nowrap'},
        ]
    });
    $('.filter-select').change(function() {
      table.column($(this).data('column'))
      .search($(this).val())
      .draw();
    });

})
</script>
</html>
