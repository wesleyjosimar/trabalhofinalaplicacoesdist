# Guia Docker - Sistema CBF

## Problema: "no configuration file provided: not found"

Este erro ocorre quando o comando `docker-compose` é executado no diretório errado.

## Solução

### Passo 1: Navegar para o diretório do projeto

Abra o PowerShell ou CMD e navegue para o diretório do projeto:

```powershell
cd C:\trabalhofinalaplicacoesdist
```

### Passo 2: Verificar se o arquivo existe

```powershell
dir docker-compose.yml
```

ou

```powershell
ls docker-compose.yml
```

### Passo 3: Executar o Docker Compose

No Windows, você pode usar tanto `docker-compose` quanto `docker compose` (versões mais recentes):

**Opção 1: docker-compose (com hífen)**
```powershell
docker-compose up -d
```

**Opção 2: docker compose (sem hífen - Docker Desktop mais recente)**
```powershell
docker compose up -d
```

## Comandos Úteis

### Iniciar os serviços
```powershell
docker compose up -d
```

### Ver logs
```powershell
docker compose logs -f
```

### Ver logs de um serviço específico
```powershell
docker compose logs -f backend
docker compose logs -f frontend
docker compose logs -f postgres
```

### Parar os serviços
```powershell
docker compose down
```

### Parar e remover volumes (limpar dados)
```powershell
docker compose down -v
```

### Reconstruir as imagens
```powershell
docker compose build
docker compose up -d
```

### Ver status dos containers
```powershell
docker compose ps
```

## Verificando se está no diretório correto

Execute este comando para ver o conteúdo do diretório:

```powershell
dir
```

Você deve ver:
- `docker-compose.yml`
- `backend/`
- `frontend/`
- `README.md`
- `ARQUITETURA.md`
- etc.

## Solução Rápida (Copiar e Colar)

Se você estiver no diretório `C:\Users\wesle`, execute:

```powershell
cd C:\trabalhofinalaplicacoesdist
docker compose up -d
```

## Troubleshooting

### Erro: "docker-compose: command not found"

Isso significa que o Docker Compose não está instalado ou não está no PATH. 

**Solução:**
1. Instale o Docker Desktop (que inclui o Docker Compose)
2. Ou use `docker compose` (sem hífen) que vem com o Docker Desktop mais recente

### Erro: "Cannot connect to the Docker daemon"

Isso significa que o Docker não está rodando.

**Solução:**
1. Abra o Docker Desktop
2. Aguarde até que o ícone do Docker fique verde
3. Tente novamente

### Erro: "Port already in use"

Isso significa que uma das portas (3000, 3001, 5432) já está sendo usada.

**Solução:**
1. Verifique quais portas estão em uso:
   ```powershell
   netstat -ano | findstr :3000
   netstat -ano | findstr :3001
   netstat -ano | findstr :5432
   ```
2. Pare o processo que está usando a porta ou mude as portas no `docker-compose.yml`

## Execução Manual (sem Docker)

Se preferir não usar Docker, você pode executar manualmente:

### 1. Backend
```powershell
cd backend
npm install
npm run start:dev
```

### 2. Frontend (em outro terminal)
```powershell
cd frontend
npm install
npm run dev
```

### 3. PostgreSQL
Instale o PostgreSQL localmente ou use um serviço em nuvem.

