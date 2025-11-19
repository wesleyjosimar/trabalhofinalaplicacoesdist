# 🚀 Guia de Deploy no cPanel

## ⚠️ PROBLEMAS COMUNS E SOLUÇÕES

### 1. ESTRUTURA DE DIRETÓRIOS NO cPanel

No cPanel, o diretório `public_html` é a raiz web. Você tem 2 opções:

#### **OPÇÃO A: Mover conteúdo de `public` para `public_html` (RECOMENDADO)**

1. No File Manager do cPanel, acesse seu domínio
2. Renomeie `public_html` para `public_html_old` (backup)
3. Crie uma nova pasta `public_html`
4. Copie TODO o conteúdo da pasta `public` para `public_html`
5. Ajuste o `public_html/index.php` para apontar corretamente:

```php
// No início do public_html/index.php, ajuste os caminhos:
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
```

#### **OPÇÃO B: Configurar domínio para apontar para `public`**

1. No cPanel, vá em **Domínios** → **Domínios Adicionais**
2. Configure o Document Root para apontar para: `/home/usuario/public_html/seu-projeto/public`

---

### 2. CONFIGURAR ARQUIVO .env

1. No File Manager, acesse a raiz do projeto (fora de `public_html`)
2. Copie `.env.example` para `.env` (se não existir, crie)
3. Edite o `.env` com estas configurações:

```env
APP_NAME=CBF_Antidoping
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:GERAR_AQUI
APP_URL=https://seu-dominio.com.br

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=amorexpr_teste
DB_USERNAME=amorexpr_admin
DB_PASSWORD=Testando@09

SESSION_DRIVER=database
LOG_CHANNEL=stack
```

4. **GERAR APP_KEY**: No Terminal do cPanel, execute:
```bash
cd /home/usuario/public_html/seu-projeto
php artisan key:generate
```

---

### 3. PERMISSÕES DE ARQUIVOS

No File Manager, ajuste as permissões:

- `storage/` → **755** (ou 775)
- `storage/framework/` → **755**
- `storage/framework/cache/` → **755**
- `storage/framework/sessions/` → **755**
- `storage/framework/views/` → **755**
- `storage/logs/` → **755**
- `bootstrap/cache/` → **755**

**Como fazer:**
1. Selecione a pasta
2. Clique em "Change Permissions"
3. Marque: Owner (Read, Write, Execute), Group (Read, Execute), Public (Read, Execute)

---

### 4. INSTALAR DEPENDÊNCIAS

No Terminal do cPanel:

```bash
cd /home/usuario/public_html/seu-projeto
composer install --no-dev --optimize-autoloader
```

---

### 5. CRIAR TABELAS NO BANCO

**Opção A: Via Terminal**
```bash
php artisan migrate
php artisan db:seed
```

**Opção B: Via phpMyAdmin**
1. Acesse phpMyAdmin no cPanel
2. Selecione o banco `amorexpr_teste`
3. Vá na aba "SQL"
4. Cole o conteúdo do arquivo `database.sql`
5. Execute

---

### 6. VERIFICAR VERSÃO DO PHP

1. No cPanel, vá em **Select PHP Version**
2. Selecione **PHP 8.1** ou superior
3. Ative as extensões necessárias:
   - ✅ pdo_mysql
   - ✅ mbstring
   - ✅ openssl
   - ✅ fileinfo
   - ✅ tokenizer
   - ✅ xml
   - ✅ ctype
   - ✅ json

---

### 7. AJUSTAR .htaccess

O arquivo `public_html/.htaccess` deve ter:

```apache
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>

    RewriteEngine On

    # Handle Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

    # Redirect Trailing Slashes If Not A Folder...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]

    # Send Requests To Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>
```

---

### 8. TESTAR A APLICAÇÃO

Acesse: `https://seu-dominio.com.br`

**Login padrão:**
- Email: `admin@cbf.com.br`
- Senha: `admin123`

---

## 🔧 ERROS COMUNS

### Erro 500 (Internal Server Error)
- Verifique permissões de `storage/` e `bootstrap/cache/`
- Verifique se o `.env` está configurado
- Verifique logs em `storage/logs/laravel.log`

### Erro "APP_KEY não definido"
```bash
php artisan key:generate
```

### Erro de conexão com banco
- Verifique credenciais no `.env`
- Verifique se o banco existe no cPanel
- Teste conexão via phpMyAdmin

### Erro 404 (Not Found)
- Verifique se o `.htaccess` está em `public_html/`
- Verifique se `mod_rewrite` está ativo no Apache

---

## 📞 PRECISA DE AJUDA?

Se ainda tiver problemas, me diga qual erro específico está aparecendo!

