<?php
// Arquivo de teste para validações de upload
require_once 'config/config.php';

echo "<h2>Teste de Validações de Upload</h2>";

echo "<h3>Configurações atuais:</h3>";
$allowed_extensions = getAllowedExtensions();
echo "<p><strong>Extensões permitidas:</strong> " . implode(', ', $allowed_extensions) . "</p>";
echo "<p><strong>Tamanho máximo:</strong> " . (MAX_FILE_SIZE / (1024 * 1024)) . " MB</p>";

echo "<h3>Teste de validação de extensões:</h3>";
$test_files = [
    'imagem.jpg' => 'jpg',
    'foto.png' => 'png',
    'documento.pdf' => 'pdf',
    'arquivo.txt' => 'txt',
    'imagem.JPG' => 'JPG',
    'foto.PNG' => 'PNG'
];

foreach ($test_files as $filename => $ext) {
    $ext_lower = strtolower($ext);
    $allowed_extensions = getAllowedExtensions();
    $is_valid = in_array($ext_lower, $allowed_extensions);
    $status = $is_valid ? '✅ VÁLIDO' : '❌ INVÁLIDO';
    echo "<p><strong>{$filename}</strong> ({$ext}) - {$status}</p>";
}

echo "<h3>Teste de validação de tamanho:</h3>";
$test_sizes = [
    1024 * 1024 => '1 MB',
    5 * 1024 * 1024 => '5 MB',
    6 * 1024 * 1024 => '6 MB',
    10 * 1024 * 1024 => '10 MB'
];

foreach ($test_sizes as $size => $description) {
    $is_valid = $size <= MAX_FILE_SIZE;
    $status = $is_valid ? '✅ VÁLIDO' : '❌ INVÁLIDO';
    echo "<p><strong>{$description}</strong> ({$size} bytes) - {$status}</p>";
}

echo "<h3>Formulário de teste:</h3>";
?>
<form method="POST" enctype="multipart/form-data">
    <input type="file" name="test_file" accept="image/*">
    <button type="submit">Testar Upload</button>
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['test_file'])) {
    echo "<h3>Resultado do teste:</h3>";
    
    $file = $_FILES['test_file'];
    
    if ($file['error'] === UPLOAD_ERR_OK) {
        $filename = $file['name'];
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        $size = $file['size'];
        
        echo "<p><strong>Arquivo:</strong> {$filename}</p>";
        echo "<p><strong>Extensão:</strong> {$ext}</p>";
        echo "<p><strong>Tamanho:</strong> " . round($size / (1024 * 1024), 2) . " MB</p>";
        
        // Validar extensão
        $allowed_extensions = getAllowedExtensions();
        if (!in_array($ext, $allowed_extensions)) {
            echo "<p style='color: red;'><strong>❌ ERRO:</strong> Tipo de arquivo não suportado: {$ext}. Formatos aceitos: " . implode(', ', $allowed_extensions) . "</p>";
        } else {
            echo "<p style='color: green;'><strong>✅ Extensão válida</strong></p>";
        }
        
        // Validar tamanho
        if ($size > MAX_FILE_SIZE) {
            $size_mb = round($size / (1024 * 1024), 2);
            $max_mb = round(MAX_FILE_SIZE / (1024 * 1024), 2);
            echo "<p style='color: red;'><strong>❌ ERRO:</strong> Arquivo muito grande: {$size_mb}MB. Tamanho máximo permitido: {$max_mb}MB</p>";
        } else {
            echo "<p style='color: green;'><strong>✅ Tamanho válido</strong></p>";
        }
        
        // Verificar se passou em ambas as validações
        $allowed_extensions = getAllowedExtensions();
        if (in_array($ext, $allowed_extensions) && $size <= MAX_FILE_SIZE) {
            echo "<p style='color: green; font-weight: bold;'>✅ ARQUIVO VÁLIDO - Pode ser enviado!</p>";
        } else {
            echo "<p style='color: red; font-weight: bold;'>❌ ARQUIVO INVÁLIDO - Não pode ser enviado!</p>";
        }
        
    } else {
        echo "<p style='color: red;'><strong>❌ ERRO:</strong> " . $file['error'] . "</p>";
    }
}
?>
