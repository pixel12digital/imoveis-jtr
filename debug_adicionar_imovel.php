<?php
// Debug específico para a página de adicionar imóvel
require_once 'config/config.php';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Debug - Adicionar Imóvel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h1>Debug - Página de Adicionar Imóvel</h1>
        
        <div class="row">
            <div class="col-md-6">
                <h3>Teste de Upload Simples</h3>
                <form method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="test_file" class="form-label">Selecione um arquivo WebP:</label>
                        <input type="file" class="form-control" name="test_file" accept="image/*" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Testar Upload</button>
                </form>
                
                <?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['test_file'])): ?>
                    <div class="mt-3">
                        <h4>Resultado do Upload:</h4>
                        <?php
                        $file = $_FILES['test_file'];
                        echo "<p><strong>Nome:</strong> " . htmlspecialchars($file['name']) . "</p>";
                        echo "<p><strong>Tamanho:</strong> " . number_format($file['size'] / 1024, 2) . " KB</p>";
                        echo "<p><strong>Tipo MIME:</strong> " . htmlspecialchars($file['type']) . "</p>";
                        echo "<p><strong>Extensão:</strong> " . strtolower(pathinfo($file['name'], PATHINFO_EXTENSION)) . "</p>";
                        echo "<p><strong>Erro:</strong> " . $file['error'] . "</p>";
                        
                        if ($file['error'] === UPLOAD_ERR_OK) {
                            $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
                            $allowed_extensions = getAllowedExtensions();
                            
                            echo "<p><strong>Extensão permitida?</strong> " . (in_array($ext, $allowed_extensions) ? '✅ SIM' : '❌ NÃO') . "</p>";
                            echo "<p><strong>Tamanho válido?</strong> " . ($file['size'] <= MAX_FILE_SIZE ? '✅ SIM' : '❌ NÃO') . "</p>";
                            
                            if (in_array($ext, $allowed_extensions) && $file['size'] <= MAX_FILE_SIZE) {
                                echo "<p style='color: green;'><strong>✅ Arquivo válido para upload!</strong></p>";
                            } else {
                                echo "<p style='color: red;'><strong>❌ Arquivo rejeitado</strong></p>";
                            }
                        }
                        ?>
                    </div>
                <?php endif; ?>
            </div>
            
            <div class="col-md-6">
                <h3>Teste de Validação JavaScript</h3>
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
                
                <div class="mt-3">
                    <h5>Console JavaScript:</h5>
                    <div id="console-output" style="background: #f8f9fa; padding: 10px; border-radius: 5px; font-family: monospace; font-size: 12px; max-height: 200px; overflow-y: auto;"></div>
                </div>
            </div>
        </div>
        
        <div class="row mt-4">
            <div class="col-12">
                <h3>Configurações do Sistema</h3>
                <div class="row">
                    <div class="col-md-6">
                        <h5>PHP:</h5>
                        <ul>
                            <li><strong>Extensões permitidas:</strong> <?php echo implode(', ', getAllowedExtensions()); ?></li>
                            <li><strong>Tamanho máximo:</strong> <?php echo (MAX_FILE_SIZE / (1024 * 1024)); ?>MB</li>
                            <li><strong>upload_max_filesize:</strong> <?php echo ini_get('upload_max_filesize'); ?></li>
                            <li><strong>post_max_size:</strong> <?php echo ini_get('post_max_size'); ?></li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h5>Suporte a WebP:</h5>
                        <ul>
                            <li><strong>imagewebp():</strong> <?php echo function_exists('imagewebp') ? '✅ Disponível' : '❌ Não disponível'; ?></li>
                            <li><strong>Extensão GD:</strong> <?php echo extension_loaded('gd') ? '✅ Carregada' : '❌ Não carregada'; ?></li>
                            <?php if (extension_loaded('gd')): ?>
                                <?php $gd_info = gd_info(); ?>
                                <li><strong>WebP Support:</strong> <?php echo isset($gd_info['WebP Support']) && $gd_info['WebP Support'] ? '✅ Sim' : '❌ Não'; ?></li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="admin/assets/js/admin.js"></script>
    
    <script>
        // Função para log no console visual
        function logToConsole(message, type = 'info') {
            const console = document.getElementById('console-output');
            const timestamp = new Date().toLocaleTimeString();
            const color = type === 'error' ? 'red' : type === 'success' ? 'green' : 'blue';
            
            console.innerHTML += `<div style="color: ${color}; margin-bottom: 5px;">[${timestamp}] ${message}</div>`;
            console.scrollTop = console.scrollHeight;
        }
        
        // Sobrescrever console.log para capturar mensagens
        const originalLog = console.log;
        const originalError = console.error;
        
        console.log = function(...args) {
            originalLog.apply(console, args);
            logToConsole(args.join(' '), 'info');
        };
        
        console.error = function(...args) {
            originalError.apply(console, args);
            logToConsole(args.join(' '), 'error');
        };
        
        // Testar validação de arquivo
        document.addEventListener('DOMContentLoaded', function() {
            logToConsole('Página carregada, testando validação...');
            
            // Testar função isValidFileType
            if (typeof isValidFileType === 'function') {
                logToConsole('✅ Função isValidFileType encontrada');
                
                // Criar arquivo de teste WebP
                const testFile = new File([''], 'test.webp', { type: 'image/webp' });
                const result = isValidFileType(testFile);
                logToConsole(`Teste WebP: ${result ? '✅ Aceito' : '❌ Rejeitado'}`);
                
                // Testar outros tipos
                const testJpg = new File([''], 'test.jpg', { type: 'image/jpeg' });
                const resultJpg = isValidFileType(testJpg);
                logToConsole(`Teste JPG: ${resultJpg ? '✅ Aceito' : '❌ Rejeitado'}`);
                
            } else {
                logToConsole('❌ Função isValidFileType não encontrada');
            }
            
            // Verificar se o admin.js foi carregado
            if (typeof AdminPanel !== 'undefined') {
                logToConsole('✅ AdminPanel carregado');
            } else {
                logToConsole('❌ AdminPanel não encontrado');
            }
        });
    </script>
</body>
</html>
