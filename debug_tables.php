<?php
// Debug para verificar tabelas relacionadas
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Carregar configurações
require_once 'config/paths.php';
require_once 'config/database.php';
require_once 'config/config.php';

echo "<h1>Debug - Verificação de Tabelas Relacionadas</h1>";

try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Verificar tipos_imovel
    echo "<h2>1. Tabela tipos_imovel</h2>";
    $stmt = $pdo->query("SELECT * FROM tipos_imovel ORDER BY id");
    $tipos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (empty($tipos)) {
        echo "❌ Tabela tipos_imovel está vazia!<br>";
    } else {
        echo "✅ Tipos de imóvel encontrados:<br>";
        foreach ($tipos as $tipo) {
            echo "- ID: {$tipo['id']}, Nome: {$tipo['nome']}<br>";
        }
    }
    
    // Verificar localizacoes
    echo "<h2>2. Tabela localizacoes</h2>";
    $stmt = $pdo->query("SELECT * FROM localizacoes ORDER BY id");
    $localizacoes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (empty($localizacoes)) {
        echo "❌ Tabela localizacoes está vazia!<br>";
    } else {
        echo "✅ Localizações encontradas:<br>";
        foreach ($localizacoes as $loc) {
            echo "- ID: {$loc['id']}, Cidade: {$loc['cidade']}, Bairro: {$loc['bairro']}, Estado: {$loc['estado']}<br>";
        }
    }
    
    // Verificar usuarios
    echo "<h2>3. Tabela usuarios</h2>";
    $stmt = $pdo->query("SELECT * FROM usuarios ORDER BY id");
    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (empty($usuarios)) {
        echo "❌ Tabela usuarios está vazia!<br>";
    } else {
        echo "✅ Usuários encontrados:<br>";
        foreach ($usuarios as $user) {
            echo "- ID: {$user['id']}, Nome: {$user['nome']}, Email: {$user['email']}<br>";
        }
    }
    
    // Verificar caracteristicas
    echo "<h2>4. Tabela caracteristicas</h2>";
    $stmt = $pdo->query("SELECT * FROM caracteristicas ORDER BY id");
    $caracteristicas = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (empty($caracteristicas)) {
        echo "❌ Tabela caracteristicas está vazia!<br>";
    } else {
        echo "✅ Características encontradas:<br>";
        foreach ($caracteristicas as $carac) {
            echo "- ID: {$carac['id']}, Nome: {$carac['nome']}<br>";
        }
    }
    
    echo "<hr>";
    echo "<h2>5. Solução - Inserir Dados de Exemplo</h2>";
    
    // Inserir tipo de imóvel se não existir
    if (empty($tipos)) {
        echo "Inserindo tipo de imóvel padrão...<br>";
        $stmt = $pdo->prepare("INSERT INTO tipos_imovel (nome, descricao) VALUES (?, ?)");
        $stmt->execute(['Apartamento', 'Apartamento residencial']);
        echo "✅ Tipo 'Apartamento' inserido com ID: " . $pdo->lastInsertId() . "<br>";
    }
    
    // Inserir localização se não existir
    if (empty($localizacoes)) {
        echo "Inserindo localização padrão...<br>";
        $stmt = $pdo->prepare("INSERT INTO localizacoes (cidade, bairro, estado, cep) VALUES (?, ?, ?, ?)");
        $stmt->execute(['Blumenau', 'Velha', 'SC', '89036-000']);
        echo "✅ Localização 'Blumenau - Velha, SC' inserida com ID: " . $pdo->lastInsertId() . "<br>";
    }
    
    // Inserir usuário se não existir
    if (empty($usuarios)) {
        echo "Inserindo usuário padrão...<br>";
        $stmt = $pdo->prepare("INSERT INTO usuarios (nome, email, senha, ativo, tipo) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute(['Admin', 'admin@jtrimoveis.com', password_hash('admin123', PASSWORD_DEFAULT), 1, 'admin']);
        echo "✅ Usuário 'Admin' inserido com ID: " . $pdo->lastInsertId() . "<br>";
    }
    
    // Inserir características se não existir
    if (empty($caracteristicas)) {
        echo "Inserindo características padrão...<br>";
        $caracs = [
            ['Quartos', 'Número de quartos'],
            ['Banheiros', 'Número de banheiros'],
            ['Vagas', 'Vagas de garagem'],
            ['Área', 'Área total do imóvel'],
            ['Mobiliado', 'Imóvel mobiliado']
        ];
        
        foreach ($caracs as $carac) {
            $stmt = $pdo->prepare("INSERT INTO caracteristicas (nome, descricao) VALUES (?, ?)");
            $stmt->execute($carac);
            echo "✅ Característica '{$carac[0]}' inserida<br>";
        }
    }
    
    echo "<hr>";
    echo "<h2>6. Teste de Inserção Após Correção</h2>";
    
    // Buscar IDs válidos
    $stmt = $pdo->query("SELECT id FROM tipos_imovel LIMIT 1");
    $tipo_id = $stmt->fetch(PDO::FETCH_COLUMN);
    
    $stmt = $pdo->query("SELECT id FROM localizacoes LIMIT 1");
    $localizacao_id = $stmt->fetch(PDO::FETCH_COLUMN);
    
    $stmt = $pdo->query("SELECT id FROM usuarios LIMIT 1");
    $usuario_id = $stmt->fetch(PDO::FETCH_COLUMN);
    
    echo "IDs válidos encontrados:<br>";
    echo "- Tipo ID: " . ($tipo_id ?: 'NÃO ENCONTRADO') . "<br>";
    echo "- Localização ID: " . ($localizacao_id ?: 'NÃO ENCONTRADO') . "<br>";
    echo "- Usuário ID: " . ($usuario_id ?: 'NÃO ENCONTRADO') . "<br>";
    
    if ($tipo_id && $localizacao_id && $usuario_id) {
        echo "<br>Testando inserção com IDs válidos...<br>";
        
        $test_data = [
            'titulo' => 'Teste Após Correção',
            'descricao' => 'Descrição de teste após inserir dados base',
            'preco' => 100000,
            'tipo_id' => $tipo_id,
            'localizacao_id' => $localizacao_id,
            'usuario_id' => $usuario_id,
            'status' => 'disponivel',
            'destaque' => 0,
            'data_criacao' => date('Y-m-d H:i:s')
        ];
        
        $result = insert("imoveis", $test_data);
        if ($result) {
            echo "✅ Imóvel inserido com sucesso! ID: " . $result . "<br>";
            
            // Remover o registro de teste
            $pdo->exec("DELETE FROM imoveis WHERE id = " . $result);
            echo "🗑️ Registro de teste removido<br>";
        } else {
            echo "❌ Falha ao inserir imóvel<br>";
        }
    } else {
        echo "❌ Não foi possível encontrar todos os IDs necessários<br>";
    }
    
} catch (Exception $e) {
    echo "❌ Erro: " . $e->getMessage() . "<br>";
}
?>
