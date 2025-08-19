<?php
// Teste das tabelas necessárias para a página de imóveis
echo "<h1>🏠 Teste das Tabelas - Página de Imóveis</h1>";

// Incluir configurações
require_once 'config/paths.php';
require_once 'config/database.php';
require_once 'config/config.php';

echo "<h2>1. Verificação de Conexão</h2>";
if (isset($pdo) && is_object($pdo)) {
    echo "<p style='color: green;'>✅ Conexão PDO disponível</p>";
} else {
    echo "<p style='color: red;'>❌ Conexão PDO não disponível</p>";
    exit;
}

echo "<h2>2. Verificação das Tabelas</h2>";

// Lista de tabelas necessárias
$tabelas_necessarias = [
    'imoveis',
    'tipos_imovel', 
    'localizacoes',
    'caracteristicas'
];

foreach ($tabelas_necessarias as $tabela) {
    try {
        $stmt = $pdo->query("SELECT COUNT(*) as total FROM $tabela");
        $result = $stmt->fetch();
        echo "<p style='color: green;'>✅ Tabela <strong>$tabela</strong>: " . $result['total'] . " registros</p>";
    } catch (Exception $e) {
        echo "<p style='color: red;'>❌ Tabela <strong>$tabela</strong>: " . $e->getMessage() . "</p>";
    }
}

echo "<h2>3. Verificação da Estrutura da Tabela Imóveis</h2>";
try {
    $stmt = $pdo->query("DESCRIBE imoveis");
    $colunas = $stmt->fetchAll();
    
    echo "<p style='color: green;'>✅ Estrutura da tabela imoveis:</p>";
    echo "<ul>";
    foreach ($colunas as $coluna) {
        echo "<li><strong>{$coluna['Field']}</strong> - {$coluna['Type']}</li>";
    }
    echo "</ul>";
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Erro ao verificar estrutura: " . $e->getMessage() . "</p>";
}

echo "<h2>4. Teste da Query Principal</h2>";
try {
    $sql = "SELECT i.*, t.nome as tipo_nome, l.cidade, l.bairro, l.estado 
            FROM imoveis i 
            INNER JOIN tipos_imovel t ON i.tipo_id = t.id 
            INNER JOIN localizacoes l ON i.localizacao_id = l.id 
            WHERE 1=1 
            LIMIT 5";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $resultados = $stmt->fetchAll();
    
    echo "<p style='color: green;'>✅ Query principal funcionou! " . count($resultados) . " imóveis encontrados</p>";
    
    if (count($resultados) > 0) {
        echo "<p>Primeiro imóvel:</p>";
        echo "<pre>" . print_r($resultados[0], true) . "</pre>";
    }
    
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Erro na query principal: " . $e->getMessage() . "</p>";
}

echo "<h2>5. Teste da Página de Imóveis</h2>";
echo "<p><a href='index.php?page=imoveis' target='_blank'>🧪 Testar Página de Imóveis Agora</a></p>";

echo "<hr>";
echo "<p><a href='index.php'>🏠 Voltar para o site</a></p>";
?>
