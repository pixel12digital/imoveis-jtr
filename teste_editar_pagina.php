<?php
// Teste específico da página de edição
require_once 'config/database.php';
require_once 'config/config.php';

echo "<h1>Teste da Página de Edição</h1>";
echo "<style>body { font-family: Arial, sans-serif; }</style>";

// Simular exatamente o que acontece na página editar.php
echo "<h2>1. Simulando página de edição...</h2>";

// Simular dados POST como se fossem enviados pelo formulário
$_POST = [
    'titulo' => 'CASA NO CONDOMÍNIO COSTA VERDE TABATINGA',
    'descricao' => 'Sobrado de Alto Padrão no Condomínio Costa Verde Tabatinga...',
    'preco' => '3.000.000,00', // NOVO VALOR
    'tipo_id' => '1',
    'localizacao_id' => '7',
    'status' => 'disponivel',
    'destaque' => '1',
    'area_total' => '620',
    'area_construida' => '350',
    'quartos' => '4',
    'banheiros' => '5',
    'vagas_garagem' => '',
    'endereco' => 'SP 055, 2500, TABATINGA -SP',
    'cep' => ''
];

echo "<h2>2. Dados POST recebidos:</h2>";
echo "<pre>" . print_r($_POST, true) . "</pre>";

// Teste 1: Verificar preço atual
echo "<h2>3. Preço Atual no Banco:</h2>";
try {
    $stmt = $pdo->prepare("SELECT preco FROM imoveis WHERE id = 6");
    $stmt->execute();
    $preco_atual = $stmt->fetchColumn();
    echo "<p><strong>Preço atual:</strong> " . number_format($preco_atual, 2, ',', '.') . "</p>";
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Erro ao consultar preço atual: " . $e->getMessage() . "</p>";
}

// Teste 2: Processar como na página editar.php
echo "<h2>4. Processamento como na página editar.php:</h2>";
try {
    // Validar dados obrigatórios
    $titulo = cleanInput($_POST['titulo']);
    $descricao = cleanInput($_POST['descricao']);
    
    // Converter preço do formato brasileiro para número
    $preco = convertBrazilianPriceToNumber($_POST['preco']);
    
    echo "<p><strong>Preço original:</strong> " . $_POST['preco'] . "</p>";
    echo "<p><strong>Preço convertido:</strong> " . $preco . "</p>";
    echo "<p><strong>Preço formatado:</strong> " . formatPrice($preco) . "</p>";
    
    $tipo_id = (int)$_POST['tipo_id'];
    $localizacao_id = (int)$_POST['localizacao_id'];
    
    if (empty($titulo) || empty($descricao) || $preco <= 0 || $tipo_id <= 0 || $localizacao_id <= 0) {
        throw new Exception('Todos os campos obrigatórios devem ser preenchidos.');
    }
    
    echo "<p style='color: green;'>✅ Validação passou</p>";
    
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Erro na validação: " . $e->getMessage() . "</p>";
    exit;
}

// Teste 3: Preparar dados
echo "<h2>5. Preparando dados para UPDATE:</h2>";
try {
    $dados_imovel = [
        'titulo' => $titulo,
        'descricao' => $descricao,
        'preco' => $preco,
        'tipo_id' => $tipo_id,
        'localizacao_id' => $localizacao_id,
        'status' => cleanInput($_POST['status']),
        'destaque' => isset($_POST['destaque']) ? 1 : 0,
        'area_total' => !empty($_POST['area_total']) ? (float)$_POST['area_total'] : null,
        'area_construida' => !empty($_POST['area_construida']) ? (float)$_POST['area_construida'] : null,
        'quartos' => !empty($_POST['quartos']) ? (int)$_POST['quartos'] : null,
        'banheiros' => !empty($_POST['banheiros']) ? (int)$_POST['banheiros'] : null,
        'vagas_garagem' => !empty($_POST['vagas_garagem']) ? (int)$_POST['vagas_garagem'] : null,
        'endereco' => cleanInput($_POST['endereco']),
        'cep' => cleanInput($_POST['cep']),
        'data_atualizacao' => date('Y-m-d H:i:s')
    ];
    
    echo "<p><strong>Dados preparados:</strong></p>";
    echo "<pre>" . print_r($dados_imovel, true) . "</pre>";
    
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Erro na preparação: " . $e->getMessage() . "</p>";
    exit;
}

// Teste 4: Executar UPDATE
echo "<h2>6. Executando UPDATE:</h2>";
try {
    echo "<p><strong>Executando:</strong> UPDATE imoveis SET ... WHERE id = 6</p>";
    
    // Usar a função update() exatamente como na página
    $resultado = update("imoveis", $dados_imovel, "id = ?", [6]);
    
    echo "<p><strong>Resultado do UPDATE:</strong> " . ($resultado ? 'SUCESSO' : 'FALHA') . "</p>";
    
    if ($resultado) {
        echo "<p style='color: green;'>✅ UPDATE executado com sucesso!</p>";
    } else {
        echo "<p style='color: red;'>❌ UPDATE falhou!</p>";
        
        // Verificar se não houve alterações
        $stmt = $pdo->prepare("SELECT preco FROM imoveis WHERE id = 6");
        $stmt->execute();
        $preco_verificacao = $stmt->fetchColumn();
        
        if ($preco_verificacao == $preco) {
            echo "<p style='color: orange;'>⚠️ UPDATE falhou porque não há alterações (preço já é o mesmo)</p>";
        } else {
            echo "<p style='color: red;'>❌ UPDATE falhou por outro motivo</p>";
        }
    }
    
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Erro no UPDATE: " . $e->getMessage() . "</p>";
}

// Teste 5: Verificar resultado
echo "<h2>7. Verificação Final:</h2>";
try {
    $stmt = $pdo->prepare("SELECT preco FROM imoveis WHERE id = 6");
    $stmt->execute();
    $preco_final = $stmt->fetchColumn();
    
    echo "<p><strong>Preço final no banco:</strong> " . number_format($preco_final, 2, ',', '.') . "</p>";
    
    if ($preco_final == $preco) {
        echo "<p style='color: green; font-weight: bold;'>✅ SUCESSO: Preço foi atualizado para " . formatPrice($preco) . "!</p>";
    } else {
        echo "<p style='color: red; font-weight: bold;'>❌ FALHA: Preço não foi atualizado!</p>";
        echo "<p><strong>Esperado:</strong> " . formatPrice($preco) . "</p>";
        echo "<p><strong>Encontrado:</strong> " . formatPrice($preco_final) . "</p>";
    }
    
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Erro na verificação: " . $e->getMessage() . "</p>";
}

echo "<hr>";
echo "<h2>8. Análise:</h2>";
echo "<p>Se o UPDATE falhar, o problema está na função update() ou na execução do SQL.</p>";
echo "<p>Se o UPDATE passar mas o preço não mudar, há um problema na lógica da página.</p>";
?>
