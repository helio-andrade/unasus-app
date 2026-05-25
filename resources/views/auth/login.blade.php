@extends('layouts.app')

@section('title', 'Login')

@section('content')
    <section class="narrow panel panel-pad">
        <div class="section-head">
            <h1>Login</h1>
        </div>

        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="field">
                <label for="email">E-mail</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus>
                @error('email')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <div class="field">
                <label for="password">Senha</label>
                <input id="password" name="password" type="password" required>
                @error('password')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <label class="checkbox-row">
                <input name="remember" type="checkbox" value="1">
                <span>Lembrar acesso</span>
            </label>

            <div class="actions">
                <a class="link" href="{{ route('register') }}">Criar conta</a>
                <button class="button button-primary" type="submit">Entrar</button>
            </div>
        </form>
    </section>
@endsection
