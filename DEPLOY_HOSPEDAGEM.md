================================================================================
  DEPLOY EM HOSPEDAGEM PHP TRADICIONAL (Apache/Nginx)
================================================================================

Este projeto está configurado para rodar em qualquer hospedagem PHP comum.

================================================================================
  REQUISITOS DA HOSPEDAGEM
================================================================================

- PHP 8.1 ou superior
- Extensões PHP: pdo, pdo_mysql, mbstring, openssl, tokenizer
- MySQL 5.7+ ou MariaDB 10.3+
- Apache com mod_rewrite OU Nginx
- Composer (para instalar dependências)

================================================================================
  PASSO A PASSO PARA DEPLOY
================================================================================

1. FAZER UPLOAD DOS ARQUIVOS
   - Faça upload de TODOS os arquivos para a raiz do seu domínio
   - OU para uma subpasta (ex: /public_html/cbf)
   - Mantenha a estrutura de pastas intacta

2. CONFIGURAR PERMISSÕES
   Via SSH ou painel de controle:
   chmod -R 755 storage
   chmod -R 755 bootstrap/cache

3. INSTALAR DEPENDÊNCIAS
   Via SSH:
   cd /caminho/do/projeto
   composer install --no-dev --optimize-autoloader

4. CONFIGURAR BANCO DE DADOS
   - Crie o banco de dados no painel da hospedagem
   - Anote: host, database, username, password

5. CRIAR ARQUIVO .env
   Crie um arquivo .env na raiz do projeto com:

   APP_NAME=CBF_Antidoping
   APP_ENV=production
   APP_DEBUG=false
   APP_KEY=GERAR_AQUI
   APP_URL=https://seu-dominio.com.br

   DB_CONNECTION=mysql
   DB_HOST=localhost
   DB_PORT=3306
   DB_DATABASE=amorexpr_teste
   DB_USERNAME=amorexpr_admin
   DB_PASSWORD=Testando@09

   SESSION_DRIVER=database
   LOG_CHANNEL=stack

6. GERAR APP_KEY
   Via SSH:
   php artisan key:generate

7. EXECUTAR MIGRATIONS
   Via SSH:
   php artisan migrate --force
   php artisan db:seed --force

8. CONFIGURAR APACHE (se necessário)
   Se usar Apache, o .htaccess já está configurado.
   Certifique-se que mod_rewrite está habilitado.

9. CONFIGURAR NGINX (se necessário)
   Veja exemplo de configuração abaixo.

================================================================================
  CONFIGURAÇÃO NGINX
================================================================================

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

    location ~ /\.(?!well-known).* {
        deny all;
    }
}

================================================================================
  CONFIGURAÇÃO APACHE (.htaccess)
================================================================================

O arquivo public/.htaccess já está configurado.
Certifique-se que:
- mod_rewrite está habilitado
- AllowOverride está como "All" no VirtualHost

================================================================================
  AJUSTAR DOCUMENT ROOT
================================================================================

IMPORTANTE: O Document Root deve apontar para a pasta PUBLIC!

Apache:
  DocumentRoot /caminho/para/projeto/public

Nginx:
  root /caminho/para/projeto/public;

cPanel:
  - Vá em "Subdomínios" ou "Addon Domains"
  - Configure o Document Root para: public_html/seu-dominio/public

================================================================================
  TESTAR
================================================================================

1. Acesse: https://seu-dominio.com.br
2. Deve redirecionar para: https://seu-dominio.com.br/login
3. Login: admin@cbf.com.br / admin123

================================================================================
  TROUBLESHOOTING
================================================================================

Erro 500:
- Verifique permissões: chmod -R 755 storage bootstrap/cache
- Verifique logs: storage/logs/laravel.log
- Ative debug temporariamente: APP_DEBUG=true

Erro 404:
- Verifique se Document Root aponta para /public
- Verifique se mod_rewrite está habilitado (Apache)
- Verifique configuração do Nginx

Erro de banco:
- Verifique credenciais no .env
- Teste conexão via SSH: php artisan tinker

================================================================================

