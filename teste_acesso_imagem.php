<?php
echo "<h2>🖼️ TESTANDO ACESSO À IMAGEM NA HOSTINGER</h2>";

// URL da imagem que não está carregando
$image_url = "https://jtr-imoveis.com.br/uploads/imoveis/6/68a4aeae5ee32.jpeg";

echo "<h3>🔍 Testando URL: {$image_url}</h3>";

// Teste 1: Verificar se a URL é válida
echo "<h4>✅ Teste 1: Validação da URL</h4>";
if (filter_var($image_url, FILTER_VALIDATE_URL)) {
    echo "<p style='color: green;'>✅ URL válida</p>";
} else {
    echo "<p style='color: red;'>❌ URL inválida</p>";
}

// Teste 2: Verificar cabeçalhos HTTP
echo "<h4>🌐 Teste 2: Cabeçalhos HTTP</h4>";
$headers = get_headers($image_url, 1);
if ($headers) {
    echo "<p style='color: green;'>✅ Cabeçalhos obtidos:</p>";
    echo "<pre>";
    print_r($headers);
    echo "</pre>";
    
    // Verificar código de status
    if (isset($headers[0])) {
        $status_line = $headers[0];
        if (strpos($status_line, '200') !== false) {
            echo "<p style='color: green;'>✅ Status: 200 OK - Imagem encontrada!</p>";
        } elseif (strpos($status_line, '404') !== false) {
            echo "<p style='color: red;'>❌ Status: 404 - Imagem não encontrada!</p>";
        } elseif (strpos($status_line, '403') !== false) {
            echo "<p style='color: red;'>❌ Status: 403 - Acesso negado!</p>";
        } else {
            echo "<p style='color: orange;'>⚠️ Status: {$status_line}</p>";
        }
    }
} else {
    echo "<p style='color: red;'>❌ Não foi possível obter cabeçalhos</p>";
}

// Teste 3: Verificar se a imagem existe via cURL
echo "<h4>🔗 Teste 3: Verificação via cURL</h4>";
if (function_exists('curl_init')) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $image_url);
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    
    $result = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $content_type = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
    $file_size = curl_getinfo($ch, CURLINFO_CONTENT_LENGTH_DOWNLOAD);
    
    curl_close($ch);
    
    echo "<p><strong>HTTP Code:</strong> {$http_code}</p>";
    echo "<p><strong>Content Type:</strong> {$content_type}</p>";
    echo "<p><strong>File Size:</strong> " . ($file_size ? number_format($file_size) . ' bytes' : 'N/A') . "</p>";
    
    if ($http_code == 200) {
        echo "<p style='color: green;'>✅ Imagem acessível via cURL!</p>";
    } else {
        echo "<p style='color: red;'>❌ Imagem não acessível via cURL (HTTP {$http_code})</p>";
    }
} else {
    echo "<p style='color: orange;'>⚠️ cURL não disponível</p>";
}

// Teste 4: Tentar baixar a imagem
echo "<h4>⬇️ Teste 4: Tentativa de Download</h4>";
$image_content = file_get_contents($image_url);
if ($image_content !== false) {
    $file_size = strlen($image_content);
    echo "<p style='color: green;'>✅ Imagem baixada com sucesso!</p>";
    echo "<p><strong>Tamanho:</strong> " . number_format($file_size) . " bytes</p>";
    
    // Verificar se é realmente uma imagem
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime_type = finfo_buffer($finfo, $image_content);
    finfo_close($finfo);
    
    echo "<p><strong>MIME Type:</strong> {$mime_type}</p>";
    
    if (strpos($mime_type, 'image/') === 0) {
        echo "<p style='color: green;'>✅ Arquivo é realmente uma imagem!</p>";
    } else {
        echo "<p style='color: red;'>❌ Arquivo não é uma imagem (MIME: {$mime_type})</p>";
    }
} else {
    echo "<p style='color: red;'>❌ Não foi possível baixar a imagem</p>";
}

// Teste 5: Verificar se a pasta existe
echo "<h4>📁 Teste 5: Verificação da Estrutura de Pastas</h4>";
$base_url = "https://jtr-imoveis.com.br/uploads";
$folders = [
    "uploads" => $base_url,
    "uploads/imoveis" => $base_url . "/imoveis",
    "uploads/imoveis/6" => $base_url . "/imoveis/6"
];

foreach ($folders as $folder => $url) {
    $headers = get_headers($url, 1);
    if ($headers && strpos($headers[0], '200') !== false) {
        echo "<p style='color: green;'>✅ Pasta {$folder}: Acessível</p>";
    } else {
        echo "<p style='color: red;'>❌ Pasta {$folder}: Não acessível</p>";
    }
}

// Teste 6: Mostrar a imagem se possível
echo "<h4>🖼️ Teste 6: Exibição da Imagem</h4>";
if (isset($image_content) && $image_content !== false) {
    echo "<img src='data:image/jpeg;base64," . base64_encode($image_content) . "' style='max-width: 300px; border: 2px solid #ccc;' alt='Imagem testada'>";
    echo "<p style='color: green;'>✅ Imagem exibida com sucesso!</p>";
} else {
    echo "<p style='color: red;'>❌ Não foi possível exibir a imagem</p>";
}
?>

<style>
body { font-family: Arial, sans-serif; margin: 20px; }
pre { background: #f5f5f5; padding: 10px; border-radius: 5px; }
</style>
