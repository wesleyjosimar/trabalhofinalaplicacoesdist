# 🏆 CBF - Sistema de Cadastro de Atletas e Testes Antidoping

Sistema web simples e monolítico desenvolvido em Laravel + Blade para gerenciamento de atletas e testes antidoping da Confederação Brasileira de Futebol (CBF).

## 📋 Características

- **Stack Simples**: Laravel 10 + Blade (PHP)
- **Banco de Dados**: MySQL/PostgreSQL
- **Arquitetura**: Monolítica, sem complexidade desnecessária
- **Autenticação**: Sistema de sessão simples
- **Interface**: Design limpo e responsivo

## 🎯 Funcionalidades

### 1. Cadastro de Atletas
- Criar, listar, editar e inativar atletas
- Campos: nome, data de nascimento, documento, clube, federação, status
- Busca e filtros

### 2. Testes Antidoping
- Registrar testes antidoping
- Editar resultado dos testes
- Listagem com filtros por atleta e resultado
- Histórico completo por atleta

### 3. Controle de Usuários
- Login com email e senha
- Dois perfis: Admin e Operacional
- Admin pode gerenciar usuários
- Operacional não pode gerenciar usuários

## 🚀 Instalação Local

### Pré-requisitos

- PHP 8.1 ou superior
- Composer
- MySQL 5.7+ ou PostgreSQL 10+
- Extensões PHP: pdo, pdo_mysql (ou pdo_pgsql), mbstring, openssl, tokenizer, xml, ctype, json

### Passo a Passo

1. **Clone ou baixe o projeto**
```bash
cd projetofinalfabiano
```

2. **Instale as dependências**
```bash
composer install
```

3. **Configure o ambiente**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Configure o banco de dados no arquivo `.env`**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=cbf_antidoping
DB_USERNAME=seu_usuario
DB_PASSWORD=sua_senha
```

5. **Crie o banco de dados**
```sql
CREATE DATABASE cbf_antidoping CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

6. **Execute as migrations**
```bash
php artisan migrate
```

7. **Popule o banco com usuários padrão (opcional)**
```bash
php artisan db:seed
```

Isso criará dois usuários:
- **Admin**: email: `admin@cbf.com.br` | senha: `admin123`
- **Operador**: email: `operador@cbf.com.br` | senha: `operador123`

8. **Inicie o servidor de desenvolvimento**
```bash
php artisan serve
```

9. **Acesse no navegador**
```
http://localhost:8000
```

## 🌐 Deploy em Servidor

### Opção 1: Apache

1. **Configure o Virtual Host**
```apache
<VirtualHost *:80>
    ServerName seu-dominio.com.br
    DocumentRoot /caminho/para/projeto/public
    
    <Directory /caminho/para/projeto/public>
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

2. **Configure permissões**
```bash
chmod -R 755 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

3. **Configure o `.env` para produção**
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://seu-dominio.com.br
```

### Opção 2: Nginx

1. **Configure o servidor**
```nginx
server {
    listen 80;
    server_name seu-dominio.com.br;
    root /caminho/para/projeto/public;
    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```

2. **Configure permissões**
```bash
chmod -R 755 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### Opção 3: Servidor Compartilhado (cPanel, etc.)

1. Faça upload dos arquivos via FTP
2. Configure o `.env` com as credenciais do banco
3. Execute via SSH:
```bash
composer install --no-dev --optimize-autoloader
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## 📊 Estrutura do Banco de Dados

### Tabela: `usuarios`
- `id` (bigint, primary key)
- `nome` (string)
- `email` (string, unique)
- `senha` (string, hashed)
- `perfil` (enum: 'admin', 'operacional')
- `created_at`, `updated_at` (timestamps)

### Tabela: `atletas`
- `id` (bigint, primary key)
- `nome` (string)
- `data_nascimento` (date)
- `documento` (string, unique)
- `clube` (string, nullable)
- `federacao` (string, nullable)
- `status` (enum: 'ativo', 'inativo')
- `created_at`, `updated_at` (timestamps)

### Tabela: `testes`
- `id` (bigint, primary key)
- `atleta_id` (bigint, foreign key -> atletas.id)
- `data_coleta` (date)
- `competicao` (string, nullable)
- `laboratorio` (string)
- `resultado` (enum: 'pendente', 'negativo', 'positivo')
- `observacoes` (text, nullable)
- `created_at`, `updated_at` (timestamps)

### Tabela: `sessions`
- Usada para armazenar sessões de usuários

## 🛣️ Rotas da Aplicação

### Públicas
- `GET /login` - Tela de login
- `POST /login` - Processar login
- `POST /logout` - Fazer logout

### Protegidas (requerem autenticação)
- `GET /` - Redireciona para /atletas
- `GET /atletas` - Lista de atletas
- `GET /atletas/create` - Formulário de novo atleta
- `POST /atletas` - Criar atleta
- `GET /atletas/{id}` - Detalhes do atleta
- `GET /atletas/{id}/edit` - Formulário de edição
- `PUT /atletas/{id}` - Atualizar atleta
- `DELETE /atletas/{id}` - Inativar atleta
- `GET /testes` - Lista de testes
- `GET /testes/create` - Formulário de novo teste
- `POST /testes` - Criar teste
- `GET /testes/{id}/edit` - Formulário de edição
- `PUT /testes/{id}` - Atualizar teste

### Apenas Admin
- `GET /usuarios` - Lista de usuários
- `GET /usuarios/create` - Formulário de novo usuário
- `POST /usuarios` - Criar usuário
- `GET /usuarios/{id}/edit` - Formulário de edição
- `PUT /usuarios/{id}` - Atualizar usuário
- `DELETE /usuarios/{id}` - Excluir usuário

## 🔐 Segurança

- Senhas são hasheadas com bcrypt
- Middleware de autenticação protege rotas
- Middleware de admin protege rotas administrativas
- Validação de dados em todos os formulários
- Proteção CSRF em todos os formulários

## 📝 Notas Importantes

- **Primeiro acesso**: Use o usuário admin criado pelo seeder
- **Alterar senhas**: Faça login como admin e edite os usuários
- **Backup**: Faça backup regular do banco de dados
- **Produção**: Sempre defina `APP_DEBUG=false` em produção

## 🐛 Solução de Problemas

### Erro: "Class not found"
```bash
composer dump-autoload
```

### Erro de permissões
```bash
chmod -R 755 storage bootstrap/cache
```

### Limpar cache
```bash
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear
```

### Recriar banco de dados
```bash
php artisan migrate:fresh
php artisan db:seed
```

## 📞 Suporte

Para dúvidas ou problemas, consulte a documentação do Laravel: https://laravel.com/docs

---

**Desenvolvido para a Confederação Brasileira de Futebol (CBF)**

