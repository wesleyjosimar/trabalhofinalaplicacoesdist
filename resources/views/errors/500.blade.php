<!DOCTYPE html>
<html>
<head>
    <title>Erro 500 - Erro no Servidor</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 50px;
            background: #f5f5f5;
        }
        .error-container {
            background: white;
            padding: 40px;
            border-radius: 8px;
            max-width: 600px;
            margin: 0 auto;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        h1 { color: #dc3545; }
        p { color: #666; }
    </style>
</head>
<body>
    <div class="error-container">
        <h1>Erro 500</h1>
        <p>Ocorreu um erro no servidor.</p>
        @if(isset($message))
        <p><strong>{{ $message }}</strong></p>
        @endif
        <p>Por favor, verifique os logs do servidor ou entre em contato com o administrador.</p>
    </div>
</body>
</html>

