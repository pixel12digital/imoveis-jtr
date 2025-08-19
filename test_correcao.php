<?php
// Teste da correção da variável global $pdo
echo "<h1>🔧 Teste da Correção - Variável Global \$pdo</h1>";

// Incluir configurações
require_once 'config/paths.php';
require_once 'config/database.php';
require_once 'config/config.php';

echo "<h2>1. Verificação da Variável Global</h2>";
echo "<p><strong>\$pdo definida:</strong> " . (isset($pdo) ? '✅ Sim' : '❌ Não') . "</p>";
echo "<p><strong>\$pdo é objeto:</strong> " . (is_object($pdo) ? '✅ Sim' : '❌ Não') . "</p>";

if (isset($pdo) && is_object($pdo)) {
    echo "<p style='color: green;'>✅ Variável \$pdo está disponível e é um objeto</p>";
    
    try {
        // Testar uma query simples
        $stmt = $pdo->query("SELECT COUNT(*) as total FROM imoveis");
        $result = $stmt->fetch();
        echo "<p style='color: green;'>✅ Query de teste funcionou: " . $result['total'] . " imóveis</p>";
    } catch (Exception $e) {
        echo "<p style='color: red;'>❌ Erro na query: " . $e->getMessage() . "</p>";
    }
} else {
    echo "<p style='color: red;'>❌ Variável \$pdo não está disponível ou não é um objeto</p>";
}

echo "<h2>2. Teste da Função includeFile</h2>";
echo "<p>Testando se a função includeFile passa a variável \$pdo corretamente...</p>";

// Simular o que o index.php faz
ob_start();
$header_result = includeFile('includes/header.php');
ob_end_clean();

if ($header_result !== false) {
    echo "<p style='color: green;'>✅ Header incluído com sucesso</p>";
} else {
    echo "<p style='color: red;'>❌ Falha ao incluir header</p>";
}

echo "<h2>3. Teste da Página de Contato</h2>";
echo "<p><a href='index.php?page=contato' target='_blank'>🧪 Testar Página de Contato Agora</a></p>";

echo "<hr>";
echo "<p><a href='index.php'>🏠 Voltar para o site</a></p>";
?>
