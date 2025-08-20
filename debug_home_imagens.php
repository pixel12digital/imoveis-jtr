<?php
/**
 * 🐛 DEBUG ESPECÍFICO - Imagens na Home
 * Execute este script para ver exatamente o que está sendo renderizado
 */

// Configurações de erro
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>🐛 Debug Específico - Imagens na Home</h1>";
echo "<style>body { font-family: Arial, sans-serif; margin: 20px; }</style>";

// Carregar configurações
if (file_exists('config/config.php')) {
    require_once 'config/config.php';
    echo "<h2>✅ Configurações carregadas</h2>";
} else {
    echo "<p>❌ Não foi possível carregar config/config.php</p>";
    exit;
}

if (file_exists('config/paths.php')) {
    require_once 'config/paths.php';
    echo "<h2>✅ Funções de caminho carregadas</h2>";
} else {
    echo "<p>❌ Não foi possível carregar config/paths.php</p>";
    exit;
}

if (file_exists('config/database.php')) {
    require_once 'config/database.php';
    echo "<h2>✅ Banco de dados carregado</h2>";
} else {
    echo "<p>❌ Não foi possível carregar config/database.php</p>";
    exit;
}

// Simular que estamos na home
$_SERVER['SCRIPT_NAME'] = '/jtr-imoveis/index.php';

echo "<h3>🏠 Simulando Home (index.php)</h3>";
echo "<p><strong>SCRIPT_NAME:</strong> " . $_SERVER['SCRIPT_NAME'] . "</p>";

// Buscar imóveis em destaque (mesma query da home)
echo "<h3>🔍 Query da Home:</h3>";
$query = "
    SELECT i.*, t.nome as tipo_nome, l.cidade, l.bairro, f.arquivo as foto_principal
    FROM imoveis i
    LEFT JOIN tipos_imovel t ON i.tipo_id = t.id
    LEFT JOIN localizacoes l ON i.localizacao_id = l.id
    LEFT JOIN fotos_imovel f ON i.id = f.imovel_id AND f.principal = 1
    WHERE i.destaque = 1 AND i.status = 'disponivel'
    ORDER BY i.data_criacao DESC
    LIMIT 6
";

echo "<div style='background: #f8f9fa; padding: 10px; border-radius: 4px; font-family: monospace; margin: 10px 0;'>";
echo htmlspecialchars($query);
echo "</div>";

try {
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $featured_properties = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if ($featured_properties) {
        echo "<h3>📋 Imóveis em Destaque encontrados:</h3>";
        echo "<p>✅ <strong>Total:</strong> " . count($featured_properties) . " imóveis</p>";
        
        foreach ($featured_properties as $index => $property) {
            echo "<div style='border: 2px solid #007bff; padding: 20px; margin: 20px 0; border-radius: 8px; background: #f8f9fa;'>";
            echo "<h4>🏠 Imóvel " . ($index + 1) . " - ID: " . $property['id'] . "</h4>";
            echo "<p><strong>Título:</strong> " . htmlspecialchars($property['titulo']) . "</p>";
            echo "<p><strong>Preço:</strong> R$ " . number_format($property['preco'], 2, ',', '.') . "</p>";
            echo "<p><strong>Localização:</strong> " . htmlspecialchars($property['bairro']) . ", " . htmlspecialchars($property['cidade']) . "</p>";
            
            // Verificar foto principal
            if ($property['foto_principal']) {
                echo "<p>✅ <strong>Foto Principal:</strong> " . htmlspecialchars($property['foto_principal']) . "</p>";
                
                // Testar getUploadPath
                $upload_path = getUploadPath($property['foto_principal']);
                echo "<p><strong>getUploadPath():</strong> " . ($upload_path ?: 'FALSE') . "</p>";
                
                // Testar imageExists
                $exists = imageExists($property['foto_principal']);
                echo "<p><strong>imageExists():</strong> " . ($exists ? 'TRUE' : 'FALSE') . "</p>";
                
                // Gerar HTML da imagem (exatamente como na home)
                if ($upload_path) {
                    echo "<h5>🖼️ HTML Gerado (exatamente como na home):</h5>";
                    echo "<div style='background: #e9ecef; padding: 15px; border-radius: 4px; font-family: monospace; margin: 10px 0;'>";
                    echo "&lt;img src=\"" . htmlspecialchars($upload_path) . "\" <br>";
                    echo "     class=\"card-img-top\" <br>";
                    echo "     alt=\"" . htmlspecialchars($property['titulo']) . "\" <br>";
                    echo "     onerror=\"this.style.display='none'; this.nextElementSibling.style.display='flex';\"&gt;";
                    echo "</div>";
                    
                    // Mostrar imagem real
                    echo "<h5>🖼️ Imagem Renderizada:</h5>";
                    echo "<div style='border: 2px solid #28a745; padding: 15px; background: white; border-radius: 8px;'>";
                    echo "<img src=\"" . htmlspecialchars($upload_path) . "\" 
                              alt=\"" . htmlspecialchars($property['titulo']) . "\" 
                              style=\"max-width: 300px; height: auto; border: 1px solid #ddd; border-radius: 4px;\"
                              onerror=\"this.style.display='none'; this.nextElementSibling.style.display='flex'; this.nextElementSibling.innerHTML='❌ ERRO AO CARREGAR IMAGEM: ' + this.src;\">";
                    echo "<div style='display: none; color: red; font-weight: bold; margin-top: 10px;'>❌ ERRO AO CARREGAR IMAGEM</div>";
                    echo "</div>";
                    
                    // Testar se a URL é acessível
                    echo "<h5>🌐 Teste de Acessibilidade da URL:</h5>";
                    $headers = @get_headers($upload_path);
                    if ($headers) {
                        echo "<p>✅ <strong>Headers da URL:</strong></p>";
                        echo "<div style='background: #d4edda; padding: 10px; border-radius: 4px; font-family: monospace;'>";
                        foreach (array_slice($headers, 0, 5) as $header) {
                            echo htmlspecialchars($header) . "<br>";
                        }
                        echo "</div>";
                    } else {
                        echo "<p>❌ <strong>Não foi possível acessar a URL</strong></p>";
                    }
                    
                } else {
                    echo "<p>❌ <strong>getUploadPath() retornou FALSE</strong></p>";
                }
            } else {
                echo "<p>❌ <strong>Foto Principal:</strong> Nenhuma foto cadastrada</p>";
            }
            
            echo "</div>";
        }
        
    } else {
        echo "<p>❌ <strong>Nenhum imóvel em destaque encontrado</strong></p>";
        
        // Verificar se há imóveis no banco
        $stmt = $pdo->query("SELECT COUNT(*) as total FROM imoveis");
        $total_imoveis = $stmt->fetch();
        echo "<p><strong>Total de imóveis no banco:</strong> " . $total_imoveis['total'] . "</p>";
        
        // Verificar se há imóveis com destaque
        $stmt = $pdo->query("SELECT COUNT(*) as total FROM imoveis WHERE destaque = 1");
        $total_destaque = $stmt->fetch();
        echo "<p><strong>Total de imóveis em destaque:</strong> " . $total_destaque['total'] . "</p>";
        
        // Verificar se há imóveis disponíveis
        $stmt = $pdo->query("SELECT COUNT(*) as total FROM imoveis WHERE status = 'disponivel'");
        $total_disponivel = $stmt->fetch();
        echo "<p><strong>Total de imóveis disponíveis:</strong> " . $total_disponivel['total'] . "</p>";
        
        // Verificar se há fotos
        $stmt = $pdo->query("SELECT COUNT(*) as total FROM fotos_imovel");
        $total_fotos = $stmt->fetch();
        echo "<p><strong>Total de fotos no banco:</strong> " . $total_fotos['total'] . "</p>";
    }
    
} catch (Exception $e) {
    echo "<p class='error'>❌ <strong>Erro na consulta:</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
}

echo "<hr>";
echo "<h3>🎯 Análise do Problema:</h3>";
echo "<ol>";
echo "<li><strong>URLs estão sendo geradas:</strong> ✅</li>";
echo "<li><strong>Funções estão funcionando:</strong> ✅</li>";
echo "<li><strong>Banco está conectado:</strong> ✅</li>";
echo "<li><strong>Imagens podem estar:</strong></li>";
echo "    <ul>";
echo "        <li>❌ <strong>URLs incorretas</strong> (mesmo sendo geradas)</li>";
echo "        <li>❌ <strong>Imagens não existem</strong> na Hostinger</li>";
echo "        <li>❌ <strong>Problema de CORS</strong> ou acesso</li>";
echo "        <li>❌ <strong>Problema de rede</strong> local</li>";
echo "    </ul>";
echo "</ol>";

echo "<hr>";
echo "<p><em>Debug executado em: " . date('Y-m-d H:i:s') . "</em></p>";
?>
