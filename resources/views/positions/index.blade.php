@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-10">
            <h1 class="mb-3 mt-3">{{ __('positions.Positions') }}</h1>
            <div class="row mb-3">
                <form>
                    <div class="form-inline">
                        <div class="form-group">
                            <select data-column="1" class="form-control filter-select">
                                <option value="">{{ __('positions.Select position') }}</option>
                                @foreach ($positions as $position_name)
                                <option value="{{ $position_name }}">{{ $position_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            @if(Auth::check() && Auth::user()->isAdmin())
                            <a href="{{ route('positions.create') }}" class="btn btn-primary ml-3">{{ __('positions.Create position') }}</a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
            <div class="row">
                <div class="table-responsive">
                    <table class="table table-bordered data-table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">{{ __('positions.Positions') }}</th>
                                <th scope="col">{{ __('positions.Creating date') }}</th>
                                <th scope="col" width="120" class="text-center text-nowrap">{{ __('positions.Actions') }}</th>
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

@endsection

@push('scripts')

<script type="text/javascript">

    let admin = "{{Auth::check() && Auth::user()->isAdmin() }}";

  $(document).ready(function () {

    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.11.5/i18n/ru.json'
        },
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
            {data: 'created_at', name: 'created_at'},
            {data: 'action', name: 'action', orderable: false, searchable: false, sClass:'text-center text-nowrap', visible: admin},
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
