<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teste Preview Simples</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body { padding: 20px; background: #f5f5f5; }
        .test-container { max-width: 600px; margin: 0 auto; background: white; padding: 30px; border-radius: 15px; box-shadow: 0 4px 20px rgba(0,0,0,0.1); }
        .preview-item { display: inline-block; margin: 10px; text-align: center; }
        .preview-item img { max-width: 150px; max-height: 150px; border-radius: 8px; border: 2px solid #ddd; }
        .preview-info { margin-top: 5px; font-size: 12px; color: #666; }
    </style>
</head>
<body>
    <div class="test-container">
        <h1 class="text-center mb-4">
            <i class="fas fa-images text-primary"></i>
            Teste Preview Simples
        </h1>
        
        <div class="mb-4">
            <h5>📸 Upload de Imagens</h5>
            <input type="file" id="fileInput" multiple accept="image/*" class="form-control">
            <small class="text-muted">Selecione uma ou mais imagens para testar</small>
        </div>
        
        <div id="preview" class="border rounded p-3" style="min-height: 100px;">
            <p class="text-muted text-center">As miniaturas aparecerão aqui...</p>
        </div>
        
        <div class="mt-4">
            <h6>🔍 Debug Console:</h6>
            <div id="debug" class="bg-light p-3 rounded" style="font-family: monospace; font-size: 12px; max-height: 200px; overflow-y: auto;">
                Aguardando arquivos...
            </div>
        </div>
    </div>

    <script>
        function log(message) {
            const debug = document.getElementById('debug');
            const time = new Date().toLocaleTimeString();
            debug.innerHTML += `<div>[${time}] ${message}</div>`;
            debug.scrollTop = debug.scrollHeight;
            console.log(message);
        }

        document.addEventListener('DOMContentLoaded', function() {
            log('Página carregada');
            
            const fileInput = document.getElementById('fileInput');
            const preview = document.getElementById('preview');
            
            log('Elementos encontrados:');
            log(`- File input: ${fileInput ? 'SIM' : 'NÃO'}`);
            log(`- Preview: ${preview ? 'SIM' : 'NÃO'}`);
            
            fileInput.addEventListener('change', function(e) {
                log('Evento change disparado');
                log(`Arquivos selecionados: ${e.target.files.length}`);
                
                const files = e.target.files;
                
                if (files.length > 0) {
                    // Limpar preview
                    preview.innerHTML = '';
                    
                    Array.from(files).forEach((file, index) => {
                        log(`Processando arquivo ${index + 1}: ${file.name} (${file.type}, ${file.size} bytes)`);
                        
                        if (file.type.startsWith('image/')) {
                            log(`Arquivo ${file.name} é uma imagem válida`);
                            
                            const reader = new FileReader();
                            
                            reader.onload = function(e) {
                                log(`FileReader carregado para ${file.name}`);
                                
                                const previewItem = document.createElement('div');
                                previewItem.className = 'preview-item';
                                
                                previewItem.innerHTML = `
                                    <img src="${e.target.result}" alt="${file.name}">
                                    <div class="preview-info">
                                        <div>${file.name}</div>
                                        <div>${(file.size / 1024).toFixed(1)} KB</div>
                                    </div>
                                `;
                                
                                preview.appendChild(previewItem);
                                log(`Preview criado para ${file.name}`);
                            };
                            
                            reader.onerror = function() {
                                log(`ERRO no FileReader para ${file.name}`);
                            };
                            
                            reader.readAsDataURL(file);
                        } else {
                            log(`Arquivo ${file.name} NÃO é uma imagem (${file.type})`);
                        }
                    });
                } else {
                    preview.innerHTML = '<p class="text-muted text-center">Nenhum arquivo selecionado</p>';
                }
            });
            
            log('Event listener configurado');
        });
    </script>
</body>
</html>
