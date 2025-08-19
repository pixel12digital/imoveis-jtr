<?php
// Arquivo de debug para verificar constantes
echo "<h2>Debug de Constantes</h2>";

// Verificar se o arquivo de configuração pode ser carregado
echo "<h3>1. Teste de carregamento do config.php</h3>";
try {
    require_once 'config/config.php';
    echo "<p style='color: green;'>✅ config.php carregado com sucesso</p>";
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Erro ao carregar config.php: " . $e->getMessage() . "</p>";
}

// Verificar se as constantes estão definidas
echo "<h3>2. Verificação das constantes</h3>";

if (defined('ALLOWED_EXTENSIONS')) {
    echo "<p style='color: green;'>✅ ALLOWED_EXTENSIONS está definida</p>";
    echo "<p><strong>Valor:</strong> " . implode(', ', ALLOWED_EXTENSIONS) . "</p>";
    echo "<p><strong>Tipo:</strong> " . gettype(ALLOWED_EXTENSIONS) . "</p>";
} else {
    echo "<p style='color: red;'>❌ ALLOWED_EXTENSIONS NÃO está definida</p>";
}

if (defined('MAX_FILE_SIZE')) {
    echo "<p style='color: green;'>✅ MAX_FILE_SIZE está definida</p>";
    echo "<p><strong>Valor:</strong> " . MAX_FILE_SIZE . " bytes (" . (MAX_FILE_SIZE / (1024 * 1024)) . " MB)</p>";
} else {
    echo "<p style='color: red;'>❌ MAX_FILE_SIZE NÃO está definida</p>";
}

if (defined('UPLOAD_DIR')) {
    echo "<p style='color: green;'>✅ UPLOAD_DIR está definida</p>";
    echo "<p><strong>Valor:</strong> " . UPLOAD_DIR . "</p>";
} else {
    echo "<p style='color: red;'>❌ UPLOAD_DIR NÃO está definida</p>";
}

// Testar a validação
echo "<h3>3. Teste de validação</h3>";

$test_extensions = ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'txt'];
foreach ($test_extensions as $ext) {
    if (defined('ALLOWED_EXTENSIONS')) {
        $is_valid = in_array($ext, ALLOWED_EXTENSIONS);
        $status = $is_valid ? '✅ VÁLIDO' : '❌ INVÁLIDO';
        echo "<p><strong>{$ext}</strong> - {$status}</p>";
    } else {
        echo "<p style='color: red;'>❌ Não é possível testar - ALLOWED_EXTENSIONS não está definida</p>";
        break;
    }
}

// Verificar se há algum problema com o array
echo "<h3>4. Debug do array ALLOWED_EXTENSIONS</h3>";
if (defined('ALLOWED_EXTENSIONS')) {
    echo "<p><strong>Conteúdo do array:</strong></p>";
    echo "<pre>" . print_r(ALLOWED_EXTENSIONS, true) . "</pre>";
    
    echo "<p><strong>Função is_array:</strong> " . (is_array(ALLOWED_EXTENSIONS) ? 'Sim' : 'Não') . "</p>";
    echo "<p><strong>Count:</strong> " . count(ALLOWED_EXTENSIONS) . "</p>";
    
    // Testar cada elemento
    foreach (ALLOWED_EXTENSIONS as $key => $value) {
        echo "<p>Elemento {$key}: '{$value}' (tipo: " . gettype($value) . ")</p>";
    }
}

// Verificar se há algum problema com o caminho do arquivo
echo "<h3>5. Verificação de caminhos</h3>";
echo "<p><strong>Diretório atual:</strong> " . __DIR__ . "</p>";
echo "<p><strong>Arquivo config.php existe:</strong> " . (file_exists('config/config.php') ? 'Sim' : 'Não') . "</p>";
echo "<p><strong>Caminho absoluto para config.php:</strong> " . realpath('config/config.php') . "</p>";

// Testar include com caminho absoluto
echo "<h3>6. Teste com caminho absoluto</h3>";
$config_path = __DIR__ . '/config/config.php';
echo "<p><strong>Caminho absoluto:</strong> {$config_path}</p>";
echo "<p><strong>Arquivo existe:</strong> " . (file_exists($config_path) ? 'Sim' : 'Não') . "</p>";

if (file_exists($config_path)) {
    try {
        require_once $config_path;
        echo "<p style='color: green;'>✅ config.php carregado com caminho absoluto</p>";
        
        if (defined('ALLOWED_EXTENSIONS')) {
            echo "<p style='color: green;'>✅ ALLOWED_EXTENSIONS agora está definida</p>";
            echo "<p><strong>Valor:</strong> " . implode(', ', ALLOWED_EXTENSIONS) . "</p>";
        } else {
            echo "<p style='color: red;'>❌ ALLOWED_EXTENSIONS ainda não está definida</p>";
        }
    } catch (Exception $e) {
        echo "<p style='color: red;'>❌ Erro ao carregar com caminho absoluto: " . $e->getMessage() . "</p>";
    }
}
?>
