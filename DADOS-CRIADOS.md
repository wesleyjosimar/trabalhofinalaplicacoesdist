# 📊 Dados Criados no Sistema CBF

## ✅ Seed Executado com Sucesso!

O sistema foi alimentado com dados de exemplo para testes e demonstração.

## 📋 Resumo dos Dados Criados

### Federações (2)
- ✅ **CBF** - Confederação Brasileira de Futebol (nacional)
- ✅ **FPF** - Federação Paulista de Futebol (estadual)

### Clubes (6)
- ✅ **Palmeiras** - São Paulo, SP
- ✅ **Corinthians** - São Paulo, SP
- ✅ **Flamengo** - Rio de Janeiro, RJ
- ✅ **São Paulo** - São Paulo, SP
- ✅ **Santos** - Santos, SP
- ✅ **Clube de Teste** - São Paulo, SP

### Laboratórios (3)
- ✅ **Laboratório Brasileiro de Controle de Dopagem** (LBCD001)
- ✅ **Laboratório de Análises Antidoping** (LAA002)
- ✅ **Laboratório de Teste** (LAB001)

### Usuários (3)
1. **admin@cbf.com.br** / admin123 (CBF) - Administrador
2. **lab@teste.com.br** / lab123 (LABORATORIO) - Laboratório
3. **federacao@fpf.com.br** / fpf123 (FEDERACAO) - Federação

### Competições (2)
- ✅ **Campeonato Brasileiro Série A 2024** (CBF)
- ✅ **Campeonato Paulista 2024** (FPF)

### Atletas (5)
1. **João Silva** - Palmeiras - Atacante
2. **Maria Santos** - Corinthians - Meio-campo
3. **Pedro Oliveira** - Flamengo - Goleiro
4. **Ana Costa** - São Paulo - Defensor
5. **Carlos Ferreira** - Santos - Atacante

### Testes Antidoping (4)
1. ✅ **João Silva** - Campeonato Brasileiro (15/05/2024) - **Resultado: NEGATIVO**
2. ✅ **Maria Santos** - Campeonato Brasileiro (20/05/2024) - **Resultado: POSITIVO**
3. ✅ **Pedro Oliveira** - Campeonato Paulista (10/02/2024) - **Pendente**
4. ✅ **Ana Costa** - Campeonato Paulista (05/03/2024) - **Pendente**

### Amostras (8)
- Cada teste possui 2 amostras (A e B)
- Total: 8 amostras criadas
- 2 amostras com resultados (1 negativo, 1 positivo)
- 6 amostras pendentes de análise

### Resultados (2)
1. ✅ **Teste 1** - João Silva - **NEGATIVO** (sem substâncias proibidas)
2. ✅ **Teste 2** - Maria Santos - **POSITIVO** (Anabolizante - 10 ng/mL)

## 🎯 Como Usar os Dados

### 1. Fazer Login

Acesse: **http://localhost:3000**

Use uma das credenciais:
- **admin@cbf.com.br** / admin123 (acesso completo)
- **lab@teste.com.br** / lab123 (laboratório)
- **federacao@fpf.com.br** / fpf123 (federação)

### 2. Visualizar Dados

Após fazer login, você poderá:
- ✅ Ver atletas cadastrados (5 atletas)
- ✅ Ver testes antidoping (4 testes)
- ✅ Ver resultados dos testes (2 resultados)
- ✅ Ver amostras (8 amostras)
- ✅ Ver competições (2 competições)
- ✅ Ver clubes (6 clubes)

### 3. Explorar Funcionalidades

- **Dashboard**: Ver resumo de atletas e testes
- **Atletas**: Listar e ver detalhes dos atletas
- **Testes Antidoping**: Listar e ver detalhes dos testes
- **Resultados**: Ver resultados dos testes (negativo e positivo)

## 📊 Dados de Exemplo

### Teste com Resultado Negativo
- **Atleta**: João Silva
- **Competição**: Campeonato Brasileiro Série A 2024
- **Data**: 15/05/2024
- **Resultado**: NEGATIVO
- **Detalhes**: Sem substâncias proibidas

### Teste com Resultado Positivo
- **Atleta**: Maria Santos
- **Competição**: Campeonato Brasileiro Série A 2024
- **Data**: 20/05/2024
- **Resultado**: POSITIVO
- **Substância**: Anabolizante
- **Concentração**: 10 ng/mL

### Testes Pendentes
- **Pedro Oliveira** - Campeonato Paulista (pendente de análise)
- **Ana Costa** - Campeonato Paulista (pendente de análise)

## 🔄 Adicionar Mais Dados

Se quiser adicionar mais dados, você pode:

1. **Usar a interface web**: Cadastrar novos atletas, testes, etc.
2. **Executar o seed novamente**: Ele não duplicará dados existentes
3. **Usar a API diretamente**: Fazer requisições POST para criar novos dados

## 🧹 Limpar Dados

Se quiser limpar todos os dados e começar do zero:

```powershell
# Parar containers
docker compose down

# Remover volumes (apaga dados do banco)
docker compose down -v

# Reiniciar
docker compose up -d

# Executar seed novamente
docker compose exec backend npm run seed:completo
```

## 📝 Notas

- Os dados são apenas para desenvolvimento e testes
- As senhas são fracas (apenas para testes)
- Os dados incluem exemplos de testes negativos e positivos
- Todas as amostras têm códigos únicos
- Os testes estão associados a competições reais

## 🎉 Pronto para Usar!

O sistema está completamente alimentado e pronto para uso. Faça login e explore as funcionalidades!

