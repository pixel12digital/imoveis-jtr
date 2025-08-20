<?php
require_once 'config/config.php';
require_once 'config/paths.php';

echo "<h2>🏠 VERIFICANDO IMAGEM NA HOME</h2>";

try {
    // Simular a query da home para imóveis em destaque
    echo "<h3>🔍 Simulando Query da Home:</h3>";
    
    // Buscar imóveis em destaque (como na home)
    global $pdo;
    
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
        echo "<tr><th>ID</th><th>Título</th><th>Foto Principal</th><th>URL Gerada</th><th>Status</th></tr>";
        
        foreach ($imoveis_destaque as $imovel) {
            echo "<tr>";
            echo "<td>{$imovel['id']}</td>";
            echo "<td>{$imovel['titulo']}</td>";
            echo "<td>{$imovel['foto_principal']}</td>";
            
            // Gerar URL da imagem (como na home)
            if ($imovel['foto_principal']) {
                $url_imagem = getUploadPath($imovel['foto_principal']);
                echo "<td style='word-break: break-all;'>{$url_imagem}</td>";
                
                // Verificar se a URL está correta
                if ($url_imagem && $url_imagem !== false) {
                    echo "<td style='color: green;'>✅ URL gerada</td>";
                } else {
                    echo "<td style='color: red;'>❌ Falha na geração</td>";
                }
            } else {
                echo "<td style='color: red;'>❌ Sem foto</td>";
                echo "<td style='color: red;'>❌ Sem foto</td>";
            }
            
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
    echo "<tr><th>Imóvel ID</th><th>Título</th><th>Foto Principal</th><th>URL Final</th></tr>";
    
    foreach ($fotos_principais as $foto) {
        echo "<tr>";
        echo "<td>{$foto['id']}</td>";
        echo "<td>{$foto['titulo']}</td>";
        echo "<td>{$foto['arquivo']}</td>";
        
        if ($foto['arquivo']) {
            $final_url = getUploadPath($foto['arquivo']);
            echo "<td style='word-break: break-all;'>{$final_url}</td>";
        } else {
            echo "<td style='color: red;'>❌ Sem arquivo</td>";
        }
        
        echo "</tr>";
    }
    echo "</table>";
    
    // Teste final: verificar se a função está funcionando como esperado
    echo "<h3>🧪 Teste Final: Verificação da Função</h3>";
    $test_cases = [
        "68a4aeae5ee32.jpeg" => "Arquivo simples",
        "imoveis/6/68a4aeae5ee32.jpeg" => "Com caminho parcial",
        "uploads/imoveis/6/68a4aeae5ee32.jpeg" => "Com caminho completo"
    ];
    
    foreach ($test_cases as $test_file => $description) {
        $result = getUploadPath($test_file);
        echo "<p><strong>{$description}:</strong> {$test_file} → <span style='color: blue;'>{$result}</span></p>";
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
