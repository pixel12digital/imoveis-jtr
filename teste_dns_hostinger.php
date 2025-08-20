<?php
echo "<h2>🌐 TESTANDO RESOLUÇÃO DNS DA HOSTINGER</h2>";

$host = "jtr-imoveis.com.br";

echo "<h3>🔍 Testando host: {$host}</h3>";

// Teste 1: Resolução DNS básica
echo "<h4>✅ Teste 1: Resolução DNS</h4>";
$ip = gethostbyname($host);
if ($ip !== $host) {
    echo "<p style='color: green;'>✅ DNS resolvido: {$host} → {$ip}</p>";
} else {
    echo "<p style='color: red;'>❌ DNS não resolvido: {$host}</p>";
}

// Teste 2: Verificar se é um IP válido
echo "<h4>🔍 Teste 2: Validação do IP</h4>";
if (filter_var($ip, FILTER_VALIDATE_IP)) {
    echo "<p style='color: green;'>✅ IP válido: {$ip}</p>";
    
    // Verificar tipo de IP
    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
        echo "<p>📡 Tipo: IPv4</p>";
    } elseif (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
        echo "<p>📡 Tipo: IPv6</p>";
    }
} else {
    echo "<p style='color: red;'>❌ IP inválido: {$ip}</p>";
}

// Teste 3: Ping para o host
echo "<h4>🏓 Teste 3: Ping para o host</h4>";
if (function_exists('exec')) {
    $ping_result = exec("ping -n 1 {$host}", $output, $return_var);
    if ($return_var === 0) {
        echo "<p style='color: green;'>✅ Ping bem-sucedido</p>";
    } else {
        echo "<p style='color: red;'>❌ Ping falhou</p>";
    }
    echo "<pre>";
    foreach ($output as $line) {
        echo htmlspecialchars($line) . "\n";
    }
    echo "</pre>";
} else {
    echo "<p style='color: orange;'>⚠️ Função exec não disponível</p>";
}

// Teste 4: Verificar conectividade via socket
echo "<h4>🔌 Teste 4: Conectividade via Socket</h4>";
$port = 80;
$connection = @fsockopen($host, $port, $errno, $errstr, 5);
if ($connection) {
    echo "<p style='color: green;'>✅ Conexão HTTP bem-sucedida na porta {$port}</p>";
    fclose($connection);
} else {
    echo "<p style='color: red;'>❌ Conexão HTTP falhou: {$errstr} ({$errno})</p>";
}

// Teste 5: Verificar conectividade HTTPS
echo "<h4>🔒 Teste 5: Conectividade HTTPS</h4>";
$port = 443;
$connection = @fsockopen("ssl://{$host}", $port, $errno, $errstr, 5);
if ($connection) {
    echo "<p style='color: green;'>✅ Conexão HTTPS bem-sucedida na porta {$port}</p>";
    fclose($connection);
} else {
    echo "<p style='color: red;'>❌ Conexão HTTPS falhou: {$errstr} ({$errno})</p>";
}

// Teste 6: Verificar se o problema é local ou global
echo "<h4>🌍 Teste 6: Verificação de Conectividade Global</h4>";
$test_hosts = [
    "google.com" => "Google (Teste Global)",
    "8.8.8.8" => "DNS do Google (IP Direto)",
    "jtr-imoveis.com.br" => "Hostinger (Seu Site)"
];

foreach ($test_hosts as $test_host => $description) {
    $test_ip = gethostbyname($test_host);
    if ($test_ip !== $test_host) {
        echo "<p style='color: green;'>✅ {$description}: {$test_host} → {$test_ip}</p>";
    } else {
        echo "<p style='color: red;'>❌ {$description}: {$test_host} não resolvido</p>";
    }
}

// Teste 7: Verificar configurações de rede
echo "<h4>⚙️ Teste 7: Configurações de Rede</h4>";
echo "<p><strong>Servidor:</strong> " . $_SERVER['SERVER_NAME'] ?? 'N/A' . "</p>";
echo "<p><strong>IP Local:</strong> " . $_SERVER['SERVER_ADDR'] ?? 'N/A' . "</p>";
echo "<p><strong>User Agent:</strong> " . $_SERVER['HTTP_USER_AGENT'] ?? 'N/A' . "</p>";

// Teste 8: Tentar resolver via IP direto se disponível
echo "<h4>🎯 Teste 8: Teste via IP Direto</h4>";
if ($ip !== $host && filter_var($ip, FILTER_VALIDATE_IP)) {
    $direct_url = "http://{$ip}/uploads/imoveis/6/68a4aeae5ee32.jpeg";
    echo "<p>🔗 Testando URL direta: {$direct_url}</p>";
    
    $headers = @get_headers($direct_url, 1);
    if ($headers) {
        echo "<p style='color: green;'>✅ Cabeçalhos obtidos via IP direto!</p>";
        echo "<pre>";
        print_r($headers);
        echo "</pre>";
    } else {
        echo "<p style='color: red;'>❌ Falha via IP direto também</p>";
    }
} else {
    echo "<p style='color: orange;'>⚠️ IP não disponível para teste direto</p>";
}
?>

<style>
body { font-family: Arial, sans-serif; margin: 20px; }
pre { background: #f5f5f5; padding: 10px; border-radius: 5px; max-height: 200px; overflow-y: auto; }
</style>
