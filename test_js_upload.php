<?php
// Teste de upload com JavaScript
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teste JavaScript Upload - JTR Imóveis</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h1>Teste JavaScript Upload - JTR Imóveis</h1>
        
        <div class="row">
            <div class="col-md-6">
                <h3>Formulário com JavaScript</h3>
                <form id="uploadForm" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="fotos" class="form-label">Selecionar Fotos</label>
                        <div class="drop-zone border-2 border-dashed border-secondary rounded p-4 text-center" id="dropZone">
                            <i class="fas fa-cloud-upload-alt fa-3x text-secondary mb-3"></i>
                            <h5>Arraste e solte as fotos aqui</h5>
                            <p class="text-muted">ou clique para selecionar</p>
                            <input type="file" class="file-upload" name="fotos[]" multiple accept="image/*" style="display: none;" id="fileInput">
                            <button type="button" class="btn btn-primary" onclick="document.getElementById('fileInput').click()">
                                <i class="fas fa-folder-open me-2"></i>Selecionar Fotos
                            </button>
                        </div>
                        <div class="file-preview mt-3" id="filePreview"></div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="titulo" class="form-label">Título</label>
                        <input type="text" class="form-control" id="titulo" name="titulo" value="Teste JS" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="descricao" class="form-label">Descrição</label>
                        <textarea class="form-control" id="descricao" name="descricao" rows="3" required>Descrição de teste</textarea>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Enviar Formulário</button>
                </form>
            </div>
            
            <div class="col-md-6">
                <h3>Debug JavaScript</h3>
                <div id="debugInfo" class="border p-3 bg-light">
                    <p><strong>Status:</strong> <span id="status">Aguardando...</span></p>
                    <p><strong>Arquivos selecionados:</strong> <span id="fileCount">0</span></p>
                    <p><strong>Último evento:</strong> <span id="lastEvent">Nenhum</span></p>
                </div>
                
                <h4 class="mt-3">Log de Eventos</h4>
                <div id="eventLog" class="border p-3 bg-light" style="max-height: 300px; overflow-y: auto;">
                    <p class="text-muted">Nenhum evento registrado</p>
                </div>
            </div>
        </div>
        
        <div class="row mt-4">
            <div class="col-12">
                <h3>Resultado do Upload</h3>
                <div id="uploadResult"></div>
            </div>
        </div>
    </div>

    <script>
        // Função para log de eventos
        function logEvent(event, details = '') {
            const eventLog = document.getElementById('eventLog');
            const timestamp = new Date().toLocaleTimeString();
            const logEntry = document.createElement('p');
            logEntry.innerHTML = `<strong>${timestamp}</strong> - ${event} ${details}`;
            
            if (eventLog.children.length > 20) {
                eventLog.removeChild(eventLog.firstChild);
            }
            
            eventLog.appendChild(logEntry);
            eventLog.scrollTop = eventLog.scrollHeight;
            
            document.getElementById('lastEvent').textContent = event;
        }
        
        // Função para atualizar status
        function updateStatus(status) {
            document.getElementById('status').textContent = status;
        }
        
        // Função para atualizar contagem de arquivos
        function updateFileCount(count) {
            document.getElementById('fileCount').textContent = count;
        }
        
        // Configurar drop zone
        const dropZone = document.getElementById('dropZone');
        const fileInput = document.getElementById('fileInput');
        const filePreview = document.getElementById('filePreview');
        
        // Event listeners para drag and drop
        dropZone.addEventListener('dragover', function(e) {
            e.preventDefault();
            e.stopPropagation();
            this.classList.add('border-primary');
            logEvent('Drag Over');
        });
        
        dropZone.addEventListener('dragleave', function(e) {
            e.preventDefault();
            e.stopPropagation();
            this.classList.remove('border-primary');
            logEvent('Drag Leave');
        });
        
        dropZone.addEventListener('drop', function(e) {
            e.preventDefault();
            e.stopPropagation();
            this.classList.remove('border-primary');
            
            const files = e.dataTransfer.files;
            logEvent('Drop', `${files.length} arquivo(s)`);
            
            if (files.length > 0) {
                fileInput.files = files;
                handleFiles(files);
            }
        });
        
        // Event listener para seleção de arquivos
        fileInput.addEventListener('change', function(e) {
            const files = e.target.files;
            logEvent('File Input Change', `${files.length} arquivo(s)`);
            handleFiles(files);
        });
        
        // Função para manipular arquivos selecionados
        function handleFiles(files) {
            updateFileCount(files.length);
            updateStatus(`Processando ${files.length} arquivo(s)...`);
            
            // Limpar preview anterior
            filePreview.innerHTML = '';
            
            Array.from(files).forEach((file, index) => {
                logEvent('Processando arquivo', `${index + 1}: ${file.name} (${(file.size / 1024 / 1024).toFixed(2)} MB)`);
                
                // Validar tipo
                if (!file.type.startsWith('image/')) {
                    logEvent('ERRO', `Arquivo ${file.name} não é uma imagem`);
                    return;
                }
                
                // Validar tamanho (5MB)
                if (file.size > 5 * 1024 * 1024) {
                    logEvent('ERRO', `Arquivo ${file.name} muito grande: ${(file.size / 1024 / 1024).toFixed(2)} MB`);
                    return;
                }
                
                // Criar preview
                const reader = new FileReader();
                reader.onload = function(e) {
                    const previewDiv = document.createElement('div');
                    previewDiv.className = 'mb-2';
                    previewDiv.innerHTML = `
                        <img src="${e.target.result}" class="img-thumbnail" style="max-width: 150px; max-height: 150px;">
                        <div class="mt-1">
                            <small class="text-muted">${file.name}</small><br>
                            <small class="text-muted">${(file.size / 1024 / 1024).toFixed(2)} MB</small>
                        </div>
                    `;
                    filePreview.appendChild(previewDiv);
                };
                reader.readAsDataURL(file);
                
                logEvent('Arquivo válido', `${file.name}`);
            });
            
            updateStatus(`${files.length} arquivo(s) processado(s)`);
        }
        
        // Event listener para envio do formulário
        document.getElementById('uploadForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const files = fileInput.files;
            
            if (files.length === 0) {
                logEvent('ERRO', 'Nenhum arquivo selecionado');
                updateStatus('Erro: Nenhum arquivo selecionado');
                return;
            }
            
            logEvent('Enviando formulário', `${files.length} arquivo(s)`);
            updateStatus('Enviando...');
            
            // Simular envio (em produção, seria um fetch real)
            setTimeout(() => {
                logEvent('Formulário enviado', 'Simulado');
                updateStatus('Formulário enviado (simulado)');
                
                // Mostrar resultado
                const resultDiv = document.getElementById('uploadResult');
                resultDiv.innerHTML = `
                    <div class="alert alert-success">
                        <h4>Formulário enviado com sucesso!</h4>
                        <p><strong>Arquivos:</strong> ${files.length}</p>
                        <p><strong>Título:</strong> ${document.getElementById('titulo').value}</p>
                        <p><strong>Descrição:</strong> ${document.getElementById('descricao').value}</p>
                        <hr>
                        <p><strong>Nota:</strong> Este é um teste simulado. Em produção, os arquivos seriam enviados para o servidor.</p>
                    </div>
                `;
            }, 2000);
        });
        
        // Inicialização
        document.addEventListener('DOMContentLoaded', function() {
            logEvent('Página carregada');
            updateStatus('Pronto');
        });
    </script>
</body>
</html>
