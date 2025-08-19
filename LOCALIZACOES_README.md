# 🗺️ Sistema de Localizações - JTR Imóveis

## 📋 Visão Geral

O sistema de localizações permite cadastrar e gerenciar cidades, bairros e estados para serem utilizados no cadastro de imóveis. Isso garante consistência nos dados e facilita a busca e filtragem de propriedades.

## 🚀 Funcionalidades

### ✅ **Cadastro de Localizações**
- **Cidade** (obrigatório)
- **Estado** (obrigatório) - Lista completa dos 27 estados brasileiros
- **Bairro** (opcional) - Para localização mais específica
- **CEP** (opcional) - Para precisão na localização

### ✅ **Gerenciamento**
- Listagem com estatísticas
- Edição de localizações existentes
- Exclusão (apenas se não houver imóveis cadastrados)
- Filtros por estado
- Contagem de imóveis por localização

### ✅ **Validações**
- Cidade e estado obrigatórios
- Validação de formato de CEP
- Prevenção de duplicatas (cidade + bairro + estado)
- Proteção contra exclusão de localizações com imóveis

## 📁 Arquivos Criados

```
admin/localizacoes/
├── index.php          # Listagem e gerenciamento
├── adicionar.php      # Cadastro de novas localizações
└── editar.php         # Edição de localizações existentes

database/
└── localizacoes_exemplo.sql  # Localizações pré-cadastradas
```

## 🛠️ Como Usar

### 1. **Acessar o Sistema**
- URL: `http://localhost/jtr-imoveis/admin/localizacoes/`
- Faça login como administrador
- Clique em "Localizações" no menu lateral

### 2. **Cadastrar Nova Localização**
- Clique em "Nova Localização"
- Preencha os campos obrigatórios:
  - **Cidade**: Nome da cidade
  - **Estado**: Selecione da lista
- Campos opcionais:
  - **Bairro**: Bairro específico
  - **CEP**: CEP da região
- Clique em "Salvar Localização"

### 3. **Editar Localização**
- Na listagem, clique no ícone de editar (✏️)
- Modifique os campos desejados
- Clique em "Atualizar Localização"

### 4. **Excluir Localização**
- Na listagem, clique no ícone de excluir (🗑️)
- **IMPORTANTE**: Só é possível excluir se não houver imóveis cadastrados
- Confirme a exclusão

## 🗃️ Populando o Banco

### **Opção 1: Arquivo SQL**
Execute o arquivo `database/localizacoes_exemplo.sql` no seu banco de dados:

```sql
-- Via phpMyAdmin ou linha de comando
source database/localizacoes_exemplo.sql
```

### **Opção 2: Manual**
Cadastre localizações uma por uma através da interface administrativa.

## 📊 Estrutura do Banco

```sql
CREATE TABLE localizacoes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cidade VARCHAR(100) NOT NULL,
    bairro VARCHAR(100),
    estado VARCHAR(2) NOT NULL,
    cep VARCHAR(10)
);
```

## 🔗 Integração com Imóveis

### **No Cadastro de Imóveis**
- O campo "Localização" agora mostra as localizações cadastradas
- Formato: `Cidade - Bairro, Estado`
- Exemplo: `São Paulo - Jardins, SP`

### **No Frontend**
- Filtros por cidade/estado
- Busca por localização
- Exibição organizada por região

## 🎯 Estados Disponíveis

O sistema inclui todos os 27 estados brasileiros:

- **AC** - Acre
- **AL** - Alagoas
- **AP** - Amapá
- **AM** - Amazonas
- **BA** - Bahia
- **CE** - Ceará
- **DF** - Distrito Federal
- **ES** - Espírito Santo
- **GO** - Goiás
- **MA** - Maranhão
- **MT** - Mato Grosso
- **MS** - Mato Grosso do Sul
- **MG** - Minas Gerais
- **PA** - Pará
- **PB** - Paraíba
- **PR** - Paraná
- **PE** - Pernambuco
- **PI** - Piauí
- **RJ** - Rio de Janeiro
- **RN** - Rio Grande do Norte
- **RS** - Rio Grande do Sul
- **RO** - Rondônia
- **RR** - Roraima
- **SC** - Santa Catarina
- **SP** - São Paulo
- **SE** - Sergipe
- **TO** - Tocantins

## 📈 Estatísticas Disponíveis

- **Total de Localizações**: Contagem geral
- **Estados**: Número de estados com localizações
- **Cidades**: Número de cidades únicas
- **Imóveis por Localização**: Contagem de propriedades

## 🔒 Segurança

- **Login obrigatório**: Apenas administradores podem acessar
- **Validação de dados**: Todos os campos são validados
- **Proteção contra exclusão**: Localizações com imóveis não podem ser excluídas
- **Sanitização**: Dados são limpos antes de salvar

## 🚨 Limitações e Considerações

### **Não é possível:**
- Excluir localizações que possuem imóveis cadastrados
- Duplicar cidade + bairro + estado
- Cadastrar estados inexistentes

### **Recomendações:**
- Cadastre localizações antes de começar a cadastrar imóveis
- Use bairros específicos para melhor organização
- Mantenha os CEPs atualizados
- Evite localizações muito genéricas

## 🔧 Personalização

### **Adicionar Novos Estados**
Edite o array `$estados_brasil` nos arquivos:
- `admin/localizacoes/adicionar.php`
- `admin/localizacoes/editar.php`

### **Modificar Validações**
Edite as funções de validação nos arquivos de formulário.

### **Alterar Layout**
Modifique os arquivos CSS e HTML conforme necessário.

## 📞 Suporte

Para dúvidas ou problemas:
1. Verifique os logs de erro do PHP
2. Confirme as permissões do banco de dados
3. Teste a conexão com o banco
4. Verifique se todas as dependências estão carregadas

## 🎉 Benefícios

- **Consistência**: Dados padronizados de localização
- **Facilidade**: Interface intuitiva para administradores
- **Organização**: Melhor estruturação das informações
- **Busca**: Filtros mais eficientes no frontend
- **Profissionalismo**: Sistema mais robusto e organizado

---

**Sistema criado para JTR Imóveis** 🏠  
*Gerenciamento completo de localizações para imóveis*

