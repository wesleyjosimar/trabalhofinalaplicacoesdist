# 🔐 Credenciais de Login - Sistema CBF

## Usuários de Teste

### 1. Administrador CBF (Recomendado)

**Email:** `admin@cbf.com.br`  
**Senha:** `admin123`  
**Perfil:** CBF  
**Permissões:** Todas (cadastrar atletas, testes, etc.)

### 2. Laboratório

**Email:** `lab@teste.com.br`  
**Senha:** `lab123`  
**Perfil:** LABORATORIO  
**Permissões:** Registrar resultados de testes

## Como Fazer Login

### 1. Acesse a Aplicação

Abra seu navegador e acesse:
- **http://localhost:3000**

### 2. Tela de Login

Você verá a tela de login da aplicação.

### 3. Digite as Credenciais

- **Email:** `admin@cbf.com.br`
- **Senha:** `admin123`

### 4. Clique em "Entrar"

Após clicar em "Entrar", você será redirecionado para o Dashboard.

## ⚠️ Se Não Conseguir Fazer Login

### Problema: "Credenciais inválidas"

Isso significa que os dados iniciais (seed) ainda não foram criados.

### Solução: Executar o Seed

Execute o seguinte comando para criar os dados iniciais:

```powershell
docker compose exec backend npm run seed
```

**Aguarde alguns segundos** para o comando concluir.

Você deve ver mensagens como:
- "Conectado ao banco de dados"
- "Federação criada"
- "Clube criado"
- "Laboratório criado"
- "Usuário admin criado"
- "Usuário laboratório criado"
- "Seed concluído!"

### Após Executar o Seed

1. Aguarde alguns segundos
2. Tente fazer login novamente
3. Use as credenciais:
   - Email: `admin@cbf.com.br`
   - Senha: `admin123`

## 📋 Verificar se o Seed Foi Executado

### Opção 1: Verificar Logs

```powershell
docker compose logs backend | Select-String -Pattern "Seed"
```

### Opção 2: Executar o Seed Novamente

```powershell
docker compose exec backend npm run seed
```

Se os dados já existirem, você verá mensagens indicando que já foram criados.

## 🎯 Após Fazer Login

Após fazer login com sucesso, você verá:

1. **Dashboard** - Resumo de atletas e testes
2. **Menu de Navegação** - Atletas, Testes Antidoping
3. **Funcionalidades**:
   - Cadastrar atletas
   - Registrar testes antidoping
   - Adicionar amostras
   - Ver relatórios

## 🔒 Segurança

**⚠️ IMPORTANTE:** Estas credenciais são apenas para desenvolvimento e testes.  
**NÃO use essas credenciais em produção!**

Em produção, você deve:
1. Alterar as senhas
2. Criar usuários com senhas seguras
3. Implementar políticas de senha
4. Configurar autenticação de dois fatores (2FA)

## 🆘 Ainda com Problemas?

Se ainda não conseguir fazer login:

1. **Verifique se o backend está rodando:**
   ```powershell
   docker compose ps
   ```

2. **Verifique os logs do backend:**
   ```powershell
   docker compose logs backend -f
   ```

3. **Teste a API diretamente:**
   ```powershell
   curl -X POST http://localhost:3001/auth/login -H "Content-Type: application/json" -d "{\"email\":\"admin@cbf.com.br\",\"senha\":\"admin123\"}"
   ```

4. **Verifique se o banco de dados está acessível:**
   ```powershell
   docker compose logs postgres
   ```

5. **Reinicie os serviços:**
   ```powershell
   docker compose restart
   ```

