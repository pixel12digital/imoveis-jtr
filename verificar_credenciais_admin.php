<?php
// Verificar credenciais de administrador
require_once 'config/database.php';

echo "<h1>🔐 Verificação de Credenciais de Administrador</h1>";
echo "<hr>";

try {
    // Verificar estrutura da tabela usuarios
    echo "<h2>📋 Estrutura da Tabela 'usuarios':</h2>";
    $stmt = $pdo->query("DESCRIBE usuarios");
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
    
    // Buscar todos os usuários
    echo "<h2>👥 Usuários Cadastrados:</h2>";
    $stmt = $pdo->query("SELECT * FROM usuarios");
    $usuarios = $stmt->fetchAll();
    
    if (count($usuarios) > 0) {
        echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
        
        // Cabeçalho da tabela
        $first_row = $usuarios[0];
        echo "<tr>";
        foreach (array_keys($first_row) as $column) {
            if ($column !== 'senha') { // Não mostrar senha
                echo "<th>" . $column . "</th>";
            }
        }
        echo "</tr>";
        
        // Dados
        foreach ($usuarios as $usuario) {
            echo "<tr>";
            foreach ($usuario as $column => $value) {
                if ($column !== 'senha') { // Não mostrar senha
                    if ($column === 'tipo' || $column === 'status') {
                        echo "<td style='background-color: " . ($value === 'admin' || $value === 'ativo' ? '#d4edda' : '#f8d7da') . ";'>" . htmlspecialchars($value) . "</td>";
                    } else {
                        echo "<td>" . htmlspecialchars($value) . "</td>";
                    }
                }
            }
            echo "</tr>";
        }
        echo "</table>";
        
        // Mostrar informações específicas dos admins
        echo "<h2>🔑 Administradores:</h2>";
        $stmt = $pdo->query("SELECT id, nome, email, tipo, status FROM usuarios WHERE tipo = 'admin' OR tipo = 'administrador'");
        $admins = $stmt->fetchAll();
        
        if (count($admins) > 0) {
            echo "<div style='background-color: #d1ecf1; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
            echo "<h3>🎯 Usuários Administradores:</h3>";
            foreach ($admins as $admin) {
                echo "<div style='margin: 10px 0; padding: 10px; background-color: white; border-radius: 3px;'>";
                echo "<strong>ID:</strong> " . $admin['id'] . "<br>";
                echo "<strong>Nome:</strong> " . htmlspecialchars($admin['nome']) . "<br>";
                echo "<strong>Email:</strong> " . htmlspecialchars($admin['email']) . "<br>";
                echo "<strong>Tipo:</strong> " . htmlspecialchars($admin['tipo']) . "<br>";
                echo "<strong>Status:</strong> " . htmlspecialchars($admin['status']) . "<br>";
                echo "</div>";
            }
            echo "</div>";
        } else {
            echo "<p style='color: orange;'>⚠️ Nenhum usuário com tipo 'admin' ou 'administrador' encontrado.</p>";
        }
        
        // Verificar senhas padrão comuns
        echo "<h2>🔍 Verificação de Senhas Padrão:</h2>";
        $senhas_padrao = ['123456', 'admin', 'password', '123', 'admin123'];
        
        foreach ($senhas_padrao as $senha_teste) {
            $stmt = $pdo->prepare("SELECT id, nome, email FROM usuarios WHERE senha = ? OR senha = MD5(?) OR senha = SHA1(?)");
            $stmt->execute([$senha_teste, $senha_teste, $senha_teste]);
            $resultados = $stmt->fetchAll();
            
            if (count($resultados) > 0) {
                echo "<div style='background-color: #fff3cd; padding: 10px; border-radius: 3px; margin: 5px 0;'>";
                echo "<strong>⚠️ Senha encontrada:</strong> '$senha_teste'<br>";
                foreach ($resultados as $user) {
                    echo "- " . htmlspecialchars($user['nome']) . " (" . htmlspecialchars($user['email']) . ")<br>";
                }
                echo "</div>";
            }
        }
        
    } else {
        echo "<p style='color: red;'>❌ Nenhum usuário encontrado na tabela.</p>";
    }
    
} catch (PDOException $e) {
    echo "<p style='color: red;'>❌ <strong>Erro:</strong> " . $e->getMessage() . "</p>";
}

echo "<hr>";
echo "<h2>🔗 Links Úteis:</h2>";
echo "<ul>";
echo "<li><a href='admin/login.php'>🔐 Página de Login</a></li>";
echo "<li><a href='admin/'>⚙️ Painel Admin</a></li>";
echo "<li><a href='index.php'>🏠 Página Inicial</a></li>";
echo "</ul>";
?>
