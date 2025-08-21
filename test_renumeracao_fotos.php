<?php
// Teste de renumeração de fotos
require_once 'config/database.php';

echo "<h2>Teste de Renumeração de Fotos</h2>";

// Simular exclusão de fotos com IDs 1 e 3
$imovel_id = 6; // ID do imóvel do print

echo "<h3>Estado atual das fotos:</h3>";
$fotos_atuais = fetchAll("SELECT id, ordem, arquivo FROM fotos_imovel WHERE imovel_id = ? ORDER BY ordem", [$imovel_id]);
echo "<pre>";
print_r($fotos_atuais);
echo "</pre>";

// Simular exclusão das fotos com IDs 1 e 3
echo "<h3>Simulando exclusão das fotos com IDs 1 e 3...</h3>";

// Excluir fotos (simulação)
// query("DELETE FROM fotos_imovel WHERE id IN (1, 3) AND imovel_id = ?", [$imovel_id]);

// Reordenar as fotos restantes
echo "<h3>Reordenando fotos restantes...</h3>";
$fotos_restantes = fetchAll("SELECT id FROM fotos_imovel WHERE imovel_id = ? ORDER BY ordem", [$imovel_id]);

echo "Fotos restantes encontradas: " . count($fotos_restantes) . "<br>";

foreach ($fotos_restantes as $index => $foto) {
    $nova_ordem = $index + 1;
    echo "Atualizando foto ID {$foto['id']} para ordem {$nova_ordem}<br>";
    // query("UPDATE fotos_imovel SET ordem = ? WHERE id = ?", [$nova_ordem, $foto['id']]);
}

echo "<h3>Estado final das fotos:</h3>";
$fotos_finais = fetchAll("SELECT id, ordem, arquivo FROM fotos_imovel WHERE imovel_id = ? ORDER BY ordem", [$imovel_id]);
echo "<pre>";
print_r($fotos_finais);
echo "</pre>";

echo "<h3>Teste concluído!</h3>";
echo "<p>Para aplicar as mudanças, descomente as linhas de query() no código.</p>";
?>
