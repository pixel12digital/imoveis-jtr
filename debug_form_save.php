<?php
// Debug para testar salvamento do formulário
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Carregar configurações
require_once 'config/paths.php';
require_once 'config/database.php';
require_once 'config/config.php';

echo "<h1>Debug - Teste de Salvamento</h1>";

// Testar conexão com banco
echo "<h2>1. Teste de Conexão</h2>";
try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "✅ Conexão com banco: OK<br>";
} catch (PDOException $e) {
    echo "❌ Erro na conexão: " . $e->getMessage() . "<br>";
    exit;
}

// Testar função insert
echo "<h2>2. Teste da Função Insert</h2>";
try {
    $test_data = [
        'titulo' => 'Teste Debug',
        'descricao' => 'Descrição de teste',
        'preco' => 100000,
        'tipo_id' => 1,
        'localizacao_id' => 1,
        'usuario_id' => 1,
        'status' => 'disponivel',
        'destaque' => 0,
        'data_criacao' => date('Y-m-d H:i:s')
    ];
    
    echo "Dados de teste: " . print_r($test_data, true) . "<br>";
    
    $result = insert("imoveis", $test_data);
    if ($result) {
        echo "✅ Insert funcionou! ID retornado: " . $result . "<br>";
        
        // Remover o registro de teste
        $pdo->exec("DELETE FROM imoveis WHERE id = " . $result);
        echo "🗑️ Registro de teste removido<br>";
    } else {
        echo "❌ Insert falhou!<br>";
    }
} catch (Exception $e) {
    echo "❌ Erro no insert: " . $e->getMessage() . "<br>";
}

// Testar função cleanInput
echo "<h2>3. Teste da Função CleanInput</h2>";
try {
    $test_input = "Teste <script>alert('xss')</script>";
    $cleaned = cleanInput($test_input);
    echo "Input original: " . htmlspecialchars($test_input) . "<br>";
    echo "Input limpo: " . htmlspecialchars($cleaned) . "<br>";
    echo "✅ CleanInput funcionou!<br>";
} catch (Exception $e) {
    echo "❌ Erro no cleanInput: " . $e->getMessage() . "<br>";
}

// Verificar estrutura da tabela imoveis
echo "<h2>4. Estrutura da Tabela Imoveis</h2>";
try {
    $stmt = $pdo->query("DESCRIBE imoveis");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo "Colunas da tabela imoveis:<br>";
    foreach ($columns as $col) {
        echo "- " . $col['Field'] . " (" . $col['Type'] . ") " . 
             ($col['Null'] == 'NO' ? 'NOT NULL' : 'NULL') . 
             ($col['Key'] == 'PRI' ? ' PRIMARY KEY' : '') . "<br>";
    }
} catch (Exception $e) {
    echo "❌ Erro ao verificar estrutura: " . $e->getMessage() . "<br>";
}

// Verificar dados existentes
echo "<h2>5. Dados Existentes</h2>";
try {
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM imoveis");
    $count = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "Total de imóveis: " . $count['total'] . "<br>";
    
    if ($count['total'] > 0) {
        $stmt = $pdo->query("SELECT * FROM imoveis LIMIT 3");
        $imoveis = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo "Primeiros 3 imóveis:<br>";
        foreach ($imoveis as $imovel) {
            echo "- ID: " . $imovel['id'] . ", Título: " . $imovel['titulo'] . "<br>";
        }
    }
} catch (Exception $e) {
    echo "❌ Erro ao verificar dados: " . $e->getMessage() . "<br>";
}

echo "<hr>";
echo "<h2>6. Teste de Formulário Simulado</h2>";
echo "<form method='POST' enctype='multipart/form-data'>";
echo "<input type='text' name='titulo' value='Imóvel Teste' required><br>";
echo "<textarea name='descricao' required>Descrição de teste</textarea><br>";
echo "<input type='number' name='preco' value='150000' required><br>";
echo "<select name='tipo_id' required><option value='1'>Apartamento</option></select><br>";
echo "<select name='localizacao_id' required><option value='1'>Blumenau - Velha, SC</option></select><br>";
echo "<select name='status'><option value='disponivel'>Disponível</option></select><br>";
echo "<input type='file' name='fotos[]' multiple accept='image/*'><br>";
echo "<button type='submit'>Testar Salvamento</button>";
echo "</form>";

// Processar formulário de teste
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo "<h3>Resultado do Processamento:</h3>";
    echo "POST data: " . print_r($_POST, true) . "<br>";
    echo "FILES data: " . print_r($_FILES, true) . "<br>";
    
    try {
        // Simular o mesmo processo da página original
        $titulo = cleanInput($_POST['titulo']);
        $descricao = cleanInput($_POST['descricao']);
        $preco = (float)$_POST['preco'];
        $tipo_id = (int)$_POST['tipo_id'];
        $localizacao_id = (int)$_POST['localizacao_id'];
        
        echo "Dados processados: Título='{$titulo}', Preço={$preco}, Tipo={$tipo_id}, Localização={$localizacao_id}<br>";
        
        if (empty($titulo) || empty($descricao) || $preco <= 0 || $tipo_id <= 0 || $localizacao_id <= 0) {
            throw new Exception('Campos obrigatórios não preenchidos');
        }
        
        $dados_imovel = [
            'titulo' => $titulo,
            'descricao' => $descricao,
            'preco' => $preco,
            'tipo_id' => $tipo_id,
            'localizacao_id' => $localizacao_id,
            'usuario_id' => 1, // Usuário fixo para teste
            'status' => cleanInput($_POST['status']),
            'destaque' => 0,
            'data_criacao' => date('Y-m-d H:i:s')
        ];
        
        echo "Dados para inserção: " . print_r($dados_imovel, true) . "<br>";
        
        $imovel_id = insert("imoveis", $dados_imovel);
        if ($imovel_id) {
            echo "✅ Imóvel inserido com sucesso! ID: " . $imovel_id . "<br>";
            
            // Remover o registro de teste
            $pdo->exec("DELETE FROM imoveis WHERE id = " . $imovel_id);
            echo "🗑️ Registro de teste removido<br>";
        } else {
            echo "❌ Falha ao inserir imóvel<br>";
        }
        
    } catch (Exception $e) {
        echo "❌ Erro: " . $e->getMessage() . "<br>";
    }
}
?>
