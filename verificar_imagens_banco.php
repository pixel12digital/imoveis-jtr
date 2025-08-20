<?php
/**
 * 🔍 VERIFICAR IMAGENS NO BANCO DE DADOS
 * Execute este script para ver onde estão as imagens cadastradas
 */

// Configurações de erro
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>🔍 Verificar Imagens no Banco de Dados</h1>";
echo "<style>body { font-family: Arial, sans-serif; margin: 20px; }</style>";

// Carregar configurações
if (file_exists('config/database.php')) {
    require_once 'config/database.php';
    
    try {
        echo "<h2>✅ Conexão com banco estabelecida</h2>";
        
        // Verificar todas as fotos do imóvel ID 6
        echo "<h3>📸 Fotos do Imóvel ID 6:</h3>";
        
        $stmt = $pdo->prepare("
            SELECT * FROM fotos_imovel 
            WHERE imovel_id = 6 
            ORDER BY principal DESC, ordem ASC
        ");
        $stmt->execute();
        $fotos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if ($fotos) {
            echo "<p>✅ <strong>Total de fotos encontradas:</strong> " . count($fotos) . "</p>";
            
            echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
            echo "<tr style='background: #f0f0f0;'>";
            echo "<th>ID</th><th>Arquivo</th><th>Principal</th><th>Ordem</th><th>Legenda</th><th>Status</th>";
            echo "</tr>";
            
            foreach ($fotos as $foto) {
                $bg_color = $foto['principal'] ? 'background: #d4edda;' : '';
                echo "<tr style='$bg_color'>";
                echo "<td>" . $foto['id'] . "</td>";
                echo "<td><strong>" . htmlspecialchars($foto['arquivo']) . "</strong></td>";
                echo "<td>" . ($foto['principal'] ? '✅ SIM' : '❌ NÃO') . "</td>";
                echo "<td>" . $foto['ordem'] . "</td>";
                echo "<td>" . htmlspecialchars($foto['legenda'] ?? 'N/A') . "</td>";
                echo "<td>" . ($foto['ativo'] ? '✅ Ativo' : '❌ Inativo') . "</td>";
                echo "</tr>";
            }
            echo "</table>";
            
            // Verificar se os arquivos existem fisicamente
            echo "<h3>🔍 Verificando existência física dos arquivos:</h3>";
            
            foreach ($fotos as $foto) {
                $arquivo = $foto['arquivo'];
                $caminhos_teste = [
                    'uploads/imoveis/6/' . $arquivo,
                    'uploads/imoveis/999/' . $arquivo,
                    'uploads/imoveis/test/' . $arquivo,
                    'uploads/' . $arquivo
                ];
                
                echo "<h4>Arquivo: <strong>$arquivo</strong></h4>";
                echo "<ul>";
                
                foreach ($caminhos_teste as $caminho) {
                    if (file_exists($caminho)) {
                        $tamanho = filesize($caminho);
                        $legivel = is_readable($caminho) ? '✅ Legível' : '❌ Não legível';
                        echo "<li>✅ <strong>$caminho</strong> - EXISTE ($tamanho bytes) - $legivel</li>";
                    } else {
                        echo "<li>❌ <strong>$caminho</strong> - NÃO EXISTE</li>";
                    }
                }
                
                echo "</ul>";
            }
            
        } else {
            echo "<p>❌ <strong>Nenhuma foto encontrada</strong> para o imóvel ID 6</p>";
        }
        
        // Verificar se o imóvel ID 6 existe
        echo "<h3>🏠 Verificando Imóvel ID 6:</h3>";
        
        $stmt = $pdo->prepare("SELECT * FROM imoveis WHERE id = 6");
        $stmt->execute();
        $imovel = $stmt->fetch();
        
        if ($imovel) {
            echo "<p>✅ <strong>Imóvel encontrado:</strong> " . htmlspecialchars($imovel['titulo']) . "</p>";
            echo "<p><strong>Status:</strong> " . $imovel['status'] . "</p>";
            echo "<p><strong>Ativo:</strong> " . ($imovel['ativo'] ? 'SIM' : 'NÃO') . "</p>";
        } else {
            echo "<p>❌ <strong>Imóvel ID 6 não encontrado</strong></p>";
        }
        
        // Verificar estrutura da tabela fotos_imovel
        echo "<h3>📋 Estrutura da Tabela fotos_imovel:</h3>";
        
        $stmt = $pdo->query("DESCRIBE fotos_imovel");
        $colunas = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if ($colunas) {
            echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
            echo "<tr style='background: #f0f0f0;'>";
            echo "<th>Campo</th><th>Tipo</th><th>Nulo</th><th>Chave</th><th>Padrão</th><th>Extra</th>";
            echo "</tr>";
            
            foreach ($colunas as $coluna) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($coluna['Field']) . "</td>";
                echo "<td>" . htmlspecialchars($coluna['Type']) . "</td>";
                echo "<td>" . htmlspecialchars($coluna['Null']) . "</td>";
                echo "<td>" . htmlspecialchars($coluna['Key']) . "</td>";
                echo "<td>" . htmlspecialchars($coluna['Default'] ?? 'NULL') . "</td>";
                echo "<td>" . htmlspecialchars($coluna['Extra']) . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        }
        
    } catch (Exception $e) {
        echo "<p class='error'>❌ <strong>Erro:</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
    }
    
} else {
    echo "<p class='error'>❌ Não foi possível carregar config/database.php</p>";
}

echo "<hr>";
echo "<h3>🎯 Análise do Problema:</h3>";
echo "<ol>";
echo "<li><strong>Imóvel ID 6:</strong> Pode não existir ou estar inativo</li>";
echo "<li><strong>Fotos cadastradas:</strong> Podem estar com caminhos incorretos</li>";
echo "<li><strong>Diretório de uploads:</strong> Estrutura pode estar diferente do esperado</li>";
echo "<li><strong>Banco de dados:</strong> Referências podem estar incorretas</li>";
echo "</ol>";

echo "<hr>";
echo "<p><em>Verificação executada em: " . date('Y-m-d H:i:s') . "</em></p>";
?>
