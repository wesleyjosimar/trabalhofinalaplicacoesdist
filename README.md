# 🏆 CBF - Sistema de Cadastro de Atletas e Testes Antidoping

Sistema web simples e monolítico desenvolvido em Laravel + Blade para gerenciamento de atletas e testes antidoping da Confederação Brasileira de Futebol (CBF).

> **Nota**: Este repositório contém a versão monolítica em Laravel. A versão anterior (NestJS + React) está nas pastas `backend/` e `frontend/`.

## 📋 Características

- **Stack Simples**: Laravel 10 + Blade (PHP)
- **Banco de Dados**: MySQL
- **Arquitetura**: Monolítica, sem complexidade desnecessária
- **Autenticação**: Sistema de sessão simples
- **Interface**: Design limpo e responsivo
- **Deploy**: Hospedagem PHP tradicional (Apache/Nginx)

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

### Passo a Passo

1. **Instale as dependências**
```bash
composer install
```

2. **Configure o ambiente**
```bash
cp .env.example .env
php artisan key:generate
```

3. **Configure o banco de dados no arquivo `.env`**
```env
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=cbf_antidoping
DB_USERNAME=seu_usuario_mysql
DB_PASSWORD=sua_senha_mysql
```

4. **Execute as migrations**
```bash
php artisan migrate
php artisan db:seed
```

5. **Inicie o servidor**
```bash
php artisan serve
```

6. **Acesse**: `http://localhost:8000`

**Login padrão:**
- Email: `admin@cbf.com.br`
- Senha: `admin123`

## ☁️ Deploy em Hospedagem PHP

O projeto está pronto para deploy em qualquer hospedagem PHP tradicional (Apache/Nginx).

### Instruções de Deploy

Para instruções detalhadas de deploy em hospedagem compartilhada, veja: `DEPLOY_HOSPEDAGEM.md`

**Resumo rápido:**
1. Faça upload dos arquivos
2. Configure o Document Root para a pasta `public`
3. Crie o banco MySQL
4. Configure o arquivo `.env`
5. Execute: `composer install`, `php artisan migrate`, `php artisan db:seed`

## 📊 Estrutura do Banco de Dados

- **usuarios**: Usuários do sistema (admin/operacional)
- **atletas**: Cadastro de atletas
- **testes**: Registro de testes antidoping
- **sessions**: Sessões de usuários

## 🛣️ Rotas Principais

- `/login` - Tela de login
- `/atletas` - Lista de atletas
- `/testes` - Lista de testes
- `/usuarios` - Gerenciar usuários (apenas admin)

## 📝 Scripts Disponíveis

- `INSTALAR.bat` - Instalação automática (Windows)
- `INICIAR.bat` - Iniciar servidor de desenvolvimento (Windows)

## 🔐 Segurança

- Senhas hasheadas com bcrypt
- Middleware de autenticação
- Validação de dados
- Proteção CSRF

## 📞 Suporte

Para dúvidas, consulte a documentação do Laravel: https://laravel.com/docs

---

**Desenvolvido para a Confederação Brasileira de Futebol (CBF)**
