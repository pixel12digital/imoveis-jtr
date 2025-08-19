-- Arquivo de localizações básicas para imobiliárias locais
-- Execute este arquivo para ter uma estrutura limpa

-- NÃO precisa do USE, pois você já está no banco correto
-- USE u342734079_jtrimoveis;

-- Limpar localizações existentes (opcional)
-- DELETE FROM localizacoes;

-- IMPORTANTE: Este arquivo está vazio intencionalmente
-- A imobiliária deve cadastrar apenas as localizações que realmente usa
-- através do sistema integrado na criação de imóveis

-- Para verificar se a tabela está funcionando:
SELECT 
    id,
    cidade,
    bairro,
    estado,
    cep
FROM localizacoes 
ORDER BY estado, cidade, bairro;

-- Contar total (deve ser 0 inicialmente)
SELECT COUNT(*) as total_localizacoes FROM localizacoes;
