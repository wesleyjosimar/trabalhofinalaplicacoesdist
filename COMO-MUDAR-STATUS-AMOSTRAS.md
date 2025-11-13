# 🔄 Como Mudar o Status das Amostras

## 📋 Status Disponíveis

As amostras podem ter os seguintes status:

1. **PENDENTE** - Amostra coletada, aguardando análise
2. **ANALISADA** - Amostra foi analisada pelo laboratório
3. **NEGATIVA** - Resultado negativo (sem substâncias proibidas)
4. **POSITIVA** - Resultado positivo (substância proibida encontrada)
5. **INCONCLUSIVA** - Resultado inconclusivo

## 🔄 Fluxo de Mudança de Status

### Fluxo Automático (ao Registrar Resultado)

Quando um laboratório registra um resultado:

1. **Amostra PENDENTE** → **ANALISADA** (automático)
2. **ANALISADA** → **NEGATIVA** ou **POSITIVA** ou **INCONCLUSIVA** (baseado no resultado)

### Fluxo Manual (via Interface)

Você pode mudar o status manualmente através da interface:

1. Acesse os **detalhes do teste**
2. Na tabela de amostras, você verá um **seletor de status**
3. Selecione o novo status
4. O status será atualizado automaticamente

## 🎯 Como Usar

### Opção 1: Via Interface Web

1. **Acesse a aplicação**: http://localhost:3000
2. **Faça login** com `admin@cbf.com.br` / `admin123`
3. **Vá para "Testes Antidoping"** no menu
4. **Clique em um teste** para ver os detalhes
5. **Na tabela de amostras**, você verá:
   - Status atual da amostra
   - Um **seletor dropdown** (se a amostra estiver pendente ou analisada)
6. **Selecione o novo status** no dropdown
7. **Confirme a alteração**

### Opção 2: Via API (para Laboratórios)

#### Endpoint

```
PATCH /antidoping/amostras/:id/status
```

#### Headers

```
Authorization: Bearer <token>
Content-Type: application/json
```

#### Body

```json
{
  "status": "ANALISADA"
}
```

#### Exemplo com cURL

```bash
curl -X PATCH http://localhost:3001/antidoping/amostras/{amostraId}/status \
  -H "Authorization: Bearer <seu-token>" \
  -H "Content-Type: application/json" \
  -d '{"status": "ANALISADA"}'
```

## 📊 Regras de Negócio

### Validações

1. **PENDENTE → ANALISADA**: ✅ Permitido
2. **ANALISADA → NEGATIVA/POSITIVA/INCONCLUSIVA**: ✅ Permitido (mas requer resultado registrado)
3. **PENDENTE → POSITIVA/NEGATIVA**: ❌ Não permitido (precisa estar analisada primeiro)
4. **POSITIVA/NEGATIVA → PENDENTE**: ❌ Não permitido (não pode voltar)

### Status que Requerem Resultado

- **POSITIVA**: Requer resultado registrado com tipo POSITIVO
- **NEGATIVA**: Requer resultado registrado com tipo NEGATIVO

### Status Automáticos

Quando você registra um resultado:
- Se resultado = **POSITIVO** → Status vira **POSITIVA** automaticamente
- Se resultado = **NEGATIVO** → Status vira **NEGATIVA** automaticamente
- Se resultado = **INCONCLUSIVO** → Status vira **INCONCLUSIVA** automaticamente

## 🔍 Verificar Status Atual

### Via Interface

1. Acesse os detalhes do teste
2. Veja a coluna "Status" na tabela de amostras

### Via API

```
GET /antidoping/testes/:id
```

Retorna todas as amostras com seus status.

## 📝 Exemplos Práticos

### Exemplo 1: Marcar Amostra como Analisada

**Situação**: Laboratório analisou a amostra, mas ainda não registrou o resultado.

**Ação**:
1. Acesse os detalhes do teste
2. Encontre a amostra na tabela
3. Selecione "ANALISADA" no dropdown
4. Confirme

**Resultado**: Status muda de PENDENTE para ANALISADA

### Exemplo 2: Registrar Resultado (Automático)

**Situação**: Laboratório registra resultado do teste.

**Ação**:
1. Acesse os detalhes do teste
2. Clique em "Registrar Resultado" (se disponível)
3. Preencha os dados do resultado
4. Selecione o tipo: NEGATIVO, POSITIVO ou INCONCLUSIVO

**Resultado**: Status muda automaticamente para NEGATIVA, POSITIVA ou INCONCLUSIVA

### Exemplo 3: Ajustar Status Manualmente

**Situação**: Status precisa ser ajustado manualmente.

**Ação**:
1. Acesse os detalhes do teste
2. Use o dropdown de status na tabela de amostras
3. Selecione o novo status
4. Confirme

**Resultado**: Status é atualizado e registrado na auditoria

## 🔐 Permissões

### Quem Pode Mudar o Status

- **CBF**: Pode mudar qualquer status
- **Federação**: Pode mudar qualquer status
- **Laboratório**: Pode mudar status (especialmente para marcar como analisada)

### Perfis com Acesso

- ✅ CBF
- ✅ FEDERACAO
- ✅ LABORATORIO

## 📊 Auditoria

Todas as mudanças de status são registradas na tabela de auditoria:

- **Usuário** que fez a mudança
- **Data e hora** da mudança
- **Status anterior**
- **Status novo**
- **Observações** (se houver)

## 🐛 Troubleshooting

### Problema: Não consigo mudar o status

**Soluções**:
1. Verifique se você tem permissão (CBF, Federação ou Laboratório)
2. Verifique se a amostra existe
3. Verifique se o status desejado é válido (veja regras acima)

### Problema: Status não atualiza na interface

**Soluções**:
1. Recarregue a página (F5)
2. Verifique se a requisição foi bem-sucedida (console do navegador)
3. Verifique os logs do backend

### Problema: Erro ao mudar para POSITIVA/NEGATIVA

**Solução**: Certifique-se de que há um resultado registrado para a amostra antes de mudar para POSITIVA ou NEGATIVA.

## 📚 Status e Resultados

### Relação entre Status e Resultado

| Status | Resultado Necessário? | Descrição |
|--------|----------------------|-----------|
| PENDENTE | ❌ Não | Aguardando análise |
| ANALISADA | ❌ Não | Análise concluída, resultado pendente |
| NEGATIVA | ✅ Sim | Resultado negativo registrado |
| POSITIVA | ✅ Sim | Resultado positivo registrado |
| INCONCLUSIVA | ✅ Sim | Resultado inconclusivo registrado |

## 🎯 Resumo

1. **Status muda automaticamente** quando você registra um resultado
2. **Status pode ser mudado manualmente** via interface ou API
3. **Algumas mudanças requerem validação** (ex: POSITIVA/NEGATIVA precisa de resultado)
4. **Todas as mudanças são auditadas**
5. **Apenas perfis autorizados** podem mudar status

## 🔗 Endpoints Relacionados

- `GET /antidoping/testes/:id` - Ver amostras e status
- `PATCH /antidoping/amostras/:id/status` - Atualizar status
- `POST /antidoping/amostras/:id/resultado` - Registrar resultado (muda status automaticamente)
- `GET /antidoping/amostras/:id/custodia` - Ver cadeia de custódia

