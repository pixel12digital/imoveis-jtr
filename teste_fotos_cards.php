<?php
// Teste de carregamento de fotos nos cards
require_once 'config/database.php';

echo "<h2>🔍 Teste de Carregamento de Fotos nos Cards</h2>";
echo "<style>body { font-family: Arial, sans-serif; margin: 20px; }</style>";

$imovel_id = 6; // ID do imóvel do teste

echo "<h3>📋 Verificando imóvel ID {$imovel_id}:</h3>";

// 1. Verificar dados do imóvel
$imovel = fetch("SELECT * FROM imoveis WHERE id = ?", [$imovel_id]);
if ($imovel) {
    echo "<div style='background: #d4edda; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
    echo "<h4>✅ Imóvel encontrado:</h4>";
    echo "<p><strong>ID:</strong> {$imovel['id']}</p>";
    echo "<p><strong>Título:</strong> " . htmlspecialchars($imovel['titulo']) . "</p>";
    echo "<p><strong>Destaque:</strong> " . ($imovel['destaque'] ? 'Sim' : 'Não') . "</p>";
    echo "<p><strong>Status:</strong> {$imovel['status']}</p>";
    echo "</div>";
} else {
    echo "<div style='background: #f8d7da; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
    echo "<h4>❌ Imóvel não encontrado</h4>";
    echo "</div>";
    exit;
}

// 2. Verificar fotos do imóvel
echo "<h3>📸 Verificando fotos:</h3>";
$fotos = fetchAll("SELECT * FROM fotos_imovel WHERE imovel_id = ? ORDER BY ordem", [$imovel_id]);

if ($fotos) {
    echo "<div style='background: #d4edda; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
    echo "<h4>✅ Fotos encontradas: " . count($fotos) . "</h4>";
    
    echo "<table border='1' style='border-collapse: collapse; width: 100%; margin-top: 10px;'>";
    echo "<tr style='background: #f0f0f0;'>";
    echo "<th style='padding: 8px;'>Ordem</th>";
    echo "<th style='padding: 8px;'>Arquivo</th>";
    echo "<th style='padding: 8px;'>Principal</th>";
    echo "<th style='padding: 8px;'>Status</th>";
    echo "</tr>";
    
    foreach ($fotos as $foto) {
        $status = file_exists("uploads/imoveis/{$imovel_id}/{$foto['arquivo']}") ? "✅ Existe" : "❌ Não existe";
        $principal = $foto['principal'] ? "⭐ Sim" : "❌ Não";
        
        echo "<tr>";
        echo "<td style='padding: 8px;'>{$foto['ordem']}</td>";
        echo "<td style='padding: 8px;'>" . htmlspecialchars($foto['arquivo']) . "</td>";
        echo "<td style='padding: 8px;'>{$principal}</td>";
        echo "<td style='padding: 8px;'>{$status}</td>";
        echo "</tr>";
    }
    echo "</table>";
    echo "</div>";
    
    // 3. Testar nova lógica de busca
    echo "<h3>🔍 Testando nova lógica de busca:</h3>";
    
    // Buscar primeira foto por ordem (nova lógica)
    $primeira_foto = fetch("SELECT arquivo FROM fotos_imovel WHERE imovel_id = ? ORDER BY ordem ASC LIMIT 1", [$imovel_id]);
    
    if ($primeira_foto) {
        echo "<div style='background: #d4edda; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
        echo "<h4>✅ Primeira foto encontrada (nova lógica):</h4>";
        echo "<p><strong>Arquivo:</strong> " . htmlspecialchars($primeira_foto['arquivo']) . "</p>";
        echo "<p><strong>Ordem:</strong> 1 (primeira)</p>";
        
        // Verificar se o arquivo existe
        $arquivo_path = "uploads/imoveis/{$imovel_id}/{$primeira_foto['arquivo']}";
        if (file_exists($arquivo_path)) {
            echo "<p><strong>Status:</strong> ✅ Arquivo físico existe</p>";
            echo "<p><strong>Caminho:</strong> {$arquivo_path}</p>";
            
            // Mostrar imagem
            echo "<h4>🖼️ Visualização da primeira foto:</h4>";
            echo "<img src='{$arquivo_path}' style='max-width: 300px; border: 2px solid #28a745; border-radius: 8px;' alt='Primeira foto'>";
        } else {
            echo "<p><strong>Status:</strong> ❌ Arquivo físico não existe</p>";
        }
        echo "</div>";
    } else {
        echo "<div style='background: #f8d7da; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
        echo "<h4>❌ Nenhuma foto encontrada</h4>";
        echo "</div>";
    }
    
    // 4. Comparar com lógica antiga
    echo "<h3>🔄 Comparando lógicas:</h3>";
    
    // Lógica antiga (por coluna principal)
    $foto_principal_antiga = fetch("SELECT arquivo FROM fotos_imovel WHERE imovel_id = ? AND principal = 1 LIMIT 1", [$imovel_id]);
    
    echo "<div style='background: #fff3cd; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
    echo "<h4>📊 Comparação:</h4>";
    echo "<p><strong>Lógica antiga (principal = 1):</strong> " . ($foto_principal_antiga ? htmlspecialchars($foto_principal_antiga['arquivo']) : "❌ Nenhuma foto") . "</p>";
    echo "<p><strong>Lógica nova (ordem ASC):</strong> " . ($primeira_foto ? htmlspecialchars($primeira_foto['arquivo']) : "❌ Nenhuma foto") . "</p>";
    
    if ($foto_principal_antiga && $primeira_foto) {
        if ($foto_principal_antiga['arquivo'] === $primeira_foto['arquivo']) {
            echo "<p><strong>Resultado:</strong> ✅ Ambas as lógicas retornam a mesma foto</p>";
        } else {
            echo "<p><strong>Resultado:</strong> ⚠️ Lógicas retornam fotos diferentes</p>";
        }
    } elseif ($primeira_foto && !$foto_principal_antiga) {
        echo "<p><strong>Resultado:</strong> ✅ Nova lógica funciona, antiga não</p>";
    } else {
        echo "<p><strong>Resultado:</strong> ❌ Ambas as lógicas falharam</p>";
    }
    echo "</div>";
    
} else {
    echo "<div style='background: #f8d7da; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
    echo "<h4>❌ Nenhuma foto encontrada para este imóvel</h4>";
    echo "</div>";
}

echo "<h3>🎯 Conclusão:</h3>";
echo "<p>A nova lógica deve funcionar corretamente agora. Teste acessando:</p>";
echo "<ul>";
echo "<li><a href='pages/home.php' target='_blank'>🏠 Home (Imóveis em Destaque)</a></li>";
echo "<li><a href='pages/filtros-avancados.php' target='_blank'>🔍 Filtros Avançados</a></li>";
echo "<li><a href='pages/imoveis.php' target='_blank'>📋 Lista de Imóveis</a></li>";
echo "</ul>";

echo "<p><strong>✅ As imagens devem aparecer nos cards agora!</strong></p>";
?>
