<?php
// SCRIPT GLOBAL PARA CORRIGIR TODOS OS IMÓVEIS
// Este script corrige a ordem das fotos de TODOS os imóveis do sistema
require_once 'config/database.php';

echo "<h2>🔧 Correção Global de Todos os Imóveis</h2>";
echo "<p>Este script corrige a ordem das fotos de TODOS os imóveis do sistema de uma vez.</p>";

// Função global de renumeração (mesma do admin)
function renumerarFotosAutomaticamente($imovel_id) {
    global $pdo;
    
    // Buscar todas as fotos do imóvel ordenadas pela ordem atual
    $stmt = $pdo->prepare("SELECT id FROM fotos_imovel WHERE imovel_id = ? ORDER BY ordem");
    $stmt->execute([$imovel_id]);
    $fotos_restantes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Renumerar sequencialmente de 1 a N
    foreach ($fotos_restantes as $index => $foto) {
        $nova_ordem = $index + 1;
        $update_stmt = $pdo->prepare("UPDATE fotos_imovel SET ordem = ? WHERE id = ?");
        $update_stmt->execute([$nova_ordem, $foto['id']]);
    }
    
    return count($fotos_restantes);
}

// 1. Listar todos os imóveis que possuem fotos
echo "<h3>📋 Imóveis encontrados com fotos:</h3>";
$stmt = $pdo->query("
    SELECT DISTINCT i.id, i.titulo, COUNT(f.id) as total_fotos
    FROM imoveis i 
    INNER JOIN fotos_imovel f ON i.id = f.imovel_id 
    GROUP BY i.id, i.titulo 
    ORDER BY i.id
");
$imoveis = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (empty($imoveis)) {
    echo "<div class='alert alert-info'>Nenhum imóvel com fotos encontrado.</div>";
    exit;
}

echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
echo "<tr style='background: #f0f0f0;'>";
echo "<th style='padding: 8px;'>ID</th>";
echo "<th style='padding: 8px;'>Título</th>";
echo "<th style='padding: 8px;'>Total de Fotos</th>";
echo "<th style='padding: 8px;'>Status</th>";
echo "</tr>";

foreach ($imoveis as $imovel) {
    echo "<tr>";
    echo "<td style='padding: 8px;'>{$imovel['id']}</td>";
    echo "<td style='padding: 8px;'>" . htmlspecialchars($imovel['titulo']) . "</td>";
    echo "<td style='padding: 8px;'>{$imovel['total_fotos']}</td>";
    echo "<td style='padding: 8px;' id='status_{$imovel['id']}'>⏳ Aguardando...</td>";
    echo "</tr>";
}
echo "</table>";

// 2. Botão para executar a correção
echo "<br><br>";
echo "<button onclick='executarCorrecaoGlobal()' style='padding: 15px 30px; font-size: 18px; background: #28a745; color: white; border: none; border-radius: 5px; cursor: pointer;'>";
echo "🚀 EXECUTAR CORREÇÃO GLOBAL";
echo "</button>";

echo "<div id='resultado' style='margin-top: 20px;'></div>";

// 3. JavaScript para executar a correção
echo "<script>
function executarCorrecaoGlobal() {
    const resultado = document.getElementById('resultado');
    resultado.innerHTML = '<h3>🔄 Executando correção global...</h3>';
    
    // Desabilitar botão
    const btn = event.target;
    btn.disabled = true;
    btn.innerHTML = '⏳ Processando...';
    
    // Fazer requisição AJAX para executar a correção
    fetch('executar_correcao_global.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({acao: 'corrigir_todos'})
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            resultado.innerHTML = '<div style=\"background: #d4edda; color: #155724; padding: 15px; border-radius: 5px; border: 1px solid #c3e6cb;\">' +
                '<h3>✅ Correção Global Concluída!</h3>' +
                '<p><strong>Total de imóveis corrigidos:</strong> ' + data.total_imoveis + '</p>' +
                '<p><strong>Total de fotos reordenadas:</strong> ' + data.total_fotos + '</p>' +
                '<p><strong>Tempo de execução:</strong> ' + data.tempo + ' segundos</p>' +
                '</div>';
        } else {
            resultado.innerHTML = '<div style=\"background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; border: 1px solid #f5c6cb;\">' +
                '<h3>❌ Erro na Correção</h3>' +
                '<p>' + data.error + '</p>' +
                '</div>';
        }
        
        // Reabilitar botão
        btn.disabled = false;
        btn.innerHTML = '🚀 EXECUTAR CORREÇÃO GLOBAL';
    })
    .catch(error => {
        resultado.innerHTML = '<div style=\"background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; border: 1px solid #f5c6cb;\">' +
            '<h3>❌ Erro na Requisição</h3>' +
            '<p>' + error.message + '</p>' +
            '</div>';
        
        // Reabilitar botão
        btn.disabled = false;
        btn.innerHTML = '🚀 EXECUTAR CORREÇÃO GLOBAL';
    });
}
</script>";

echo "<br><br>";
echo "<h3>📝 Como funciona:</h3>";
echo "<ol>";
echo "<li>Este script identifica TODOS os imóveis que possuem fotos</li>";
echo "<li>Para cada imóvel, reordena as fotos sequencialmente de 1 a N</li>";
echo "<li>A correção é aplicada automaticamente sem intervenção manual</li>";
echo "<li>Após a correção, TODOS os imóveis terão fotos numeradas corretamente</li>";
echo "</ol>";

echo "<h3>⚠️ Importante:</h3>";
echo "<ul>";
echo "<li>Faça backup do banco antes de executar</li>";
echo "<li>A correção é irreversível</li>";
echo "<li>Execute apenas uma vez</li>";
echo "<li>Após a correção, o sistema funcionará automaticamente para novos imóveis</li>";
echo "</ul>";

echo "<h3>🔮 Solução Futura:</h3>";
echo "<p>Após executar este script, o sistema funcionará automaticamente para:</p>";
echo "<ul>";
echo "<li>✅ Novos imóveis cadastrados</li>";
echo "<li>✅ Exclusão de fotos em qualquer imóvel</li>";
echo "<li>✅ Reordenação via drag & drop</li>";
echo "<li>✅ Qualquer operação que afete a ordem das fotos</li>";
echo "</ul>";
?>
