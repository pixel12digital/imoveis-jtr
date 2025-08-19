<?php
// Teste Simples da Página de Contato - JTR Imóveis

echo "<h1>Teste da Página de Contato</h1>";
echo "<hr>";

// Testar inclusão dos arquivos de configuração
echo "<h2>1. Teste de Inclusão de Arquivos</h2>";

try {
    require_once 'config/database.php';
    echo "<p style='color: green;'>✅ config/database.php incluído com sucesso</p>";
    
    if (isset($pdo)) {
        echo "<p style='color: green;'>✅ Variável \$pdo está definida</p>";
    } else {
        echo "<p style='color: red;'>❌ Variável \$pdo NÃO está definida</p>";
    }
    
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Erro ao incluir database.php: " . $e->getMessage() . "</p>";
}

try {
    require_once 'config/config.php';
    echo "<p style='color: green;'>✅ config/config.php incluído com sucesso</p>";
    
    if (defined('PHONE_VENDA')) {
        echo "<p style='color: green;'>✅ Constante PHONE_VENDA definida: " . PHONE_VENDA . "</p>";
    } else {
        echo "<p style='color: red;'>❌ Constante PHONE_VENDA NÃO está definida</p>";
    }
    
    if (defined('PHONE_LOCACAO')) {
        echo "<p style='color: green;'>✅ Constante PHONE_LOCACAO definida: " . PHONE_LOCACAO . "</p>";
    } else {
        echo "<p style='color: red;'>❌ Constante PHONE_LOCACAO NÃO está definida</p>";
    }
    
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Erro ao incluir config.php: " . $e->getMessage() . "</p>";
}

echo "<hr>";

// Testar conexão com banco
echo "<h2>2. Teste de Conexão com Banco</h2>";

if (isset($pdo)) {
    try {
        $stmt = $pdo->query("SELECT 1");
        echo "<p style='color: green;'>✅ Conexão com banco funcionando</p>";
        
        // Testar consulta simples
        $stmt = $pdo->query("SELECT COUNT(*) as total FROM imoveis");
        $result = $stmt->fetch();
        echo "<p style='color: green;'>✅ Consulta ao banco funcionando. Total de imóveis: " . ($result['total'] ?? 'N/A') . "</p>";
        
    } catch (Exception $e) {
        echo "<p style='color: red;'>❌ Erro na conexão com banco: " . $e->getMessage() . "</p>";
    }
} else {
    echo "<p style='color: red;'>❌ Não é possível testar banco - variável \$pdo não definida</p>";
}

echo "<hr>";

// Instruções
echo "<h2>3. Próximos Passos</h2>";
echo "<ol>";
echo "<li>Se todos os testes passaram, a página de contato deve funcionar</li>";
echo "<li>Se houver erros, verifique os caminhos dos arquivos de configuração</li>";
echo "<li>Teste a página de contato em: <a href='contato'>/contato</a></li>";
echo "</ol>";

echo "<hr>";
echo "<p><em>Teste executado em: " . date('d/m/Y H:i:s') . "</em></p>";
?>
