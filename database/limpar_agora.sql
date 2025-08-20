-- Script AGESSIVO para limpar TODAS as localizações
-- ⚠️ ATENÇÃO: Este script irá REMOVER TODAS as localizações cadastradas

-- 1. Verificar o que existe ANTES
SELECT 'ANTES DA LIMPEZA:' as info;
SELECT COUNT(*) as total_localizacoes FROM localizacoes;

-- 2. Mostrar todas as localizações que serão removidas
SELECT 
    id,
    cidade,
    bairro,
    estado,
    cep
FROM localizacoes;

-- 3. LIMPEZA COMPLETA - Múltiplas opções
-- Opção A: DELETE simples
DELETE FROM localizacoes;

-- Opção B: Se a opção A não funcionar, usar WHERE
-- DELETE FROM localizacoes WHERE id > 0;

-- Opção C: Se ainda não funcionar, usar TRUNCATE
-- TRUNCATE TABLE localizacoes;

-- 4. Verificar se foi limpo
SELECT 'DEPOIS DA LIMPEZA:' as info;
SELECT COUNT(*) as total_localizacoes FROM localizacoes;

-- 5. Confirmar que está vazio
SELECT 
    CASE 
        WHEN COUNT(*) = 0 THEN '✅ SUCESSO: Tabela localizacoes limpa!'
        ELSE CONCAT('❌ FALHOU: Ainda existem ', COUNT(*), ' localização(ões)')
    END as resultado
FROM localizacoes;

-- 6. Verificar estrutura da tabela
DESCRIBE localizacoes;




