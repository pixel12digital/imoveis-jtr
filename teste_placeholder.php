<?php
require_once 'config/config.php';
require_once 'config/paths.php';

echo "<h2>🧪 TESTANDO PLACEHOLDER</h2>";

// Teste 1: Verificar se a função está funcionando
echo "<h3>✅ Teste 1: Função getUploadPath</h3>";
$test_file = "68a4aeae5ee32.jpeg";
$result = getUploadPath($test_file);
echo "<p><strong>Arquivo:</strong> {$test_file}</p>";
echo "<p><strong>URL gerada:</strong> {$result}</p>";

// Teste 2: Simular HTML que seria gerado
echo "<h3>🖼️ Teste 2: HTML Simulado</h3>";
$image_url = getUploadPath($test_file);
$titulo = "CASA NO CONDOMÍNIO COSTA VERDE TABATINGA";

echo "<div style='border: 2px solid #ccc; padding: 20px; margin: 20px; max-width: 400px;'>";
echo "<h4>Card do Imóvel</h4>";
echo "<div style='position: relative;'>";
echo "<img src='{$image_url}' 
           style='width: 100%; height: 200px; object-fit: cover; border-radius: 8px 8px 0 0;' 
           alt='{$titulo}'
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
echo "<div style='padding: 15px;'>";
echo "<h5>{$titulo}</h5>";
echo "<p>Preço: R$ 5.900.000,00</p>";
echo "</div>";
echo "</div>";

// Teste 3: Verificar se a imagem está carregando
echo "<h3>🔍 Teste 3: Status da Imagem</h3>";
echo "<p><strong>URL da imagem:</strong> <a href='{$image_url}' target='_blank'>{$image_url}</a></p>";

// Teste 4: Verificar se há problemas de CSS
echo "<h3>🎨 Teste 4: CSS e JavaScript</h3>";
echo "<p>O placeholder deve estar com <code>display: none</code> por padrão.</p>";
echo "<p>Quando a imagem falha, o <code>onerror</code> deve:</p>";
echo "<ul>";
echo "<li>Esconder a imagem: <code>this.style.display='none'</code></li>";
echo "<li>Mostrar o placeholder: <code>this.nextElementSibling.style.display='flex'</code></li>";
echo "</ul>";

// Teste 5: Verificar se o problema é de cache
echo "<h3>🗂️ Teste 5: Cache e Recarregamento</h3>";
echo "<p>Se ainda estiver aparecendo ambos, tente:</p>";
echo "<ul>";
echo "<li><strong>Ctrl + F5</strong> - Recarregar sem cache</li>";
echo "<li><strong>F12 → Network → Disable cache</strong></li>";
echo "<li><strong>F12 → Console → Limpar console</strong></li>";
echo "</ul>";
?>

<style>
body { font-family: Arial, sans-serif; margin: 20px; }
code { background: #f5f5f5; padding: 2px 4px; border-radius: 3px; }
</style>
