<?php
require_once 'config/config.php';
require_once 'config/paths.php';

echo "<h2>🧪 TESTANDO FUNÇÃO DE IMAGEM</h2>";

// Teste 1: Verificar se a função existe
echo "<h3>✅ Teste 1: Existência da Função</h3>";
if (function_exists('getHostingerImageUrl')) {
    echo "<p style='color: green;'>✅ Função getHostingerImageUrl existe</p>";
} else {
    echo "<p style='color: red;'>❌ Função getHostingerImageUrl não existe</p>";
}

// Teste 2: Verificar ambiente detectado
echo "<h3>🌍 Teste 2: Detecção de Ambiente</h3>";
$http_host = $_SERVER['HTTP_HOST'] ?? 'N/A';
echo "<p><strong>HTTP_HOST:</strong> {$http_host}</p>";

$is_local = in_array($_SERVER['HTTP_HOST'] ?? '', ['localhost', '127.0.0.1']) || 
            strpos($_SERVER['HTTP_HOST'] ?? '', 'localhost') !== false;

if ($is_local) {
    echo "<p style='color: blue;'>🏠 AMBIENTE DETECTADO: LOCAL</p>";
} else {
    echo "<p style='color: green;'>🌐 AMBIENTE DETECTADO: PRODUÇÃO</p>";
}

// Teste 3: Testar função com arquivo simples
echo "<h3>🖼️ Teste 3: Teste da Função</h3>";
$test_file = "68a4aeae5ee32.jpeg";
echo "<p><strong>Arquivo de teste:</strong> {$test_file}</p>";

$result = getHostingerImageUrl($test_file);
echo "<p><strong>Resultado da função:</strong> {$result}</p>";

// Teste 4: Verificar se o resultado é o esperado
if ($is_local) {
    $expected = "../../uploads/imoveis/6/{$test_file}";
    if ($result === $expected) {
        echo "<p style='color: green;'>✅ RESULTADO CORRETO para ambiente LOCAL!</p>";
    } else {
        echo "<p style='color: red;'>❌ RESULTADO INCORRETO para ambiente LOCAL!</p>";
        echo "<p><strong>Esperado:</strong> {$expected}</p>";
        echo "<p><strong>Recebido:</strong> {$result}</p>";
    }
} else {
    $expected = "https://imoveisjtr.com.br/uploads/imoveis/6/{$test_file}";
    if ($result === $expected) {
        echo "<p style='color: green;'>✅ RESULTADO CORRETO para ambiente PRODUÇÃO!</p>";
    } else {
        echo "<p style='color: red;'>❌ RESULTADO INCORRETO para ambiente PRODUÇÃO!</p>";
        echo "<p><strong>Esperado:</strong> {$expected}</p>";
        echo "<p><strong>Recebido:</strong> {$result}</p>";
    }
}

// Teste 5: Verificar se a função getUploadPath está usando getHostingerImageUrl
echo "<h3>🔗 Teste 5: Verificação da Cadeia de Funções</h3>";
if (function_exists('getUploadPath')) {
    $upload_result = getUploadPath($test_file);
    echo "<p><strong>getUploadPath resultado:</strong> {$upload_result}</p>";
    
    if ($upload_result === $result) {
        echo "<p style='color: green;'>✅ getUploadPath está usando getHostingerImageUrl corretamente!</p>";
    } else {
        echo "<p style='color: red;'>❌ getUploadPath NÃO está usando getHostingerImageUrl!</p>";
    }
} else {
    echo "<p style='color: red;'>❌ Função getUploadPath não existe!</p>";
}

// Teste 6: Verificar se a função shouldUseHostingerImages está funcionando
echo "<h3>⚙️ Teste 6: Verificação de Configuração</h3>";
if (function_exists('shouldUseHostingerImages')) {
    $should_use = shouldUseHostingerImages();
    echo "<p><strong>shouldUseHostingerImages:</strong> " . ($should_use ? 'true' : 'false') . "</p>";
    
    if ($should_use) {
        echo "<p style='color: green;'>✅ Configuração correta: usando Hostinger</p>";
    } else {
        echo "<p style='color: red;'>❌ Configuração incorreta: não usando Hostinger</p>";
    }
} else {
    echo "<p style='color: red;'>❌ Função shouldUseHostingerImages não existe!</p>";
}

// Teste 7: Verificar se a constante está definida
echo "<h3>🔧 Teste 7: Verificação de Constantes</h3>";
if (defined('HOSTINGER_IMAGES_URL')) {
    echo "<p style='color: green;'>✅ HOSTINGER_IMAGES_URL definida: " . HOSTINGER_IMAGES_URL . "</p>";
} else {
    echo "<p style='color: red;'>❌ HOSTINGER_IMAGES_URL não definida</p>";
}
?>

<style>
body { font-family: Arial, sans-serif; margin: 20px; }
pre { background: #f5f5f5; padding: 10px; border-radius: 5px; }
</style>
