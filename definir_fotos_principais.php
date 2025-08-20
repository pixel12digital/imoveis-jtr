<?php
/**
 * 🔧 DEFINIR FOTOS PRINCIPAIS
 * Execute este script para definir a primeira foto de cada imóvel como principal
 */

// Configurações de erro
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>🔧 Definir Fotos Principais</h1>";
echo "<style>body { font-family: Arial, sans-serif; margin: 20px; }</style>";

// Carregar configurações
if (file_exists('config/database.php')) {
    require_once 'config/database.php';
    echo "<h2>✅ Banco de dados carregado</h2>";
} else {
    echo "<p>❌ Não foi possível carregar config/database.php</p>";
    exit;
}

try {
    echo "<h3>🔍 Verificando imóveis sem foto principal:</h3>";
    
    // Buscar imóveis que não têm foto principal
    $stmt = $pdo->prepare("
        SELECT i.id, i.titulo, COUNT(f.id) as total_fotos
        FROM imoveis i
        LEFT JOIN fotos_imovel f ON i.id = f.imovel_id AND f.principal = 1
        WHERE f.id IS NULL
        GROUP BY i.id
        HAVING total_fotos > 0
    ");
    $stmt->execute();
    $imoveis_sem_principal = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if ($imoveis_sem_principal) {
        echo "<p>❌ <strong>Imóveis sem foto principal:</strong> " . count($imoveis_sem_principal) . "</p>";
        
        foreach ($imoveis_sem_principal as $imovel) {
            echo "<div style='border: 1px solid #dc3545; padding: 10px; margin: 10px 0; border-radius: 4px; background: #f8d7da;'>";
            echo "<p><strong>ID:</strong> " . $imovel['id'] . "</p>";
            echo "<p><strong>Título:</strong> " . htmlspecialchars($imovel['titulo']) . "</p>";
            echo "<p><strong>Total de fotos:</strong> " . $imovel['total_fotos'] . "</p>";
            echo "</div>";
        }
        
        echo "<h3>🔧 Corrigindo fotos principais:</h3>";
        
        foreach ($imoveis_sem_principal as $imovel) {
            $imovel_id = $imovel['id'];
            
            // Buscar a primeira foto do imóvel
            $stmt = $pdo->prepare("
                SELECT id, arquivo 
                FROM fotos_imovel 
                WHERE imovel_id = ? 
                ORDER BY ordem ASC, id ASC 
                LIMIT 1
            ");
            $stmt->execute([$imovel_id]);
            $primeira_foto = $stmt->fetch();
            
            if ($primeira_foto) {
                // Definir como principal
                $stmt = $pdo->prepare("
                    UPDATE fotos_imovel 
                    SET principal = 1 
                    WHERE id = ?
                ");
                $result = $stmt->execute([$primeira_foto['id']]);
                
                if ($result) {
                    echo "<div style='border: 1px solid #28a745; padding: 10px; margin: 10px 0; border-radius: 4px; background: #d4edda;'>";
                    echo "<p>✅ <strong>Imóvel ID $imovel_id:</strong> Foto definida como principal</p>";
                    echo "<p><strong>Arquivo:</strong> " . htmlspecialchars($primeira_foto['arquivo']) . "</p>";
                    echo "</div>";
                } else {
                    echo "<div style='border: 1px solid #dc3545; padding: 10px; margin: 10px 0; border-radius: 4px; background: #f8d7da;'>";
                    echo "<p>❌ <strong>Erro ao definir foto principal</strong> para imóvel ID $imovel_id</p>";
                    echo "</div>";
                }
            } else {
                echo "<div style='border: 1px solid #ffc107; padding: 10px; margin: 10px 0; border-radius: 4px; background: #fff3cd;'>";
                echo "<p>⚠️ <strong>Imóvel ID $imovel_id:</strong> Nenhuma foto encontrada</p>";
                echo "</div>";
            }
        }
        
    } else {
        echo "<p>✅ <strong>Todos os imóveis já têm foto principal!</strong></p>";
    }
    
    // Verificar resultado final
    echo "<h3>🔍 Verificação final:</h3>";
    
    $stmt = $pdo->query("
        SELECT i.id, i.titulo, f.arquivo as foto_principal
        FROM imoveis i
        LEFT JOIN fotos_imovel f ON i.id = f.imovel_id AND f.principal = 1
        ORDER BY i.id
    ");
    $resultado_final = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if ($resultado_final) {
        echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
        echo "<tr style='background: #f0f0f0;'>";
        echo "<th>ID</th><th>Título</th><th>Foto Principal</th><th>Status</th>";
        echo "</tr>";
        
        foreach ($resultado_final as $imovel) {
            $bg_color = $imovel['foto_principal'] ? 'background: #d4edda;' : 'background: #f8d7da;';
            $status = $imovel['foto_principal'] ? '✅ Tem foto' : '❌ Sem foto';
            
            echo "<tr style='$bg_color'>";
            echo "<td>" . $imovel['id'] . "</td>";
            echo "<td>" . htmlspecialchars($imovel['titulo']) . "</td>";
            echo "<td>" . htmlspecialchars($imovel['foto_principal'] ?? 'N/A') . "</td>";
            echo "<td>$status</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
    
} catch (Exception $e) {
    echo "<p class='error'>❌ <strong>Erro:</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
}

echo "<hr>";
echo "<h3>🎯 Próximos Passos:</h3>";
echo "<ol>";
echo "<li><strong>Execute este script</strong> para corrigir as fotos principais</li>";
echo "<li><strong>Teste a home</strong> - as imagens devem aparecer agora</li>";
echo "<li><strong>Verifique se os cartões</strong> estão mostrando as imagens</li>";
echo "</ol>";

echo "<hr>";
echo "<p><em>Script executado em: " . date('Y-m-d H:i:s') . "</em></p>";
?>
