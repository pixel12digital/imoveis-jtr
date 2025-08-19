<?php
// Teste real de upload simulando o formulário de adição de imóveis
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Teste Real de Upload - Simulando Formulário de Imóveis</h1>";

// Carregar configurações
require_once 'config/config.php';
require_once 'config/database.php';

echo "<h2>Configurações</h2>";
echo "<p><strong>MAX_FILE_SIZE:</strong> " . (MAX_FILE_SIZE / (1024 * 1024)) . " MB</p>";
echo "<p><strong>ALLOWED_EXTENSIONS:</strong> " . implode(', ', getAllowedExtensions()) . "</p>";

echo "<h2>Formulário Simulado de Imóvel</h2>";
echo "<form method='POST' enctype='multipart/form-data'>";
echo "<div style='margin-bottom: 20px;'>";
echo "<label><strong>Título:</strong> <input type='text' name='titulo' value='Casa Teste' required></label>";
echo "</div>";
echo "<div style='margin-bottom: 20px;'>";
echo "<label><strong>Descrição:</strong> <textarea name='descricao' required>Descrição de teste para casa</textarea></label>";
echo "</div>";
echo "<div style='margin-bottom: 20px;'>";
echo "<label><strong>Preço:</strong> <input type='number' name='preco' value='150000' step='0.01' required></label>";
echo "</div>";
echo "<div style='margin-bottom: 20px;'>";
echo "<label><strong>Tipo:</strong> <select name='tipo_id' required><option value='1'>Casa</option></select></label>";
echo "</div>";
echo "<div style='margin-bottom: 20px;'>";
echo "<label><strong>Localização:</strong> <select name='localizacao_id' required><option value='1'>Teste</option></select></label>";
echo "</div>";
echo "<div style='margin-bottom: 20px;'>";
echo "<label><strong>Fotos (múltiplas):</strong> <input type='file' name='fotos[]' multiple accept='image/*' required></label>";
echo "</div>";
echo "<button type='submit' style='padding: 10px 20px; background: #007bff; color: white; border: none; border-radius: 5px;'>Simular Cadastro de Imóvel</button>";
echo "</form>";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo "<hr>";
    echo "<h2>Resultado do Teste</h2>";
    
    echo "<h3>1. Dados POST Recebidos:</h3>";
    echo "<pre>" . print_r($_POST, true) . "</pre>";
    
    echo "<h3>2. Dados FILES Recebidos:</h3>";
    echo "<pre>" . print_r($_FILES, true) . "</pre>";
    
    // Simular o processo de cadastro de imóvel
    try {
        echo "<h3>3. Processando Dados do Imóvel:</h3>";
        
        // Validar dados obrigatórios
        $titulo = cleanInput($_POST['titulo']);
        $descricao = cleanInput($_POST['descricao']);
        $preco = (float)$_POST['preco'];
        $tipo_id = (int)$_POST['tipo_id'];
        $localizacao_id = (int)$_POST['localizacao_id'];
        
        echo "<p><strong>Dados validados:</strong></p>";
        echo "<ul>";
        echo "<li>Título: {$titulo}</li>";
        echo "<li>Preço: R$ " . number_format($preco, 2, ',', '.') . "</li>";
        echo "<li>Tipo ID: {$tipo_id}</li>";
        echo "<li>Localização ID: {$localizacao_id}</li>";
        echo "</ul>";
        
        if (empty($titulo) || empty($descricao) || $preco <= 0 || $tipo_id <= 0 || $localizacao_id <= 0) {
            throw new Exception('Todos os campos obrigatórios devem ser preenchidos.');
        }
        
        echo "<p style='color: green;'><strong>✅ Dados do imóvel válidos</strong></p>";
        
        // Simular inserção no banco (sem realmente inserir)
        $imovel_id = 999; // ID simulado para teste
        echo "<p><strong>Imóvel simulado criado com ID:</strong> {$imovel_id}</p>";
        
        // Processar upload de fotos
        echo "<h3>4. Processando Upload de Fotos:</h3>";
        
        if (isset($_FILES['fotos']) && !empty($_FILES['fotos']['name'][0])) {
            echo "<p style='color: green;'><strong>✅ Fotos detectadas no formulário</strong></p>";
            
            $upload_dir = 'uploads/imoveis/' . $imovel_id . '/';
            echo "<p><strong>Diretório de upload:</strong> {$upload_dir}</p>";
            
            // Criar diretório se não existir
            if (!is_dir($upload_dir)) {
                $created = mkdir($upload_dir, 0755, true);
                echo "<p><strong>Criação do diretório:</strong> " . ($created ? '✅ SUCESSO' : '❌ FALHOU') . "</p>";
            } else {
                echo "<p><strong>Diretório já existe</strong></p>";
            }
            
            // Processar cada arquivo
            $total_files = count($_FILES['fotos']['name']);
            echo "<p><strong>Total de arquivos para processar:</strong> {$total_files}</p>";
            
            foreach ($_FILES['fotos']['tmp_name'] as $key => $tmp_name) {
                echo "<hr>";
                echo "<h4>Processando arquivo " . ($key + 1) . " de {$total_files}</h4>";
                
                $filename = $_FILES['fotos']['name'][$key];
                $size = $_FILES['fotos']['size'][$key];
                $error = $_FILES['fotos']['error'][$key];
                $type = $_FILES['fotos']['type'][$key];
                
                echo "<p><strong>Nome:</strong> {$filename}</p>";
                echo "<p><strong>Tamanho:</strong> " . round($size / (1024 * 1024), 2) . " MB</p>";
                echo "<p><strong>Tipo MIME:</strong> {$type}</p>";
                echo "<p><strong>Código de erro:</strong> {$error}</p>";
                echo "<p><strong>Arquivo temporário:</strong> {$tmp_name}</p>";
                
                if ($error === UPLOAD_ERR_OK) {
                    echo "<p style='color: green;'><strong>✅ Upload OK</strong></p>";
                    
                    // Validar extensão
                    $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
                    $allowed_extensions = getAllowedExtensions();
                    
                    echo "<p><strong>Extensão detectada:</strong> {$ext}</p>";
                    echo "<p><strong>Extensões permitidas:</strong> " . implode(', ', $allowed_extensions) . "</p>";
                    
                    if (in_array($ext, $allowed_extensions)) {
                        echo "<p style='color: green;'><strong>✅ Extensão válida</strong></p>";
                    } else {
                        echo "<p style='color: red;'><strong>❌ Extensão inválida</strong></p>";
                        continue;
                    }
                    
                    // Validar tamanho
                    if ($size <= MAX_FILE_SIZE) {
                        echo "<p style='color: green;'><strong>✅ Tamanho válido</strong></p>";
                    } else {
                        echo "<p style='color: red;'><strong>❌ Tamanho inválido</strong></p>";
                        continue;
                    }
                    
                    // Tentar mover arquivo
                    $new_filename = uniqid() . '.' . $ext;
                    $upload_path = $upload_dir . $new_filename;
                    
                    echo "<p><strong>Tentando mover para:</strong> {$upload_path}</p>";
                    
                    if (move_uploaded_file($tmp_name, $upload_path)) {
                        echo "<p style='color: green;'><strong>✅ Arquivo movido com sucesso!</strong></p>";
                        echo "<p><strong>Arquivo final:</strong> {$new_filename}</p>";
                        
                        // Verificar se arquivo existe
                        if (file_exists($upload_path)) {
                            echo "<p style='color: green;'><strong>✅ Arquivo existe no destino</strong></p>";
                            echo "<p><strong>Tamanho final:</strong> " . round(filesize($upload_path) / (1024 * 1024), 2) . " MB</p>";
                            
                            // Mostrar preview
                            echo "<p><strong>Preview:</strong></p>";
                            echo "<img src='{$upload_path}' style='max-width: 200px; max-height: 200px; border: 1px solid #ccc;'>";
                            
                            // Simular inserção no banco
                            echo "<p><strong>Simulando inserção no banco...</strong></p>";
                            echo "<p style='color: green;'><strong>✅ Foto registrada no banco (simulado)</strong></p>";
                        } else {
                            echo "<p style='color: red;'><strong>❌ Arquivo não encontrado no destino</strong></p>";
                        }
                    } else {
                        echo "<p style='color: red;'><strong>❌ Falha ao mover arquivo</strong></p>";
                        $last_error = error_get_last();
                        if ($last_error) {
                            echo "<p><strong>Erro:</strong> " . $last_error['message'] . "</p>";
                        }
                    }
                } else {
                    echo "<p style='color: red;'><strong>❌ Erro no upload</strong></p>";
                    
                    $error_msg = '';
                    switch ($error) {
                        case UPLOAD_ERR_INI_SIZE:
                            $error_msg = "Arquivo excede upload_max_filesize";
                            break;
                        case UPLOAD_ERR_FORM_SIZE:
                            $error_msg = "Arquivo excede MAX_FILE_SIZE";
                            break;
                        case UPLOAD_ERR_PARTIAL:
                            $error_msg = "Upload parcial do arquivo";
                            break;
                        case UPLOAD_ERR_NO_FILE:
                            $error_msg = "Nenhum arquivo foi enviado";
                            break;
                        case UPLOAD_ERR_NO_TMP_DIR:
                            $error_msg = "Diretório temporário não encontrado";
                            break;
                        case UPLOAD_ERR_CANT_WRITE:
                            $error_msg = "Falha ao escrever no disco";
                            break;
                        case UPLOAD_ERR_EXTENSION:
                            $error_msg = "Upload parado por extensão";
                            break;
                        default:
                            $error_msg = "Erro no upload do arquivo (código: {$error})";
                    }
                    echo "<p><strong>Descrição do erro:</strong> {$error_msg}</p>";
                }
            }
            
            echo "<hr>";
            echo "<h3>5. Resumo do Processamento:</h3>";
            echo "<p style='color: green;'><strong>✅ Processamento de fotos concluído</strong></p>";
            
        } else {
            echo "<p style='color: red;'><strong>❌ Nenhuma foto foi enviada</strong></p>";
            echo "<p><strong>isset(\$_FILES['fotos']):</strong> " . (isset($_FILES['fotos']) ? 'SIM' : 'NÃO') . "</p>";
            if (isset($_FILES['fotos'])) {
                echo "<p><strong>!empty(\$_FILES['fotos']['name'][0]):</strong> " . (!empty($_FILES['fotos']['name'][0]) ? 'SIM' : 'NÃO') . "</p>";
                echo "<p><strong>Estrutura \$_FILES['fotos']:</strong></p>";
                echo "<pre>" . print_r($_FILES['fotos'], true) . "</pre>";
            }
        }
        
        echo "<hr>";
        echo "<h3>6. Teste Concluído</h3>";
        echo "<p style='color: green;'><strong>✅ Simulação de cadastro de imóvel concluída com sucesso!</strong></p>";
        
    } catch (Exception $e) {
        echo "<p style='color: red;'><strong>❌ Erro durante o processamento:</strong> " . $e->getMessage() . "</p>";
    }
}

echo "<hr>";
echo "<h2>Informações Adicionais</h2>";
echo "<p><strong>PHP Version:</strong> " . phpversion() . "</p>";
echo "<p><strong>Server Software:</strong> " . $_SERVER['SERVER_SOFTWARE'] . "</p>";
echo "<p><strong>Document Root:</strong> " . $_SERVER['DOCUMENT_ROOT'] . "</p>";
echo "<p><strong>Script Name:</strong> " . $_SERVER['SCRIPT_NAME'] . "</p>";
echo "<p><strong>Current Working Directory:</strong> " . getcwd() . "</p>";
echo "<p><strong>Upload Max Filesize:</strong> " . ini_get('upload_max_filesize') . "</p>";
echo "<p><strong>Post Max Size:</strong> " . ini_get('post_max_size') . "</p>";
echo "<p><strong>Max File Uploads:</strong> " . ini_get('max_file_uploads') . "</p>";
echo "<p><strong>Memory Limit:</strong> " . ini_get('memory_limit') . "</p>";
?>
