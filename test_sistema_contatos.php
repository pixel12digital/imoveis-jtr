<?php
// Teste do Sistema de Contatos Inteligente - JTR Imóveis
require_once 'config/paths.php';
require_once 'config/database.php';
require_once 'config/config.php';

echo "<h1>Teste do Sistema de Contatos Inteligente</h1>";
echo "<hr>";

// Testar constantes
echo "<h2>1. Verificação das Constantes</h2>";
echo "<p><strong>PHONE_VENDA:</strong> " . PHONE_VENDA . "</p>";
echo "<p><strong>PHONE_LOCACAO:</strong> " . PHONE_LOCACAO . "</p>";
echo "<p><strong>PHONE_WHATSAPP_VENDA:</strong> " . PHONE_WHATSAPP_VENDA . "</p>";
echo "<p><strong>PHONE_WHATSAPP_LOCACAO:</strong> " . PHONE_WHATSAPP_LOCACAO . "</p>";
echo "<hr>";

// Testar função de identificação
echo "<h2>2. Teste de Identificação de Tipo de Operação</h2>";

// Incluir as funções do process_contact.php
function identificarTipoOperacao($assunto, $mensagem) {
    $assunto_lower = strtolower($assunto);
    $mensagem_lower = strtolower($mensagem);
    
    // Palavras-chave para venda
    $palavras_venda = [
        'compra', 'comprar', 'adquirir', 'adquirindo', 'comprador', 'compradores',
        'financiamento', 'financiar', 'hipoteca', 'entrada', 'parcelas',
        'valor total', 'preço total', 'custo total', 'investimento'
    ];
    
    // Palavras-chave para locação
    $palavras_locacao = [
        'aluguel', 'alugar', 'locação', 'locar', 'locatário', 'locatários',
        'mensalidade', 'caução', 'fiador', 'contrato de aluguel',
        'valor mensal', 'preço mensal', 'mensal', 'temporário'
    ];
    
    // Verificar no assunto
    foreach ($palavras_venda as $palavra) {
        if (strpos($assunto_lower, $palavra) !== false) {
            return 'venda';
        }
    }
    
    foreach ($palavras_locacao as $palavra) {
        if (strpos($assunto_lower, $palavra) !== false) {
            return 'locacao';
        }
    }
    
    // Verificar na mensagem
    foreach ($palavras_venda as $palavra) {
        if (strpos($mensagem_lower, $palavra) !== false) {
            return 'venda';
        }
    }
    
    foreach ($palavras_locacao as $palavra) {
        if (strpos($mensagem_lower, $palavra) !== false) {
            return 'locacao';
        }
    }
    
    // Se não conseguir identificar, usar padrão baseado no assunto
    if (strpos($assunto_lower, 'compra') !== false || strpos($assunto_lower, 'venda') !== false) {
        return 'venda';
    } elseif (strpos($assunto_lower, 'aluguel') !== false) {
        return 'locacao';
    }
    
    // Padrão: venda (mais comum)
    return 'venda';
}

function obterTelefoneOperacao($tipo_operacao) {
    switch ($tipo_operacao) {
        case 'venda':
            return PHONE_VENDA;
        case 'locacao':
            return PHONE_LOCACAO;
        default:
            return PHONE_VENDA; // Usar número de vendas como padrão
    }
}

// Casos de teste
$testes = [
    [
        'assunto' => 'Compra de imóvel',
        'mensagem' => 'Gostaria de comprar uma casa',
        'esperado' => 'venda'
    ],
    [
        'assunto' => 'Aluguel de apartamento',
        'mensagem' => 'Procurando um apartamento para alugar',
        'esperado' => 'locacao'
    ],
    [
        'assunto' => 'Financiamento',
        'mensagem' => 'Preciso de financiamento para comprar',
        'esperado' => 'venda'
    ],
    [
        'assunto' => 'Locação',
        'mensagem' => 'Quero alugar uma casa',
        'esperado' => 'locacao'
    ],
    [
        'assunto' => 'Dúvida',
        'mensagem' => 'Tenho uma dúvida sobre imóveis',
        'esperado' => 'venda' // padrão
    ]
];

foreach ($testes as $i => $teste) {
    $resultado = identificarTipoOperacao($teste['assunto'], $teste['mensagem']);
    $telefone = obterTelefoneOperacao($resultado);
    $status = ($resultado === $teste['esperado']) ? '✅' : '❌';
    
    echo "<div style='border: 1px solid #ccc; padding: 10px; margin: 10px 0;'>";
    echo "<h4>Teste " . ($i + 1) . " $status</h4>";
    echo "<p><strong>Assunto:</strong> " . htmlspecialchars($teste['assunto']) . "</p>";
    echo "<p><strong>Mensagem:</strong> " . htmlspecialchars($teste['mensagem']) . "</p>";
    echo "<p><strong>Esperado:</strong> " . $teste['esperado'] . "</p>";
    echo "<p><strong>Resultado:</strong> " . $resultado . "</p>";
    echo "<p><strong>Telefone:</strong> " . $telefone . "</p>";
    echo "</div>";
}

echo "<hr>";

// Testar estrutura do banco
echo "<h2>3. Verificação da Estrutura do Banco</h2>";
try {
    // Verificar se a tabela contatos existe
    $sql = "DESCRIBE contatos";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $colunas = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<p><strong>Estrutura da tabela contatos:</strong></p>";
    echo "<ul>";
    foreach ($colunas as $coluna) {
        $tipo_operacao = ($coluna['Field'] === 'tipo_operacao') ? ' <strong style="color: green;">✅ NOVO CAMPO</strong>' : '';
        echo "<li>{$coluna['Field']} - {$coluna['Type']}{$tipo_operacao}</li>";
    }
    echo "</ul>";
    
    // Verificar se o campo tipo_operacao existe
    $tem_tipo_operacao = false;
    foreach ($colunas as $coluna) {
        if ($coluna['Field'] === 'tipo_operacao') {
            $tem_tipo_operacao = true;
            break;
        }
    }
    
    if ($tem_tipo_operacao) {
        echo "<p style='color: green;'><strong>✅ Campo tipo_operacao encontrado!</strong></p>";
    } else {
        echo "<p style='color: red;'><strong>❌ Campo tipo_operacao NÃO encontrado!</strong></p>";
        echo "<p>Execute o script: <code>database/update_contatos_table.sql</code></p>";
    }
    
} catch (Exception $e) {
    echo "<p style='color: red;'><strong>Erro ao verificar banco:</strong> " . $e->getMessage() . "</p>";
}

echo "<hr>";

// Testar contagem de contatos
echo "<h2>4. Estatísticas do Banco</h2>";
try {
    $sql = "SELECT COUNT(*) as total FROM contatos";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $total = $stmt->fetch()['total'];
    
    echo "<p><strong>Total de contatos:</strong> $total</p>";
    
    if ($tem_tipo_operacao) {
        $sql = "SELECT 
            COUNT(*) as total,
            SUM(CASE WHEN tipo_operacao = 'venda' THEN 1 ELSE 0 END) as vendas,
            SUM(CASE WHEN tipo_operacao = 'locacao' THEN 1 ELSE 0 END) as locacoes,
            SUM(CASE WHEN tipo_operacao = 'outros' OR tipo_operacao IS NULL THEN 1 ELSE 0 END) as outros
        FROM contatos";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $stats = $stmt->fetch();
        
        echo "<p><strong>Por tipo de operação:</strong></p>";
        echo "<ul>";
        echo "<li>Vendas: " . ($stats['vendas'] ?? 0) . "</li>";
        echo "<li>Locações: " . ($stats['locacoes'] ?? 0) . "</li>";
        echo "<li>Outros: " . ($stats['outros'] ?? 0) . "</li>";
        echo "</ul>";
    }
    
} catch (Exception $e) {
    echo "<p style='color: red;'><strong>Erro ao buscar estatísticas:</strong> " . $e->getMessage() . "</p>";
}

echo "<hr>";

// Instruções finais
echo "<h2>5. Próximos Passos</h2>";
echo "<ol>";
echo "<li>Execute o script SQL: <code>database/update_contatos_table.sql</code></li>";
echo "<li>Teste o formulário de contato em: <code>pages/contato.php</code></li>";
echo "<li>Verifique o painel administrativo em: <code>admin/contatos/</code></li>";
echo "<li>Teste diferentes tipos de mensagens para verificar a identificação automática</li>";
echo "</ol>";

echo "<p><strong>Status do Sistema:</strong> ";
if ($tem_tipo_operacao) {
    echo "<span style='color: green;'>✅ PRONTO PARA USO</span>";
} else {
    echo "<span style='color: red;'>❌ NECESSITA ATUALIZAÇÃO DO BANCO</span>";
}
echo "</p>";

echo "<hr>";
echo "<p><em>Teste executado em: " . date('d/m/Y H:i:s') . "</em></p>";
?>
