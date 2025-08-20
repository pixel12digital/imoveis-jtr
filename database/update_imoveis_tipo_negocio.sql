-- Adicionar campo tipo_negocio para identificar se o imóvel é para venda ou locação
ALTER TABLE imoveis 
ADD COLUMN tipo_negocio ENUM('venda', 'locacao') DEFAULT 'venda' AFTER status;

-- Criar índice para melhor performance
CREATE INDEX idx_imoveis_tipo_negocio ON imoveis(tipo_negocio);

-- Atualizar imóveis existentes baseado no status
-- Por padrão, imóveis disponíveis são para venda
UPDATE imoveis SET tipo_negocio = 'venda' WHERE status = 'disponivel';

-- Imóveis alugados são para locação
UPDATE imoveis SET tipo_negocio = 'locacao' WHERE status = 'alugado';

-- Imóveis vendidos eram para venda
UPDATE imoveis SET tipo_negocio = 'venda' WHERE status = 'vendido';

-- Comentário da tabela
ALTER TABLE imoveis COMMENT = 'Tabela de imóveis com campo tipo_negocio para identificar venda/locação';
