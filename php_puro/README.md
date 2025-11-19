# CBF Antidoping - PHP Puro

Aplicação PHP pura, sem frameworks, para gerenciamento de atletas e testes antidoping.

## 📋 Estrutura

```
php_puro/
├── config.php              # Configurações
├── Database.php            # Conexão com banco
├── index.php               # Página inicial
├── login.php               # Login
├── logout.php              # Logout
├── atletas.php             # CRUD Atletas
├── testes.php              # CRUD Testes
├── usuarios.php            # CRUD Usuários (admin)
├── criar_usuarios.php      # Script para criar usuários padrão
├── models/                 # Modelos
│   ├── Usuario.php
│   ├── Atleta.php
│   └── Teste.php
├── controllers/            # Controllers
│   ├── AuthController.php
│   ├── AtletaController.php
│   ├── TesteController.php
│   └── UsuarioController.php
└── views/                  # Views HTML
    ├── layout.php
    ├── auth/
    ├── atletas/
    ├── testes/
    └── usuarios/
```

## 🚀 Instalação no CWP

### 1. Copiar arquivos
Copie toda a pasta `php_puro/` para `public_html/` no servidor.

### 2. Configurar banco
Edite `config.php` e ajuste as credenciais:
```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'amorexpr_teste');
define('DB_USER', 'amorexpr_admin');
define('DB_PASS', 'Testando@09');
```

### 3. Criar tabelas
Execute o arquivo `database.sql` no phpMyAdmin.

### 4. Criar usuários padrão
No Terminal SSH:
```bash
cd /home/usuario/public_html
php criar_usuarios.php
```

### 5. Acessar
- URL: `https://teste.amorexpress.com.br/login.php`
- Login: `admin@cbf.com.br` / `admin123`

## 📝 Funcionalidades

- ✅ Login/Logout com sessões
- ✅ CRUD de Atletas
- ✅ CRUD de Testes Antidoping
- ✅ CRUD de Usuários (apenas admin)
- ✅ Histórico de testes por atleta
- ✅ Filtros e buscas
- ✅ Interface responsiva

## 🔒 Segurança

- Senhas hasheadas com `password_hash()`
- Verificação de autenticação em todas as páginas
- Verificação de perfil admin para usuários
- Proteção contra SQL Injection (PDO prepared statements)
- Escape de HTML (htmlspecialchars)

## 📦 Requisitos

- PHP 7.4+
- MySQL 5.7+
- Extensões: PDO, PDO_MySQL

