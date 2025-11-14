# ✅ Checklist de Deploy no Render

Use este checklist para acompanhar seu progresso durante o deploy.

---

## 📋 Pré-requisitos

- [ ] Código commitado e enviado para o Git (GitHub/GitLab)
- [ ] URL do repositório Git anotada
- [ ] Conta criada no Render (https://render.com)
- [ ] Acesso ao Render funcionando

---

## 🗄️ PASSO 1: PostgreSQL

- [ ] Render acessado e logado
- [ ] PostgreSQL criado (New + → PostgreSQL)
- [ ] Nome: `cbf-postgres`
- [ ] Database: `cbf_db`
- [ ] Região selecionada
- [ ] Plano selecionado (Free ou Starter)
- [ ] Deploy do PostgreSQL concluído
- [ ] Status: Available
- [ ] Credenciais anotadas:
  - [ ] Internal Database URL: `[ANOTADA]`
  - [ ] External Database URL: `[ANOTADA]`
  - [ ] Host: `[ANOTADO]`
  - [ ] Port: `5432`
  - [ ] User: `[ANOTADO]`
  - [ ] Password: `[ANOTADA]`
  - [ ] Database: `cbf_db`

---

## 🔧 PASSO 2: Backend

- [ ] Web Service criado no Render (New + → Web Service)
- [ ] Repositório conectado
- [ ] Nome: `cbf-backend`
- [ ] Região: (mesma do PostgreSQL)
- [ ] Branch: `main` (ou `master`)
- [ ] Root Directory: `backend`
- [ ] Runtime: `Node`
- [ ] Build Command: `npm install && npm run build`
- [ ] Start Command: `npm run start:prod`
- [ ] Instance Type: `Free` ou `Starter`
- [ ] Variáveis de ambiente configuradas:
  - [ ] `DB_HOST=[HOST]` ou `DATABASE_URL=[URL COMPLETA]`
  - [ ] `DB_PORT=5432` (se não usar DATABASE_URL)
  - [ ] `DB_USER=[USUÁRIO]` (se não usar DATABASE_URL)
  - [ ] `DB_PASSWORD=[SENHA]` (se não usar DATABASE_URL)
  - [ ] `DB_NAME=cbf_db` (se não usar DATABASE_URL)
  - [ ] `JWT_SECRET=[GERADO]`
  - [ ] `JWT_EXPIRES_IN=24h`
  - [ ] `PORT=3001`
  - [ ] `NODE_ENV=production`
  - [ ] `FRONTEND_URL=[DEIXAR VAZIO POR ENQUANTO]`
- [ ] Auto-Deploy habilitado
- [ ] Deploy do backend iniciado
- [ ] Build concluído com sucesso
- [ ] Deploy concluído
- [ ] Status: Live
- [ ] Health check testado: `https://[URL-BACKEND]/health` → `{"status":"ok"}`
- [ ] URL do backend anotada: `[URL]`

---

## 🎨 PASSO 3: Frontend

- [ ] Static Site criado no Render (New + → Static Site)
- [ ] Repositório conectado (mesmo repositório)
- [ ] Nome: `cbf-frontend`
- [ ] Branch: `main` (ou `master`)
- [ ] Root Directory: `frontend`
- [ ] Build Command: `npm install && npm run build`
- [ ] Publish Directory: `dist`
- [ ] Variáveis de ambiente configuradas:
  - [ ] `VITE_API_URL=https://[URL-DO-BACKEND]`
- [ ] Deploy do frontend iniciado
- [ ] Build concluído com sucesso
- [ ] Deploy concluído
- [ ] Status: Live
- [ ] URL do frontend anotada: `[URL]`

---

## 🔄 PASSO 4: Atualizar Variáveis

- [ ] Acessado serviço `cbf-backend` no Render
- [ ] Vá em Environment (aba no topo)
- [ ] Encontrado variável `FRONTEND_URL`
- [ ] Atualizado `FRONTEND_URL` com URL do frontend
- [ ] Salvo as alterações
- [ ] Redeploy automático ou manual executado
- [ ] Redeploy concluído com sucesso

---

## 🌱 PASSO 5: Seed (Dados Iniciais)

- [ ] Acessado Shell do Render (serviço `cbf-backend`)
- [ ] Aba "Shell" clicada
- [ ] Executado: `npm run seed:completo`
- [ ] Seed executado com sucesso
- [ ] Mensagem de sucesso visualizada:
  ```
  ✅ Seed concluído com sucesso!
  📊 Resumo: [dados criados]
  ```

---

## 🧪 PASSO 6: Testes

### Backend
- [ ] Acessado: `https://[URL-BACKEND]`
- [ ] Informações da API exibidas
- [ ] Acessado: `https://[URL-BACKEND]/health`
- [ ] Retornou: `{"status":"ok"}`

### Frontend
- [ ] Acessado: `https://[URL-FRONTEND]`
- [ ] Aplicação React carregou
- [ ] Tela de login exibida
- [ ] Login testado:
  - [ ] Email: `admin@cbf.com.br`
  - [ ] Senha: `admin123`
  - [ ] Login bem-sucedido
- [ ] Funcionalidades testadas:
  - [ ] Visualizar atletas
  - [ ] Visualizar testes antidoping
  - [ ] Cadastrar novo atleta (opcional)
  - [ ] Registrar novo teste (opcional)

---

## 📝 Documentação

- [ ] URLs anotadas:
  - [ ] Frontend: `[URL]`
  - [ ] Backend: `[URL]`
  - [ ] Health Check: `[URL]/health`
- [ ] Credenciais salvas em local seguro
- [ ] JWT_SECRET salvo em local seguro
- [ ] Senha do banco salva em local seguro
- [ ] Internal Database URL salva

---

## 🎉 Concluído!

- [ ] ✅ Deploy completo e funcionando
- [ ] ✅ Aplicação acessível
- [ ] ✅ Login funcionando
- [ ] ✅ Funcionalidades testadas

---

## 📚 Próximos Passos (Opcional)

- [ ] Configurar domínio customizado
- [ ] Configurar backup do banco de dados
- [ ] Configurar monitoramento (plano Starter)
- [ ] Documentar URLs e credenciais
- [ ] Considerar upgrade para Starter (se necessário)

---

## 🆘 Problemas Encontrados

Anote aqui qualquer problema encontrado durante o deploy:

```
[Anotar problemas aqui]
```

---

## 💡 Dicas Importantes

- ⚠️ **Plano Free**: Aplicação "dorme" após 15 min de inatividade
- ✅ Use **Internal Database URL** quando possível (mais seguro)
- ✅ **Root Directory** não deve ter barra no final
- ✅ Verifique logs se algo não funcionar
- ✅ Primeira requisição após "dormir" pode levar 30-60 segundos

---

**Dica**: Marque cada item conforme for completando. Isso ajuda a não esquecer nenhum passo importante!

