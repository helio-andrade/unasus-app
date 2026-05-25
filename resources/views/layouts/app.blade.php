<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('app.name', 'UNASUS'))</title>
    <style>
        :root {
            --bg: #f6f7f5;
            --surface: #ffffff;
            --surface-muted: #eef5f2;
            --text: #16211d;
            --muted: #65736d;
            --line: #d9e2dd;
            --primary: #0f766e;
            --primary-dark: #115e59;
            --danger: #b42318;
            --danger-bg: #fff1f0;
            --success: #14703f;
            --success-bg: #edfdf5;
            --warning-bg: #fff8db;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            background: var(--bg);
            color: var(--text);
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            font-size: 16px;
            line-height: 1.5;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        button,
        input {
            font: inherit;
        }

        .topbar {
            border-bottom: 1px solid var(--line);
            background: rgba(255, 255, 255, .9);
        }

        .topbar-inner,
        .page {
            width: min(1120px, calc(100% - 32px));
            margin: 0 auto;
        }

        .topbar-inner {
            min-height: 64px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 700;
        }

        .brand-mark {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: grid;
            place-items: center;
            background: var(--primary);
            color: #fff;
            font-size: 14px;
        }

        .nav {
            display: flex;
            align-items: center;
            gap: 12px;
            color: var(--muted);
            font-size: 14px;
        }

        .page {
            padding: 40px 0;
        }

        .narrow {
            width: min(440px, 100%);
            margin: 0 auto;
        }

        .panel {
            border: 1px solid var(--line);
            border-radius: 8px;
            background: var(--surface);
            box-shadow: 0 10px 30px rgba(15, 23, 42, .06);
        }

        .panel-pad {
            padding: 28px;
        }

        .section-head {
            margin-bottom: 24px;
        }

        h1 {
            margin: 0;
            font-size: 24px;
            line-height: 1.2;
            font-weight: 750;
        }

        .muted {
            color: var(--muted);
        }

        .field {
            margin-top: 18px;
        }

        label {
            display: block;
            margin-bottom: 7px;
            color: #26352f;
            font-size: 14px;
            font-weight: 650;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="file"] {
            width: 100%;
            min-height: 44px;
            border: 1px solid #cbd7d1;
            border-radius: 6px;
            background: #fff;
            color: var(--text);
            padding: 10px 12px;
            outline: none;
        }

        input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(15, 118, 110, .16);
        }

        .checkbox-row {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-top: 18px;
            color: var(--muted);
            font-size: 14px;
        }

        .actions {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            margin-top: 24px;
            flex-wrap: wrap;
        }

        .button {
            min-height: 42px;
            border: 1px solid transparent;
            border-radius: 6px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 9px 16px;
            cursor: pointer;
            font-weight: 700;
        }

        .button-primary {
            background: var(--primary);
            color: #fff;
        }

        .button-primary:hover {
            background: var(--primary-dark);
        }

        .button-secondary {
            border-color: var(--line);
            background: #fff;
            color: var(--text);
        }

        .link {
            color: var(--primary-dark);
            font-weight: 700;
        }

        .error {
            margin-top: 6px;
            color: var(--danger);
            font-size: 14px;
        }

        .alert {
            border-radius: 6px;
            padding: 12px 14px;
            margin-bottom: 18px;
            font-size: 14px;
        }

        .alert-success {
            background: var(--success-bg);
            color: var(--success);
            border: 1px solid #ccefdc;
        }

        .summary {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 12px;
            margin-bottom: 20px;
        }

        .summary-item {
            border: 1px solid var(--line);
            border-radius: 8px;
            background: var(--surface);
            padding: 16px;
        }

        .summary-label {
            color: var(--muted);
            font-size: 13px;
        }

        .summary-value {
            margin-top: 4px;
            font-size: 28px;
            font-weight: 800;
        }

        .table-wrap {
            overflow-x: auto;
            border: 1px solid var(--line);
            border-radius: 8px;
            background: var(--surface);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 900px;
        }

        th,
        td {
            padding: 12px 14px;
            border-bottom: 1px solid var(--line);
            text-align: left;
            vertical-align: top;
            font-size: 14px;
        }

        th {
            background: var(--surface-muted);
            color: #33443d;
            font-size: 12px;
            text-transform: uppercase;
        }

        tr.valid-row td {
            background: var(--success-bg);
        }

        tr.invalid-row td {
            background: var(--danger-bg);
        }

        .badge {
            display: inline-flex;
            align-items: center;
            border-radius: 999px;
            padding: 3px 9px;
            font-size: 12px;
            font-weight: 800;
        }

        .badge-valid {
            background: #d7f7e4;
            color: var(--success);
        }

        .badge-invalid {
            background: #ffd9d6;
            color: var(--danger);
        }

        .error-list {
            margin: 0;
            padding-left: 18px;
            color: var(--danger);
        }

        @media (max-width: 680px) {
            .topbar-inner {
                align-items: flex-start;
                flex-direction: column;
                padding: 14px 0;
            }

            .summary {
                grid-template-columns: 1fr;
            }

            .panel-pad {
                padding: 22px;
            }
        }
    </style>
</head>
<body>
    <header class="topbar">
        <div class="topbar-inner">
            <a class="brand" href="{{ route('import.create') }}">
                <span class="brand-mark">UA</span>
                <span>UNASUS</span>
            </a>

            <nav class="nav">
                @auth
                    <a class="link" href="{{ route('import.create') }}">Upload</a>
                    <span>{{ auth()->user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="button button-secondary" type="submit">Sair</button>
                    </form>
                @else
                    <a class="link" href="{{ route('login') }}">Entrar</a>
                    <a class="button button-secondary" href="{{ route('register') }}">Cadastro</a>
                @endauth
            </nav>
        </div>
    </header>

    <main class="page">
        @yield('content')
    </main>
</body>
</html>
