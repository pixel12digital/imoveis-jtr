<?php
// Teste específico para upload de WebP
require_once 'config/config.php';

echo "<h1>Teste de Upload WebP</h1>";
echo "<p><strong>Extensões permitidas:</strong> " . implode(', ', getAllowedExtensions()) . "</p>";
echo "<p><strong>Tamanho máximo:</strong> " . (MAX_FILE_SIZE / (1024 * 1024)) . "MB</p>";

// Verificar se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['test_file'])) {
    $file = $_FILES['test_file'];
    
    echo "<h2>Informações do arquivo enviado:</h2>";
    echo "<p><strong>Nome:</strong> " . htmlspecialchars($file['name']) . "</p>";
    echo "<p><strong>Tamanho:</strong> " . number_format($file['size'] / 1024, 2) . " KB</p>";
    echo "<p><strong>Tipo MIME:</strong> " . htmlspecialchars($file['type']) . "</p>";
    echo "<p><strong>Extensão:</strong> " . strtolower(pathinfo($file['name'], PATHINFO_EXTENSION)) . "</p>";
    echo "<p><strong>Erro:</strong> " . $file['error'] . "</p>";
    
    if ($file['error'] === UPLOAD_ERR_OK) {
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $allowed_extensions = getAllowedExtensions();
        
        echo "<h3>Validação:</h3>";
        echo "<p><strong>Extensão permitida?</strong> " . (in_array($ext, $allowed_extensions) ? 'SIM' : 'NÃO') . "</p>";
        echo "<p><strong>Tamanho válido?</strong> " . ($file['size'] <= MAX_FILE_SIZE ? 'SIM' : 'NÃO') . "</p>";
        
        if (in_array($ext, $allowed_extensions) && $file['size'] <= MAX_FILE_SIZE) {
            // Criar diretório de teste se não existir
            $test_dir = 'uploads/test/';
            if (!is_dir($test_dir)) {
                mkdir($test_dir, 0755, true);
            }
            
            $test_filename = 'test_webp_' . time() . '.' . $ext;
            $test_path = $test_dir . $test_filename;
            
            if (move_uploaded_file($file['tmp_name'], $test_path)) {
                echo "<p style='color: green;'><strong>✅ Upload realizado com sucesso!</strong></p>";
                echo "<p><strong>Arquivo salvo em:</strong> " . htmlspecialchars($test_path) . "</p>";
                
                // Mostrar preview se for imagem
                if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                    echo "<p><strong>Preview:</strong></p>";
                    echo "<img src='{$test_path}' style='max-width: 300px; max-height: 300px; border: 2px solid #28a745;'>";
                }
            } else {
                echo "<p style='color: red;'><strong>❌ Erro ao mover arquivo</strong></p>";
                echo "<p><strong>Erro:</strong> " . error_get_last()['message'] ?? 'Erro desconhecido' . "</p>";
            }
        } else {
            echo "<p style='color: red;'><strong>❌ Arquivo rejeitado</strong></p>";
            if (!in_array($ext, $allowed_extensions)) {
                echo "<p>Extensão '{$ext}' não é permitida.</p>";
            }
            if ($file['size'] > MAX_FILE_SIZE) {
                echo "<p>Arquivo muito grande: " . number_format($file['size'] / (1024 * 1024), 2) . "MB > " . (MAX_FILE_SIZE / (1024 * 1024)) . "MB</p>";
            }
        }
    } else {
        echo "<p style='color: red;'><strong>❌ Erro no upload</strong></p>";
        $error_messages = [
            UPLOAD_ERR_INI_SIZE => 'Arquivo excede upload_max_filesize',
            UPLOAD_ERR_FORM_SIZE => 'Arquivo excede MAX_FILE_SIZE',
            UPLOAD_ERR_PARTIAL => 'Upload parcial do arquivo',
            UPLOAD_ERR_NO_FILE => 'Nenhum arquivo foi enviado',
            UPLOAD_ERR_NO_TMP_DIR => 'Diretório temporário não encontrado',
            UPLOAD_ERR_CANT_WRITE => 'Falha ao escrever arquivo no disco',
            UPLOAD_ERR_EXTENSION => 'Upload parado por extensão'
        ];
        echo "<p><strong>Erro:</strong> " . ($error_messages[$file['error']] ?? 'Erro desconhecido') . "</p>";
    }
    
    echo "<hr>";
}

// Verificar configurações do PHP
echo "<h2>Configurações do PHP:</h2>";
echo "<p><strong>upload_max_filesize:</strong> " . ini_get('upload_max_filesize') . "</p>";
echo "<p><strong>post_max_size:</strong> " . ini_get('post_max_size') . "</p>";
echo "<p><strong>max_file_uploads:</strong> " . ini_get('max_file_uploads') . "</p>";
echo "<p><strong>memory_limit:</strong> " . ini_get('memory_limit') . "</p>";

// Verificar suporte a WebP
echo "<h2>Suporte a WebP:</h2>";
if (function_exists('imagewebp')) {
    echo "<p style='color: green;'>✅ Função imagewebp() disponível</p>";
} else {
    echo "<p style='color: red;'>❌ Função imagewebp() não disponível</p>";
}

if (extension_loaded('gd')) {
    $gd_info = gd_info();
    echo "<p><strong>GD Info:</strong></p>";
    echo "<pre>" . print_r($gd_info, true) . "</pre>";
} else {
    echo "<p style='color: red;'>❌ Extensão GD não carregada</p>";
}

// Formulário de teste
?>
<form method="POST" enctype="multipart/form-data" style="margin-top: 20px; padding: 20px; border: 1px solid #ccc; border-radius: 5px;">
    <h3>Testar Upload de WebP:</h3>
    <p>
        <label for="test_file">Selecione um arquivo WebP:</label><br>
        <input type="file" name="test_file" id="test_file" accept="image/webp,image/*" required>
    </p>
    <p>
        <button type="submit" style="background: #007bff; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;">
            Testar Upload
        </button>
    </p>
    <p><small>Formatos aceitos: JPG, PNG, GIF, WebP. Máximo 5MB.</small></p>
</form>

<style>
body { font-family: Arial, sans-serif; margin: 20px; }
h1, h2, h3 { color: #333; }
p { margin: 10px 0; }
hr { margin: 20px 0; border: none; border-top: 1px solid #ccc; }
</style>
