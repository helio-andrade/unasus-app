@extends('layouts.app')

@section('title', 'Resultado da importacao')

@section('content')
    <section>
        <div class="section-head">
            <h1>Resultado da importacao</h1>
            <p class="muted">{{ $filename }}</p>
        </div>

        <div class="summary">
            <div class="summary-item">
                <div class="summary-label">Linhas processadas</div>
                <div class="summary-value">{{ $report['summary']['total'] }}</div>
            </div>
            <div class="summary-item">
                <div class="summary-label">Validas</div>
                <div class="summary-value">{{ $report['summary']['valid'] }}</div>
            </div>
            <div class="summary-item">
                <div class="summary-label">Com erro</div>
                <div class="summary-value">{{ $report['summary']['invalid'] }}</div>
            </div>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Linha</th>
                        <th>Nome</th>
                        <th>CPF</th>
                        <th>E-mail</th>
                        <th>Telefone</th>
                        <th>Status</th>
                        <th>Erros</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($report['rows'] as $row)
                        <tr class="{{ $row['valid'] ? 'valid-row' : 'invalid-row' }}">
                            <td>{{ $row['line'] }}</td>
                            <td>{{ $row['data']['nome'] ?: '-' }}</td>
                            <td>{{ $row['data']['cpf'] ?: '-' }}</td>
                            <td>{{ $row['data']['email'] ?: '-' }}</td>
                            <td>{{ $row['data']['telefone'] ?: '-' }}</td>
                            <td>
                                @if ($row['valid'])
                                    <span class="badge badge-valid">Valida</span>
                                @else
                                    <span class="badge badge-invalid">Erro</span>
                                @endif
                            </td>
                            <td>
                                @if ($row['valid'])
                                    -
                                @else
                                    <ul class="error-list">
                                        @foreach ($row['errors'] as $field => $messages)
                                            @foreach ($messages as $message)
                                                <li>{{ ucfirst($field) }}: {{ $message }}</li>
                                            @endforeach
                                        @endforeach
                                    </ul>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">Nenhuma linha encontrada.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="actions">
            <a class="button button-secondary" href="{{ route('import.create') }}">Novo upload</a>
        </div>
    </section>
@endsection
