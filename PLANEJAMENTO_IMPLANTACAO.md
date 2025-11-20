# Planejamento de Implantação de Aplicação Distribuída
## Sistema de Cadastro de Atletas e Acompanhamento Antidoping - CBF

---

## 1. ANÁLISE DE REQUISITOS

### 1.1 Requisitos Funcionais Identificados

#### Funções Críticas do Sistema:

1. **Cadastro de Atletas**
   - Registro de dados pessoais (nome, documento, data de nascimento)
   - Informações de clube e federação
   - Controle de status (ativo/inativo)
   - Operações: criar, listar, editar, inativar

2. **Registro de Testes Antidoping**
   - Vinculação de teste ao atleta
   - Registro de data de coleta, competição e laboratório
   - Controle de resultado (pendente, negativo, positivo)
   - Observações e histórico completo

3. **Consultas e Relatórios**
   - Listagem de atletas com filtros
   - Histórico de testes por atleta
   - Listagem geral de testes
   - Relatórios de resultados (positivos/negativos)

4. **Controle de Acesso**
   - Autenticação de usuários
   - Perfis: Administrador e Operacional
   - Controle de permissões por perfil

### 1.2 Requisitos Não Funcionais

#### Desempenho:
- Tempo de resposta para consultas: < 2 segundos
- Suporte a 100 usuários simultâneos
- Processamento de relatórios: < 5 segundos

#### Disponibilidade:
- Uptime de 99% (máximo 7 horas de indisponibilidade por mês)
- Recuperação automática em caso de falha
- Backup automático diário

#### Escalabilidade:
- Capacidade de crescimento para 500+ usuários
- Suporte a aumento de volume de dados (10.000+ atletas)
- Expansão geográfica (federações estaduais)

#### Segurança:
- Criptografia de senhas (bcrypt)
- Proteção contra SQL Injection (PDO prepared statements)
- Sessões seguras
- Controle de acesso por perfil

---

## 2. DEFINIÇÃO DA ARQUITETURA DISTRIBUÍDA

### 2.1 Arquitetura Proposta (Fase Inicial - Simples)

```
┌─────────────────────────────────────────────────────────┐
│                    LOAD BALANCER                        │
│              (Nginx ou Apache mod_proxy)                │
└──────────────┬──────────────────────┬──────────────────┘
               │                      │
       ┌───────▼───────┐      ┌───────▼───────┐
       │  Servidor 1   │      │  Servidor 2   │
       │  (PHP App)    │      │  (PHP App)    │
       │  Replicação   │      │  Replicação   │
       └───────┬───────┘      └───────┬───────┘
               │                      │
               └──────────┬───────────┘
                          │
                  ┌───────▼────────┐
                  │  MySQL Master  │
                  │  (Escrita)     │
                  └───────┬────────┘
                          │
                  ┌───────▼────────┐
                  │  MySQL Slave   │
                  │  (Leitura)     │
                  └────────────────┘
```

### 2.2 Componentes da Arquitetura

#### 2.2.1 Camada de Apresentação
- **Tecnologia**: PHP puro com views HTML/CSS
- **Servidores**: 2 servidores web (replicação)
- **Função**: Processar requisições HTTP e renderizar views

#### 2.2.2 Camada de Aplicação
- **Tecnologia**: PHP (Controllers e Models)
- **Função**: Lógica de negócio e acesso a dados
- **Replicação**: Código idêntico em ambos servidores

#### 2.2.3 Camada de Dados
- **Tecnologia**: MySQL com Master-Slave
- **Master**: Recebe todas as escritas (INSERT, UPDATE, DELETE)
- **Slave**: Replicação para leituras (SELECT)
- **Função**: Armazenamento e consulta de dados

#### 2.2.4 Balanceador de Carga
- **Tecnologia**: Nginx ou Apache mod_proxy
- **Função**: Distribuir requisições entre servidores
- **Método**: Round-robin ou least connections

### 2.3 Vantagens da Arquitetura

1. **Alta Disponibilidade**: Se um servidor falhar, o outro continua operando
2. **Melhor Performance**: Carga distribuída entre servidores
3. **Escalabilidade**: Fácil adicionar mais servidores
4. **Redundância**: Dados replicados (Master-Slave)

---

## 3. PLANEJAMENTO DA INFRAESTRUTURA

### 3.1 Recursos Necessários

#### Servidores Web (2 unidades):
- **CPU**: 2 cores
- **RAM**: 4GB
- **Disco**: 50GB SSD
- **Sistema Operacional**: Linux (Ubuntu Server 22.04)
- **Software**: PHP 8.0+, Apache/Nginx

#### Servidor de Banco de Dados Master:
- **CPU**: 4 cores
- **RAM**: 8GB
- **Disco**: 100GB SSD
- **Sistema Operacional**: Linux (Ubuntu Server 22.04)
- **Software**: MySQL 8.0+

#### Servidor de Banco de Dados Slave:
- **CPU**: 2 cores
- **RAM**: 4GB
- **Disco**: 100GB SSD
- **Sistema Operacional**: Linux (Ubuntu Server 22.04)
- **Software**: MySQL 8.0+

#### Servidor Load Balancer:
- **CPU**: 2 cores
- **RAM**: 2GB
- **Disco**: 20GB SSD
- **Software**: Nginx

### 3.2 Configuração de Rede

#### Topologia:
```
Internet → Load Balancer (IP Público)
           ├─ Servidor Web 1 (IP Privado)
           ├─ Servidor Web 2 (IP Privado)
           ├─ MySQL Master (IP Privado)
           └─ MySQL Slave (IP Privado)
```

#### Portas:
- **80/443**: HTTP/HTTPS (Load Balancer)
- **3306**: MySQL (apenas rede interna)
- **22**: SSH (gerenciamento)

### 3.3 Segurança

1. **Firewall**: Bloquear portas desnecessárias
2. **SSL/TLS**: Certificado para HTTPS
3. **Backup Automático**: Diário para servidor externo
4. **Monitoramento**: Logs e alertas de falhas

### 3.4 Ferramentas de Monitoramento

- **Zabbix ou Nagios**: Monitoramento de servidores
- **MySQL Monitor**: Acompanhamento de performance do banco
- **Logs Centralizados**: Análise de erros e acesso

---

## 4. CRONOGRAMA DE IMPLANTAÇÃO

### Fase 1: Levantamento e Modelagem (2 semanas)
- ✅ Análise de requisitos funcionais
- ✅ Modelagem do banco de dados
- ✅ Definição de arquitetura
- ✅ Prototipagem da interface

### Fase 2: Desenvolvimento do Protótipo (4 semanas)
- ✅ Desenvolvimento do sistema monolítico (CONCLUÍDO)
- ✅ Implementação de CRUD completo
- ✅ Sistema de autenticação e autorização
- ✅ Testes unitários e de integração

### Fase 3: Preparação para Distribuição (3 semanas)
- ⏳ Configuração de servidores de desenvolvimento
- ⏳ Implementação de replicação MySQL (Master-Slave)
- ⏳ Configuração de Load Balancer
- ⏳ Testes de carga e performance
- ⏳ Ajustes de otimização

### Fase 4: Implantação Piloto (2 semanas)
- ⏳ Deploy em ambiente de homologação
- ⏳ Testes com usuários reais (federação estadual)
- ⏳ Coleta de feedback
- ⏳ Correções e melhorias

### Fase 5: Implantação Nacional (3 semanas)
- ⏳ Deploy em produção
- ⏳ Migração de dados (se houver sistema legado)
- ⏳ Treinamento de usuários
- ⏳ Documentação final
- ⏳ Go-live

**Total Estimado**: 14 semanas (3,5 meses)

---

## 5. MITIGAÇÃO DE RISCOS

### 5.1 Riscos Identificados e Estratégias de Mitigação

#### Risco 1: Falhas de Comunicação entre Servidores

**Probabilidade**: Média  
**Impacto**: Alto

**Mitigação**:
- Implementar health checks automáticos
- Configurar failover automático no Load Balancer
- Monitoramento contínuo de latência entre servidores
- Testes periódicos de desconexão

#### Risco 2: Problemas de Segurança

**Probabilidade**: Média  
**Impacto**: Crítico

**Mitigação**:
- Implementar HTTPS obrigatório
- Firewall configurado corretamente
- Atualizações de segurança regulares
- Auditoria de segurança periódica
- Backup criptografado

#### Risco 3: Inconsistência de Dados (Master-Slave)

**Probabilidade**: Baixa  
**Impacto**: Alto

**Mitigação**:
- Monitoramento de replicação em tempo real
- Alertas automáticos em caso de atraso na replicação
- Scripts de verificação de integridade
- Backup do Master antes de mudanças críticas

#### Risco 4: Custos Adicionais de Infraestrutura

**Probabilidade**: Alta  
**Impacto**: Médio

**Mitigação**:
- Iniciar com servidores menores e escalar conforme necessário
- Utilizar cloud computing (AWS, Azure) para flexibilidade
- Monitorar uso de recursos e otimizar
- Planejar crescimento gradual

#### Risco 5: Curva de Aprendizado dos Usuários

**Probabilidade**: Alta  
**Impacto**: Médio

**Mitigação**:
- Interface simples e intuitiva
- Documentação completa e clara
- Treinamento presencial e online
- Suporte técnico nos primeiros meses
- Vídeos tutoriais

#### Risco 6: Falhas de Hardware

**Probabilidade**: Baixa  
**Impacto**: Alto

**Mitigação**:
- Redundância de servidores
- Backup automático diário
- Plano de recuperação de desastres (DR)
- Contrato de suporte com fornecedor
- Monitoramento proativo

---

## 6. RESULTADOS ESPERADOS

### 6.1 Melhoria no Desempenho

**Antes (Sistema Centralizado)**:
- Tempo de resposta: 5-10 segundos
- Suporte: 20-30 usuários simultâneos
- Relatórios: 15-30 segundos

**Depois (Sistema Distribuído)**:
- Tempo de resposta: < 2 segundos ✅
- Suporte: 100+ usuários simultâneos ✅
- Relatórios: < 5 segundos ✅

### 6.2 Escalabilidade

- Capacidade de adicionar servidores conforme demanda
- Suporte a crescimento de 10x no volume de dados
- Expansão geográfica (federações estaduais)

### 6.3 Alta Disponibilidade

- Uptime de 99% (máximo 7 horas/mês de indisponibilidade)
- Recuperação automática em caso de falha
- Redundância de componentes críticos

### 6.4 Integração Futura

- API REST para integração com laboratórios
- Webhooks para notificações
- Exportação de dados para WADA
- Integração com sistemas de federações

---

## 7. CONSIDERAÇÕES FINAIS

### 7.1 Vantagens da Solução Proposta

1. **Simplicidade**: Arquitetura distribuída sem complexidade desnecessária
2. **Custo-Benefício**: Solução eficiente sem custos excessivos
3. **Manutenibilidade**: Código PHP puro, fácil de manter
4. **Escalabilidade**: Crescimento gradual conforme necessidade
5. **Confiabilidade**: Redundância e alta disponibilidade

### 7.2 Próximos Passos

1. Aprovação do planejamento pela CBF
2. Contratação de infraestrutura (cloud ou servidores físicos)
3. Início da Fase 3 (Preparação para Distribuição)
4. Configuração de ambiente de homologação
5. Testes de carga e performance

### 7.3 Tecnologias Utilizadas

- **Backend**: PHP 8.0+ (puro, sem frameworks)
- **Banco de Dados**: MySQL 8.0+ (Master-Slave)
- **Servidor Web**: Apache/Nginx
- **Load Balancer**: Nginx
- **Sistema Operacional**: Linux (Ubuntu Server)
- **Monitoramento**: Zabbix/Nagios

---

**Documento elaborado para**: Trabalho de Aplicações Distribuídas  
**Sistema**: CBF Antidoping  
**Data**: 2024

