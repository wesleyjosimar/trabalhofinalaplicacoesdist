# 🚀 Guia de Deploy em Produção - CBF Antidoping

## Passo a Passo para Deploy em Banco Externo

### 1. Preparar o Banco de Dados Externo

#### 1.1 Criar o Banco de Dados
- Acesse o painel do seu provedor (cPanel, CWP, etc.)
- Crie um novo banco de dados MySQL
- Anote: **nome do banco**, **usuário**, **senha**, **host**

#### 1.2 Criar as Tabelas
- Acesse o phpMyAdmin
- Selecione o banco criado
- Execute o arquivo `database.sql`
- Verifique se as 4 tabelas foram criadas:
  - `usuarios`
  - `sessions`
  - `atletas`
  - `testes`

### 2. Configurar o Sistema

#### 2.1 Editar config.php
Edite o arquivo `config.php` com as credenciais do banco externo:

```php
// Configurações do banco de dados - PRODUÇÃO
define('DB_HOST', 'seu-host-aqui');        // Ex: mysql.seuservidor.com.br
define('DB_PORT', '3306');
define('DB_NAME', 'seu-banco-aqui');       // Nome do banco criado
define('DB_USER', 'seu-usuario-aqui');     // Usuário do banco
define('DB_PASS', 'sua-senha-aqui');       // Senha do banco
define('DB_CHARSET', 'utf8mb4');

// Configurações da aplicação
define('APP_NAME', 'CBF Antidoping');
define('APP_URL', 'https://seu-dominio.com.br');  // URL do seu site
define('APP_DEBUG', false);  // IMPORTANTE: false em produção!
```

#### 2.2 Ajustar .htaccess (se necessário)
- Verifique se o `.htaccess` está configurado corretamente
- Se usar subdomínio, ajuste os caminhos se necessário

### 3. Fazer Upload dos Arquivos

#### 3.1 Via FTP/FileZilla
1. Conecte via FTP ao servidor
2. Navegue até a pasta do site (ex: `public_html/` ou `public_html/subdominio/`)
3. Faça upload de **TODOS** os arquivos:
   - Todos os arquivos `.php` da raiz
   - Pasta `models/`
   - Pasta `controllers/`
   - Pasta `views/`
   - Arquivo `.htaccess`
   - Arquivo `config.php` (já editado)

#### 3.2 Via File Manager (cPanel/CWP)
1. Acesse o File Manager
2. Navegue até a pasta do site
3. Faça upload de um ZIP com todos os arquivos
4. Extraia o ZIP
5. Edite o `config.php` diretamente no servidor

### 4. Criar Usuários no Banco

#### Opção A - Via phpMyAdmin (Recomendado)
1. Acesse o phpMyAdmin
2. Selecione o banco
3. Vá na aba "SQL"
4. Execute o arquivo `inserir_usuarios.sql`
5. OU execute o script PHP via SSH

#### Opção B - Via Script PHP (SSH)
```bash
cd /caminho/do/site
php criar_usuarios.php
```

### 5. Popular Dados (Opcional)

Se quiser popular com dados de exemplo:

```bash
# Via SSH
php popular_atletas.php
php popular_testes.php
```

OU execute os arquivos SQL no phpMyAdmin:
- `popular_atletas.sql`
- `popular_testes.sql`

### 6. Verificar Permissões

Certifique-se de que as permissões estão corretas:
- Arquivos PHP: `644` ou `755`
- Pastas: `755`
- `.htaccess`: `644`

### 7. Testar o Sistema

1. Acesse: `https://seu-dominio.com.br/login.php`
2. Faça login: `admin@cbf.com.br` / `admin123`
3. Verifique se tudo está funcionando:
   - Listagem de atletas
   - Listagem de testes
   - Relatórios
   - Criação de novos registros

### 8. Segurança em Produção

✅ **IMPORTANTE - Antes de colocar em produção:**

1. **Desabilitar Debug:**
   ```php
   define('APP_DEBUG', false);
   ```

2. **Alterar Senhas Padrão:**
   - Altere as senhas dos usuários padrão
   - Use senhas fortes

3. **Remover Arquivos de Teste:**
   - Remova ou proteja: `teste.php`, `testar_banco.php`
   - Remova scripts de população se não precisar mais

4. **HTTPS:**
   - Configure SSL/HTTPS no servidor
   - Atualize `APP_URL` para usar `https://`

5. **Backup:**
   - Configure backup automático do banco
   - Faça backup dos arquivos regularmente

## Checklist de Deploy

- [ ] Banco de dados criado
- [ ] Tabelas criadas (database.sql executado)
- [ ] config.php configurado com credenciais corretas
- [ ] APP_DEBUG = false
- [ ] Arquivos enviados para o servidor
- [ ] Usuários criados (inserir_usuarios.sql ou criar_usuarios.php)
- [ ] Permissões de arquivos corretas
- [ ] SSL/HTTPS configurado
- [ ] Login testado
- [ ] Funcionalidades testadas
- [ ] Backup configurado

## Suporte

Se encontrar problemas:
1. Verifique os logs de erro do PHP
2. Teste a conexão com o banco: `teste.php`
3. Verifique se todas as extensões PHP necessárias estão instaladas
4. Confirme que o caminho do banco está correto

