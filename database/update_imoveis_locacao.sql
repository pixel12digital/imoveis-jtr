-- Adicionar campos para locação na tabela imoveis
-- Permitir múltiplos tipos de negócio e preço de locação

-- Modificar o campo tipo_negocio para permitir venda_locacao
ALTER TABLE imoveis 
MODIFY COLUMN tipo_negocio ENUM('venda', 'locacao', 'venda_locacao') DEFAULT 'venda';

-- Adicionar campo para preço de locação
ALTER TABLE imoveis 
ADD COLUMN preco_locacao DECIMAL(12,2) NULL AFTER preco;

-- Adicionar campo para condições de locação
ALTER TABLE imoveis 
ADD COLUMN condicoes_locacao TEXT NULL AFTER preco_locacao;

-- Criar índice para melhor performance no tipo_negocio
CREATE INDEX idx_imoveis_tipo_negocio ON imoveis(tipo_negocio);

-- Atualizar comentário da tabela
ALTER TABLE imoveis COMMENT = 'Tabela de imóveis com suporte a múltiplos tipos de negócio (venda/locação)';

-- Verificar se a alteração foi aplicada
SELECT COLUMN_NAME, DATA_TYPE, IS_NULLABLE, COLUMN_DEFAULT, COLUMN_COMMENT
FROM INFORMATION_SCHEMA.COLUMNS 
WHERE TABLE_SCHEMA = 'jtr_imoveis' 
AND TABLE_NAME = 'imoveis' 
AND COLUMN_NAME IN ('tipo_negocio', 'preco_locacao', 'condicoes_locacao');
