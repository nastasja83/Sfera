@extends('layouts.app')

@section('content')
<script src="{{ asset('chart.js/Chart.js') }}"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<div class="container-fluid">
    <div class="row justify-content-center mt-5 mb-5">
        <div class="col col-10">
        <h1 class="mb-3">Statistic</h1>
            {!! Form::open(['route' => 'statistic.update', 'method' => 'POST', 'class' => 'form-inline mb-5']) !!}
            <div class="form-group">
                    {{ Form::label('Period', __('statistic.Period')) }}
                    {{Form::text('Period', $inputDates, ['class' => 'form-control mx-sm-3', 'name' => 'daterange'])}}
                    {{Form::submit(__('statistic.Update'), ['class' => 'btn btn-light my-2'])}}
            </div>

            <div style="width:80%;">
                {!! $registrationChart->render() !!}
            </div>
        </div>
    </div>
    <div class="row justify-content-center mt-5 mb-5">
        <div class="col col-6">
            <div style="width:80%;">
                {!! $skillsChart->render() !!}
            </div>
        </div>
        <div class="col col-6">
            <div style="width:80%;">
                {!! $positionsChart->render() !!}
            </div>
        </div>
    </div>
</div>
<script>
$(function() {
    $('input[name="daterange"]').daterangepicker({
        opens: 'left',
        locale: {
            applyLabel: 'Принять',
            cancelLabel: 'Отмена',
            invalidDateLabel: 'Выберите дату',
            daysOfWeek: ['Вс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб'],
            monthNames: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],
            firstDay: 1
        },
    }, function(start, end, label) {
        console.log("A new date selection was made: " + start.format('DD-MM-YYYY') + ' to ' + end.format('DD-MM-DD'));
    });
});
$('input[name="daterange"]').data('daterangepicker').setStartDate(startDate);
$('input[name="daterange"]').data('daterangepicker').setEndDate(endDate);

</script>
@endsection
