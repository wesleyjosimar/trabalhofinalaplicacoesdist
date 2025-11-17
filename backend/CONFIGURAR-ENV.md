# 🔧 Configurar Variáveis de Ambiente

## 📝 Criar arquivo .env

1. Copie o arquivo de exemplo:
```bash
cd backend
cp env.example .env
```

2. Edite o arquivo `.env` e configure com as credenciais do PostgreSQL:

```env
# Banco de Dados PostgreSQL (Render)
DB_HOST=dpg-d4b7d60dl3ps7397gdbg-a.oregon-postgres.render.com
DB_PORT=5432
DB_USER=cbf_postgres_user
DB_PASSWORD=aiLhGACmjSaagb3ndX7EZo0BnQL4h9pu
DB_NAME=cbf_postgres

# JWT - GERAR UMA CHAVE SEGURA
JWT_SECRET=[GERAR COM O COMANDO ABAIXO]
JWT_EXPIRES_IN=24h

# Aplicação
PORT=3001
NODE_ENV=development

# Frontend URL (para CORS)
FRONTEND_URL=http://localhost:3000
```

## 🔐 Gerar JWT_SECRET

**Windows PowerShell:**
```powershell
[Convert]::ToBase64String((1..32 | ForEach-Object { Get-Random -Minimum 0 -Maximum 256 }))
```

**Linux/Mac:**
```bash
openssl rand -base64 32
```

Copie o resultado e cole no lugar de `[GERAR COM O COMANDO ABAIXO]` no arquivo `.env`.

## ✅ Testar Conexão

Após configurar o `.env`, teste a conexão:

```bash
cd backend
npm run start:dev
```

Se conectar corretamente, você verá:
```
Application is running on: http://0.0.0.0:3001
```

## 🚀 Próximos Passos

1. ✅ Configurar `.env` com as credenciais
2. ✅ Gerar `JWT_SECRET`
3. ✅ Testar conexão com `npm run start:dev`
4. ✅ Executar seed: `npm run seed:completo`

