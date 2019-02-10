@extends('auth::layouts.master')
@section('css')
    @include('auth::css')
@endsection

@section('scripts')
    @include('auth::js')
@endsection

@section('content')
    <body id="bromo"
          class="m--skin- m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--fixed m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">

    <!-- begin:: Page -->
    <div class="m-grid m-grid--hor m-grid--root m-page">

        <div class="m-grid__item m-grid__item--fluid m-grid m-grid--hor m-login m-login--signin m-login--2 m-login-2--skin-2"
             id="m_login" style="background-image: url('{{ asset('themes/app/media/img//bg/bg-3.jpg') }}');">
            <div class="m-grid__item m-grid__item--fluid	m-login__wrapper">
                <div class="m-login__container">

                    <div class="m-login__logo">
                        <a href="#">
                            <img src="{{ asset('themes/app/media/img/logos/logo-1.png') }}">
                        </a>
                    </div>

                    <div class="m-login__signin">
                        <div class="m-login__head">
                            <h3 class="m-login__title">Sign In To Continue</h3>
                        </div>
                        <form id="form" class="m-form m-form--fit" method="POST"
                              action="{{ route('post.login') }}">
                            @csrf
                            <div class="m-login__signin_form">
                                <div class="input-group m-input-group m-input-group--pill m-input-group--air">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="la la-user"></i></span>
                                    </div>
                                    <input type="email" class="form-control m-input" placeholder="Your email address"
                                           id="email" name="email" value="{{ old('email') }}" required="">
                                </div>
                                <div class="ml-4">
                                    @if ($errors->has('email'))
                                        <div class="form-control-feedback" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </div>
                                    @endif
                                    <span class="m-form__help" id="email_help"></span>
                                </div>
                            </div>

                            <div class="m-login__signin_form">
                                <div class="input-group m-input-group m-input-group--pill m-input-group--air">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="la la-lock"></i></span>
                                    </div>
                                    <input type="password" class="form-control m-input" placeholder="Your password"
                                           id="password" name="password" required="">
                                </div>
                                <div class="ml-4">
                                    @if ($errors->has('password'))
                                        <div class="form-control-feedback" role="alert">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </div>
                                    @endif
                                    <span class="m-form__help" id="password_help"></span>
                                </div>
                            </div>

                            <div class="m-login__form-action text-center">
                                <button type="submit" id="submit"
                                        class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air m-login__btn m-login__btn--primary">
                                    Submit
                                </button>
                            </div>
                        </form>

                    </div>

                </div>
            </div>
        </div>

    </div>
    <!-- end:: Page -->

    @include('theme::layouts.includes.js')

    </body>
@endsection
