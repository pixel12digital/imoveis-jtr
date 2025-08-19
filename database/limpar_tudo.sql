-- Script para limpar TODAS as localizações
-- ⚠️ ATENÇÃO: Este script irá REMOVER TODAS as localizações cadastradas

-- Verificar o que será removido
SELECT 
    id,
    cidade,
    bairro,
    estado,
    cep
FROM localizacoes;

-- Contar quantas localizações existem
SELECT COUNT(*) as total_localizacoes FROM localizacoes;

-- ⚠️ LIMPAR TODAS AS LOCALIZAÇÕES
TRUNCATE TABLE localizacoes;

-- Verificar se foi limpo
SELECT COUNT(*) as total_apos_limpeza FROM localizacoes;

-- Confirmar que está vazio
SELECT '✅ Tabela localizacoes limpa com sucesso!' as resultado;



