-- Arquivo para verificar se a estrutura de localizações está funcionando
-- Execute este arquivo para testar a conexão e estrutura

-- Verificar se a tabela localizacoes existe e está funcionando
SELECT 
    id,
    cidade,
    bairro,
    estado,
    cep
FROM localizacoes 
ORDER BY estado, cidade, bairro;

-- Contar total de localizações (deve ser 0 inicialmente)
SELECT COUNT(*) as total_localizacoes FROM localizacoes;

-- Verificar estrutura da tabela
DESCRIBE localizacoes;

-- Verificar se há imóveis cadastrados
SELECT COUNT(*) as total_imoveis FROM imoveis;

-- Verificar relacionamento entre imóveis e localizações
SELECT 
    i.id as imovel_id,
    i.titulo,
    l.cidade,
    l.bairro,
    l.estado
FROM imoveis i
LEFT JOIN localizacoes l ON i.localizacao_id = l.id
LIMIT 5;

