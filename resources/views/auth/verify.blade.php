@extends('app')

@section('content')
    <section class="ftco-section contact-section px-md-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">{{ __('auth.verifyEmail') }}</div>

                        <div class="card-body">
                            @if (session('resent'))
                                <div class="alert alert-success" role="alert">
                                    {{ __('auth.verifyLink') }}
                                </div>
                            @endif

                            {{ __('auth.checkVerificationLink') }}
                            {{ __('auth.didNotReceiveEmail') }},
                            <form class="d-inline" method="POST" action="{{ route('verification.resend', app()->getLocale()) }}">
                                @csrf
                                <button type="submit"
                                        class="btn btn-link p-0 m-0 align-baseline">{{ __('auth.clickHere') }}</button>
                                .
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
