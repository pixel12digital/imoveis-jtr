<?php
/**
 * Script para executar atualizações do banco de dados
 * relacionadas à funcionalidade de locação
 */

// Carregar configurações
require_once 'config/database.php';
require_once 'config/config.php';

echo "<h2>🔄 Executando Atualizações do Banco de Dados</h2>";
echo "<hr>";

try {
    // 1. Modificar campo tipo_negocio
    echo "<h3>1. Modificando campo tipo_negocio...</h3>";
    $sql = "ALTER TABLE imoveis MODIFY COLUMN tipo_negocio ENUM('venda', 'locacao', 'venda_locacao') DEFAULT 'venda'";
    $result = query($sql);
    if ($result) {
        echo "✅ Campo tipo_negocio modificado com sucesso!<br>";
    } else {
        echo "❌ Erro ao modificar campo tipo_negocio<br>";
    }
    
    // 2. Adicionar campo preco_locacao
    echo "<h3>2. Adicionando campo preco_locacao...</h3>";
    $sql = "ALTER TABLE imoveis ADD COLUMN preco_locacao DECIMAL(12,2) NULL AFTER preco";
    $result = query($sql);
    if ($result) {
        echo "✅ Campo preco_locacao adicionado com sucesso!<br>";
    } else {
        echo "❌ Erro ao adicionar campo preco_locacao (pode já existir)<br>";
    }
    
    // 3. Adicionar campo condicoes_locacao
    echo "<h3>3. Adicionando campo condicoes_locacao...</h3>";
    $sql = "ALTER TABLE imoveis ADD COLUMN condicoes_locacao TEXT NULL AFTER preco_locacao";
    $result = query($sql);
    if ($result) {
        echo "✅ Campo condicoes_locacao adicionado com sucesso!<br>";
    } else {
        echo "❌ Erro ao adicionar campo condicoes_locacao (pode já existir)<br>";
    }
    
    // 4. Criar índice para tipo_negocio
    echo "<h3>4. Criando índice para tipo_negocio...</h3>";
    $sql = "CREATE INDEX idx_imoveis_tipo_negocio ON imoveis(tipo_negocio)";
    $result = query($sql);
    if ($result) {
        echo "✅ Índice criado com sucesso!<br>";
    } else {
        echo "❌ Erro ao criar índice (pode já existir)<br>";
    }
    
    // 5. Atualizar comentário da tabela
    echo "<h3>5. Atualizando comentário da tabela...</h3>";
    $sql = "ALTER TABLE imoveis COMMENT = 'Tabela de imóveis com suporte a múltiplos tipos de negócio (venda/locação)'";
    $result = query($sql);
    if ($result) {
        echo "✅ Comentário da tabela atualizado com sucesso!<br>";
    } else {
        echo "❌ Erro ao atualizar comentário da tabela<br>";
    }
    
    // 6. Verificar estrutura atual
    echo "<h3>6. Verificando estrutura atual da tabela...</h3>";
    $sql = "DESCRIBE imoveis";
    $result = fetchAll($sql);
    
    if ($result) {
        echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
        echo "<tr><th>Campo</th><th>Tipo</th><th>Nulo</th><th>Chave</th><th>Padrão</th><th>Extra</th></tr>";
        
        foreach ($result as $row) {
            echo "<tr>";
            echo "<td>{$row['Field']}</td>";
            echo "<td>{$row['Type']}</td>";
            echo "<td>{$row['Null']}</td>";
            echo "<td>{$row['Key']}</td>";
            echo "<td>{$row['Default']}</td>";
            echo "<td>{$row['Extra']}</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
    
    // 7. Verificar dados existentes
    echo "<h3>7. Verificando dados existentes...</h3>";
    $sql = "SELECT COUNT(*) as total, tipo_negocio FROM imoveis GROUP BY tipo_negocio";
    $result = fetchAll($sql);
    
    if ($result) {
        echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
        echo "<tr><th>Tipo de Negócio</th><th>Quantidade</th></tr>";
        
        foreach ($result as $row) {
            echo "<tr>";
            echo "<td>{$row['tipo_negocio']}</td>";
            echo "<td>{$row['total']}</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
    
    echo "<hr>";
    echo "<h3>🎉 Atualizações concluídas com sucesso!</h3>";
    echo "<p>Agora você pode:</p>";
    echo "<ul>";
    echo "<li>✅ Cadastrar imóveis para venda E locação</li>";
    echo "<li>✅ Definir preços diferentes para cada tipo de negócio</li>";
    echo "<li>✅ Adicionar condições específicas para locação</li>";
    echo "<li>✅ Usar os filtros existentes que já funcionam</li>";
    echo "</ul>";
    
    echo "<p><strong>Próximos passos:</strong></p>";
    echo "<ol>";
    echo "<li>Teste o formulário de cadastro de imóveis</li>";
    echo "<li>Teste o formulário de edição de imóveis</li>";
    echo "<li>Verifique se os filtros estão funcionando corretamente</li>";
    echo "</ol>";
    
} catch (Exception $e) {
    echo "<h3>❌ Erro durante a execução:</h3>";
    echo "<p style='color: red;'>{$e->getMessage()}</p>";
}

echo "<hr>";
echo "<p><a href='admin/imoveis/adicionar.php'>→ Ir para Cadastro de Imóveis</a></p>";
echo "<p><a href='admin/imoveis/'>→ Ir para Lista de Imóveis</a></p>";
echo "<p><a href='admin/'>→ Ir para Dashboard</a></p>";
?>
