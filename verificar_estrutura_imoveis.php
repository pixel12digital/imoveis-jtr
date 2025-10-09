<?php
// Verificar estrutura da tabela imoveis
require_once 'config/database.php';

echo "<h1>🔍 Verificação da Estrutura da Tabela Imóveis</h1>";
echo "<hr>";

try {
    // Mostrar estrutura da tabela imoveis
    echo "<h2>📋 Estrutura da Tabela 'imoveis':</h2>";
    $stmt = $pdo->query("DESCRIBE imoveis");
    $columns = $stmt->fetchAll();
    
    echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
    echo "<tr><th>Campo</th><th>Tipo</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th></tr>";
    
    foreach ($columns as $column) {
        echo "<tr>";
        echo "<td><strong>" . $column['Field'] . "</strong></td>";
        echo "<td>" . $column['Type'] . "</td>";
        echo "<td>" . $column['Null'] . "</td>";
        echo "<td>" . $column['Key'] . "</td>";
        echo "<td>" . ($column['Default'] ?? 'NULL') . "</td>";
        echo "<td>" . $column['Extra'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    // Mostrar alguns dados de exemplo
    echo "<h2>📊 Dados de Exemplo (primeiros 3 registros):</h2>";
    $stmt = $pdo->query("SELECT * FROM imoveis LIMIT 3");
    $imoveis = $stmt->fetchAll();
    
    if (count($imoveis) > 0) {
        echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
        
        // Cabeçalho da tabela
        $first_row = $imoveis[0];
        echo "<tr>";
        foreach (array_keys($first_row) as $column) {
            echo "<th>" . $column . "</th>";
        }
        echo "</tr>";
        
        // Dados
        foreach ($imoveis as $imovel) {
            echo "<tr>";
            foreach ($imovel as $value) {
                echo "<td>" . htmlspecialchars($value ?? 'NULL') . "</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>Nenhum imóvel encontrado na tabela.</p>";
    }
    
    // Verificar outras tabelas importantes
    echo "<h2>🔍 Verificação de Outras Tabelas:</h2>";
    
    $tables_to_check = ['localizacoes', 'tipos_imovel', 'caracteristicas', 'usuarios'];
    
    foreach ($tables_to_check as $table) {
        echo "<h3>📋 Tabela: $table</h3>";
        try {
            $stmt = $pdo->query("SELECT COUNT(*) as total FROM $table");
            $result = $stmt->fetch();
            echo "<p><strong>Total de registros:</strong> " . $result['total'] . "</p>";
            
            if ($result['total'] > 0) {
                $stmt = $pdo->query("SELECT * FROM $table LIMIT 2");
                $data = $stmt->fetchAll();
                
                if (count($data) > 0) {
                    echo "<table border='1' style='border-collapse: collapse; width: 100%; font-size: 12px;'>";
                    
                    // Cabeçalho
                    $first_row = $data[0];
                    echo "<tr>";
                    foreach (array_keys($first_row) as $column) {
                        echo "<th>" . $column . "</th>";
                    }
                    echo "</tr>";
                    
                    // Dados
                    foreach ($data as $row) {
                        echo "<tr>";
                        foreach ($row as $value) {
                            echo "<td>" . htmlspecialchars(substr($value ?? 'NULL', 0, 50)) . "</td>";
                        }
                        echo "</tr>";
                    }
                    echo "</table>";
                }
            }
        } catch (Exception $e) {
            echo "<p style='color: red;'>Erro ao verificar tabela $table: " . $e->getMessage() . "</p>";
        }
    }
    
} catch (PDOException $e) {
    echo "<p style='color: red;'>❌ <strong>Erro:</strong> " . $e->getMessage() . "</p>";
}

echo "<hr>";
echo "<p><a href='index.php'>🏠 Voltar ao Início</a> | <a href='test_nova_conexao_banco.php'>🧪 Teste de Conexão</a></p>";
?>
