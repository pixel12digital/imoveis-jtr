-- Script para corrigir a ordem das fotos do imóvel ID 6
-- Este script reordena as fotos sequencialmente após exclusões

-- Primeiro, vamos ver o estado atual
SELECT id, ordem, arquivo FROM fotos_imovel WHERE imovel_id = 6 ORDER BY ordem;

-- Agora vamos corrigir a ordem das fotos restantes
-- Foto ID 6 (atual ordem 2) -> nova ordem 1
UPDATE fotos_imovel SET ordem = 1 WHERE id = 6 AND imovel_id = 6;

-- Foto ID 8 (atual ordem 4) -> nova ordem 2
UPDATE fotos_imovel SET ordem = 2 WHERE id = 8 AND imovel_id = 6;

-- Foto ID 9 (atual ordem 5) -> nova ordem 3
UPDATE fotos_imovel SET ordem = 3 WHERE id = 9 AND imovel_id = 6;

-- Foto ID 10 (atual ordem 6) -> nova ordem 4
UPDATE fotos_imovel SET ordem = 4 WHERE id = 10 AND imovel_id = 6;

-- Foto ID 11 (atual ordem 7) -> nova ordem 5
UPDATE fotos_imovel SET ordem = 5 WHERE id = 11 AND imovel_id = 6;

-- Foto ID 12 (atual ordem 8) -> nova ordem 6
UPDATE fotos_imovel SET ordem = 6 WHERE id = 12 AND imovel_id = 6;

-- Foto ID 13 (atual ordem 9) -> nova ordem 7
UPDATE fotos_imovel SET ordem = 7 WHERE id = 13 AND imovel_id = 6;

-- Foto ID 14 (atual ordem 10) -> nova ordem 8
UPDATE fotos_imovel SET ordem = 8 WHERE id = 14 AND imovel_id = 6;

-- Foto ID 15 (atual ordem 11) -> nova ordem 9
UPDATE fotos_imovel SET ordem = 9 WHERE id = 15 AND imovel_id = 6;

-- Foto ID 16 (atual ordem 12) -> nova ordem 10
UPDATE fotos_imovel SET ordem = 10 WHERE id = 16 AND imovel_id = 6;

-- Foto ID 17 (atual ordem 13) -> nova ordem 11
UPDATE fotos_imovel SET ordem = 11 WHERE id = 17 AND imovel_id = 6;

-- Foto ID 18 (atual ordem 14) -> nova ordem 12
UPDATE fotos_imovel SET ordem = 12 WHERE id = 18 AND imovel_id = 6;

-- Foto ID 19 (atual ordem 15) -> nova ordem 13
UPDATE fotos_imovel SET ordem = 13 WHERE id = 19 AND imovel_id = 6;

-- Foto ID 20 (atual ordem 16) -> nova ordem 14
UPDATE fotos_imovel SET ordem = 14 WHERE id = 20 AND imovel_id = 6;

-- Foto ID 21 (atual ordem 17) -> nova ordem 15
UPDATE fotos_imovel SET ordem = 15 WHERE id = 21 AND imovel_id = 6;

-- Foto ID 22 (atual ordem 18) -> nova ordem 16
UPDATE fotos_imovel SET ordem = 16 WHERE id = 22 AND imovel_id = 6;

-- Foto ID 23 (atual ordem 19) -> nova ordem 17
UPDATE fotos_imovel SET ordem = 17 WHERE id = 23 AND imovel_id = 6;

-- Foto ID 24 (atual ordem 20) -> nova ordem 18
UPDATE fotos_imovel SET ordem = 18 WHERE id = 24 AND imovel_id = 6;

-- Verificar o resultado final
SELECT id, ordem, arquivo FROM fotos_imovel WHERE imovel_id = 6 ORDER BY ordem;
