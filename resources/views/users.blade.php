@extends('layouts.app')

@section('content')

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

@endsection

@push('scripts')

<script type="text/javascript">
  $(document).ready(function () {

    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        stateSave: true,
        pageLength: 5,
            lengthMenu: [
                [5, 10, 15, 20, 30],
                [5, 10, 15, 20, 30]
            ],
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
@endpush
