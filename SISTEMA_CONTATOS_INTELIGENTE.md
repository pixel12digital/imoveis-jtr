# Sistema de Contatos Inteligente - JTR Imóveis

## Visão Geral

O sistema de contatos inteligente identifica automaticamente se um contato é relacionado a **venda** ou **locação** de imóveis e direciona a mensagem para o contato correto.

## Números de Contato

### Vendas
- **Telefone:** +55 12 98863-2149
- **WhatsApp:** +55 12 98863-2149

### Locação
- **Telefone:** +55 12 99126-7831
- **WhatsApp:** +55 12 99126-7831

## Como Funciona

### 1. Identificação Automática
O sistema analisa o **assunto** e **mensagem** do formulário para identificar palavras-chave:

#### Palavras-chave para Venda:
- compra, comprar, adquirir, comprador
- financiamento, financiar, hipoteca
- entrada, parcelas, valor total
- preço total, custo total, investimento

#### Palavras-chave para Locação:
- aluguel, alugar, locação, locar
- locatário, mensalidade, caução
- fiador, contrato de aluguel
- valor mensal, preço mensal, mensal

### 2. Processamento
1. Usuário preenche o formulário de contato
2. Sistema identifica automaticamente o tipo de operação
3. Mensagem é salva no banco com o tipo identificado
4. E-mail de notificação é enviado com o contato correto
5. Usuário recebe confirmação com o número específico

### 3. Direcionamento
- **Venda:** Contato direcionado para +55 12 98863-2149
- **Locação:** Contato direcionado para +55 12 99126-7831
- **Outros:** Contato direcionado para número padrão

## Arquivos do Sistema

### `config/config.php`
- Constantes dos números de telefone
- `PHONE_VENDA` e `PHONE_LOCACAO`
- `PHONE_WHATSAPP_VENDA` e `PHONE_WHATSAPP_LOCACAO`

### `process_contact.php`
- Processamento do formulário
- Identificação automática do tipo
- Salvamento no banco de dados
- Envio de e-mail de notificação

### `pages/contato.php`
- Formulário de contato atualizado
- Exibição dos números específicos
- Botões de WhatsApp separados por tipo

### `admin/contatos/index.php`
- Painel administrativo atualizado
- Filtros por tipo de operação
- Estatísticas por categoria

## Banco de Dados

### Tabela `contatos` atualizada:
```sql
ALTER TABLE contatos 
ADD COLUMN tipo_operacao ENUM('venda', 'locacao', 'outros') DEFAULT 'outros' 
AFTER assunto;
```

### Script de atualização:
Execute o arquivo `database/update_contatos_table.sql` para atualizar a estrutura.

## Funcionalidades

### Frontend
- ✅ Formulário de contato inteligente
- ✅ Identificação automática venda/locação
- ✅ Números específicos por tipo
- ✅ Botões WhatsApp separados
- ✅ Validação em tempo real
- ✅ Notificações de sucesso

### Backend
- ✅ Processamento automático
- ✅ Análise de palavras-chave
- ✅ Direcionamento inteligente
- ✅ Salvamento no banco
- ✅ E-mail de notificação
- ✅ Suporte AJAX

### Admin
- ✅ Visualização por tipo
- ✅ Filtros avançados
- ✅ Estatísticas por categoria
- ✅ Gerenciamento completo

## Como Usar

### 1. Configuração
1. Execute o script SQL de atualização
2. Verifique as constantes no `config.php`
3. Teste o formulário de contato

### 2. Teste
1. Acesse a página de contato
2. Preencha o formulário com palavras relacionadas a venda
3. Verifique se foi direcionado para o número correto
4. Teste com palavras de locação

### 3. Monitoramento
1. Acesse o painel administrativo
2. Verifique os contatos recebidos
3. Monitore as estatísticas por tipo
4. Acompanhe o direcionamento automático

## Exemplos de Uso

### Venda (será direcionado para +55 12 98863-2149)
- Assunto: "Compra de imóvel"
- Mensagem: "Gostaria de comprar uma casa com financiamento"

### Locação (será direcionado para +55 12 99126-7831)
- Assunto: "Aluguel de apartamento"
- Mensagem: "Procurando um apartamento para alugar"

## Benefícios

1. **Atendimento Especializado:** Cada tipo de operação tem um contato dedicado
2. **Eficiência:** Reduz tempo de resposta e melhora a experiência do cliente
3. **Organização:** Separação clara entre vendas e locações
4. **Automação:** Identificação automática sem intervenção manual
5. **Rastreabilidade:** Histórico completo de todos os contatos

## Suporte

Para dúvidas ou problemas:
- Verifique os logs de erro
- Teste o formulário com diferentes cenários
- Confirme a estrutura do banco de dados
- Verifique as configurações de e-mail

---

**Desenvolvido para JTR Imóveis**  
*Sistema de contatos inteligente para melhor atendimento aos clientes*
