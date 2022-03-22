@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-10">
            <h1 class="mb-3 mt-3">Positions</h1>
            <div class="mb-3 mt-3">
            @if(Auth::check() && Auth::user()->isAdmin())
            <a href="{{ route('positions.create') }}" class="btn btn-primary ml-auto">{{ __('positions.Create position') }}</a>
            @endif
            </div>
            <div class="row mb-3">
                <div class="col col-4 align-self-start">
                    <form>
                        <div class="form-row">
                            <div class="col">
                                <select data-column="1" class="form-control filter-select">
                                    <option value="">Select positions</option>
                                    @foreach ($positions as $position_name)
                                    <option value="{{ $position_name }}">{{ $position_name }}</option>
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
                                    <th scope="col">Positions</th>
                                    <th scope="col">Creating date</th>
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
        order: [2, 'asc'],
        pageLength: 10,
            lengthMenu: [
                [5, 10, 15, 20, 30],
                [5, 10, 15, 20, 30]
            ],
        ajax: "{{ route('positions.index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false,},
            {data: 'position_name', name: 'position_name'},
            {data: 'created_at', name: 'created_at', visible: logined},
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
