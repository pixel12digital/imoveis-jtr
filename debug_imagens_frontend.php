<?php
/**
 * 🐛 DEBUG - Imagens não aparecendo no Frontend
 * Execute este script para identificar o problema com as imagens
 */

// Configurações de erro
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>🐛 Debug - Imagens não aparecendo no Frontend</h1>";
echo "<style>body { font-family: Arial, sans-serif; margin: 20px; }</style>";

// Carregar configurações
if (file_exists('config/paths.php')) {
    require_once 'config/paths.php';
    
    echo "<h2>✅ Configurações carregadas</h2>";
    
    // Simular que estamos em pages/imovel-detalhes.php
    $_SERVER['SCRIPT_NAME'] = '/jtr-imoveis/pages/imovel-detalhes.php';
    
    echo "<h3>🔍 Simulando execução de pages/imovel-detalhes.php</h3>";
    echo "<p><strong>SCRIPT_NAME:</strong> " . $_SERVER['SCRIPT_NAME'] . "</p>";
    
    // Verificar funções de caminho
    echo "<h3>📁 Testando funções de caminho:</h3>";
    
    $test_filename = '68a4aeae5f5be.jpeg';
    $test_path = 'imoveis/6/' . $test_filename;
    
    echo "<p><strong>Arquivo de teste:</strong> $test_filename</strong></p>";
    echo "<p><strong>Caminho completo:</strong> $test_path</strong></p>";
    
    // Testar getAbsolutePath
    $absolute_path = getAbsolutePath('uploads/' . $test_path);
    echo "<p><strong>getAbsolutePath('uploads/$test_path'):</strong> $absolute_path</p>";
    
    // Verificar se o arquivo existe
    if (file_exists($absolute_path)) {
        echo "<p>✅ <strong>Arquivo EXISTE no caminho absoluto</strong></p>";
    } else {
        echo "<p>❌ <strong>Arquivo NÃO EXISTE no caminho absoluto</strong></p>";
    }
    
    // Testar getRelativePath
    $relative_path = getRelativePath('uploads/' . $test_path);
    echo "<p><strong>getRelativePath('uploads/$test_path'):</strong> $relative_path</p>";
    
    // Testar getUploadPath
    $upload_path = getUploadPath($test_path);
    echo "<p><strong>getUploadPath('$test_path'):</strong> " . ($upload_path ?: 'FALSE') . "</p>";
    
    // Testar imageExists
    $image_exists = imageExists($test_path);
    echo "<p><strong>imageExists('$test_path'):</strong> " . ($image_exists ? 'TRUE' : 'FALSE') . "</p>";
    
    // Verificar estrutura de diretórios
    echo "<h3>📂 Estrutura de diretórios:</h3>";
    
    $uploads_dir = getAbsolutePath('uploads');
    echo "<p><strong>Diretório uploads:</strong> $uploads_dir</p>";
    
    if (is_dir($uploads_dir)) {
        echo "<p>✅ <strong>Diretório uploads EXISTE</strong></p>";
        
        $imoveis_dir = $uploads_dir . '/imoveis';
        if (is_dir($imoveis_dir)) {
            echo "<p>✅ <strong>Diretório imoveis EXISTE</strong></p>";
            
            $imovel_6_dir = $imoveis_dir . '/6';
            if (is_dir($imovel_6_dir)) {
                echo "<p>✅ <strong>Diretório imovel/6 EXISTE</strong></p>";
                
                // Listar arquivos
                $files = scandir($imovel_6_dir);
                $image_files = array_filter($files, function($file) {
                    return in_array(strtolower(pathinfo($file, PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png', 'webp', 'gif']);
                });
                
                echo "<p><strong>Arquivos de imagem encontrados:</strong></p>";
                echo "<ul>";
                foreach ($image_files as $file) {
                    $full_path = $imovel_6_dir . '/' . $file;
                    $exists = file_exists($full_path);
                    $status = $exists ? '✅' : '❌';
                    echo "<li>$status $file - " . ($exists ? 'EXISTE' : 'NÃO EXISTE') . "</li>";
                }
                echo "</ul>";
                
            } else {
                echo "<p>❌ <strong>Diretório imovel/6 NÃO EXISTE</strong></p>";
            }
        } else {
            echo "<p>❌ <strong>Diretório imoveis NÃO EXISTE</strong></p>";
        }
    } else {
        echo "<p>❌ <strong>Diretório uploads NÃO EXISTE</strong></p>";
    }
    
    // Testar com caminho direto
    echo "<h3>🧪 Teste com caminho direto:</h3>";
    
    $direct_path = 'uploads/imoveis/6/' . $test_filename;
    echo "<p><strong>Caminho direto:</strong> $direct_path</p>";
    
    if (file_exists($direct_path)) {
        echo "<p>✅ <strong>Arquivo EXISTE com caminho direto</strong></p>";
        
        // Testar se é legível
        if (is_readable($direct_path)) {
            echo "<p>✅ <strong>Arquivo é LEGÍVEL</strong></p>";
            
            // Verificar tamanho
            $file_size = filesize($direct_path);
            echo "<p><strong>Tamanho do arquivo:</strong> " . number_format($file_size) . " bytes</p>";
            
        } else {
            echo "<p>❌ <strong>Arquivo NÃO é legível</strong></p>";
        }
    } else {
        echo "<p>❌ <strong>Arquivo NÃO EXISTE com caminho direto</strong></p>";
    }
    
    // Verificar permissões
    echo "<h3>🔐 Verificando permissões:</h3>";
    
    if (is_dir($uploads_dir)) {
        $perms = substr(sprintf('%o', fileperms($uploads_dir)), -4);
        echo "<p><strong>Permissões do diretório uploads:</strong> $perms</p>";
        
        if (is_dir($imoveis_dir)) {
            $perms = substr(sprintf('%o', fileperms($imoveis_dir)), -4);
            echo "<p><strong>Permissões do diretório imoveis:</strong> $perms</p>";
            
            if (is_dir($imovel_6_dir)) {
                $perms = substr(sprintf('%o', fileperms($imovel_6_dir)), -4);
                echo "<p><strong>Permissões do diretório imovel/6:</strong> $perms</p>";
            }
        }
    }
    
} else {
    echo "<p class='error'>❌ Não foi possível carregar config/paths.php</p>";
}

echo "<hr>";
echo "<h3>🎯 Possíveis Problemas Identificados:</h3>";
echo "<ol>";
echo "<li><strong>Função getUploadPath:</strong> Pode estar retornando caminhos incorretos</li>";
echo "<li><strong>Função imageExists:</strong> Pode estar falhando na verificação</li>";
echo "<li><strong>Permissões de arquivo:</strong> Arquivos podem não ter permissão de leitura</li>";
echo "<li><strong>Caminhos relativos:</strong> Lógica de caminhos pode estar incorreta</li>";
echo "</ol>";

echo "<hr>";
echo "<p><em>Debug executado em: " . date('Y-m-d H:i:s') . "</em></p>";
?>
