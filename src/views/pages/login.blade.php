@extends('fastadminpanel.layouts.app')

@section('content')
<style>
    body {
        background: linear-gradient(-45deg, #ee7752, #e73c7e, #23a6d5, #23d5ab);
        background-size: 400% 400%;
        animation: gradient 15s ease infinite;
    }
    @keyframes gradient {
        0% {
            background-position: 0% 50%;
        }
        50% {
            background-position: 100% 50%;
        }
        100% {
            background-position: 0% 50%;
        }
    }
</style>
<main class="login-form">
    <div class="login-form-fields">
        <div class="login-form-logo-wrapper">
            <img src="/vendor/fastadminpanel/images/white-logo.svg" alt="" class="login-form-logo">
        </div>
        <div class="login-form-title">Sign in</div>
        <form action="/sign-in" method="POST">
            <input type="text" class="login-form-input" name="email" placeholder="E-mail" required autofocus>
            <input type="password" class="login-form-input" name="password" placeholder="Password" required>
            <label class="login-form-checkbox">
                <input class="login-form-checkbox-input" style="display: none;" type="checkbox" name="remember" value="true">
                <div class="login-form-checkbox-rectangle">
                    <svg class="login-form-checkbox-mark" enable-background="new 0 0 515.556 515.556" height="512" viewBox="0 0 515.556 515.556" width="512" xmlns="http://www.w3.org/2000/svg"><path d="m0 274.226 176.549 176.886 339.007-338.672-48.67-47.997-290.337 290-128.553-128.552z" fill="white"/></svg>
                </div>
                <div class="login-form-checkbox-text">Remember Me</div>
            </label>
            <button type="submit" class="login-form-btn">
                Login
            </button>

            @if (isset($_COOKIE['password']) && $_COOKIE['password'] == 'incorrect')
                <div class="mt-30 red">
                    Login or password incorrect
                </div>
                <script>
                    delete_cookie('password')
                </script>
            @endif
            @csrf
        </form>
    </div>
</main>
@endsection