<?php
// Teste simples de upload sem JavaScript
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Teste Simples de Upload - JTR Imóveis</h1>";

// Carregar configurações
require_once 'config/config.php';
require_once 'config/database.php';

echo "<h2>Configurações</h2>";
echo "<p><strong>MAX_FILE_SIZE:</strong> " . (MAX_FILE_SIZE / (1024 * 1024)) . " MB</p>";
echo "<p><strong>ALLOWED_EXTENSIONS:</strong> " . implode(', ', getAllowedExtensions()) . "</p>";

echo "<h2>Formulário de Teste</h2>";
echo "<form method='POST' enctype='multipart/form-data'>";
echo "<p><label>Selecione uma foto: <input type='file' name='foto' accept='image/*' required></label></p>";
echo "<p><label>Título: <input type='text' name='titulo' value='Teste' required></label></p>";
echo "<p><label>Descrição: <textarea name='descricao' required>Descrição de teste</textarea></label></p>";
echo "<p><label>Preço: <input type='number' name='preco' value='100000' step='0.01' required></label></p>";
echo "<p><label>Tipo: <select name='tipo_id' required><option value='1'>Casa</option></select></label></p>";
echo "<p><label>Localização: <select name='localizacao_id' required><option value='1'>Teste</option></select></label></p>";
echo "<button type='submit'>Testar Upload</button>";
echo "</form>";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo "<h2>Resultado do Teste</h2>";
    
    echo "<h3>Dados POST:</h3>";
    echo "<pre>" . print_r($_POST, true) . "</pre>";
    
    echo "<h3>Dados FILES:</h3>";
    echo "<pre>" . print_r($_FILES, true) . "</pre>";
    
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        echo "<h3>Processando Upload:</h3>";
        
        $file = $_FILES['foto'];
        $filename = $file['name'];
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        $size = $file['size'];
        
        echo "<p><strong>Nome:</strong> {$filename}</p>";
        echo "<p><strong>Extensão:</strong> {$ext}</p>";
        echo "<p><strong>Tamanho:</strong> " . round($size / (1024 * 1024), 2) . " MB</p>";
        
        // Validar extensão
        $allowed_extensions = getAllowedExtensions();
        if (in_array($ext, $allowed_extensions)) {
            echo "<p style='color: green;'><strong>✅ Extensão válida</strong></p>";
        } else {
            echo "<p style='color: red;'><strong>❌ Extensão inválida</strong></p>";
            echo "<p>Formatos aceitos: " . implode(', ', $allowed_extensions) . "</p>";
        }
        
        // Validar tamanho
        if ($size <= MAX_FILE_SIZE) {
            echo "<p style='color: green;'><strong>✅ Tamanho válido</strong></p>";
        } else {
            echo "<p style='color: red;'><strong>❌ Tamanho inválido</strong></p>";
            echo "<p>Máximo permitido: " . (MAX_FILE_SIZE / (1024 * 1024)) . " MB</p>";
        }
        
        // Tentar criar diretório de teste
        $test_dir = 'uploads/imoveis/test/';
        if (!is_dir($test_dir)) {
            $created = mkdir($test_dir, 0755, true);
            echo "<p><strong>Criar diretório:</strong> " . ($created ? '✅ SUCESSO' : '❌ FALHOU') . "</p>";
        }
        
        // Tentar mover arquivo
        if (is_dir($test_dir)) {
            $new_filename = uniqid() . '.' . $ext;
            $test_path = $test_dir . $new_filename;
            
            echo "<p><strong>Tentando mover para:</strong> {$test_path}</p>";
            
            if (move_uploaded_file($file['tmp_name'], $test_path)) {
                echo "<p style='color: green;'><strong>✅ Upload realizado com sucesso!</strong></p>";
                echo "<p><strong>Arquivo salvo como:</strong> {$new_filename}</p>";
                
                // Mostrar imagem
                echo "<p><strong>Preview:</strong></p>";
                echo "<img src='{$test_path}' style='max-width: 300px; max-height: 300px; border: 1px solid #ccc;'>";
            } else {
                echo "<p style='color: red;'><strong>❌ Falha ao mover arquivo</strong></p>";
                $error = error_get_last();
                if ($error) {
                    echo "<p><strong>Erro:</strong> " . $error['message'] . "</p>";
                }
            }
        }
    } else {
        echo "<h3>Erro no Upload:</h3>";
        if (isset($_FILES['foto'])) {
            $error_code = $_FILES['foto']['error'];
            echo "<p><strong>Código de erro:</strong> {$error_code}</p>";
            
            switch ($error_code) {
                case UPLOAD_ERR_INI_SIZE:
                    echo "<p>Arquivo excede upload_max_filesize</p>";
                    break;
                case UPLOAD_ERR_FORM_SIZE:
                    echo "<p>Arquivo excede MAX_FILE_SIZE</p>";
                    break;
                case UPLOAD_ERR_PARTIAL:
                    echo "<p>Upload parcial do arquivo</p>";
                    break;
                case UPLOAD_ERR_NO_FILE:
                    echo "<p>Nenhum arquivo foi enviado</p>";
                    break;
                case UPLOAD_ERR_NO_TMP_DIR:
                    echo "<p>Diretório temporário não encontrado</p>";
                    break;
                case UPLOAD_ERR_CANT_WRITE:
                    echo "<p>Falha ao escrever no disco</p>";
                    break;
                case UPLOAD_ERR_EXTENSION:
                    echo "<p>Upload parado por extensão</p>";
                    break;
                default:
                    echo "<p>Erro desconhecido</p>";
            }
        } else {
            echo "<p>Nenhum arquivo foi enviado</p>";
        }
    }
}

echo "<h2>Informações do Sistema</h2>";
echo "<p><strong>PHP Version:</strong> " . phpversion() . "</p>";
echo "<p><strong>file_uploads:</strong> " . (ini_get('file_uploads') ? 'Habilitado' : 'Desabilitado') . "</p>";
echo "<p><strong>upload_max_filesize:</strong> " . ini_get('upload_max_filesize') . "</p>";
echo "<p><strong>post_max_size:</strong> " . ini_get('post_max_size') . "</p>";
echo "<p><strong>max_file_uploads:</strong> " . ini_get('max_file_uploads') . "</p>";
echo "<p><strong>memory_limit:</strong> " . ini_get('memory_limit') . "</p>";
echo "<p><strong>max_execution_time:</strong> " . ini_get('max_execution_time') . "s</p>";
echo "<p><strong>max_input_time:</strong> " . ini_get('max_input_time') . "s</p>";
?>
