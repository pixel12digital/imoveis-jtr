<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teste Preview de Imagens</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="admin/assets/css/admin.css" rel="stylesheet">
    <style>
        body { padding: 20px; background: #f5f5f5; }
        .test-container { max-width: 800px; margin: 0 auto; background: white; padding: 30px; border-radius: 15px; box-shadow: 0 4px 20px rgba(0,0,0,0.1); }
        .test-section { margin: 30px 0; padding: 20px; border: 1px solid #e0e0e0; border-radius: 10px; }
        .test-title { color: #1D4C34; font-weight: bold; margin-bottom: 15px; }
        .status { padding: 10px; border-radius: 5px; margin: 10px 0; }
        .status.success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .status.error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .status.info { background: #d1ecf1; color: #0c5460; border: 1px solid #bee5eb; }
    </style>
</head>
<body>
    <div class="test-container">
        <h1 class="text-center mb-4">
            <i class="fas fa-images text-primary"></i>
            Teste de Preview de Imagens
        </h1>
        
        <div class="test-section">
            <h3 class="test-title">🔍 Verificação do Sistema</h3>
            <div id="system-status"></div>
        </div>
        
        <div class="test-section">
            <h3 class="test-title">📸 Teste de Upload</h3>
            <p>Teste o upload de imagens para verificar se as miniaturas estão sendo exibidas corretamente.</p>
            
            <div class="drop-zone border-2 border-dashed border-secondary rounded p-4 text-center">
                <i class="fas fa-cloud-upload-alt fa-3x text-secondary mb-3"></i>
                <h5>Arraste e solte as fotos aqui</h5>
                <p class="text-muted">ou clique para selecionar</p>
                <input type="file" class="file-upload" name="fotos[]" multiple accept="image/*" style="display: none;">
                <button type="button" class="btn btn-primary" onclick="document.querySelector('.file-upload').click()">
                    <i class="fas fa-folder-open me-2"></i>Selecionar Fotos
                </button>
            </div>
            
            <div class="file-preview mt-3"></div>
            
            <small class="text-muted">
                <i class="fas fa-info-circle me-1"></i>
                Formatos aceitos: JPG, PNG, GIF, WebP. Máximo 5MB por foto.
            </small>
        </div>
        
        <div class="test-section">
            <h3 class="test-title">📋 Instruções de Teste</h3>
            <ol>
                <li><strong>Seleção de arquivos:</strong> Clique em "Selecionar Fotos" ou arraste arquivos para a zona</li>
                <li><strong>Validação:</strong> Verifique se apenas imagens são aceitas</li>
                <li><strong>Preview:</strong> Confirme se as miniaturas aparecem com informações</li>
                <li><strong>Remoção:</strong> Teste o botão X para remover arquivos</li>
                <li><strong>Drag & Drop:</strong> Teste arrastar arquivos para a zona</li>
            </ol>
        </div>
        
        <div class="test-section">
            <h3 class="test-title">✅ Funcionalidades Esperadas</h3>
            <ul>
                <li>✅ Preview de miniaturas para cada imagem</li>
                <li>✅ Informações do arquivo (nome e tamanho)</li>
                <li>✅ Botão de remoção individual</li>
                <li>✅ Validação de tipo e tamanho</li>
                <li>✅ Suporte a múltiplos arquivos</li>
                <li>✅ Drag & drop funcional</li>
                <li>✅ Notificações de sucesso/erro</li>
            </ul>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Admin JS -->
    <script src="admin/assets/js/admin.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DEBUG: Página de teste carregada');
            
            // Verificar se as funções estão disponíveis
            const systemStatus = document.getElementById('system-status');
            let statusHtml = '';
            
            // Verificar função isValidFileType
            if (typeof isValidFileType === 'function') {
                statusHtml += '<div class="status success">✅ Função isValidFileType disponível</div>';
            } else {
                statusHtml += '<div class="status error">❌ Função isValidFileType NÃO disponível</div>';
            }
            
            // Verificar função handleFileUpload
            if (typeof handleFileUpload === 'function') {
                statusHtml += '<div class="status success">✅ Função handleFileUpload disponível</div>';
            } else {
                statusHtml += '<div class="status error">❌ Função handleFileUpload NÃO disponível</div>';
            }
            
            // Verificar função removeFile
            if (typeof removeFile === 'function') {
                statusHtml += '<div class="status success">✅ Função removeFile disponível</div>';
            } else {
                statusHtml += '<div class="status error">❌ Função removeFile NÃO disponível</div>';
            }
            
            // Verificar função showNotification
            if (typeof showNotification === 'function') {
                statusHtml += '<div class="status success">✅ Função showNotification disponível</div>';
            } else {
                statusHtml += '<div class="status error">❌ Função showNotification NÃO disponível</div>';
            }
            
            // Verificar se o setupFileUploads foi chamado
            if (typeof setupFileUploads === 'function') {
                statusHtml += '<div class="status info">ℹ️ Função setupFileUploads disponível - será chamada automaticamente</div>';
            } else {
                statusHtml += '<div class="status error">❌ Função setupFileUploads NÃO disponível</div>';
            }
            
            systemStatus.innerHTML = statusHtml;
            
            // Configurar uploads automaticamente
            if (typeof setupFileUploads === 'function') {
                setupFileUploads();
                console.log('DEBUG: setupFileUploads executado');
            }
            
            // Configurar notificações
            if (typeof setupNotifications === 'function') {
                setupNotifications();
                console.log('DEBUG: setupNotifications executado');
            }
            
            // Testar com arquivo simulado
            console.log('DEBUG: Testando com arquivo simulado...');
            const testFile = new File([''], 'test.jpg', { type: 'image/jpeg' });
            if (typeof isValidFileType === 'function') {
                const result = isValidFileType(testFile);
                console.log('DEBUG: Teste isValidFileType:', result);
            }
        });
    </script>
</body>
</html>
