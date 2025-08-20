<?php
/**
 * 🧪 TESTE - URLs das Imagens da Hostinger
 * Execute este script para verificar se as URLs estão sendo geradas corretamente
 */

// Configurações de erro
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>🧪 Teste - URLs das Imagens da Hostinger</h1>";
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

// Testar funções
echo "<h3>🔧 Testando Funções:</h3>";

// Testar shouldUseHostingerImages
if (function_exists('shouldUseHostingerImages')) {
    $use_hostinger = shouldUseHostingerImages();
    echo "<p>✅ <strong>shouldUseHostingerImages():</strong> " . ($use_hostinger ? 'TRUE' : 'FALSE') . "</p>";
} else {
    echo "<p>❌ <strong>shouldUseHostingerImages():</strong> Função não existe</p>";
}

// Testar getHostingerImageUrl
if (function_exists('getHostingerImageUrl')) {
    echo "<p>✅ <strong>getHostingerImageUrl():</strong> Função existe</p>";
} else {
    echo "<p>❌ <strong>getHostingerImageUrl():</strong> Função não existe</p>";
}

// Testar getUploadPath
if (function_exists('getUploadPath')) {
    echo "<p>✅ <strong>getUploadPath():</strong> Função existe</p>";
} else {
    echo "<p>❌ <strong>getUploadPath():</strong> Função não existe</p>";
}

// Testar imageExists
if (function_exists('imageExists')) {
    echo "<p>✅ <strong>imageExists():</strong> Função existe</p>";
} else {
    echo "<p>❌ <strong>imageExists():</strong> Função não existe</p>";
}

// Testar URLs
echo "<h3>🌐 Testando URLs:</h3>";

$test_images = [
    'imoveis/6/68a4aeae5ee32.jpeg',
    'imoveis/6/68a4aeae5f5be.jpeg',
    'imoveis/6/68a4aeae5fb5d.jpeg',
    'uploads/imoveis/6/68a4aeae5ee32.jpeg',
    '68a4aeae5ee32.jpeg'
];

foreach ($test_images as $test_image) {
    echo "<h4>Teste: <strong>$test_image</strong></h4>";
    
    // Testar getHostingerImageUrl
    if (function_exists('getHostingerImageUrl')) {
        $hostinger_url = getHostingerImageUrl($test_image);
        echo "<p><strong>getHostingerImageUrl():</strong> $hostinger_url</p>";
    }
    
    // Testar getUploadPath
    if (function_exists('getUploadPath')) {
        $upload_path = getUploadPath($test_image);
        echo "<p><strong>getUploadPath():</strong> " . ($upload_path ?: 'FALSE') . "</p>";
    }
    
    // Testar imageExists
    if (function_exists('imageExists')) {
        $exists = imageExists($test_image);
        echo "<p><strong>imageExists():</strong> " . ($exists ? 'TRUE' : 'FALSE') . "</p>";
    }
    
    echo "<hr>";
}

// Testar constante HOSTINGER_IMAGES_URL
echo "<h3>🔗 Constante HOSTINGER_IMAGES_URL:</h3>";
if (defined('HOSTINGER_IMAGES_URL')) {
    echo "<p>✅ <strong>HOSTINGER_IMAGES_URL:</strong> " . HOSTINGER_IMAGES_URL . "</p>";
} else {
    echo "<p>❌ <strong>HOSTINGER_IMAGES_URL:</strong> Não definida</p>";
}

// Simular diferentes contextos
echo "<h3>🔄 Testando Diferentes Contextos:</h3>";

$contexts = [
    'pages/imovel-detalhes.php' => '/jtr-imoveis/pages/imovel-detalhes.php',
    'admin/imoveis/editar.php' => '/jtr-imoveis/admin/imoveis/editar.php',
    'index.php' => '/jtr-imoveis/index.php'
];

foreach ($contexts as $context_name => $script_name) {
    echo "<h4>Contexto: <strong>$context_name</strong></h4>";
    
    // Simular SCRIPT_NAME
    $_SERVER['SCRIPT_NAME'] = $script_name;
    
    // Testar getUploadPath
    $test_image = 'imoveis/6/68a4aeae5ee32.jpeg';
    $upload_path = getUploadPath($test_image);
    
    echo "<p><strong>SCRIPT_NAME:</strong> $script_name</p>";
    echo "<p><strong>getUploadPath('$test_image'):</strong> " . ($upload_path ?: 'FALSE') . "</p>";
    
    echo "<hr>";
}

echo "<hr>";
echo "<h3>🎯 Resultado Esperado:</h3>";
echo "<p>As imagens devem aparecer com URLs da Hostinger como:</p>";
echo "<p><code>https://jtr-imoveis.com.br/uploads/imoveis/6/68a4aeae5ee32.jpeg</code></p>";

echo "<hr>";
echo "<p><em>Teste executado em: " . date('Y-m-d H:i:s') . "</em></p>";
?>
