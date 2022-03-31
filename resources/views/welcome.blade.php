@extends('layouts.app')

@section('content')
<section id="jobBanner" class="banner mb-n5">
    <div id="jobBannerFilter">
        <div class="container px-md-0">
            <div class="row">
                <div class="col-md-8 col-12 text-white">
                    <h1 class="h1 text-lg-main ">
                    {{ __('welcome.Sfera service') }}
                    </h1>
                    <div class="pr-md-2 mb-5">
                    {{ __('welcome.Ample opportunities. Simple functionality') }}
                    </div>
                        <a href="{{ route('users.index') }}" class="btn btn-lg btn-primary">
                        {{ __('welcome.List of employees') }}
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
                    {{ __('welcome.Employee data') }}
                </h2>
                <div class="text-muted mb-3">
                    {{ __('welcome.About service') }}
                </div>
                <a href="{{ route('users.index') }}" class="btn btn-lg btn-primary">
                    {{ __('users.Employees') }}
                </a>
                <a href="{{ route('statistic.index') }}" class="btn btn-lg btn-primary">
                    {{ __('statistic.Statistic') }}
                </a>
            </div>
        </div>
    </div>
</section>

@endsection
