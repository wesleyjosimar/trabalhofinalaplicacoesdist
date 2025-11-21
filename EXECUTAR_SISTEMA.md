# 🚀 Como Executar o Sistema CBF Antidoping

## ✅ Passos Rápidos

### 1. Iniciar XAMPP
1. Abra o **XAMPP Control Panel**
2. Clique em **Start** ao lado de **Apache**
3. Clique em **Start** ao lado de **MySQL**
4. Aguarde até ambos ficarem verdes

### 2. Acessar o Sistema

**Opção A - Via Navegador:**
- Abra: `http://localhost/cbf/login.php`

**Opção B - Via Script:**
- Execute: `iniciar_sistema.bat` (duplo clique)

### 3. Fazer Login

**Credenciais:**
- **Admin**: `admin@cbf.com.br` / `admin123`
- **Operador**: `operador@cbf.com.br` / `operador123`

---

## 🔧 Se o MySQL não iniciar

1. **Verifique a porta 3306:**
   - Execute: `verificar_porta_mysql.bat` (como Admin)

2. **Corrija permissões:**
   - Execute: `corrigir_permissoes_mysql.bat` (como Admin)

3. **Veja o guia completo:**
   - Leia: `SOLUCAO_MYSQL_XAMPP.md`

---

## 🧪 Testar o Sistema

### Diagnóstico Completo:
```
http://localhost/cbf/diagnostico_banco.php
```

### Testar Banco e Criar Usuários:
```
http://localhost/cbf/testar_banco.php
```

### Testar Conexão:
```
http://localhost/cbf/teste.php
```

---

## 📋 Checklist

- [ ] XAMPP instalado em `C:\xampp`
- [ ] Apache iniciado (verde no XAMPP)
- [ ] MySQL iniciado (verde no XAMPP)
- [ ] Arquivos copiados para `C:\xampp\htdocs\cbf\`
- [ ] Banco `cbf_antidoping` criado
- [ ] Tabelas criadas (executou `database.sql`)
- [ ] Usuários criados (executou `inserir_usuarios.sql` ou `testar_banco.php`)

---

## 🌐 URLs do Sistema

- **Login**: `http://localhost/cbf/login.php`
- **Atletas**: `http://localhost/cbf/atletas.php`
- **Testes**: `http://localhost/cbf/testes.php`
- **Relatórios**: `http://localhost/cbf/relatorios.php`
- **Usuários**: `http://localhost/cbf/usuarios.php` (apenas admin)

---

## ⚠️ Problemas Comuns

### Erro 404 - Página não encontrada
- Verifique se os arquivos estão em `C:\xampp\htdocs\cbf\`
- Verifique se o Apache está rodando

### Erro de conexão com banco
- Verifique se o MySQL está rodando
- Verifique o `config.php`
- Execute `diagnostico_banco.php`

### Página em branco
- Verifique os logs do Apache: `C:\xampp\apache\logs\error.log`
- Ative `APP_DEBUG = true` no `config.php`

