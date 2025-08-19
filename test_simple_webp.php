<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teste Simples WebP</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .drop-zone { border: 2px dashed #ccc; padding: 20px; text-align: center; margin: 20px 0; }
        .file-preview { margin: 20px 0; }
        .console { background: #f0f0f0; padding: 10px; border-radius: 5px; font-family: monospace; max-height: 300px; overflow-y: auto; }
    </style>
</head>
<body>
    <h1>Teste Simples de Upload WebP</h1>
    
    <div class="drop-zone">
        <h3>Arraste e solte as fotos aqui</h3>
        <p>ou clique para selecionar</p>
        <input type="file" id="fileInput" multiple accept="image/*" style="display: none;">
        <button onclick="document.getElementById('fileInput').click()">Selecionar Fotos</button>
    </div>
    
    <div class="file-preview" id="filePreview"></div>
    
    <div class="console" id="console"></div>
    
    <script>
        function log(message) {
            const console = document.getElementById('console');
            const timestamp = new Date().toLocaleTimeString();
            console.innerHTML += `[${timestamp}] ${message}<br>`;
            console.scrollTop = console.scrollHeight;
        }
        
        function isValidFileType(file) {
            // Verificar MIME type
            const allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            if (allowedMimeTypes.includes(file.type)) {
                return true;
            }
            
            // Verificar extensão como fallback
            const allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            const fileName = file.name.toLowerCase();
            const extension = fileName.split('.').pop();
            
            return allowedExtensions.includes(extension);
        }
        
        document.getElementById('fileInput').addEventListener('change', function(e) {
            const files = e.target.files;
            const preview = document.getElementById('filePreview');
            
            log(`Arquivos selecionados: ${files.length}`);
            
            if (files.length > 0) {
                preview.innerHTML = '';
                
                for (let i = 0; i < files.length; i++) {
                    const file = files[i];
                    
                    log(`Arquivo ${i + 1}: ${file.name} (${file.type})`);
                    
                    // Validar tipo de arquivo
                    if (!isValidFileType(file)) {
                        log(`❌ Tipo de arquivo não suportado: ${file.name}`);
                        continue;
                    }
                    
                    // Validar tamanho
                    if (file.size > 5 * 1024 * 1024) { // 5MB
                        log(`❌ Arquivo muito grande: ${file.name}`);
                        continue;
                    }
                    
                    log(`✅ Arquivo válido: ${file.name}`);
                    
                    // Mostrar preview
                    if (file.type.startsWith('image/')) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const img = document.createElement('img');
                            img.src = e.target.result;
                            img.style.maxWidth = '200px';
                            img.style.maxHeight = '200px';
                            img.style.margin = '10px';
                            img.style.border = '1px solid #ccc';
                            preview.appendChild(img);
                        };
                        reader.readAsDataURL(file);
                    }
                }
            }
        });
        
        // Teste inicial
        log('Página carregada');
        log('Função isValidFileType disponível: ' + (typeof isValidFileType === 'function'));
        
        // Teste com arquivo simulado
        const testFile = new File([''], 'test.webp', { type: 'image/webp' });
        const result = isValidFileType(testFile);
        log(`Teste WebP simulado: ${result ? '✅ Aceito' : '❌ Rejeitado'}`);
    </script>
</body>
</html>
