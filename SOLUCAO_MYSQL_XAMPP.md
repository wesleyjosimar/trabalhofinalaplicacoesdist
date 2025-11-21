# 🔧 Solução para Erro "MySQL shutdown unexpectedly" no XAMPP

## Erro
```
Error: MySQL shutdown unexpectedly.
This may be due to a blocked port, missing dependencies, 
improper privileges, a crash, or a shutdown by another method.
```

## Soluções (Teste uma por vez)

### ✅ Solução 1: Verificar se a Porta 3306 está em Uso

1. **Abra o Prompt de Comando como Administrador**
   - Pressione `Win + X`
   - Escolha "Terminal (Admin)" ou "PowerShell (Admin)"

2. **Verifique se algo está usando a porta 3306:**
   ```cmd
   netstat -ano | findstr :3306
   ```

3. **Se encontrar algo, mate o processo:**
   ```cmd
   taskkill /PID [número_do_PID] /F
   ```
   (Substitua [número_do_PID] pelo número que apareceu)

4. **Tente iniciar o MySQL novamente no XAMPP**

---

### ✅ Solução 2: Verificar e Corrigir Permissões

1. **Feche o XAMPP completamente**

2. **Navegue até a pasta do MySQL:**
   ```
   C:\xampp\mysql\data
   ```

3. **Clique com botão direito na pasta `data` → Propriedades**

4. **Na aba "Segurança", clique em "Editar"**

5. **Adicione permissões completas para:**
   - Seu usuário do Windows
   - Sistema
   - Administradores

6. **Marque "Substituir todas as entradas de permissão filhas"**

7. **Clique em OK e aguarde**

8. **Tente iniciar o MySQL novamente**

---

### ✅ Solução 3: Verificar Arquivo de Log de Erro

1. **No XAMPP Control Panel, clique em "Logs" ao lado do MySQL**

2. **OU abra manualmente:**
   ```
   C:\xampp\mysql\data\*.err
   ```
   (Procure o arquivo mais recente)

3. **Leia as últimas linhas do arquivo de erro**

4. **Erros comuns:**
   - `InnoDB: Unable to lock ./ibdata1` → Solução 4
   - `Can't create/write to file` → Solução 2 (permissões)
   - `Port already in use` → Solução 1 (porta)

---

### ✅ Solução 4: Remover Arquivos de Lock do InnoDB

**⚠️ ATENÇÃO: Faça backup antes!**

1. **Feche o XAMPP completamente**

2. **Navegue até:**
   ```
   C:\xampp\mysql\data
   ```

3. **Procure e DELETE (se existirem):**
   - `ibdata1.lock`
   - `ib_logfile0.lock`
   - `ib_logfile1.lock`
   - Qualquer arquivo `.lock`

4. **Tente iniciar o MySQL novamente**

---

### ✅ Solução 5: Verificar Arquivo my.ini

1. **Abra o arquivo:**
   ```
   C:\xampp\mysql\bin\my.ini
   ```

2. **Verifique se as linhas estão corretas:**
   ```ini
   [mysqld]
   port=3306
   datadir="C:/xampp/mysql/data"
   ```

3. **Se estiver errado, corrija e salve**

4. **Tente iniciar novamente**

---

### ✅ Solução 6: Reinstalar MySQL (Último Recurso)

**⚠️ Isso vai APAGAR todos os bancos de dados!**

1. **Faça backup dos seus bancos:**
   - Exporte via phpMyAdmin
   - OU copie a pasta `C:\xampp\mysql\data\cbf_antidoping`

2. **Pare o MySQL no XAMPP**

3. **Renomeie a pasta data:**
   ```
   C:\xampp\mysql\data → C:\xampp\mysql\data_backup
   ```

4. **Crie uma nova pasta `data` vazia**

5. **Inicie o MySQL (vai criar estrutura nova)**

6. **Pare o MySQL**

7. **Copie seus bancos de volta:**
   - Copie `data_backup\cbf_antidoping` para `data\cbf_antidoping`

8. **Inicie o MySQL novamente**

---

### ✅ Solução 7: Verificar Windows Event Viewer

1. **Pressione `Win + R`**

2. **Digite:**
   ```
   eventvwr.msc
   ```

3. **Navegue até:**
   - Windows Logs → Application

4. **Procure por erros relacionados ao MySQL**

5. **Leia a mensagem de erro completa**

---

## 🎯 Solução Rápida (Mais Comum)

**Na maioria dos casos, é a porta 3306 em uso:**

1. Abra o Prompt como Admin
2. Execute:
   ```cmd
   netstat -ano | findstr :3306
   ```
3. Se aparecer algo, execute:
   ```cmd
   taskkill /PID [PID] /F
   ```
4. Inicie o MySQL no XAMPP

---

## 📋 Checklist de Diagnóstico

- [ ] Porta 3306 está livre?
- [ ] Permissões da pasta `data` estão corretas?
- [ ] Arquivo de log mostra algum erro específico?
- [ ] Arquivos `.lock` foram removidos?
- [ ] Arquivo `my.ini` está correto?
- [ ] Nenhum outro MySQL/Servidor está rodando?

---

## 💡 Dica

Se nada funcionar, tente:
1. Reiniciar o computador
2. Executar o XAMPP como Administrador
3. Verificar se há antivírus bloqueando

