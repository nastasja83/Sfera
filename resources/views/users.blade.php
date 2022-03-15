@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-10">
            <h1 class="mb-3 mt-3">Employees</h1>
            <div class="row mb-3">
                <div class="col col-4 align-self-start">
                    <form>
                        <div class="form-row">
                            <div class="col">
                                <select data-column="4" class="form-control filter-select">
                                    <option value="">Select position</option>
                                    @foreach ($position_names as $position_name)
                                    <option value="{{ $position_name }}">{{ $position_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col">
                                <select data-column="5" class="form-control filter-select">
                                    <option value="">Select skills</option>
                                    @foreach ($skill_names as $skill_name)
                                    <option value="{{ $skill_name }}">{{ $skill_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="table-responsive">
                        <table class="table table-bordered data-table table-hover">
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
                                    <th scope="col" width="120" class="text-center text-nowrap">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')

<script type="text/javascript">

    let logined = "{{ Auth::check() }}";

  $(document).ready(function () {

    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 5,
            lengthMenu: [
                [5, 10, 15, 20, 30],
                [5, 10, 15, 20, 30]
            ],
        ajax: "{{ route('users.index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'last_name', name: 'last_name', visible: logined},
            {data: 'first_name', name: 'first_name', visible: logined},
            {data: 'middle_name', name: 'middle_name', visible: logined},
            {data: 'position_name', name: 'position_name'},
            {data: 'skills', name: 'skills'},
            {data: 'email', name: 'email', visible: logined},
            {data: 'phone', name: 'phone', visible: logined},
            {data: 'created_at', name: 'created_at', visible: logined},
            {data: 'online', name: 'online', sClass:'text-center', visible: logined},
            {data: 'action', name: 'action', orderable: false, searchable: false, sClass:'text-center text-nowrap', visible: logined},
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
