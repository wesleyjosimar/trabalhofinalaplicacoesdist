# ✅ Checklist Pré-Commit para Render

## 📋 Antes de Fazer Commit

### 1. Verificar Arquivos Sensíveis
- [ ] Nenhum arquivo `.env` está sendo commitado
- [ ] Nenhuma senha ou token está hardcoded no código
- [ ] `env.example` está atualizado (sem valores reais)

### 2. Verificar Build
- [ ] Backend compila sem erros: `cd backend && npm run build`
- [ ] Frontend compila sem erros: `cd frontend && npm run build`
- [ ] Não há erros de TypeScript

### 3. Verificar .gitignore
- [ ] `.gitignore` na raiz existe e está correto
- [ ] `node_modules/` está ignorado
- [ ] `dist/` está ignorado
- [ ] `.env` está ignorado
- [ ] Arquivos temporários estão ignorados

### 4. Verificar Estrutura
- [ ] `backend/package.json` tem `@nestjs/cli` em `dependencies`
- [ ] `backend/package.json` tem script `start:prod`
- [ ] `frontend/package.json` tem script `build`
- [ ] `env.example` existe no backend

### 5. Documentação
- [ ] `README.md` está atualizado
- [ ] `DEPLOY-RENDER.md` está atualizado
- [ ] `INTEGRACAO.md` está atualizado (se necessário)

## 🚀 Comandos para Commit

```bash
# 1. Verificar status
git status

# 2. Adicionar arquivos (não adiciona .env, node_modules, dist)
git add .

# 3. Verificar o que será commitado
git status

# 4. Fazer commit
git commit -m "feat: preparar projeto para deploy no Render"

# 5. Push para o repositório
git push origin main
```

## ⚠️ Importante

- **NUNCA** commite arquivos `.env` com credenciais reais
- **SEMPRE** use `env.example` como template
- Verifique `git status` antes de cada commit
- Teste o build localmente antes de fazer push

## 📝 Arquivos que DEVEM ser commitados

✅ Código fonte (`.ts`, `.tsx`, `.js`, `.jsx`)
✅ Configurações (`package.json`, `tsconfig.json`, `vite.config.ts`)
✅ Documentação (`.md`)
✅ `env.example` (sem valores reais)
✅ `.gitignore`
✅ Arquivos de configuração do projeto

## 🚫 Arquivos que NÃO devem ser commitados

❌ `.env` (com credenciais)
❌ `node_modules/`
❌ `dist/` ou `build/`
❌ Arquivos de log (`.log`)
❌ Arquivos temporários
❌ Credenciais ou tokens

