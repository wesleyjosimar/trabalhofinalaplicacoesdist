<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'CBF - Sistema Antidoping')</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background-color: #f5f5f5;
            color: #333;
        }
        .header {
            background: linear-gradient(135deg, #006600 0%, #004400 100%);
            color: white;
            padding: 1rem 2rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .header-content {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .header h1 {
            font-size: 1.5rem;
        }
        .header-user {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        .nav {
            background-color: #fff;
            border-bottom: 1px solid #ddd;
            padding: 0 2rem;
        }
        .nav-content {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            gap: 2rem;
        }
        .nav a {
            display: inline-block;
            padding: 1rem 0;
            color: #666;
            text-decoration: none;
            border-bottom: 3px solid transparent;
            transition: all 0.3s;
        }
        .nav a:hover, .nav a.active {
            color: #006600;
            border-bottom-color: #006600;
        }
        .container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 2rem;
        }
        .alert {
            padding: 1rem;
            margin-bottom: 1rem;
            border-radius: 4px;
            border-left: 4px solid;
        }
        .alert-sucesso {
            background-color: #d4edda;
            border-color: #28a745;
            color: #155724;
        }
        .alert-erro {
            background-color: #f8d7da;
            border-color: #dc3545;
            color: #721c24;
        }
        .btn {
            display: inline-block;
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            font-size: 0.9rem;
            transition: all 0.3s;
        }
        .btn-primary {
            background-color: #006600;
            color: white;
        }
        .btn-primary:hover {
            background-color: #004400;
        }
        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }
        .btn-danger {
            background-color: #dc3545;
            color: white;
        }
        .btn-danger:hover {
            background-color: #c82333;
        }
        .table {
            width: 100%;
            background: white;
            border-collapse: collapse;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            border-radius: 4px;
            overflow: hidden;
        }
        .table th {
            background-color: #006600;
            color: white;
            padding: 1rem;
            text-align: left;
            font-weight: 600;
        }
        .table td {
            padding: 1rem;
            border-bottom: 1px solid #eee;
        }
        .table tr:hover {
            background-color: #f8f9fa;
        }
        .form-group {
            margin-bottom: 1.5rem;
        }
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: #555;
        }
        .form-control {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
        }
        .form-control:focus {
            outline: none;
            border-color: #006600;
            box-shadow: 0 0 0 3px rgba(0, 102, 0, 0.1);
        }
        .card {
            background: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 12px;
            font-size: 0.85rem;
            font-weight: 600;
        }
        .badge-ativo {
            background-color: #d4edda;
            color: #155724;
        }
        .badge-inativo {
            background-color: #f8d7da;
            color: #721c24;
        }
        .badge-pendente {
            background-color: #fff3cd;
            color: #856404;
        }
        .badge-negativo {
            background-color: #d4edda;
            color: #155724;
        }
        .badge-positivo {
            background-color: #f8d7da;
            color: #721c24;
        }
        .actions {
            display: flex;
            gap: 0.5rem;
        }
        .pagination {
            margin-top: 2rem;
            display: flex;
            justify-content: center;
            gap: 0.5rem;
        }
        .pagination a, .pagination span {
            padding: 0.5rem 1rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            text-decoration: none;
            color: #333;
        }
        .pagination .active {
            background-color: #006600;
            color: white;
            border-color: #006600;
        }
        .filters {
            background: white;
            padding: 1.5rem;
            border-radius: 8px;
            margin-bottom: 2rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .filters form {
            display: flex;
            gap: 1rem;
            align-items: end;
            flex-wrap: wrap;
        }
        .filters .form-group {
            margin-bottom: 0;
            flex: 1;
            min-width: 200px;
        }
    </style>
</head>
<body>
    @if(session()->has('usuario_id'))
    <div class="header">
        <div class="header-content">
            <h1>🏆 CBF - Sistema Antidoping</h1>
            <div class="header-user">
                <span>Olá, {{ session('usuario_nome') }}</span>
                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-secondary" style="padding: 0.5rem 1rem;">Sair</button>
                </form>
            </div>
        </div>
    </div>
    <div class="nav">
        <div class="nav-content">
            <a href="/atletas" class="{{ request()->is('atletas*') ? 'active' : '' }}">Atletas</a>
            <a href="/testes" class="{{ request()->is('testes*') ? 'active' : '' }}">Testes Antidoping</a>
            @if(session('usuario_perfil') === 'admin')
            <a href="/usuarios" class="{{ request()->is('usuarios*') ? 'active' : '' }}">Usuários</a>
            @endif
        </div>
    </div>
    @endif

    <div class="container">
        @if(session('sucesso'))
        <div class="alert alert-sucesso">
            {{ session('sucesso') }}
        </div>
        @endif

        @if(session('erro'))
        <div class="alert alert-erro">
            {{ session('erro') }}
        </div>
        @endif

        @yield('content')
    </div>
</body>
</html>

