<?php
// Script para executar a correção global de todos os imóveis
header('Content-Type: application/json');

require_once 'config/database.php';

try {
    // Verificar se é uma requisição POST
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Método não permitido');
    }
    
    // Ler dados JSON
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (!isset($input['acao']) || $input['acao'] !== 'corrigir_todos') {
        throw new Exception('Ação inválida');
    }
    
    // Iniciar cronômetro
    $inicio = microtime(true);
    
    // Função global de renumeração
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
    
    // 1. Buscar todos os imóveis que possuem fotos
    $stmt = $pdo->query("
        SELECT DISTINCT i.id, i.titulo, COUNT(f.id) as total_fotos
        FROM imoveis i 
        INNER JOIN fotos_imovel f ON i.id = f.imovel_id 
        GROUP BY i.id, i.titulo 
        ORDER BY i.id
    ");
    $imoveis = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (empty($imoveis)) {
        throw new Exception('Nenhum imóvel com fotos encontrado');
    }
    
    // 2. Executar correção para cada imóvel
    $total_imoveis = 0;
    $total_fotos = 0;
    
    foreach ($imoveis as $imovel) {
        $fotos_corrigidas = renumerarFotosAutomaticamente($imovel['id']);
        $total_imoveis++;
        $total_fotos += $fotos_corrigidas;
        
        // Log para auditoria
        error_log("CORREÇÃO GLOBAL: Imóvel ID {$imovel['id']} - {$imovel['titulo']} - {$fotos_corrigidas} fotos corrigidas");
    }
    
    // 3. Calcular tempo de execução
    $fim = microtime(true);
    $tempo_execucao = round($fim - $inicio, 2);
    
    // 4. Retornar resultado
    echo json_encode([
        'success' => true,
        'total_imoveis' => $total_imoveis,
        'total_fotos' => $total_fotos,
        'tempo' => $tempo_execucao,
        'mensagem' => "Correção global concluída com sucesso! {$total_imoveis} imóveis corrigidos, {$total_fotos} fotos reordenadas."
    ]);
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
?>
