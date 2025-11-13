# 🚀 Início Rápido - Sistema CBF

## ✅ Status Atual

Os serviços estão rodando! ✅
- ✅ PostgreSQL (porta 5432)
- ✅ Backend (porta 3001)
- ✅ Frontend (porta 3000)

## 📱 Acessar a Aplicação

### 1. Abra seu navegador

Acesse: **http://localhost:3000**

### 2. Criar dados iniciais (SE NECESSÁRIO)

Se você ainda não executou o seed, execute:

```powershell
docker compose exec backend npm run seed
```

**Aguarde alguns segundos** para o comando concluir.

### 3. Fazer Login

**Credenciais:**
- **Email**: `admin@cbf.com.br`
- **Senha**: `admin123`

### 4. Começar a usar!

Após fazer login, você verá:
- **Dashboard** com resumo de atletas e testes
- **Menu** para navegar entre Atletas e Testes Antidoping

## 🎯 Funcionalidades Disponíveis

### Gestão de Atletas
1. Clique em **"Atletas"** no menu
2. Clique em **"Novo Atleta"** para cadastrar
3. Clique em **"Ver Detalhes"** para ver informações completas

### Gestão de Testes Antidoping
1. Clique em **"Testes Antidoping"** no menu
2. Clique em **"Novo Teste"** para registrar um teste
3. Acesse os detalhes do teste para adicionar amostras

## 🔍 Verificar se está tudo funcionando

### Testar a API diretamente

Abra o navegador e acesse:
- **Backend**: http://localhost:3001
- Você deve ver uma resposta (pode ser um erro 404, mas significa que o servidor está rodando)

### Testar o Login via API

Use o Postman, Insomnia ou curl:

```powershell
curl -X POST http://localhost:3001/auth/login ^
  -H "Content-Type: application/json" ^
  -d "{\"email\":\"admin@cbf.com.br\",\"senha\":\"admin123\"}"
```

Se retornar um token JWT, está funcionando! ✅

## ⚠️ Problemas Comuns

### Erro: "Não é possível fazer login"

**Solução:**
1. Execute o seed:
   ```powershell
   docker compose exec backend npm run seed
   ```
2. Aguarde alguns segundos
3. Tente fazer login novamente

### Erro: "Página não carrega"

**Solução:**
1. Verifique se o frontend está rodando:
   ```powershell
   docker compose logs frontend
   ```
2. Verifique se há erros nos logs
3. Tente recarregar a página (F5)

### Erro: "Erro de conexão"

**Solução:**
1. Verifique se o backend está rodando:
   ```powershell
   docker compose logs backend
   ```
2. Verifique se o PostgreSQL está saudável:
   ```powershell
   docker compose ps
   ```
3. Reinicie os serviços:
   ```powershell
   docker compose restart
   ```

## 📋 Próximos Passos

1. **Fazer login** na aplicação
2. **Cadastrar um atleta** de teste
3. **Registrar um teste antidoping** para o atleta
4. **Adicionar amostras** (A e B) ao teste
5. **Explorar** as funcionalidades da aplicação

## 🆘 Precisa de Ajuda?

1. Verifique os logs:
   ```powershell
   docker compose logs -f
   ```
2. Verifique o status:
   ```powershell
   docker compose ps
   ```
3. Consulte o arquivo `ACESSO-APLICACAO.md` para mais detalhes

