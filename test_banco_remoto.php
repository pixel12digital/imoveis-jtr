<?php
// Script para testar conexão com banco remoto do Hostinger
echo "<h1>🌐 Teste de Conexão - Banco Remoto Hostinger</h1>";

echo "<h2>1. Configurações do Banco Remoto</h2>";
echo "<ul>";
echo "<li><strong>Host:</strong> auth-db1607.hstgr.io</li>";
echo "<li><strong>Database:</strong> u342734079_jtrimoveis</li>";
echo "<li><strong>Usuário:</strong> u342734079_jtrimoveis</li>";
echo "<li><strong>Porta:</strong> 3306 (padrão MySQL)</li>";
echo "</ul>";

echo "<h2>2. Teste de Conectividade de Rede</h2>";

// Testar se o host está acessível
$host = 'auth-db1607.hstgr.io';
$port = 3306;

echo "<p>Testando conectividade com <strong>$host:$port</strong>...</p>";

$connection = @fsockopen($host, $port, $errno, $errstr, 10);
if ($connection) {
    echo "<p style='color: green;'>✅ Conectividade de rede: OK</p>";
    echo "<p>O servidor está aceitando conexões na porta $port</p>";
    fclose($connection);
} else {
    echo "<p style='color: red;'>❌ Conectividade de rede: FALHOU</p>";
    echo "<p><em>Erro: $errstr ($errno)</em></p>";
    
    // Tentar outras portas comuns
    $common_ports = [3306, 3307, 33060, 33061];
    echo "<p>Tentando outras portas comuns...</p>";
    
    foreach ($common_ports as $test_port) {
        if ($test_port != $port) {
            $test_conn = @fsockopen($host, $test_port, $test_errno, $test_errstr, 5);
            if ($test_conn) {
                echo "<p style='color: orange;'>⚠ Porta $test_port está aberta (pode ser a porta correta)</p>";
                fclose($test_conn);
            }
        }
    }
}

echo "<h2>3. Teste de Conexão MySQL</h2>";

try {
    // Tentar conexão com timeout reduzido
    $dsn = "mysql:host=$host;dbname=u342734079_jtrimoveis;charset=utf8;connect_timeout=10";
    $pdo = new PDO($dsn, 'u342734079_jtrimoveis', 'Los@ngo#081081');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<p style='color: green;'>✅ Conexão MySQL: SUCESSO!</p>";
    
    // Testar uma query simples
    $stmt = $pdo->query("SELECT VERSION() as version");
    $version = $stmt->fetch();
    echo "<p><strong>Versão do MySQL:</strong> " . $version['version'] . "</p>";
    
    // Verificar tabelas
    $stmt = $pdo->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    if (!empty($tables)) {
        echo "<p style='color: green;'>✅ Tabelas encontradas: " . count($tables) . "</p>";
        echo "<ul>";
        foreach (array_slice($tables, 0, 10) as $table) { // Mostrar apenas as primeiras 10
            echo "<li>$table</li>";
        }
        if (count($tables) > 10) {
            echo "<li>... e mais " . (count($tables) - 10) . " tabelas</li>";
        }
        echo "</ul>";
    } else {
        echo "<p style='color: orange;'>⚠ Nenhuma tabela encontrada</p>";
    }
    
} catch(PDOException $e) {
    echo "<p style='color: red;'>❌ Erro na conexão MySQL: " . $e->getMessage() . "</p>";
    
    // Análise detalhada do erro
    $error_code = $e->getCode();
    echo "<h3>Análise do Erro:</h3>";
    
    switch($error_code) {
        case 2002:
            echo "<p><strong>Erro 2002:</strong> Não foi possível conectar ao servidor MySQL</p>";
            echo "<ul>";
            echo "<li>Verifique se o host está correto</li>";
            echo "<li>Verifique se a porta está correta</li>";
            echo "<li>Verifique se o firewall não está bloqueando</li>";
            echo "<li>Verifique se o servidor MySQL está rodando</li>";
            echo "</ul>";
            break;
        case 1045:
            echo "<p><strong>Erro 1045:</strong> Acesso negado (usuário/senha incorretos)</p>";
            break;
        case 1049:
            echo "<p><strong>Erro 1049:</strong> Banco de dados não existe</p>";
            break;
        case 2003:
            echo "<p><strong>Erro 2003:</strong> Não foi possível conectar ao servidor MySQL</p>";
            break;
        default:
            echo "<p><strong>Código de erro:</strong> $error_code</p>";
            echo "<p><strong>Mensagem:</strong> " . $e->getMessage() . "</p>";
    }
}

echo "<h2>4. Teste de Configuração Atual</h2>";

// Verificar qual configuração está sendo usada
echo "<p>Verificando configuração atual...</p>";

// Simular a detecção de ambiente
$is_dev = in_array($_SERVER['HTTP_HOST'], ['localhost', '127.0.0.1', '::1']) || 
           strpos($_SERVER['HTTP_HOST'], '.local') !== false ||
           strpos($_SERVER['HTTP_HOST'], '.test') !== false;

if ($is_dev) {
    echo "<p style='color: blue;'>🌐 <strong>AMBIENTE DETECTADO:</strong> DESENVOLVIMENTO (localhost)</p>";
    echo "<p>Mas você quer usar o banco REMOTO. Vamos forçar o uso do banco remoto.</p>";
} else {
    echo "<p style='color: green;'>✅ <strong>AMBIENTE DETECTADO:</strong> PRODUÇÃO</p>";
    echo "<p>Usando banco remoto automaticamente.</p>";
}

echo "<h2>5. Soluções Possíveis</h2>";

echo "<div style='background: #e7f3ff; border: 1px solid #b3d9ff; padding: 15px; border-radius: 5px;'>";
echo "<h3>🔧 Soluções para usar banco remoto em desenvolvimento:</h3>";
echo "<ol>";
echo "<li><strong>Forçar uso do banco remoto:</strong> Modificar a configuração para sempre usar produção</li>";
echo "<li><strong>Configurar ambiente específico:</strong> Criar variável de ambiente para forçar produção</li>";
echo "<li><strong>Usar banco remoto via VPN:</strong> Se houver restrições de IP</li>";
echo "<li><strong>Verificar firewall:</strong> Seu provedor pode estar bloqueando conexões</li>";
echo "</ol>";
echo "</div>";

echo "<h2>6. Próximos Passos</h2>";

echo "<p>Para resolver o problema:</p>";
echo "<ol>";
echo "<li>✅ Verifique se o host <strong>$host</strong> está correto</li>";
echo "<li>✅ Verifique se a porta <strong>$port</strong> está correta</li>";
echo "<li>✅ Verifique se as credenciais estão corretas</li>";
echo "<li>✅ Verifique se há restrições de IP no Hostinger</li>";
echo "<li>✅ Teste a conexão via phpMyAdmin do Hostinger</li>";
echo "</ol>";

echo "<hr>";
echo "<p><a href='index.php'>← Voltar para o site</a></p>";
echo "<p><a href='https://auth-db1607.hstgr.io/index.php?db=u342734079_jtrimoveis' target='_blank'>🔗 Acessar phpMyAdmin do Hostinger</a></p>";
?>
