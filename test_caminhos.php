<?php
// Teste de caminhos para desenvolvimento e produção
echo "<h1>🛣️ Teste de Caminhos - Dev e Produção</h1>";

// Incluir configurações
require_once 'config/paths.php';
require_once 'config/database.php';
require_once 'config/config.php';

echo "<h2>1. Informações do Ambiente</h2>";
echo "<p><strong>HTTP_HOST:</strong> " . $_SERVER['HTTP_HOST'] . "</p>";
echo "<p><strong>SCRIPT_NAME:</strong> " . $_SERVER['SCRIPT_NAME'] . "</p>";
echo "<p><strong>REQUEST_URI:</strong> " . $_SERVER['REQUEST_URI'] . "</p>";
echo "<p><strong>PHP_SELF:</strong> " . $_SERVER['PHP_SELF'] . "</p>";
echo "<p><strong>Ambiente:</strong> " . (isDevelopment() ? '🟢 Desenvolvimento' : '🔴 Produção') . "</p>";

echo "<h2>2. Caminhos Definidos</h2>";
echo "<p><strong>ROOT_PATH:</strong> " . ROOT_PATH . "</p>";
echo "<p><strong>CONFIG_PATH:</strong> " . CONFIG_PATH . "</p>";
echo "<p><strong>INCLUDES_PATH:</strong> " . INCLUDES_PATH . "</p>";
echo "<p><strong>PAGES_PATH:</strong> " . PAGES_PATH . "</p>";
echo "<p><strong>ASSETS_PATH:</strong> " . ASSETS_PATH . "</p>";

echo "<h2>3. Teste de Funções de Caminho</h2>";

// Teste getRelativePath
echo "<p><strong>getRelativePath('assets/css/style.css'):</strong> " . getRelativePath('assets/css/style.css') . "</p>";
echo "<p><strong>getRelativePath('pages/home.php'):</strong> " . getRelativePath('pages/home.php') . "</p>";

// Teste getAssetPath
echo "<p><strong>getAssetPath('css/style.css'):</strong> " . getAssetPath('css/style.css') . "</p>";
echo "<p><strong>getAssetPath('js/main.js'):</strong> " . getAssetPath('js/main.js') . "</p>";

// Teste getBaseUrl
echo "<p><strong>getBaseUrl():</strong> " . getBaseUrl() . "</p>";

echo "<h2>4. Teste de Inclusão de Arquivos</h2>";

// Testar se os arquivos principais podem ser incluídos
$arquivos_teste = [
    'config/paths.php',
    'config/database.php', 
    'config/config.php',
    'includes/header.php',
    'pages/home.php'
];

foreach ($arquivos_teste as $arquivo) {
    $caminho_absoluto = getAbsolutePath($arquivo);
    $caminho_relativo = ROOT_PATH . '/' . $arquivo;
    
    echo "<p><strong>$arquivo:</strong></p>";
    echo "<ul>";
    echo "<li>Caminho Absoluto: " . $caminho_absoluto . " - " . (file_exists($caminho_absoluto) ? '✅ Existe' : '❌ Não existe') . "</li>";
    echo "<li>Caminho Relativo: " . $caminho_relativo . " - " . (file_exists($caminho_relativo) ? '✅ Existe' : '❌ Não existe') . "</li>";
    echo "</ul>";
}

echo "<h2>5. Teste de Funcionamento</h2>";

// Testar se a função includeFile funciona
try {
    $header_result = includeFile('includes/header.php');
    if ($header_result !== false) {
        echo "<p style='color: green;'>✅ includeFile funcionando corretamente</p>";
    } else {
        echo "<p style='color: red;'>❌ includeFile falhou</p>";
    }
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Erro no includeFile: " . $e->getMessage() . "</p>";
}

echo "<h2>6. URLs de Teste</h2>";
echo "<p><a href='index.php'>🏠 Página Inicial</a></p>";
echo "<p><a href='index.php?page=imoveis'>🏠 Página de Imóveis</a></p>";
echo "<p><a href='index.php?page=contato'>📞 Página de Contato</a></p>";

echo "<h2>7. Verificação de Produção</h2>";
if (!isDevelopment()) {
    echo "<p style='color: orange;'>⚠️ <strong>AMBIENTE DE PRODUÇÃO DETECTADO</strong></p>";
    echo "<p>Verificando se os caminhos estão funcionando...</p>";
    
    // Testar se os arquivos essenciais estão acessíveis
    $arquivos_essenciais = ['index.php', 'config/paths.php', 'includes/header.php'];
    foreach ($arquivos_essenciais as $arquivo) {
        $caminho = ROOT_PATH . '/' . $arquivo;
        echo "<p><strong>$arquivo:</strong> " . (file_exists($caminho) ? '✅ Acessível' : '❌ Não acessível') . "</p>";
    }
} else {
    echo "<p style='color: green;'>✅ <strong>AMBIENTE DE DESENVOLVIMENTO DETECTADO</strong></p>";
}

echo "<hr>";
echo "<p><a href='index.php'>🏠 Voltar para o site</a></p>";
?>
