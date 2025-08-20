<?php
// Teste de UPDATE direto no banco
require_once 'config/database.php';
require_once 'config/config.php';

echo "<h1>Teste de UPDATE Direto no Banco</h1>";
echo "<style>body { font-family: Arial, sans-serif; }</style>";

// Teste 1: Verificar preço atual
echo "<h2>1. Preço Atual:</h2>";
try {
    $stmt = $pdo->prepare("SELECT preco FROM imoveis WHERE id = 6");
    $stmt->execute();
    $preco_atual = $stmt->fetchColumn();
    echo "<p><strong>Preço atual:</strong> " . number_format($preco_atual, 2, ',', '.') . "</p>";
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Erro: " . $e->getMessage() . "</p>";
    exit;
}

// Teste 2: Executar UPDATE diretamente
echo "<h2>2. Executando UPDATE Direto:</h2>";
try {
    $novo_preco = 3000000;
    
    echo "<p><strong>Alterando preço para:</strong> " . formatPrice($novo_preco) . "</p>";
    
    // UPDATE direto no banco
    $sql = "UPDATE imoveis SET preco = ?, data_atualizacao = ? WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    
    echo "<p><strong>SQL:</strong> " . $sql . "</p>";
    echo "<p><strong>Parâmetros:</strong> [$novo_preco, " . date('Y-m-d H:i:s') . ", 6]</p>";
    
    $resultado = $stmt->execute([$novo_preco, date('Y-m-d H:i:s'), 6]);
    
    if ($resultado) {
        $linhas_afetadas = $stmt->rowCount();
        echo "<p style='color: green;'>✅ UPDATE executado com sucesso!</p>";
        echo "<p><strong>Linhas afetadas:</strong> " . $linhas_afetadas . "</p>";
    } else {
        echo "<p style='color: red;'>❌ UPDATE falhou na execução!</p>";
    }
    
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Erro no UPDATE: " . $e->getMessage() . "</p>";
}

// Teste 3: Verificar resultado
echo "<h2>3. Verificação do Resultado:</h2>";
try {
    $stmt = $pdo->prepare("SELECT preco FROM imoveis WHERE id = 6");
    $stmt->execute();
    $preco_final = $stmt->fetchColumn();
    
    echo "<p><strong>Preço final:</strong> " . number_format($preco_final, 2, ',', '.') . "</p>";
    
    if ($preco_final == $novo_preco) {
        echo "<p style='color: green; font-weight: bold;'>✅ SUCESSO: Preço foi atualizado para " . formatPrice($novo_preco) . "!</p>";
    } else {
        echo "<p style='color: red; font-weight: bold;'>❌ FALHA: Preço não foi atualizado!</p>";
        echo "<p><strong>Esperado:</strong> " . formatPrice($novo_preco) . "</p>";
        echo "<p><strong>Encontrado:</strong> " . formatPrice($preco_final) . "</p>";
    }
    
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Erro na verificação: " . $e->getMessage() . "</p>";
}

// Teste 4: Verificar se há triggers ou constraints
echo "<h2>4. Verificando Estrutura da Tabela:</h2>";
try {
    $stmt = $pdo->prepare("SHOW CREATE TABLE imoveis");
    $stmt->execute();
    $estrutura = $stmt->fetch(PDO::FETCH_ASSOC);
    
    echo "<p><strong>Estrutura da tabela:</strong></p>";
    echo "<pre>" . htmlspecialchars($estrutura['Create Table']) . "</pre>";
    
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Erro ao verificar estrutura: " . $e->getMessage() . "</p>";
}

echo "<hr>";
echo "<h2>5. Análise:</h2>";
echo "<p>Se o UPDATE direto funcionar, o problema está na função update().</p>";
echo "<p>Se o UPDATE direto falhar, há um problema no banco ou na tabela.</p>";
?>
