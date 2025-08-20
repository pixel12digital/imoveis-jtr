-- 🔧 CORRIGIR FOTO PRINCIPAL DO IMÓVEL ID 6
-- Execute este comando no seu banco de dados

-- 1. Verificar fotos disponíveis para o imóvel 6
SELECT id, arquivo, principal, ordem 
FROM fotos_imovel 
WHERE imovel_id = 6 
ORDER BY ordem ASC, id ASC;

-- 2. Definir a primeira foto como principal
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

-- 3. Verificar se foi corrigido
SELECT i.id, i.titulo, f.arquivo as foto_principal, f.principal
FROM imoveis i
LEFT JOIN fotos_imovel f ON i.id = f.imovel_id AND f.principal = 1
WHERE i.id = 6;

-- 4. Verificar todas as fotos do imóvel 6
SELECT * FROM fotos_imovel WHERE imovel_id = 6 ORDER BY principal DESC, ordem ASC;
