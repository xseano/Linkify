@extends('layouts.app')

@section('content')

<article>
    <div class="container">
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="field">
              <label class="label">Username</label>
              <div class="control has-icons-left has-icons-right">
                <input id="name" type="text" class="input {{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>
                <span class="icon is-small is-left">
                  <i class="fas fa-user"></i>
                </span>
              </div>
            </div>

            <div class="field">
              <label class="label">Email</label>
              <div class="control has-icons-left has-icons-right">
                <input id="email" type="email" class="input {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>
                <span class="icon is-small is-left">
                  <i class="fas fa-envelope"></i>
                </span>
              </div>
            </div>

            <div class="field">
              <label class="label">Password</label>
              <div class="control has-icons-left has-icons-right">
                <input id="password" type="password" class="input {{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
                <span class="icon is-small is-left">
                  <i class="fas fa-lock"></i>
                </span>
              </div>
            </div>

            <div class="field">
              <label class="label">Confirm Password</label>
              <div class="control has-icons-left has-icons-right">
                <input id="password-confirm" type="password" class="input" name="password_confirmation" required>
                <span class="icon is-small is-left">
                  <i class="fas fa-check"></i>
                </span>
              </div>
            </div>

            <div class="field is-grouped">
              <div class="control">
                <button class="button is-link">Register</button>
              </div>
            </div>
        </form>
    </div>
</article>
@endsection
