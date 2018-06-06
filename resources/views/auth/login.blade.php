@extends('layouts.app')

@section('title')
Login
@endsection

@section('content')
<article>
    <div class="container">
        <form method="POST" action="{{ route('login') }}">
            @csrf

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

            <div class="field is-grouped">
              <div class="control">
                <button class="button is-link">Login</button>
              </div>
            </div>
        </form>
    </div>
</article>
@endsection
