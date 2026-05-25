@extends('layouts.app')

@section('title', 'Cadastro')

@section('content')
    <section class="narrow panel panel-pad">
        <div class="section-head">
            <h1>Cadastro</h1>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="field">
                <label for="name">Nome</label>
                <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus>
                @error('name')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <div class="field">
                <label for="email">E-mail</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required>
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

            <div class="field">
                <label for="password_confirmation">Confirmar senha</label>
                <input id="password_confirmation" name="password_confirmation" type="password" required>
            </div>

            <div class="actions">
                <a class="link" href="{{ route('login') }}">Ja tenho conta</a>
                <button class="button button-primary" type="submit">Cadastrar</button>
            </div>
        </form>
    </section>
@endsection
