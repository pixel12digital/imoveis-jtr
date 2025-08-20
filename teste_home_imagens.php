<?php
require_once 'config/config.php';
require_once 'config/database.php';
require_once 'config/paths.php';

echo "<h2>🏠 TESTANDO IMAGENS NA HOME</h2>";

try {
    global $pdo;
    
    // Buscar imóveis em destaque
    echo "<h3>🔍 Imóveis em Destaque:</h3>";
    $stmt = $pdo->prepare("
        SELECT i.id, i.titulo, i.preco, i.foto_principal, 
               l.cidade, l.bairro
        FROM imoveis i 
        LEFT JOIN localizacoes l ON i.localizacao_id = l.id 
        WHERE i.destaque = 1 
        ORDER BY i.id DESC 
        LIMIT 6
    ");
    $stmt->execute();
    $imoveis_destaque = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (empty($imoveis_destaque)) {
        echo "<p>❌ Nenhum imóvel em destaque encontrado!</p>";
    } else {
        echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
        echo "<tr><th>ID</th><th>Título</th><th>Foto Principal</th><th>URL Gerada</th><th>Localização</th></tr>";
        
        foreach ($imoveis_destaque as $imovel) {
            echo "<tr>";
            echo "<td>{$imovel['id']}</td>";
            echo "<td>{$imovel['titulo']}</td>";
            echo "<td>{$imovel['foto_principal']}</td>";
            
            // Gerar URL da imagem
            if ($imovel['foto_principal']) {
                $url_imagem = getUploadPath($imovel['foto_principal']);
                echo "<td style='word-break: break-all;'>{$url_imagem}</td>";
            } else {
                echo "<td style='color: red;'>❌ Sem foto</td>";
            }
            
            echo "<td>{$imovel['cidade']} - {$imovel['bairro']}</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
    
    // Verificar se há fotos marcadas como principal
    echo "<h3>🔍 Verificando Fotos Principais:</h3>";
    $stmt = $pdo->prepare("
        SELECT i.id, i.titulo, f.arquivo, f.principal
        FROM imoveis i
        LEFT JOIN fotos_imovel f ON i.id = f.imovel_id AND f.principal = 1
        WHERE i.destaque = 1
        ORDER BY i.id DESC
    ");
    $stmt->execute();
    $fotos_principais = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
    echo "<tr><th>Imóvel ID</th><th>Título</th><th>Foto Principal</th><th>Status</th></tr>";
    
    foreach ($fotos_principais as $foto) {
        $status = $foto['arquivo'] ? '✅ Tem foto' : '❌ Sem foto';
        echo "<tr>";
        echo "<td>{$foto['id']}</td>";
        echo "<td>{$foto['titulo']}</td>";
        echo "<td>{$foto['arquivo']}</td>";
        echo "<td>{$status}</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    // Testar se a função getUploadPath está funcionando
    echo "<h3>🧪 Testando getUploadPath:</h3>";
    if (!empty($fotos_principais)) {
        foreach ($fotos_principais as $foto) {
            if ($foto['arquivo']) {
                $url = getUploadPath($foto['arquivo']);
                echo "<p><strong>Imóvel {$foto['id']}:</strong> {$url}</p>";
            }
        }
    }
    
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Erro: " . $e->getMessage() . "</p>";
}
?>

<style>
body { font-family: Arial, sans-serif; margin: 20px; }
table { margin: 20px 0; }
th, td { padding: 8px; text-align: left; }
th { background-color: #f2f2f2; }
</style>
