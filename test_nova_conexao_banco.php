<?php
// Teste da nova configuração do banco de dados
require_once 'config/database.php';

echo "<h1>🧪 Teste da Nova Configuração do Banco de Dados</h1>";
echo "<hr>";

echo "<h2>📋 Configurações Atuais:</h2>";
echo "<ul>";
echo "<li><strong>Host:</strong> " . DB_HOST . "</li>";
echo "<li><strong>Database:</strong> " . DB_NAME . "</li>";
echo "<li><strong>User:</strong> " . DB_USER . "</li>";
echo "<li><strong>Password:</strong> " . str_repeat('*', strlen(DB_PASS)) . "</li>";
echo "</ul>";

echo "<h2>🔗 Teste de Conexão:</h2>";

try {
    // Testar conexão básica
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8";
    $test_pdo = new PDO($dsn, DB_USER, DB_PASS);
    $test_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<p style='color: green;'>✅ <strong>Conexão estabelecida com sucesso!</strong></p>";
    
    // Testar query básica
    $stmt = $test_pdo->query("SELECT VERSION() as version, DATABASE() as database_name");
    $result = $stmt->fetch();
    
    echo "<p><strong>Versão MySQL:</strong> " . $result['version'] . "</p>";
    echo "<p><strong>Database conectado:</strong> " . $result['database_name'] . "</p>";
    
    // Listar tabelas
    echo "<h2>📊 Tabelas Disponíveis:</h2>";
    $stmt = $test_pdo->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    if (count($tables) > 0) {
        echo "<ul>";
        foreach ($tables as $table) {
            echo "<li>" . $table . "</li>";
        }
        echo "</ul>";
        echo "<p><strong>Total de tabelas:</strong> " . count($tables) . "</p>";
    } else {
        echo "<p style='color: orange;'>⚠️ Nenhuma tabela encontrada no banco.</p>";
    }
    
    // Testar uma query específica se a tabela imoveis existir
    if (in_array('imoveis', $tables)) {
        echo "<h2>🏠 Teste da Tabela Imóveis:</h2>";
        $stmt = $test_pdo->query("SELECT COUNT(*) as total FROM imoveis");
        $result = $stmt->fetch();
        echo "<p><strong>Total de imóveis:</strong> " . $result['total'] . "</p>";
        
        if ($result['total'] > 0) {
            // Primeiro vamos descobrir quais colunas existem
            $stmt = $test_pdo->query("DESCRIBE imoveis");
            $columns = $stmt->fetchAll();
            $column_names = array_column($columns, 'Field');
            
            // Construir SELECT dinâmico com colunas que existem
            $select_columns = ['id'];
            if (in_array('titulo', $column_names)) $select_columns[] = 'titulo';
            if (in_array('preco', $column_names)) $select_columns[] = 'preco';
            if (in_array('preco_venda', $column_names)) $select_columns[] = 'preco_venda';
            if (in_array('preco_locacao', $column_names)) $select_columns[] = 'preco_locacao';
            if (in_array('tipo_negocio', $column_names)) $select_columns[] = 'tipo_negocio';
            
            $stmt = $test_pdo->query("SELECT " . implode(', ', $select_columns) . " FROM imoveis LIMIT 3");
            $imoveis = $stmt->fetchAll();
            
            echo "<h3>📋 Primeiros 3 imóveis:</h3>";
            echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
            
            // Cabeçalho dinâmico
            echo "<tr>";
            foreach ($select_columns as $col) {
                $header_name = ucfirst(str_replace('_', ' ', $col));
                echo "<th>" . $header_name . "</th>";
            }
            echo "</tr>";
            
            // Dados
            foreach ($imoveis as $imovel) {
                echo "<tr>";
                foreach ($select_columns as $col) {
                    $value = $imovel[$col];
                    if (strpos($col, 'preco') !== false && $value && is_numeric($value)) {
                        echo "<td>R$ " . number_format($value, 2, ',', '.') . "</td>";
                    } else {
                        echo "<td>" . htmlspecialchars($value ?? '-') . "</td>";
                    }
                }
                echo "</tr>";
            }
            echo "</table>";
            
            echo "<p><em>Colunas disponíveis na tabela: " . implode(', ', $column_names) . "</em></p>";
        }
    }
    
    echo "<h2>✅ Status Final:</h2>";
    echo "<p style='color: green; font-size: 18px;'><strong>🎉 Nova configuração do banco funcionando perfeitamente!</strong></p>";
    
} catch (PDOException $e) {
    echo "<p style='color: red;'>❌ <strong>Erro na conexão:</strong> " . $e->getMessage() . "</p>";
    
    echo "<h2>🔍 Diagnóstico:</h2>";
    echo "<ul>";
    echo "<li>Verifique se o host <strong>" . DB_HOST . "</strong> está correto</li>";
    echo "<li>Verifique se as credenciais estão corretas</li>";
    echo "<li>Verifique se há restrições de IP no Hostinger</li>";
    echo "<li>Verifique se o servidor MySQL está rodando</li>";
    echo "</ul>";
}

echo "<hr>";
echo "<p><a href='index.php'>🏠 Voltar ao Início</a> | <a href='admin/'>⚙️ Painel Admin</a></p>";
?>
