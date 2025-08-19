<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teste Preview - Adicionar Imóvel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="admin/assets/css/admin.css" rel="stylesheet">
    <style>
        body { padding: 20px; background: #f5f5f5; }
        .test-container { max-width: 800px; margin: 0 auto; background: white; padding: 30px; border-radius: 15px; box-shadow: 0 4px 20px rgba(0,0,0,0.1); }
        .debug-section { background: #f8f9fa; padding: 15px; border-radius: 8px; margin: 20px 0; font-family: monospace; font-size: 12px; max-height: 300px; overflow-y: auto; }
    </style>
</head>
<body>
    <div class="test-container">
        <h1 class="text-center mb-4">
            <i class="fas fa-home text-primary"></i>
            Teste Preview - Adicionar Imóvel
        </h1>
        
        <div class="alert alert-info">
            <i class="fas fa-info-circle me-2"></i>
            Esta página simula exatamente a estrutura da página de adicionar imóvel para testar o preview de imagens.
        </div>
        
        <!-- Simulação da seção de fotos -->
        <div class="row mb-4">
            <div class="col-12">
                <h6 class="text-primary mb-3">
                    <i class="fas fa-images me-2"></i>Fotos do Imóvel
                </h6>
            </div>
            
            <div class="col-12">
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
        </div>
        
        <!-- Debug Console -->
        <div class="debug-section">
            <h6>🔍 Debug Console:</h6>
            <div id="debug-output">
                Aguardando...
            </div>
        </div>
        
        <!-- Status do Sistema -->
        <div class="debug-section">
            <h6>📊 Status do Sistema:</h6>
            <div id="system-status">
                Verificando...
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Admin JS -->
    <script src="admin/assets/js/admin.js"></script>
    
    <script>
        function log(message) {
            const debug = document.getElementById('debug-output');
            const time = new Date().toLocaleTimeString();
            debug.innerHTML += `<div>[${time}] ${message}</div>`;
            debug.scrollTop = debug.scrollHeight;
            console.log(message);
        }

        function updateStatus(message, type = 'info') {
            const status = document.getElementById('system-status');
            const time = new Date().toLocaleTimeString();
            status.innerHTML += `<div class="text-${type}">[${time}] ${message}</div>`;
        }

        document.addEventListener('DOMContentLoaded', function() {
            log('Página carregada');
            
            // Verificar se as funções estão disponíveis
            updateStatus('Verificando funções JavaScript...');
            
            if (typeof setupFileUploads === 'function') {
                updateStatus('✅ setupFileUploads disponível', 'success');
            } else {
                updateStatus('❌ setupFileUploads NÃO disponível', 'danger');
            }
            
            if (typeof handleFileUpload === 'function') {
                updateStatus('✅ handleFileUpload disponível', 'success');
            } else {
                updateStatus('❌ handleFileUpload NÃO disponível', 'danger');
            }
            
            if (typeof isValidFileType === 'function') {
                updateStatus('✅ isValidFileType disponível', 'success');
            } else {
                updateStatus('❌ isValidFileType NÃO disponível', 'danger');
            
            if (typeof showNotification === 'function') {
                updateStatus('✅ showNotification disponível', 'success');
            } else {
                updateStatus('❌ showNotification NÃO disponível', 'danger');
            }
            
            // Verificar elementos HTML
            updateStatus('Verificando elementos HTML...');
            
            const fileInput = document.querySelector('.file-upload');
            const preview = document.querySelector('.file-preview');
            const dropZone = document.querySelector('.drop-zone');
            
            if (fileInput) {
                updateStatus('✅ Input file encontrado', 'success');
                log(`Input file: ${fileInput.name}, multiple: ${fileInput.multiple}, accept: ${fileInput.accept}`);
            } else {
                updateStatus('❌ Input file NÃO encontrado', 'danger');
            }
            
            if (preview) {
                updateStatus('✅ Div preview encontrada', 'success');
                log(`Preview div: ${preview.className}`);
            } else {
                updateStatus('❌ Div preview NÃO encontrada', 'danger');
            }
            
            if (dropZone) {
                updateStatus('✅ Drop zone encontrada', 'success');
                log(`Drop zone: ${dropZone.className}`);
            } else {
                updateStatus('❌ Drop zone NÃO encontrada', 'danger');
            }
            
            // Configurar manualmente se necessário
            if (typeof setupFileUploads === 'function') {
                updateStatus('Executando setupFileUploads...');
                setupFileUploads();
                updateStatus('✅ setupFileUploads executado', 'success');
            }
            
            if (typeof setupNotifications === 'function') {
                updateStatus('Executando setupNotifications...');
                setupNotifications();
                updateStatus('✅ setupNotifications executado', 'success');
            }
            
            // Teste manual de upload
            log('Configurando teste manual...');
            
            const manualInput = document.querySelector('.file-upload');
            if (manualInput) {
                manualInput.addEventListener('change', function(e) {
                    log('Evento change disparado manualmente');
                    log(`Arquivos: ${e.target.files.length}`);
                    
                    // Chamar handleFileUpload manualmente se disponível
                    if (typeof handleFileUpload === 'function') {
                        log('Chamando handleFileUpload manualmente');
                        handleFileUpload(e);
                    } else {
                        log('handleFileUpload não disponível, processando manualmente');
                        
                        const files = e.target.files;
                        const preview = document.querySelector('.file-preview');
                        
                        if (files.length > 0 && preview) {
                            preview.innerHTML = '';
                            
                            Array.from(files).forEach((file, index) => {
                                log(`Processando arquivo ${index + 1}: ${file.name}`);
                                
                                if (file.type.startsWith('image/')) {
                                    const reader = new FileReader();
                                    reader.onload = function(e) {
                                        const previewItem = document.createElement('div');
                                        previewItem.className = 'preview-item d-inline-block me-3 mb-3';
                                        previewItem.style.cssText = 'position: relative;';
                                        
                                        previewItem.innerHTML = `
                                            <img src="${e.target.result}" class="img-thumbnail" style="max-width: 150px; max-height: 150px; object-fit: cover;">
                                            <div class="preview-info mt-2 text-center">
                                                <small class="text-muted d-block">${file.name}</small>
                                                <small class="text-muted d-block">${(file.size / 1024).toFixed(1)} KB</small>
                                            </div>
                                        `;
                                        
                                        preview.appendChild(previewItem);
                                        log(`Preview criado para ${file.name}`);
                                    };
                                    
                                    reader.readAsDataURL(file);
                                }
                            });
                        }
                    }
                });
                
                log('Event listener manual configurado');
            }
            
            updateStatus('✅ Sistema configurado e pronto para teste', 'success');
        });
    </script>
</body>
</html>
