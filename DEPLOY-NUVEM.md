# ☁️ Guia de Deploy na Nuvem - Sistema CBF

## 📋 Visão Geral

Este guia explica como fazer o deploy da aplicação CBF na nuvem, cobrindo diferentes provedores e estratégias.

## 🎯 Opções de Deploy

### 1. **AWS (Amazon Web Services)**
- **Serviços recomendados**: ECS, EKS, EC2, RDS, ElastiCache
- **Vantagens**: Escalabilidade, muitos serviços, mercado consolidado
- **Custo**: Médio a alto

### 2. **Azure (Microsoft Azure)**
- **Serviços recomendados**: Container Instances, AKS, App Service, Azure Database
- **Vantagens**: Integração com ferramentas Microsoft, bom suporte
- **Custo**: Médio

### 3. **Google Cloud Platform (GCP)**
- **Serviços recomendados**: Cloud Run, GKE, Cloud SQL, Memorystore
- **Vantagens**: Kubernetes nativo, preços competitivos
- **Custo**: Médio

### 4. **Heroku**
- **Vantagens**: Simples, rápido de configurar
- **Desvantagens**: Mais caro, menos controle
- **Custo**: Alto

### 5. **DigitalOcean**
- **Serviços recomendados**: App Platform, Kubernetes, Managed Databases
- **Vantagens**: Preços acessíveis, interface simples
- **Custo**: Baixo a médio

### 6. **Railway / Render**
- **Vantagens**: Muito simples, bom para começar
- **Desvantagens**: Limitações em escala
- **Custo**: Baixo a médio

## 🚀 Preparação para Produção

### 1. Otimizar Dockerfile

Criar Dockerfiles otimizados para produção:

#### Backend Dockerfile (Produção)

```dockerfile
# backend/Dockerfile.prod
FROM node:18-alpine AS builder

WORKDIR /app

COPY package*.json ./
RUN npm ci --only=production

COPY . .
RUN npm run build

FROM node:18-alpine AS runner

WORKDIR /app

ENV NODE_ENV=production

COPY --from=builder /app/dist ./dist
COPY --from=builder /app/node_modules ./node_modules
COPY --from=builder /app/package*.json ./

EXPOSE 3001

CMD ["node", "dist/main"]
```

#### Frontend Dockerfile (Produção)

```dockerfile
# frontend/Dockerfile.prod
FROM node:18-alpine AS builder

WORKDIR /app

COPY package*.json ./
RUN npm ci

COPY . .
RUN npm run build

FROM nginx:alpine

COPY --from=builder /app/dist /usr/share/nginx/html
COPY nginx.conf /etc/nginx/nginx.conf

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]
```

### 2. Configurar Variáveis de Ambiente

Criar arquivo `.env.production`:

```env
# Backend
DB_HOST=seu-postgres-host
DB_PORT=5432
DB_USER=seu-usuario
DB_PASSWORD=sua-senha-segura
DB_NAME=cbf_db
JWT_SECRET=seu-jwt-secret-super-seguro-aqui
JWT_EXPIRES_IN=24h
PORT=3001
NODE_ENV=production
FRONTEND_URL=https://seu-dominio.com

# Frontend
VITE_API_URL=https://api.seu-dominio.com
```

### 3. Configurar Nginx (Frontend)

Criar `frontend/nginx.conf`:

```nginx
server {
    listen 80;
    server_name _;

    root /usr/share/nginx/html;
    index index.html;

    location / {
        try_files $uri $uri/ /index.html;
    }

    location /api {
        proxy_pass http://backend:3001;
        proxy_http_version 1.1;
        proxy_set_header Upgrade $http_upgrade;
        proxy_set_header Connection 'upgrade';
        proxy_set_header Host $host;
        proxy_cache_bypass $http_upgrade;
    }
}
```

### 4. Docker Compose para Produção

Criar `docker-compose.prod.yml`:

```yaml
version: '3.8'

services:
  postgres:
    image: postgres:15-alpine
    environment:
      POSTGRES_USER: ${DB_USER}
      POSTGRES_PASSWORD: ${DB_PASSWORD}
      POSTGRES_DB: ${DB_NAME}
    volumes:
      - postgres_data:/var/lib/postgresql/data
    healthcheck:
      test: ["CMD-SHELL", "pg_isready -U ${DB_USER}"]
      interval: 10s
      timeout: 5s
      retries: 5

  backend:
    build:
      context: ./backend
      dockerfile: Dockerfile.prod
    environment:
      DB_HOST: postgres
      DB_PORT: 5432
      DB_USER: ${DB_USER}
      DB_PASSWORD: ${DB_PASSWORD}
      DB_NAME: ${DB_NAME}
      JWT_SECRET: ${JWT_SECRET}
      JWT_EXPIRES_IN: 24h
      PORT: 3001
      NODE_ENV: production
      FRONTEND_URL: ${FRONTEND_URL}
    depends_on:
      postgres:
        condition: service_healthy
    restart: unless-stopped

  frontend:
    build:
      context: ./frontend
      dockerfile: Dockerfile.prod
    depends_on:
      - backend
    restart: unless-stopped
    ports:
      - "80:80"

volumes:
  postgres_data:
```

## ☁️ Deploy na AWS

### Opção 1: AWS ECS (Elastic Container Service)

#### 1. Criar ECR (Elastic Container Registry)

```bash
# Criar repositório
aws ecr create-repository --repository-name cbf-backend
aws ecr create-repository --repository-name cbf-frontend

# Fazer login
aws ecr get-login-password --region us-east-1 | docker login --username AWS --password-stdin <account-id>.dkr.ecr.us-east-1.amazonaws.com

# Fazer build e push
docker build -t cbf-backend ./backend
docker tag cbf-backend:latest <account-id>.dkr.ecr.us-east-1.amazonaws.com/cbf-backend:latest
docker push <account-id>.dkr.ecr.us-east-1.amazonaws.com/cbf-backend:latest
```

#### 2. Criar RDS (PostgreSQL)

```bash
aws rds create-db-instance \
  --db-instance-identifier cbf-db \
  --db-instance-class db.t3.micro \
  --engine postgres \
  --master-username postgres \
  --master-user-password sua-senha-segura \
  --allocated-storage 20 \
  --vpc-security-group-ids sg-xxxxx
```

#### 3. Criar Task Definition (ECS)

```json
{
  "family": "cbf-backend",
  "networkMode": "awsvpc",
  "requiresCompatibilities": ["FARGATE"],
  "cpu": "256",
  "memory": "512",
  "containerDefinitions": [
    {
      "name": "cbf-backend",
      "image": "<account-id>.dkr.ecr.us-east-1.amazonaws.com/cbf-backend:latest",
      "portMappings": [
        {
          "containerPort": 3001,
          "protocol": "tcp"
        }
      ],
      "environment": [
        {
          "name": "DB_HOST",
          "value": "seu-rds-endpoint"
        },
        {
          "name": "NODE_ENV",
          "value": "production"
        }
      ],
      "secrets": [
        {
          "name": "JWT_SECRET",
          "valueFrom": "arn:aws:secretsmanager:us-east-1:xxx:secret:jwt-secret"
        }
      ]
    }
  ]
}
```

#### 4. Criar Service (ECS)

```bash
aws ecs create-service \
  --cluster cbf-cluster \
  --service-name cbf-backend \
  --task-definition cbf-backend \
  --desired-count 2 \
  --launch-type FARGATE \
  --network-configuration "awsvpcConfiguration={subnets=[subnet-xxx],securityGroups=[sg-xxx],assignPublicIp=ENABLED}"
```

### Opção 2: AWS EC2 (Máquina Virtual)

#### 1. Criar Instância EC2

```bash
# Criar instância
aws ec2 run-instances \
  --image-id ami-0c55b159cbfafe1f0 \
  --instance-type t3.medium \
  --key-name sua-chave \
  --security-group-ids sg-xxxxx
```

#### 2. Conectar e Configurar

```bash
# SSH na instância
ssh -i sua-chave.pem ubuntu@<ip-da-instancia>

# Instalar Docker
sudo apt update
sudo apt install docker.io docker-compose -y

# Clonar repositório
git clone <seu-repositorio>
cd trabalhofinalaplicacoesdist

# Configurar variáveis de ambiente
nano .env.production

# Iniciar serviços
docker-compose -f docker-compose.prod.yml up -d
```

## ☁️ Deploy no Azure

### Opção 1: Azure Container Instances

#### 1. Criar Container Registry

```bash
az acr create --resource-group cbf-rg --name cbfregistry --sku Basic

# Fazer login
az acr login --name cbfregistry

# Fazer build e push
az acr build --registry cbfregistry --image cbf-backend:latest ./backend
```

#### 2. Criar Container Instance

```bash
az container create \
  --resource-group cbf-rg \
  --name cbf-backend \
  --image cbfregistry.azurecr.io/cbf-backend:latest \
  --cpu 1 \
  --memory 1 \
  --registry-login-server cbfregistry.azurecr.io \
  --registry-username cbfregistry \
  --registry-password sua-senha \
  --environment-variables \
    DB_HOST=seu-postgres \
    NODE_ENV=production
```

### Opção 2: Azure App Service

```bash
# Criar App Service
az webapp create \
  --resource-group cbf-rg \
  --plan cbf-plan \
  --name cbf-backend \
  --deployment-container-image-name cbfregistry.azurecr.io/cbf-backend:latest

# Configurar variáveis de ambiente
az webapp config appsettings set \
  --resource-group cbf-rg \
  --name cbf-backend \
  --settings \
    DB_HOST=seu-postgres \
    NODE_ENV=production
```

## ☁️ Deploy no Google Cloud

### Opção 1: Cloud Run

#### 1. Fazer Build e Push

```bash
# Configurar projeto
gcloud config set project seu-projeto-id

# Fazer build
gcloud builds submit --tag gcr.io/seu-projeto-id/cbf-backend ./backend

# Deploy no Cloud Run
gcloud run deploy cbf-backend \
  --image gcr.io/seu-projeto-id/cbf-backend \
  --platform managed \
  --region us-central1 \
  --allow-unauthenticated \
  --set-env-vars DB_HOST=seu-postgres,NODE_ENV=production
```

### Opção 2: GKE (Google Kubernetes Engine)

#### 1. Criar Cluster

```bash
gcloud container clusters create cbf-cluster \
  --num-nodes=3 \
  --machine-type=n1-standard-1 \
  --zone=us-central1-a
```

#### 2. Deploy com Kubernetes

```yaml
# k8s/deployment.yaml
apiVersion: apps/v1
kind: Deployment
metadata:
  name: cbf-backend
spec:
  replicas: 2
  selector:
    matchLabels:
      app: cbf-backend
  template:
    metadata:
      labels:
        app: cbf-backend
    spec:
      containers:
      - name: cbf-backend
        image: gcr.io/seu-projeto-id/cbf-backend:latest
        ports:
        - containerPort: 3001
        env:
        - name: DB_HOST
          valueFrom:
            secretKeyRef:
              name: db-secret
              key: host
        - name: NODE_ENV
          value: "production"
```

## 🚀 Deploy no Railway

### 1. Criar Conta no Railway

1. Acesse: https://railway.app
2. Faça login com GitHub
3. Crie um novo projeto

### 2. Conectar Repositório

1. Clique em "New Project"
2. Selecione "Deploy from GitHub repo"
3. Escolha seu repositório

### 3. Configurar Serviços

#### Backend

1. Adicione novo serviço
2. Selecione o diretório `backend`
3. Configure variáveis de ambiente:
   - `DB_HOST`, `DB_USER`, `DB_PASSWORD`, etc.
4. Railway detecta automaticamente e faz deploy

#### Frontend

1. Adicione novo serviço
2. Selecione o diretório `frontend`
3. Configure variáveis de ambiente:
   - `VITE_API_URL`
4. Railway faz build e deploy automaticamente

### 4. Adicionar Banco de Dados

1. Clique em "New" → "Database" → "PostgreSQL"
2. Railway cria automaticamente
3. Use as credenciais fornecidas no backend

## 🚀 Deploy no Render

### 1. Criar Conta no Render

1. Acesse: https://render.com
2. Faça login com GitHub
3. Conecte seu repositório

### 2. Deploy do Backend

1. Clique em "New" → "Web Service"
2. Conecte seu repositório
3. Configure:
   - **Name**: cbf-backend
   - **Environment**: Node
   - **Build Command**: `cd backend && npm install && npm run build`
   - **Start Command**: `cd backend && npm run start:prod`
   - **Environment Variables**: Adicione todas as variáveis

### 3. Deploy do Frontend

1. Clique em "New" → "Static Site"
2. Conecte seu repositório
3. Configure:
   - **Build Command**: `cd frontend && npm install && npm run build`
   - **Publish Directory**: `frontend/dist`

### 4. Adicionar Banco de Dados

1. Clique em "New" → "PostgreSQL"
2. Render cria automaticamente
3. Use as credenciais fornecidas

## 🔒 Segurança em Produção

### 1. Variáveis de Ambiente

**Nunca commite** arquivos `.env` com senhas reais!

Use serviços de gerenciamento de segredos:
- **AWS**: Secrets Manager
- **Azure**: Key Vault
- **GCP**: Secret Manager
- **Heroku**: Config Vars
- **Railway**: Environment Variables

### 2. HTTPS/SSL

Configure certificados SSL:
- **Let's Encrypt**: Gratuito
- **Cloudflare**: Gratuito (com CDN)
- **AWS Certificate Manager**: Gratuito (com ALB)
- **Azure App Service**: SSL incluído

### 3. Firewall e Segurança

- Configure Security Groups (AWS) ou Network Security Groups (Azure)
- Use apenas portas necessárias (80, 443, 5432)
- Limite acesso ao banco de dados apenas para aplicação
- Use VPN ou bastion hosts para acesso administrativo

### 4. Backups

Configure backups automáticos:
- **RDS**: Backups automáticos
- **Azure Database**: Backups automáticos
- **Cloud SQL**: Backups automáticos
- **Railway/Render**: Configure backups manuais

## 📊 Monitoramento

### 1. Logs

Configure logs centralizados:
- **AWS CloudWatch**
- **Azure Monitor**
- **GCP Cloud Logging**
- **Datadog** (terceiro)
- **Sentry** (erros)

### 2. Métricas

Monitore:
- CPU e memória
- Requisições por segundo
- Tempo de resposta
- Taxa de erro
- Uso do banco de dados

### 3. Alertas

Configure alertas para:
- Alta CPU/memória
- Erros 5xx
- Banco de dados lento
- Disponibilidade do serviço

## 🔄 CI/CD (Continuous Integration/Deployment)

### GitHub Actions

Criar `.github/workflows/deploy.yml`:

```yaml
name: Deploy to Production

on:
  push:
    branches: [main]

jobs:
  deploy-backend:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v2
      - name: Build and push Docker image
        run: |
          docker build -t cbf-backend ./backend
          docker push cbf-backend:latest
      - name: Deploy to AWS ECS
        run: |
          aws ecs update-service --cluster cbf-cluster --service cbf-backend --force-new-deployment
```

## 📋 Checklist de Deploy

### Antes do Deploy

- [ ] Variáveis de ambiente configuradas
- [ ] Banco de dados criado e acessível
- [ ] Dockerfiles otimizados para produção
- [ ] SSL/HTTPS configurado
- [ ] Backups configurados
- [ ] Monitoramento configurado
- [ ] Logs configurados
- [ ] Testes passando
- [ ] Documentação atualizada

### Durante o Deploy

- [ ] Build das imagens Docker
- [ ] Push para registry
- [ ] Deploy dos serviços
- [ ] Verificar saúde dos serviços
- [ ] Testar endpoints
- [ ] Verificar logs

### Após o Deploy

- [ ] Testar aplicação completa
- [ ] Verificar métricas
- [ ] Configurar alertas
- [ ] Documentar URLs e credenciais
- [ ] Testar backup/restore

## 🎯 Recomendações por Tamanho

### Pequeno Projeto (MVP)
- **Recomendado**: Railway, Render, Heroku
- **Custo**: $0-50/mês
- **Setup**: 15-30 minutos

### Projeto Médio
- **Recomendado**: DigitalOcean, AWS ECS, Azure App Service
- **Custo**: $50-200/mês
- **Setup**: 1-2 horas

### Projeto Grande (Produção)
- **Recomendado**: AWS EKS, Azure AKS, GKE
- **Custo**: $200-1000+/mês
- **Setup**: 4-8 horas

## 📚 Recursos Adicionais

- [AWS ECS Documentation](https://docs.aws.amazon.com/ecs/)
- [Azure Container Instances](https://docs.microsoft.com/azure/container-instances/)
- [Google Cloud Run](https://cloud.google.com/run/docs)
- [Railway Documentation](https://docs.railway.app/)
- [Render Documentation](https://render.com/docs)

## 🆘 Troubleshooting

### Problema: Container não inicia

**Solução**:
1. Verifique logs: `docker logs <container-id>`
2. Verifique variáveis de ambiente
3. Verifique conectividade com banco de dados
4. Verifique portas e firewall

### Problema: Banco de dados não conecta

**Solução**:
1. Verifique Security Groups / Firewall
2. Verifique credenciais
3. Verifique endpoint do banco
4. Teste conexão manualmente

### Problema: Aplicação lenta

**Solução**:
1. Aumente recursos (CPU/memória)
2. Configure cache (Redis)
3. Otimize queries do banco
4. Configure CDN para frontend

## 🎉 Próximos Passos

1. **Escolha um provedor** baseado em suas necessidades
2. **Prepare o ambiente** (Dockerfiles, variáveis)
3. **Faça deploy de teste** em ambiente de staging
4. **Teste completamente** antes de produção
5. **Configure monitoramento** e alertas
6. **Documente o processo** de deploy
7. **Configure CI/CD** para automação

---

**Dica**: Comece com Railway ou Render para MVP, depois migre para AWS/Azure/GCP quando precisar de mais controle e escala.

