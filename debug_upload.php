<?php
// Arquivo de debug para upload de fotos
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Debug de Upload de Fotos - JTR Imóveis</h1>";

// Carregar configurações
require_once 'config/config.php';
require_once 'config/database.php';
require_once 'config/paths.php';

echo "<h2>1. Verificação de Configurações</h2>";
echo "<p><strong>UPLOAD_DIR:</strong> " . UPLOAD_DIR . "</p>";
echo "<p><strong>MAX_FILE_SIZE:</strong> " . (MAX_FILE_SIZE / (1024 * 1024)) . " MB</p>";
echo "<p><strong>ALLOWED_EXTENSIONS:</strong> " . implode(', ', getAllowedExtensions()) . "</p>";

echo "<h2>2. Verificação de Diretórios</h2>";
$upload_dir = 'uploads/imoveis/';
$test_dir = $upload_dir . 'test/';

echo "<p><strong>Diretório de upload:</strong> " . $upload_dir . "</p>";
echo "<p><strong>Existe uploads/imoveis:</strong> " . (is_dir($upload_dir) ? '✅ SIM' : '❌ NÃO') . "</p>";
echo "<p><strong>Permissões uploads/imoveis:</strong> " . (is_dir($upload_dir) ? substr(sprintf('%o', fileperms($upload_dir)), -4) : 'N/A') . "</p>";

// Tentar criar diretório de teste
if (!is_dir($test_dir)) {
    $created = mkdir($test_dir, 0755, true);
    echo "<p><strong>Criar diretório de teste:</strong> " . ($created ? '✅ SUCESSO' : '❌ FALHOU') . "</p>";
} else {
    echo "<p><strong>Diretório de teste já existe</strong></p>";
}

echo "<h2>3. Verificação de Permissões PHP</h2>";
echo "<p><strong>file_uploads:</strong> " . (ini_get('file_uploads') ? '✅ HABILITADO' : '❌ DESABILITADO') . "</p>";
echo "<p><strong>upload_max_filesize:</strong> " . ini_get('upload_max_filesize') . "</p>";
echo "<p><strong>post_max_size:</strong> " . ini_get('post_max_size') . "</p>";
echo "<p><strong>max_file_uploads:</strong> " . ini_get('max_file_uploads') . "</p>";
echo "<p><strong>memory_limit:</strong> " . ini_get('memory_limit') . "</p>";

echo "<h2>4. Verificação de Sessão</h2>";
session_start();
echo "<p><strong>Sessão iniciada:</strong> " . (session_status() === PHP_SESSION_ACTIVE ? '✅ SIM' : '❌ NÃO') . "</p>";
echo "<p><strong>ID da sessão:</strong> " . session_id() . "</p>";

echo "<h2>5. Teste de Upload Simulado</h2>";
echo "<form method='POST' enctype='multipart/form-data'>";
echo "<input type='file' name='test_file' accept='image/*' required>";
echo "<button type='submit'>Testar Upload</button>";
echo "</form>";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['test_file'])) {
    echo "<h3>Resultado do Teste:</h3>";
    
    $file = $_FILES['test_file'];
    
    echo "<p><strong>Nome do arquivo:</strong> " . $file['name'] . "</p>";
    echo "<p><strong>Tipo:</strong> " . $file['type'] . "</p>";
    echo "<p><strong>Tamanho:</strong> " . round($file['size'] / (1024 * 1024), 2) . " MB</p>";
    echo "<p><strong>Erro:</strong> " . $file['error'] . " (" . getUploadErrorMessage($file['error']) . ")</p>";
    echo "<p><strong>Arquivo temporário:</strong> " . $file['tmp_name'] . "</p>";
    
    if ($file['error'] === UPLOAD_ERR_OK) {
        echo "<p style='color: green;'><strong>✅ Upload OK</strong></p>";
        
        // Validar extensão
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $allowed_extensions = getAllowedExtensions();
        
        echo "<p><strong>Extensão detectada:</strong> {$ext}</p>";
        echo "<p><strong>Extensões permitidas:</strong> " . implode(', ', $allowed_extensions) . "</p>";
        
        if (in_array($ext, $allowed_extensions)) {
            echo "<p style='color: green;'><strong>✅ Extensão válida</strong></p>";
        } else {
            echo "<p style='color: red;'><strong>❌ Extensão inválida</strong></p>";
        }
        
        // Validar tamanho
        if ($file['size'] <= MAX_FILE_SIZE) {
            echo "<p style='color: green;'><strong>✅ Tamanho válido</strong></p>";
        } else {
            echo "<p style='color: red;'><strong>❌ Tamanho inválido</strong></p>";
        }
        
        // Tentar mover arquivo
        $test_filename = uniqid() . '.' . $ext;
        $test_path = $test_dir . $test_filename;
        
        echo "<p><strong>Tentando mover para:</strong> {$test_path}</p>";
        
        if (move_uploaded_file($file['tmp_name'], $test_path)) {
            echo "<p style='color: green;'><strong>✅ Arquivo movido com sucesso!</strong></p>";
            echo "<p><strong>Arquivo final:</strong> {$test_filename}</p>";
            
            // Verificar se arquivo existe
            if (file_exists($test_path)) {
                echo "<p style='color: green;'><strong>✅ Arquivo existe no destino</strong></p>";
                echo "<p><strong>Tamanho final:</strong> " . round(filesize($test_path) / (1024 * 1024), 2) . " MB</p>";
                
                // Mostrar imagem se for uma imagem válida
                if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                    echo "<p><strong>Preview:</strong></p>";
                    echo "<img src='{$test_path}' style='max-width: 200px; max-height: 200px; border: 1px solid #ccc;'>";
                }
            } else {
                echo "<p style='color: red;'><strong>❌ Arquivo não encontrado no destino</strong></p>";
            }
        } else {
            echo "<p style='color: red;'><strong>❌ Falha ao mover arquivo</strong></p>";
            echo "<p><strong>Erro:</strong> " . error_get_last()['message'] ?? 'Erro desconhecido' . "</p>";
        }
    } else {
        echo "<p style='color: red;'><strong>❌ Erro no upload</strong></p>";
    }
}

echo "<h2>6. Verificação de Banco de Dados</h2>";
try {
    $test_query = fetch("SELECT 1 as test");
    echo "<p style='color: green;'><strong>✅ Conexão com banco OK</strong></p>";
    
    // Verificar tabela de fotos
    $fotos_table = fetch("SHOW TABLES LIKE 'fotos_imovel'");
    if ($fotos_table) {
        echo "<p style='color: green;'><strong>✅ Tabela fotos_imovel existe</strong></p>";
        
        // Verificar estrutura da tabela
        $columns = fetchAll("DESCRIBE fotos_imovel");
        echo "<p><strong>Estrutura da tabela fotos_imovel:</strong></p>";
        echo "<ul>";
        foreach ($columns as $column) {
            echo "<li>{$column['Field']} - {$column['Type']} - {$column['Null']} - {$column['Key']}</li>";
        }
        echo "</ul>";
    } else {
        echo "<p style='color: red;'><strong>❌ Tabela fotos_imovel não existe</strong></p>";
    }
    
} catch (Exception $e) {
    echo "<p style='color: red;'><strong>❌ Erro no banco:</strong> " . $e->getMessage() . "</p>";
}

echo "<h2>7. Informações do Sistema</h2>";
echo "<p><strong>PHP Version:</strong> " . phpversion() . "</p>";
echo "<p><strong>Server Software:</strong> " . $_SERVER['SERVER_SOFTWARE'] . "</p>";
echo "<p><strong>Document Root:</strong> " . $_SERVER['DOCUMENT_ROOT'] . "</p>";
echo "<p><strong>Script Name:</strong> " . $_SERVER['SCRIPT_NAME'] . "</p>";
echo "<p><strong>Current Working Directory:</strong> " . getcwd() . "</p>";

// Função auxiliar para mensagens de erro de upload
function getUploadErrorMessage($error_code) {
    switch ($error_code) {
        case UPLOAD_ERR_OK:
            return 'Nenhum erro';
        case UPLOAD_ERR_INI_SIZE:
            return 'Arquivo excede upload_max_filesize';
        case UPLOAD_ERR_FORM_SIZE:
            return 'Arquivo excede MAX_FILE_SIZE';
        case UPLOAD_ERR_PARTIAL:
            return 'Upload parcial';
        case UPLOAD_ERR_NO_FILE:
            return 'Nenhum arquivo';
        case UPLOAD_ERR_NO_TMP_DIR:
            return 'Diretório temporário não encontrado';
        case UPLOAD_ERR_CANT_WRITE:
            return 'Falha ao escrever no disco';
        case UPLOAD_ERR_EXTENSION:
            return 'Upload parado por extensão';
        default:
            return 'Erro desconhecido';
    }
}
?>
