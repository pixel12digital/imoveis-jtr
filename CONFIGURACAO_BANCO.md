# Configuração do Banco de Dados - JTR Imóveis

## Visão Geral

O sistema agora detecta automaticamente o ambiente (desenvolvimento vs produção) e usa as configurações de banco apropriadas.

## Ambientes Suportados

### 🖥️ Desenvolvimento Local (XAMPP)
- **Host**: `localhost`
- **Database**: `jtr_imoveis`
- **Usuário**: `root`
- **Senha**: `` (vazia)
- **Detecção**: Automática via `localhost`, `127.0.0.1`, `.local`, `.test`

### 🌐 Produção (Hostinger)
- **Host**: `auth-db1607.hstgr.io`
- **Database**: `u342734079_jtrimoveis`
- **Usuário**: `u342734079_jtrimoveis`
- **Senha**: `Los@ngo#081081`
- **Detecção**: Automática quando não é localhost

## Configuração Inicial para Desenvolvimento

### 1. Certifique-se de que o XAMPP está rodando
- Inicie o Apache e MySQL no painel do XAMPP
- Verifique se a porta 3306 (MySQL) está livre

### 2. Execute o script de configuração
```bash
# Acesse no navegador:
http://localhost/jtr-imoveis/setup_database.php
```

Este script irá:
- ✅ Verificar a conexão com MySQL
- ✅ Criar o banco `jtr_imoveis` se não existir
- ✅ Executar o schema SQL
- ✅ Inserir dados de exemplo
- ✅ Verificar se tudo está funcionando

### 3. Acesse o site normalmente
```
http://localhost/jtr-imoveis/
```

## Como Funciona a Detecção

O sistema usa a função `isDevelopment()` do arquivo `config/paths.php`:

```php
function isDevelopment() {
    return in_array($_SERVER['HTTP_HOST'], ['localhost', '127.0.0.1', '::1']) || 
           strpos($_SERVER['HTTP_HOST'], '.local') !== false ||
           strpos($_SERVER['HTTP_HOST'], '.test') !== false;
}
```

## Arquivos de Configuração

- **`config/paths.php`**: Funções de ambiente e paths
- **`config/database.php`**: Configuração automática do banco
- **`config/database_local.php`**: Configurações específicas para local
- **`database/schema.sql`**: Estrutura das tabelas
- **`database/sample_data.sql`**: Dados de exemplo

## Logs e Debug

### Em Desenvolvimento
- Erros detalhados são exibidos
- Logs são gravados no error_log do PHP
- Conexão com banco é logada

### Em Produção
- Erros genéricos são exibidos para usuários
- Erros reais são logados para administradores
- Segurança mantida

## Solução de Problemas

### Erro: "Could not establish connection with the database"
1. Verifique se o XAMPP está rodando
2. Execute `setup_database.php`
3. Verifique os logs de erro do PHP

### Erro: "Access denied for user 'root'@'localhost'"
1. Verifique se o MySQL está ativo no XAMPP
2. Confirme que a senha está vazia (padrão XAMPP)
3. Teste a conexão via phpMyAdmin

### Erro: "Unknown database 'jtr_imoveis'"
1. Execute `setup_database.php`
2. Verifique se o schema SQL foi executado
3. Confirme que as tabelas foram criadas

## Migração para Produção

Quando fizer deploy:
1. O sistema detectará automaticamente que não é localhost
2. Usará as credenciais do Hostinger
3. Nenhuma alteração de código é necessária

## Segurança

- ✅ Credenciais de produção não são expostas em desenvolvimento
- ✅ Detecção automática de ambiente
- ✅ Logs apropriados para cada ambiente
- ✅ Tratamento de erros específico por ambiente

## Comandos Úteis

### Verificar ambiente atual
```php
echo isDevelopment() ? 'Desenvolvimento' : 'Produção';
```

### Verificar informações do ambiente
```php
$env = getEnvironmentInfo();
print_r($env);
```

### Testar conexão manualmente
```php
require_once 'config/database_local.php';
echo testLocalConnection();
```
