# 🏆 CBF - Sistema de Cadastro de Atletas e Testes Antidoping

Sistema web simples e monolítico desenvolvido em Laravel + Blade para gerenciamento de atletas e testes antidoping da Confederação Brasileira de Futebol (CBF).

> **Nota**: Este repositório contém a versão monolítica em Laravel. A versão anterior (NestJS + React) está nas pastas `backend/` e `frontend/`.

## 📋 Características

- **Stack Simples**: Laravel 10 + Blade (PHP)
- **Banco de Dados**: MySQL/PostgreSQL
- **Arquitetura**: Monolítica, sem complexidade desnecessária
- **Autenticação**: Sistema de sessão simples
- **Interface**: Design limpo e responsivo
- **Deploy**: Configurado para Render.com

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
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=cbf_antidoping
DB_USERNAME=seu_usuario
DB_PASSWORD=sua_senha
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

## ☁️ Deploy no Render

O projeto está configurado para deploy automático no Render.com.

### Configuração Rápida

1. Conecte este repositório ao Render
2. Crie um banco PostgreSQL no Render
3. Configure as variáveis de ambiente (veja `INSTRUCOES_RENDER.txt`)
4. O deploy será automático via `render.yaml`

Para instruções detalhadas, veja: `INSTRUCOES_RENDER.txt`

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
- `INICIAR.bat` - Iniciar servidor (Windows)
- `build.sh` - Script de build para produção
- `deploy.sh` - Script de deploy

## 🔐 Segurança

- Senhas hasheadas com bcrypt
- Middleware de autenticação
- Validação de dados
- Proteção CSRF

## 📞 Suporte

Para dúvidas, consulte a documentação do Laravel: https://laravel.com/docs

---

**Desenvolvido para a Confederação Brasileira de Futebol (CBF)**
