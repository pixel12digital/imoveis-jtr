-- Script para atualizar a tabela de contatos com novos campos
-- Execute este script para adicionar os campos necessários para o sistema de contatos inteligente

USE jtr_imoveis;

-- Adicionar campo tipo_operacao para identificar se é venda ou locação
ALTER TABLE contatos 
ADD COLUMN tipo_operacao ENUM('venda', 'locacao', 'outros') DEFAULT 'outros' 
AFTER assunto;

-- Atualizar campo status para usar os valores corretos
ALTER TABLE contatos 
MODIFY COLUMN status ENUM('nao_lido', 'lido', 'em_contato', 'respondido', 'finalizado') DEFAULT 'nao_lido';

-- Renomear campo data_criacao para data_envio para manter consistência
ALTER TABLE contatos 
CHANGE COLUMN data_criacao data_envio TIMESTAMP DEFAULT CURRENT_TIMESTAMP;

-- Adicionar índices para melhorar performance
CREATE INDEX idx_contatos_tipo_operacao ON contatos(tipo_operacao);
CREATE INDEX idx_contatos_status ON contatos(status);
CREATE INDEX idx_contatos_data_envio ON contatos(data_envio);

-- Atualizar contatos existentes baseado no assunto
UPDATE contatos 
SET tipo_operacao = 'venda' 
WHERE assunto LIKE '%compra%' OR assunto LIKE '%venda%' OR assunto LIKE '%financiamento%';

UPDATE contatos 
SET tipo_operacao = 'locacao' 
WHERE assunto LIKE '%aluguel%' OR assunto LIKE '%locação%' OR assunto LIKE '%locar%';

-- Verificar estrutura atualizada
DESCRIBE contatos;
