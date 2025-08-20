<?php
require_once 'config/config.php';
require_once 'config/database.php';
require_once 'config/paths.php';

echo "<h2>🔍 VERIFICANDO CAMINHOS DAS IMAGENS</h2>";

try {
    // Usar a variável global $pdo que já está disponível
    global $pdo;
    
    if (!isset($pdo)) {
        throw new Exception("Conexão com banco não encontrada!");
    }
    
    // Verificar estrutura da tabela fotos_imovel
    echo "<h3>📋 Estrutura da tabela fotos_imovel:</h3>";
    $stmt = $pdo->query("DESCRIBE fotos_imovel");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo "<pre>";
    print_r($columns);
    echo "</pre>";
    
    // Verificar todas as fotos do imóvel 6
    echo "<h3>🖼️ Fotos do Imóvel ID 6:</h3>";
    $stmt = $pdo->prepare("SELECT id, arquivo, principal, ordem, imovel_id FROM fotos_imovel WHERE imovel_id = 6 ORDER BY principal DESC, ordem ASC");
    $stmt->execute();
    $fotos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
    echo "<tr><th>ID</th><th>Arquivo</th><th>Principal</th><th>Ordem</th><th>Imóvel ID</th></tr>";
    
    foreach ($fotos as $foto) {
        $status = $foto['principal'] ? '✅ PRINCIPAL' : '📷';
        echo "<tr>";
        echo "<td>{$foto['id']}</td>";
        echo "<td style='word-break: break-all;'>{$foto['arquivo']}</td>";
        echo "<td>{$status}</td>";
        echo "<td>{$foto['ordem']}</td>";
        echo "<td>{$foto['imovel_id']}</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    // Verificar se há fotos com caminhos incorretos
    echo "<h3>🔍 Verificando caminhos incorretos:</h3>";
    $stmt = $pdo->prepare("SELECT id, arquivo FROM fotos_imovel WHERE imovel_id = 6 AND arquivo LIKE '%/s/%'");
    $stmt->execute();
    $caminhos_incorretos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (empty($caminhos_incorretos)) {
        echo "<p>✅ Nenhum caminho incorreto encontrado!</p>";
    } else {
        echo "<p>❌ Caminhos incorretos encontrados:</p>";
        echo "<ul>";
        foreach ($caminhos_incorretos as $caminho) {
            echo "<li>ID {$caminho['id']}: {$caminho['arquivo']}</li>";
        }
        echo "</ul>";
    }
    
    // Testar função getUploadPath
    echo "<h3>🧪 Testando função getUploadPath:</h3>";
    if (!empty($fotos)) {
        $primeira_foto = $fotos[0];
        echo "<p><strong>Primeira foto:</strong> {$primeira_foto['arquivo']}</p>";
        
        if (function_exists('getUploadPath')) {
            $url_gerada = getUploadPath($primeira_foto['arquivo']);
            echo "<p><strong>URL gerada:</strong> {$url_gerada}</p>";
        } else {
            echo "<p>❌ Função getUploadPath não existe!</p>";
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
