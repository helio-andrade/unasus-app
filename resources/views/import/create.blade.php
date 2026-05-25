@extends('layouts.app')

@section('title', 'Upload de alunos')

@section('content')
    <section class="narrow panel panel-pad">
        <div class="section-head">
            <h1>Upload de alunos</h1>
        </div>

        <form method="POST" action="{{ route('import.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="field">
                <label for="arquivo">Arquivo Excel</label>
                <input id="arquivo" name="arquivo" type="file" accept=".xlsx,.xls" required>
                @error('arquivo')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <div class="actions">
                <span class="muted">.xlsx ou .xls</span>
                <button class="button button-primary" type="submit">Processar</button>
            </div>
        </form>
    </section>
@endsection
