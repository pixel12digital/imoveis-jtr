-- 🔧 CORRIGIR FOTO PRINCIPAL - COMANDO SIMPLES
-- Execute este comando no phpMyAdmin

-- Definir a primeira foto do imóvel 6 como principal
UPDATE fotos_imovel 
SET principal = 1 
WHERE id = (
    SELECT id FROM (
        SELECT id 
        FROM fotos_imovel 
        WHERE imovel_id = 6 
        ORDER BY ordem ASC, id ASC 
        LIMIT 1
    ) AS temp
);

-- Verificar se foi corrigido
SELECT id, arquivo, principal, ordem 
FROM fotos_imovel 
WHERE imovel_id = 6 
ORDER BY principal DESC, ordem ASC;
