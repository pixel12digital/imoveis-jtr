-- Script FORÇADO para limpar localizações
-- ⚠️ ATENÇÃO: Este script irá REMOVER TODAS as localizações cadastradas

-- Verificar permissões e configurações
SHOW VARIABLES LIKE 'sql_mode';
SHOW VARIABLES LIKE 'foreign_key_checks';

-- Desabilitar verificações de chave estrangeira temporariamente
SET FOREIGN_KEY_CHECKS = 0;

-- Verificar o que existe
SELECT 'ANTES:' as info;
SELECT COUNT(*) as total FROM localizacoes;

-- Tentar múltiplas formas de limpeza
-- Forma 1: DELETE simples
DELETE FROM localizacoes;

-- Forma 2: DELETE com WHERE
DELETE FROM localizacoes WHERE id IS NOT NULL;

-- Forma 3: DELETE com condição sempre verdadeira
DELETE FROM localizacoes WHERE 1=1;

-- Forma 4: TRUNCATE (mais agressivo)
TRUNCATE TABLE localizacoes;

-- Reabilitar verificações de chave estrangeira
SET FOREIGN_KEY_CHECKS = 1;

-- Verificar resultado
SELECT 'DEPOIS:' as info;
SELECT COUNT(*) as total FROM localizacoes;

-- Confirmar limpeza
SELECT 
    CASE 
        WHEN COUNT(*) = 0 THEN '✅ LIMPEZA CONCLUÍDA!'
        ELSE CONCAT('❌ FALHOU: ', COUNT(*), ' localizações restantes')
    END as status
FROM localizacoes;












