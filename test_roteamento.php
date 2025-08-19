<?php
// Teste de Roteamento - JTR Imóveis

echo "<h1>Teste de Roteamento</h1>";
echo "<hr>";

// Incluir configurações
require_once 'config/paths.php';

echo "<h2>1. Informações do Ambiente</h2>";
echo "<p><strong>ROOT_PATH:</strong> " . ROOT_PATH . "</p>";
echo "<p><strong>SCRIPT_NAME:</strong> " . ($_SERVER['SCRIPT_NAME'] ?? 'N/A') . "</p>";
echo "<p><strong>REQUEST_URI:</strong> " . ($_SERVER['REQUEST_URI'] ?? 'N/A') . "</p>";
echo "<p><strong>QUERY_STRING:</strong> " . ($_SERVER['QUERY_STRING'] ?? 'N/A') . "</p>";

echo "<hr>";

echo "<h2>2. Teste de Caminhos</h2>";

// Testar função getAbsolutePath
$test_paths = [
    'pages/contato.php',
    'pages/home.php',
    'config/database.php'
];

foreach ($test_paths as $path) {
    $absolute = getAbsolutePath($path);
    $exists = file_exists($absolute);
    $status = $exists ? '✅' : '❌';
    echo "<p>{$status} <strong>{$path}:</strong> {$absolute} - " . ($exists ? 'EXISTE' : 'NÃO EXISTE') . "</p>";
}

echo "<hr>";

echo "<h2>3. Teste de Roteamento</h2>";

// Simular diferentes páginas
$test_pages = ['home', 'contato', 'imoveis', 'sobre'];

foreach ($test_pages as $page) {
    $url = getPagePath($page);
    echo "<p><strong>{$page}:</strong> <a href='{$url}' target='_blank'>{$url}</a></p>";
}

echo "<hr>";

echo "<h2>4. Teste de Inclusão</h2>";

// Testar se a página de contato pode ser incluída
$contato_path = getAbsolutePath('pages/contato.php');
if (file_exists($contato_path)) {
    echo "<p>✅ Página de contato encontrada em: {$contato_path}</p>";
    
    // Tentar incluir apenas o PHP para ver se há erros
    ob_start();
    try {
        // Incluir apenas o PHP da página de contato
        $contato_content = file_get_contents($contato_path);
        if (strpos($contato_content, '<?php') !== false) {
            echo "<p>✅ Arquivo contém código PHP válido</p>";
        } else {
            echo "<p>❌ Arquivo não contém código PHP</p>";
        }
    } catch (Exception $e) {
        echo "<p>❌ Erro ao ler arquivo: " . $e->getMessage() . "</p>";
    }
    ob_end_clean();
} else {
    echo "<p>❌ Página de contato NÃO encontrada</p>";
}

echo "<hr>";

echo "<h2>5. Links de Teste</h2>";
echo "<p><a href='index.php?page=home'>Home</a></p>";
echo "<p><a href='index.php?page=contato'>Contato</a></p>";
echo "<p><a href='index.php?page=imoveis'>Imóveis</a></p>";
echo "<p><a href='index.php?page=sobre'>Sobre</a></p>";

echo "<hr>";
echo "<p><em>Teste executado em: " . date('d/m/Y H:i:s') . "</em></p>";
?>
