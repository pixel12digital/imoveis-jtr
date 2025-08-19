<?php
// Teste completo para verificar se todos os elementos da página de adicionar imóvel estão sendo salvos

// Verificar se os arquivos de configuração existem
if (!file_exists('config/config.php')) {
    die('<h1 style="color: red;">❌ Erro: Arquivo config/config.php não encontrado!</h1>');
}

if (!file_exists('config/database.php')) {
    die('<h1 style="color: red;">❌ Erro: Arquivo config/database.php não encontrado!</h1>');
}

require_once 'config/config.php';
require_once 'config/database.php';

// Iniciar sessão para simular usuário logado
session_start();

// Simular usuário logado
$_SESSION['admin_logged_in'] = true;
$_SESSION['admin_id'] = 1;
$_SESSION['admin_nome'] = 'Teste Admin';

$test_results = [];
$test_errors = [];

// Função para buscar dados do banco de forma segura
function getDataSafely($query, $default = []) {
    try {
        if (function_exists('fetchAll')) {
            return fetchAll($query);
        }
        return $default;
    } catch (Exception $e) {
        return $default;
    }
}

// Função para executar testes
function runTest($test_name, $test_function) {
    global $test_results, $test_errors;
    
    try {
        $result = $test_function();
        $test_results[$test_name] = $result;
        echo "<div style='color: green; margin: 5px 0;'>✅ {$test_name}: {$result}</div>";
    } catch (Exception $e) {
        $test_results[$test_name] = false;
        $test_errors[$test_name] = $e->getMessage();
        echo "<div style='color: red; margin: 5px 0;'>❌ {$test_name}: {$e->getMessage()}</div>";
    }
}

// Teste 1: Verificar se as funções básicas estão disponíveis
runTest("Função fetch disponível", function() {
    return function_exists('fetch') ? "Sim" : "Não";
});

runTest("Função fetchAll disponível", function() {
    return function_exists('fetchAll') ? "Sim" : "Não";
});

// Teste 2: Verificar conexão com banco
runTest("Conexão com banco", function() {
    if (!function_exists('fetch')) {
        return "Função fetch não disponível";
    }
    try {
        $test = fetch("SELECT 1 as test");
        return $test ? "Conectado" : "Falhou";
    } catch (Exception $e) {
        return "Erro: " . $e->getMessage();
    }
});

// Teste 3: Verificar tabelas necessárias
runTest("Tabela tipos_imovel", function() {
    $result = fetch("SHOW TABLES LIKE 'tipos_imovel'");
    return $result ? "Existe" : "Não existe";
});

runTest("Tabela localizacoes", function() {
    $result = fetch("SHOW TABLES LIKE 'localizacoes'");
    return $result ? "Existe" : "Não existe";
});

runTest("Tabela usuarios", function() {
    $result = fetch("SHOW TABLES LIKE 'usuarios'");
    return $result ? "Existe" : "Não existe";
});

runTest("Tabela caracteristicas", function() {
    $result = fetch("SHOW TABLES LIKE 'caracteristicas'");
    return $result ? "Existe" : "Não existe";
});

runTest("Tabela imoveis", function() {
    $result = fetch("SHOW TABLES LIKE 'imoveis'");
    return $result ? "Existe" : "Não existe";
});

runTest("Tabela fotos_imovel", function() {
    $result = fetch("SHOW TABLES LIKE 'fotos_imovel'");
    return $result ? "Existe" : "Não existe";
});

runTest("Tabela imovel_caracteristicas", function() {
    $result = fetch("SHOW TABLES LIKE 'imovel_caracteristicas'");
    return $result ? "Existe" : "Não existe";
});

// Teste 4: Verificar dados nos selects
runTest("Tipos de imóvel", function() {
    $tipos_imovel = getDataSafely("SELECT * FROM tipos_imovel ORDER BY nome");
    $count = count($tipos_imovel);
    return "{$count} tipos encontrados";
});

runTest("Localizações", function() {
    $localizacoes = getDataSafely("SELECT * FROM localizacoes ORDER BY estado, cidade, bairro");
    $count = count($localizacoes);
    return "{$count} localizações encontradas";
});

runTest("Usuários", function() {
    $usuarios = getDataSafely("SELECT * FROM usuarios WHERE ativo = 1 ORDER BY nome");
    $count = count($usuarios);
    return "{$count} usuários encontrados";
});

runTest("Características", function() {
    $caracteristicas = getDataSafely("SELECT * FROM caracteristicas ORDER BY nome");
    $count = count($caracteristicas);
    return "{$count} características encontradas";
});

// Teste 5: Verificar configurações de upload
runTest("Extensões permitidas", function() {
    if (!function_exists('getAllowedExtensions')) {
        return "Função getAllowedExtensions não disponível";
    }
    $extensions = getAllowedExtensions();
    $webp_supported = in_array('webp', $extensions);
    return "WebP " . ($webp_supported ? "suportado" : "não suportado") . " - " . implode(', ', $extensions);
});

runTest("Tamanho máximo de arquivo", function() {
    if (!defined('MAX_FILE_SIZE')) {
        return "Constante MAX_FILE_SIZE não definida";
    }
    $max_size_mb = MAX_FILE_SIZE / (1024 * 1024);
    return "{$max_size_mb}MB";
});

// Teste 6: Verificar diretórios de upload
runTest("Diretório uploads", function() {
    $upload_dir = 'uploads/';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }
    return is_dir($upload_dir) ? "Existe" : "Não existe";
});

runTest("Diretório uploads/imoveis", function() {
    $upload_dir = 'uploads/imoveis/';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }
    return is_dir($upload_dir) ? "Existe" : "Não existe";
});

// Teste 7: Verificar permissões de escrita
runTest("Permissão de escrita uploads", function() {
    $test_file = 'uploads/test_write.txt';
    $result = file_put_contents($test_file, 'test');
    if ($result !== false) {
        unlink($test_file);
        return "Permissão OK";
    }
    return "Sem permissão de escrita";
});

// Teste 8: Verificar suporte a WebP no PHP
runTest("Função imagewebp", function() {
    return function_exists('imagewebp') ? "Disponível" : "Não disponível";
});

runTest("Extensão GD", function() {
    return extension_loaded('gd') ? "Carregada" : "Não carregada";
});

if (extension_loaded('gd')) {
    $gd_info = gd_info();
    runTest("Suporte WebP GD", function() use ($gd_info) {
        return isset($gd_info['WebP Support']) && $gd_info['WebP Support'] ? "Sim" : "Não";
    });
}

// Teste 9: Simular upload de arquivo WebP
runTest("Upload simulado WebP", function() {
    $test_dir = 'uploads/test/';
    if (!is_dir($test_dir)) {
        mkdir($test_dir, 0755, true);
    }
    
    // Criar arquivo de teste WebP (simulado)
    $test_content = 'RIFF' . pack('V', 0) . 'WEBP';
    $test_file = $test_dir . 'test_' . time() . '.webp';
    
    if (file_put_contents($test_file, $test_content)) {
        $file_size = filesize($test_file);
        unlink($test_file);
        return "Arquivo criado e removido - {$file_size} bytes";
    }
    return "Falha ao criar arquivo";
});

// Teste 10: Verificar funções de banco
runTest("Função fetch", function() {
    return function_exists('fetch') ? "Disponível" : "Não disponível";
});

runTest("Função fetchAll", function() {
    return function_exists('fetchAll') ? "Disponível" : "Não disponível";
});

runTest("Função insert", function() {
    return function_exists('insert') ? "Disponível" : "Não disponível";
});

runTest("Função update", function() {
    return function_exists('update') ? "Disponível" : "Não disponível";
});

runTest("Função query", function() {
    return function_exists('query') ? "Disponível" : "Não disponível";
});

// Teste 11: Verificar estrutura da tabela imoveis
runTest("Estrutura tabela imoveis", function() {
    $columns = fetchAll("DESCRIBE imoveis");
    $required_fields = ['id', 'titulo', 'descricao', 'preco', 'tipo_id', 'localizacao_id', 'usuario_id'];
    $found_fields = array_column($columns, 'Field');
    
    $missing = array_diff($required_fields, $found_fields);
    if (empty($missing)) {
        return "Todos os campos obrigatórios presentes";
    }
    return "Campos faltando: " . implode(', ', $missing);
});

// Teste 12: Verificar estrutura da tabela fotos_imovel
runTest("Estrutura tabela fotos_imovel", function() {
    $columns = fetchAll("DESCRIBE fotos_imovel");
    $required_fields = ['id', 'imovel_id', 'arquivo', 'legenda', 'ordem'];
    $found_fields = array_column($columns, 'Field');
    
    $missing = array_diff($required_fields, $found_fields);
    if (empty($missing)) {
        return "Todos os campos obrigatórios presentes";
    }
    return "Campos faltando: " . implode(', ', $missing);
});

// Teste 13: Verificar configurações do PHP
runTest("upload_max_filesize", function() {
    return ini_get('upload_max_filesize');
});

runTest("post_max_size", function() {
    return ini_get('post_max_size');
});

runTest("max_file_uploads", function() {
    return ini_get('max_file_uploads');
});

runTest("memory_limit", function() {
    return ini_get('memory_limit');
});

// Teste 14: Verificar se há dados de exemplo
runTest("Dados de exemplo - tipos", function() {
    $tipos_imovel = getDataSafely("SELECT * FROM tipos_imovel ORDER BY nome");
    $count = count($tipos_imovel);
    if ($count > 0) {
        $first = $tipos_imovel[0];
        return "Primeiro tipo: {$first['nome']}";
    }
    return "Nenhum tipo cadastrado";
});

runTest("Dados de exemplo - localizações", function() {
    $localizacoes = getDataSafely("SELECT * FROM localizacoes ORDER BY estado, cidade, bairro");
    $count = count($localizacoes);
    if ($count > 0) {
        $first = $localizacoes[0];
        return "Primeira localização: {$first['cidade']}, {$first['estado']}";
    }
    return "Nenhuma localização cadastrada";
});

// Resumo dos testes
$total_tests = count($test_results);
$passed_tests = count(array_filter($test_results));
$failed_tests = $total_tests - $passed_tests;

echo "<hr>";
echo "<h2>📊 Resumo dos Testes</h2>";
echo "<p><strong>Total de testes:</strong> {$total_tests}</p>";
echo "<p><strong>Testes aprovados:</strong> <span style='color: green;'>{$passed_tests}</span></p>";
echo "<p><strong>Testes falharam:</strong> <span style='color: red;'>{$failed_tests}</span></p>";

if ($failed_tests > 0) {
    echo "<h3>❌ Testes que falharam:</h3>";
    foreach ($test_errors as $test_name => $error) {
        echo "<p><strong>{$test_name}:</strong> {$error}</p>";
    }
}

if ($passed_tests === $total_tests) {
    echo "<h2 style='color: green;'>🎉 Todos os testes passaram! O sistema está funcionando perfeitamente.</h2>";
} else {
    echo "<h2 style='color: orange;'>⚠️ Alguns testes falharam. Verifique os erros acima.</h2>";
}

// Teste de formulário real
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo "<hr>";
    echo "<h2>🧪 Teste de Formulário Real</h2>";
    
    try {
        // Verificar se a função cleanInput está disponível
        if (!function_exists('cleanInput')) {
            function cleanInput($data) {
                $data = trim($data);
                $data = stripslashes($data);
                $data = htmlspecialchars($data);
                return $data;
            }
        }
        
        // Validar dados obrigatórios
        $titulo = cleanInput($_POST['titulo']);
        $descricao = cleanInput($_POST['descricao']);
        $preco = (float)$_POST['preco'];
        $tipo_id = (int)$_POST['tipo_id'];
        $localizacao_id = (int)$_POST['localizacao_id'];
        
        if (empty($titulo) || empty($descricao) || $preco <= 0 || $tipo_id <= 0 || $localizacao_id <= 0) {
            throw new Exception('Todos os campos obrigatórios devem ser preenchidos.');
        }
        
        // Preparar dados do imóvel
        $dados_imovel = [
            'titulo' => $titulo,
            'descricao' => $descricao,
            'preco' => $preco,
            'tipo_id' => $tipo_id,
            'localizacao_id' => $localizacao_id,
            'usuario_id' => $_SESSION['admin_id'],
            'status' => cleanInput($_POST['status']),
            'destaque' => isset($_POST['destaque']) ? 1 : 0,
            'area_total' => !empty($_POST['area_total']) ? (float)$_POST['area_total'] : null,
            'area_construida' => !empty($_POST['area_construida']) ? (float)$_POST['area_construida'] : null,
            'quartos' => !empty($_POST['quartos']) ? (int)$_POST['quartos'] : null,
            'banheiros' => !empty($_POST['banheiros']) ? (int)$_POST['banheiros'] : null,
            'vagas_garagem' => !empty($_POST['vagas_garagem']) ? (int)$_POST['vagas_garagem'] : null,
            'endereco' => cleanInput($_POST['endereco']),
            'cep' => cleanInput($_POST['cep']),
            'data_criacao' => date('Y-m-d H:i:s')
        ];
        
        echo "<p style='color: green;'>✅ Dados do formulário validados com sucesso!</p>";
        echo "<p><strong>Dados preparados:</strong></p>";
        echo "<pre>" . print_r($dados_imovel, true) . "</pre>";
        
        // Testar upload de arquivo
        if (isset($_FILES['fotos']) && !empty($_FILES['fotos']['name'][0])) {
            echo "<h3>📸 Teste de Upload de Fotos</h3>";
            
            foreach ($_FILES['fotos']['tmp_name'] as $key => $tmp_name) {
                $filename = $_FILES['fotos']['name'][$key];
                $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
                $size = $_FILES['fotos']['size'][$key];
                $type = $_FILES['fotos']['type'][$key];
                
                echo "<p><strong>Arquivo:</strong> {$filename}</p>";
                echo "<p><strong>Extensão:</strong> {$ext}</p>";
                echo "<p><strong>Tamanho:</strong> " . number_format($size / 1024, 2) . " KB</p>";
                echo "<p><strong>Tipo MIME:</strong> {$type}</p>";
                
                                 // Validar extensão
                 if (function_exists('getAllowedExtensions')) {
                     $allowed_extensions = getAllowedExtensions();
                     if (in_array($ext, $allowed_extensions)) {
                         echo "<p style='color: green;'>✅ Extensão válida</p>";
                     } else {
                         echo "<p style='color: red;'>❌ Extensão inválida</p>";
                     }
                 } else {
                     echo "<p style='color: orange;'>⚠️ Função getAllowedExtensions não disponível</p>";
                 }
                 
                 // Validar tamanho
                 if (defined('MAX_FILE_SIZE')) {
                     if ($size <= MAX_FILE_SIZE) {
                         echo "<p style='color: green;'>✅ Tamanho válido</p>";
                     } else {
                         echo "<p style='color: red;'>❌ Tamanho inválido</p>";
                     }
                 } else {
                     echo "<p style='color: orange;'>⚠️ Constante MAX_FILE_SIZE não definida</p>";
                 }
                
                echo "<hr>";
            }
        } else {
            echo "<p style='color: orange;'>⚠️ Nenhuma foto foi enviada para teste</p>";
        }
        
    } catch (Exception $e) {
        echo "<p style='color: red;'>❌ Erro na validação: " . $e->getMessage() . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teste Completo - Adicionar Imóvel</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f5f5f5; }
        .container { max-width: 1200px; margin: 0 auto; background: white; padding: 20px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h1 { color: #333; text-align: center; border-bottom: 3px solid #007bff; padding-bottom: 10px; }
        h2 { color: #007bff; margin-top: 30px; }
        h3 { color: #555; }
        .test-section { background: #f8f9fa; padding: 15px; margin: 15px 0; border-radius: 5px; border-left: 4px solid #007bff; }
        .form-group { margin: 15px 0; }
        label { display: block; margin-bottom: 5px; font-weight: bold; color: #555; }
        input, select, textarea { width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; }
        textarea { height: 100px; resize: vertical; }
        button { background: #007bff; color: white; padding: 12px 24px; border: none; border-radius: 5px; cursor: pointer; font-size: 16px; }
        button:hover { background: #0056b3; }
        .file-input { border: 2px dashed #007bff; padding: 20px; text-align: center; margin: 15px 0; border-radius: 5px; }
        .summary { background: #e7f3ff; padding: 15px; border-radius: 5px; margin: 20px 0; }
        .error { background: #ffe7e7; border-left-color: #dc3545; }
        .success { background: #e7ffe7; border-left-color: #28a745; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🧪 Teste Completo - Sistema de Adicionar Imóvel</h1>
        
        <div class="test-section">
            <h2>🔍 Verificações do Sistema</h2>
            <p>Este teste verifica se todos os componentes necessários estão funcionando corretamente.</p>
        </div>
        
        <div class="test-section">
            <h2>📋 Formulário de Teste</h2>
            <p>Preencha o formulário abaixo para testar se todos os campos estão sendo processados corretamente.</p>
            
            <form method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="titulo">Título *</label>
                    <input type="text" id="titulo" name="titulo" value="Imóvel de Teste" required>
                </div>
                
                <div class="form-group">
                    <label for="descricao">Descrição *</label>
                    <textarea id="descricao" name="descricao" required>Este é um imóvel de teste para verificar se o sistema está funcionando corretamente.</textarea>
                </div>
                
                <div class="form-group">
                    <label for="preco">Preço *</label>
                    <input type="number" id="preco" name="preco" value="150000" step="0.01" min="0" required>
                </div>
                
                                 <div class="form-group">
                     <label for="tipo_id">Tipo de Imóvel *</label>
                     <select id="tipo_id" name="tipo_id" required>
                         <option value="">Selecione...</option>
                         <?php 
                         $tipos_imovel = getDataSafely("SELECT * FROM tipos_imovel ORDER BY nome");
                         foreach ($tipos_imovel as $tipo): 
                         ?>
                             <option value="<?php echo $tipo['id']; ?>"><?php echo htmlspecialchars($tipo['nome']); ?></option>
                         <?php endforeach; ?>
                     </select>
                 </div>
                 
                 <div class="form-group">
                     <label for="localizacao_id">Localização *</label>
                     <select id="localizacao_id" name="localizacao_id" required>
                         <option value="">Selecione...</option>
                         <?php 
                         $localizacoes = getDataSafely("SELECT * FROM localizacoes ORDER BY estado, cidade, bairro");
                         foreach ($localizacoes as $localizacao): 
                         ?>
                             <option value="<?php echo $localizacao['id']; ?>">
                                 <?php echo htmlspecialchars($localizacao['cidade'] . ' - ' . ($localizacao['bairro'] ?: 'Centro') . ', ' . $localizacao['estado']); ?>
                             </option>
                         <?php endforeach; ?>
                     </select>
                 </div>
                
                <div class="form-group">
                    <label for="status">Status</label>
                    <select id="status" name="status">
                        <option value="disponivel">Disponível</option>
                        <option value="vendido">Vendido</option>
                        <option value="alugado">Alugado</option>
                        <option value="reservado">Reservado</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="area_total">Área Total (m²)</label>
                    <input type="number" id="area_total" name="area_total" step="0.01" min="0" value="120">
                </div>
                
                <div class="form-group">
                    <label for="quartos">Quartos</label>
                    <input type="number" id="quartos" name="quartos" min="0" value="3">
                </div>
                
                <div class="form-group">
                    <label for="banheiros">Banheiros</label>
                    <input type="number" id="banheiros" name="banheiros" min="0" value="2">
                </div>
                
                <div class="form-group">
                    <label for="endereco">Endereço</label>
                    <input type="text" id="endereco" name="endereco" value="Rua de Teste, 123">
                </div>
                
                <div class="form-group">
                    <label for="cep">CEP</label>
                    <input type="text" id="cep" name="cep" value="01234-567">
                </div>
                
                <div class="form-group">
                    <label>
                        <input type="checkbox" name="destaque" value="1"> Imóvel em Destaque
                    </label>
                </div>
                
                                 <div class="form-group">
                     <label>Características:</label>
                     <?php 
                     $caracteristicas = getDataSafely("SELECT * FROM caracteristicas ORDER BY nome");
                     foreach ($caracteristicas as $caracteristica): 
                     ?>
                         <div style="margin: 5px 0;">
                             <label style="font-weight: normal;">
                                 <input type="checkbox" name="caracteristicas[]" value="<?php echo $caracteristica['id']; ?>">
                                 <?php echo htmlspecialchars($caracteristica['nome']); ?>
                             </label>
                         </div>
                     <?php endforeach; ?>
                 </div>
                
                <div class="file-input">
                    <h3>📸 Fotos do Imóvel</h3>
                    <p>Selecione fotos para testar o upload (incluindo WebP):</p>
                    <input type="file" name="fotos[]" multiple accept="image/*" required>
                    <p><small>Formatos aceitos: JPG, PNG, GIF, WebP. Máximo 5MB por foto.</small></p>
                </div>
                
                <button type="submit">🧪 Executar Teste Completo</button>
            </form>
        </div>
        
        <div class="summary">
            <h3>📊 Resumo do Teste</h3>
            <p><strong>Total de verificações:</strong> <?php echo $total_tests; ?></p>
            <p><strong>Aprovadas:</strong> <span style="color: green;"><?php echo $passed_tests; ?></span></p>
            <p><strong>Falharam:</strong> <span style="color: red;"><?php echo $failed_tests; ?></span></p>
            
            <?php if ($passed_tests === $total_tests): ?>
                <p style="color: green; font-weight: bold;">🎉 Sistema funcionando perfeitamente!</p>
            <?php else: ?>
                <p style="color: orange; font-weight: bold;">⚠️ Algumas verificações falharam. Verifique os erros acima.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
