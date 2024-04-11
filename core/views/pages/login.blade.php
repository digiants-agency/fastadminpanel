@extends('fastadminpanel.layouts.app')

@section('content')
<style>
    body {
        background: #EFF2F4;
    }
</style>
<main class="login-form">
    <div class="login-form-fields">
        <div class="login-form-logo-wrapper">
            <a href="/">
                <img src="/vendor/fastadminpanel/images/logo.svg" alt="" class="login-form-logo">
            </a>
            <div class="login-title">Admin Panel</div>
        </div>
        <div class="login-form-title">Log In</div>
        <form action="/sign-in" method="POST">
            <input type="text" class="login-form-input" name="email" placeholder="E-mail" required autofocus>
            <input type="password" class="login-form-input" name="password" placeholder="Password" required>
            <label class="checkbox">
                <input class="checkbox-input" style="display: none;" type="checkbox" name="remember" value="true">
                <div class="checkbox-rectangle">
                    <svg class="checkbox-mark" enable-background="new 0 0 515.556 515.556" height="512" viewBox="0 0 515.556 515.556" width="512" xmlns="http://www.w3.org/2000/svg"><path d="m0 274.226 176.549 176.886 339.007-338.672-48.67-47.997-290.337 290-128.553-128.552z" fill="white"/></svg>
                </div>
                <div class="checkbox-text">Remember Me</div>
            </label>
            <button type="submit" class="login-form-btn">
                Login
            </button>

            @if (isset($_COOKIE['password']) && $_COOKIE['password'] == 'incorrect')
                <div class="login-error">
                    Login or password incorrect
                </div>
                <script>
                    delete_cookie('password')
                </script>
            @endif
            @csrf
        </form>
    </div>
    <img src="/vendor/fastadminpanel/images/digiants.svg" alt="" class="digiants">
</main>
@endsection