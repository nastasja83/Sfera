@extends('layouts.app')

@section('content')
<section id="jobBanner" class="banner mb-n5">
    <div id="jobBannerFilter">
        <div class="container px-md-0">
            <div class="row">
                <div class="col-md-8 col-12 text-white">
                    <h1 class="h1 text-lg-main ">
                        Сфера - современный сервис для поиска работы и персонала
                    </h1>
                    <div class="pr-md-2 mb-5">
                        Широкие возможности. Простой функционал
                    </div>
                        <a href="{{ route('users.index') }}" class="btn btn-lg btn-primary">
                            Список сотрудников
                        </a>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="py-0 bg-white">
    <div class="container px-md-0">
        <div class="row align-items-center justify-content-between">
            <div class="col-lg-6 d-none d-md-flex overflow-hidden">
                <img src="https://sfera-rabota.ru/images/job_advantage_candidate.png" alt="Sfera-rabota.ru">
            </div>
            <div class="col-lg-6 col-12 pl-lg-7">
                <h2 class="pr-md-7">
                Данные сотрудников
                </h2>
                <div class="text-muted mb-3">
                    ФИО, должность, навыки, статистика: график регистраций, количество сотрудников по должностям и навыкам.
                </div>
                <a href="{{ route('users.index') }}" class="btn btn-lg btn-primary">
                    Сотрудники
                </a>
                <a href="{{ route('users.index') }}" class="btn btn-lg btn-primary">
                    Статистика
                </a>
            </div>
        </div>
    </div>
</section>

@endsection
