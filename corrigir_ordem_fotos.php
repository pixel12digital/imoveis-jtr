<?php
// Script para corrigir a ordem das fotos
require_once 'config/database.php';

echo "<h2>Corrigindo Ordem das Fotos</h2>";

$imovel_id = 6; // ID do imóvel do print

echo "<h3>Estado atual das fotos:</h3>";
$fotos_atuais = fetchAll("SELECT id, ordem, arquivo FROM fotos_imovel WHERE imovel_id = ? ORDER BY ordem", [$imovel_id]);
echo "<pre>";
print_r($fotos_atuais);
echo "</pre>";

echo "<h3>Corrigindo ordem das fotos...</h3>";

// Reordenar as fotos sequencialmente
foreach ($fotos_atuais as $index => $foto) {
    $nova_ordem = $index + 1;
    echo "Atualizando foto ID {$foto['id']} de ordem {$foto['ordem']} para ordem {$nova_ordem}<br>";
    
    // Aplicar a correção
    query("UPDATE fotos_imovel SET ordem = ? WHERE id = ?", [$nova_ordem, $foto['id']]);
}

echo "<h3>Estado final das fotos:</h3>";
$fotos_finais = fetchAll("SELECT id, ordem, arquivo FROM fotos_imovel WHERE imovel_id = ? ORDER BY ordem", [$imovel_id]);
echo "<pre>";
print_r($fotos_finais);
echo "</pre>";

echo "<h3>Correção concluída!</h3>";
echo "<p>As fotos foram reordenadas sequencialmente de 1 a " . count($fotos_finais) . ".</p>";
?>
