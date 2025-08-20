<?php
require_once 'config/config.php';
require_once 'config/database.php';
require_once 'config/paths.php';

echo "<h2>🔍 VERIFICANDO HTML DA HOME</h2>";

// Simular exatamente o que a home está fazendo
echo "<h3>📋 Simulando Query da Home:</h3>";

try {
    global $pdo;
    
    // Mesma query da home
    $stmt = $pdo->prepare("
        SELECT i.*, t.nome as tipo_nome, l.cidade, l.bairro, f.arquivo as foto_principal
        FROM imoveis i
        LEFT JOIN tipos_imovel t ON i.tipo_id = t.id
        LEFT JOIN localizacoes l ON i.localizacao_id = l.id
        LEFT JOIN fotos_imovel f ON i.id = f.imovel_id AND f.principal = 1
        WHERE i.destaque = 1 AND i.status = 'disponivel'
        ORDER BY i.data_criacao DESC
        LIMIT 1
    ");
    $stmt->execute();
    $property = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($property) {
        echo "<h4>✅ Imóvel encontrado:</h4>";
        echo "<p><strong>ID:</strong> {$property['id']}</p>";
        echo "<p><strong>Título:</strong> {$property['titulo']}</p>";
        echo "<p><strong>Foto Principal:</strong> {$property['foto_principal']}</p>";
        
        // Gerar URL da imagem
        $image_url = getUploadPath($property['foto_principal']);
        echo "<p><strong>URL gerada:</strong> {$image_url}</p>";
        
        // Simular HTML que seria gerado na home
        echo "<h4>🖼️ HTML que seria gerado na home:</h4>";
        echo "<div style='border: 2px solid #ccc; padding: 20px; margin: 20px; max-width: 400px;'>";
        echo "<h5>Card do Imóvel (Simulação)</h5>";
        
        if ($property['foto_principal']) {
            if ($image_url) {
                echo "<div style='position: relative;'>";
                echo "<img src='{$image_url}' 
                           style='width: 100%; height: 200px; object-fit: cover; border-radius: 8px 8px 0 0;' 
                           alt='{$property['titulo']}'
                           onload='this.nextElementSibling.style.display=\"none\";'
                           onerror='this.style.display=\"none\"; this.nextElementSibling.style.display=\"flex\";'>";
                echo "<div class='no-image' 
                           style='height: 200px; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); 
                                  border-radius: 8px 8px 0 0; display: none; 
                                  align-items: center; justify-content: center;'>
                        <div style='text-align: center;'>
                            <i class='fas fa-home' style='font-size: 3rem; color: #6c757d; margin-bottom: 0.5rem;'></i>
                            <p style='color: #6c757d; margin: 0;'>Foto não disponível</p>
                        </div>
                      </div>";
                echo "</div>";
            } else {
                echo "<div class='no-image' style='height: 200px; background: #f8f9fa; display: flex; align-items: center; justify-content: center;'>";
                echo "<p>❌ Falha na geração da URL</p>";
                echo "</div>";
            }
        } else {
            echo "<div class='no-image' style='height: 200px; background: #f8f9fa; display: flex; align-items: center; justify-content: center;'>";
            echo "<p>❌ Sem foto principal</p>";
            echo "</div>";
        }
        
        echo "<div style='padding: 15px;'>";
        echo "<h5>{$property['titulo']}</h5>";
        echo "<p>Preço: " . formatPrice($property['preco']) . "</p>";
        echo "<p>Localização: {$property['bairro']}, {$property['cidade']}</p>";
        echo "</div>";
        echo "</div>";
        
        // Verificar se o HTML está correto
        echo "<h4>🔍 Verificação do HTML:</h4>";
        echo "<p><strong>onload presente:</strong> " . (strpos($image_url, 'onload') !== false ? '❌ NÃO' : '✅ SIM (via PHP)') . "</p>";
        echo "<p><strong>onerror presente:</strong> " . (strpos($image_url, 'onerror') !== false ? '❌ NÃO' : '✅ SIM (via PHP)') . "</p>";
        
    } else {
        echo "<p>❌ Nenhum imóvel em destaque encontrado!</p>";
    }
    
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Erro: " . $e->getMessage() . "</p>";
}

// Teste final: verificar se a função está funcionando
echo "<h3>🧪 Teste Final: Verificação da Função</h3>";
$test_file = "68a4aeae5ee32.jpeg";
$result = getUploadPath($test_file);
echo "<p><strong>Teste com arquivo simples:</strong></p>";
echo "<p>Arquivo: {$test_file}</p>";
echo "<p>Resultado: {$result}</p>";

if ($result === "https://imoveisjtr.com.br/uploads/imoveis/6/{$test_file}") {
    echo "<p style='color: green;'>✅ Função funcionando perfeitamente!</p>";
} else {
    echo "<p style='color: red;'>❌ Função com problema!</p>";
}
?>

<style>
body { font-family: Arial, sans-serif; margin: 20px; }
.no-image { background: #f8f9fa; border-radius: 8px 8px 0 0; }
</style>
