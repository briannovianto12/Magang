
@extends('theme::layouts.master')

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
             id="m_login">
            <div class="m-grid__item m-grid__item--fluid	m-login__wrapper">
                <div class="m-login__container">


                    <div class="m-login__signin">
                        <div class="m-login__head">
                            <h3 class="m-login__title">Update Password</h3>
                        </div>
                        <form id="form" class="m-form m-form--fit" method="POST"
                              action="{{ route('post.update-password') }}">
                            @csrf

                            <div class="m-login__signin_form">
                                <div class="input-group m-input-group m-input-group m-input-group--air">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="la la-lock"></i></span>
                                    </div>
                                    <input type="password" class="form-control m-input" placeholder="Old Password"
                                           id="old_password" name="old_password" required="">
                                </div>
                                <div class="ml-4">
                                    @if (Session::has('unauthorized'))
                                       <div class="alert alert-info">{{ Session::get('unauthorized') }}</div>
                                    @endif
                                    <span class="m-form__help" id="password_help"></span>
                                </div>
                            </div>

                            <div class="m-login__signin_form">
                                <div class="input-group m-input-group m-input-group m-input-group--air">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="la la-lock"></i></span>
                                    </div>
                                    <input type="password" class="form-control m-input" placeholder="New Password"
                                           id="new_password" name="new_password" required="">
                                </div>
                                <div class="ml-4">
                                    @if ($errors->has('new_password'))
                                        <div class="form-control-feedback" role="alert">
                                            <strong>{{ $errors->first('new_password') }}</strong>
                                        </div>
                                    @endif
                                    <span class="m-form__help" id="password_help"></span>
                                </div>
                            </div>

                            <div class="m-login__signin_form">
                                <div class="input-group m-input-group m-input-group m-input-group--air">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="la la-lock"></i></span>
                                    </div>
                                    <input type="password" class="form-control m-input" placeholder="Confirm Password"
                                           id="new_password_confirmation" name="new_password_confirmation" required="">
                                </div>
                                <div class="ml-4">
                                    @if ($errors->has('new_password_confirmation'))
                                        <div class="form-control-feedback" role="alert">
                                            <strong>{{ $errors->first('new_password_confirmation') }}</strong>
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
    </body>
@endsection
