<?php
// Iniciar output buffering para evitar problemas com headers
ob_start();

// Carregar configurações ANTES de iniciar a sessão
require_once '../../config/paths.php';
require_once '../../config/database.php';
require_once '../../config/config.php';

// Agora iniciar a sessão
session_start();

// Verificar se o usuário está logado
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: ../login.php');
    exit;
}

$success_message = '';
$error_message = '';

// Buscar dados para os selects
$tipos_imovel = fetchAll("SELECT * FROM tipos_imovel ORDER BY nome");
$localizacoes = fetchAll("SELECT * FROM localizacoes ORDER BY cidade, bairro");
$usuarios = fetchAll("SELECT * FROM usuarios WHERE ativo = 1 ORDER BY nome");
$caracteristicas = fetchAll("SELECT * FROM caracteristicas ORDER BY nome");

// Processar formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Validar dados obrigatórios
        $titulo = cleanInput($_POST['titulo']);
        $descricao = cleanInput($_POST['descricao']);
        $preco = (float)$_POST['preco'];
        $tipo_id = (int)$_POST['tipo_id'];
        $localizacao_id = (int)$_POST['localizacao_id'];
        
        if (empty($titulo) || empty($descricao) || $preco <= 0 || $tipo_id <= 0 || $localizacao_id <= 0) {
            throw new Exception('Todos os campos obrigatórios devem ser preenchidos.');
        }
        
        // Preparar dados do imóvel
        $dados_imovel = [
            'titulo' => $titulo,
            'descricao' => $descricao,
            'preco' => $preco,
            'tipo_id' => $tipo_id,
            'localizacao_id' => $localizacao_id,
            'usuario_id' => $_SESSION['admin_id'],
            'status' => cleanInput($_POST['status']),
            'destaque' => isset($_POST['destaque']) ? 1 : 0,
            'area_total' => !empty($_POST['area_total']) ? (float)$_POST['area_total'] : null,
            'area_construida' => !empty($_POST['area_construida']) ? (float)$_POST['area_construida'] : null,
            'quartos' => !empty($_POST['quartos']) ? (int)$_POST['quartos'] : null,
            'banheiros' => !empty($_POST['banheiros']) ? (int)$_POST['banheiros'] : null,
            'vagas_garagem' => !empty($_POST['vagas_garagem']) ? (int)$_POST['vagas_garagem'] : null,
            'endereco' => cleanInput($_POST['endereco']),
            'cep' => cleanInput($_POST['cep']),
            'data_criacao' => date('Y-m-d H:i:s')
        ];
        
        // Inserir imóvel
        $imovel_id = insert("imoveis", $dados_imovel);
        
        if ($imovel_id) {
            // Inserir características selecionadas
            if (isset($_POST['caracteristicas']) && is_array($_POST['caracteristicas'])) {
                foreach ($_POST['caracteristicas'] as $caracteristica_id) {
                    insert("imovel_caracteristicas", [
                        'imovel_id' => $imovel_id,
                        'caracteristica_id' => (int)$caracteristica_id
                    ]);
                }
            }
            
            // Processar upload de fotos
            if (isset($_FILES['fotos']) && !empty($_FILES['fotos']['name'][0])) {
                $upload_dir = '../../uploads/imoveis/' . $imovel_id . '/';
                
                // Criar diretório se não existir
                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0755, true);
                }
                
                foreach ($_FILES['fotos']['tmp_name'] as $key => $tmp_name) {
                    if ($_FILES['fotos']['error'][$key] === UPLOAD_ERR_OK) {
                        $filename = $_FILES['fotos']['name'][$key];
                        $ext = pathinfo($filename, PATHINFO_EXTENSION);
                        $new_filename = uniqid() . '.' . $ext;
                        
                        if (move_uploaded_file($tmp_name, $upload_dir . $new_filename)) {
                            insert("fotos_imovel", [
                                'imovel_id' => $imovel_id,
                                'arquivo' => $new_filename,
                                'legenda' => cleanInput($_POST['legendas'][$key] ?? ''),
                                'ordem' => $key + 1
                            ]);
                        }
                    }
                }
            }
            
            $success_message = "Imóvel cadastrado com sucesso! ID: " . $imovel_id;
            
            // Limpar formulário
            $_POST = array();
        } else {
            throw new Exception('Erro ao inserir imóvel no banco de dados.');
        }
        
    } catch (Exception $e) {
        $error_message = "Erro ao cadastrar imóvel: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Imóvel - Painel Administrativo JTR Imóveis</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Admin CSS -->
    <link href="../assets/css/admin.css" rel="stylesheet">
    <!-- Dropzone CSS -->
    <link href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" rel="stylesheet">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="../index.php">
                <i class="fas fa-home me-2"></i>JTR Imóveis - Admin
            </a>
            
            <div class="navbar-nav ms-auto">
                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-user me-1"></i><?php echo htmlspecialchars($_SESSION['admin_nome']); ?>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="../perfil.php"><i class="fas fa-user-cog me-2"></i>Perfil</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="../logout.php"><i class="fas fa-sign-out-alt me-2"></i>Sair</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 d-md-block bg-light sidebar">
                <div class="position-sticky pt-3">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="../index.php">
                                <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="index.php">
                                <i class="fas fa-home me-2"></i>Imóveis
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../usuarios/">
                                <i class="fas fa-users me-2"></i>Usuários
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../contatos/">
                                <i class="fas fa-envelope me-2"></i>Contatos
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../configuracoes/">
                                <i class="fas fa-cog me-2"></i>Configurações
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../../" target="_blank">
                                <i class="fas fa-external-link-alt me-2"></i>Ver Site
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Conteúdo Principal -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">
                        <i class="fas fa-plus me-2"></i>Adicionar Novo Imóvel
                    </h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group me-2">
                            <a href="index.php" class="btn btn-sm btn-secondary">
                                <i class="fas fa-arrow-left me-1"></i>Voltar
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Mensagens -->
                <?php if ($success_message): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i><?php echo htmlspecialchars($success_message); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if ($error_message): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i><?php echo htmlspecialchars($error_message); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <!-- Formulário -->
                <div class="card shadow">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-home me-2"></i>Informações do Imóvel
                        </h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                            
                            <!-- Informações Básicas -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h6 class="text-primary mb-3">
                                        <i class="fas fa-info-circle me-2"></i>Informações Básicas
                                    </h6>
                                </div>
                                
                                <div class="col-md-8">
                                    <label for="titulo" class="form-label">Título *</label>
                                    <input type="text" class="form-control" id="titulo" name="titulo" 
                                           value="<?php echo htmlspecialchars($_POST['titulo'] ?? ''); ?>" required>
                                    <div class="invalid-feedback">Título é obrigatório</div>
                                </div>
                                
                                <div class="col-md-4">
                                    <label for="preco" class="form-label">Preço *</label>
                                    <div class="input-group">
                                        <span class="input-group-text">R$</span>
                                        <input type="number" class="form-control" id="preco" name="preco" 
                                               step="0.01" min="0" 
                                               value="<?php echo htmlspecialchars($_POST['preco'] ?? ''); ?>" required>
                                    </div>
                                    <div class="invalid-feedback">Preço é obrigatório</div>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="tipo_id" class="form-label">Tipo de Imóvel *</label>
                                    <select class="form-select" id="tipo_id" name="tipo_id" required>
                                        <option value="">Selecione...</option>
                                        <?php foreach ($tipos_imovel as $tipo): ?>
                                            <option value="<?php echo $tipo['id']; ?>" 
                                                    <?php echo (isset($_POST['tipo_id']) && $_POST['tipo_id'] == $tipo['id']) ? 'selected' : ''; ?>>
                                                <?php echo htmlspecialchars($tipo['nome']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="invalid-feedback">Tipo de imóvel é obrigatório</div>
                                </div>
                                
                                <div class="col-md-6">
                                    <label for="localizacao_id" class="form-label">Localização *</label>
                                    <select class="form-select" id="localizacao_id" name="localizacao_id" required>
                                        <option value="">Selecione...</option>
                                        <?php foreach ($localizacoes as $localizacao): ?>
                                            <option value="<?php echo $localizacao['id']; ?>" 
                                                    <?php echo (isset($_POST['localizacao_id']) && $_POST['localizacao_id'] == $localizacao['id']) ? 'selected' : ''; ?>>
                                                <?php echo htmlspecialchars($localizacao['bairro'] . ', ' . $localizacao['cidade']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="invalid-feedback">Localização é obrigatória</div>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-select" id="status" name="status">
                                        <option value="disponivel" <?php echo (isset($_POST['status']) && $_POST['status'] == 'disponivel') ? 'selected' : ''; ?>>Disponível</option>
                                        <option value="vendido" <?php echo (isset($_POST['status']) && $_POST['status'] == 'vendido') ? 'selected' : ''; ?>>Vendido</option>
                                        <option value="alugado" <?php echo (isset($_POST['status']) && $_POST['status'] == 'alugado') ? 'selected' : ''; ?>>Alugado</option>
                                        <option value="reservado" <?php echo (isset($_POST['status']) && $_POST['status'] == 'reservado') ? 'selected' : ''; ?>>Reservado</option>
                                    </select>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-check mt-4">
                                        <input class="form-check-input" type="checkbox" id="destaque" name="destaque" 
                                               <?php echo (isset($_POST['destaque']) && $_POST['destaque']) ? 'checked' : ''; ?>>
                                        <label class="form-check-label" for="destaque">
                                            <i class="fas fa-star me-1"></i>Imóvel em Destaque
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Características -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h6 class="text-primary mb-3">
                                        <i class="fas fa-list me-2"></i>Características
                                    </h6>
                                </div>
                                
                                <div class="col-md-3">
                                    <label for="area_total" class="form-label">Área Total (m²)</label>
                                    <input type="number" class="form-control" id="area_total" name="area_total" 
                                           step="0.01" min="0" 
                                           value="<?php echo htmlspecialchars($_POST['area_total'] ?? ''); ?>">
                                </div>
                                
                                <div class="col-md-3">
                                    <label for="area_construida" class="form-label">Área Construída (m²)</label>
                                    <input type="number" class="form-control" id="area_construida" name="area_construida" 
                                           step="0.01" min="0" 
                                           value="<?php echo htmlspecialchars($_POST['area_construida'] ?? ''); ?>">
                                </div>
                                
                                <div class="col-md-2">
                                    <label for="quartos" class="form-label">Quartos</label>
                                    <input type="number" class="form-control" id="quartos" name="quartos" 
                                           min="0" value="<?php echo htmlspecialchars($_POST['quartos'] ?? ''); ?>">
                                </div>
                                
                                <div class="col-md-2">
                                    <label for="banheiros" class="form-label">Banheiros</label>
                                    <input type="number" class="form-control" id="banheiros" name="banheiros" 
                                           min="0" value="<?php echo htmlspecialchars($_POST['banheiros'] ?? ''); ?>">
                                </div>
                                
                                <div class="col-md-2">
                                    <label for="vagas_garagem" class="form-label">Vagas</label>
                                    <input type="number" class="form-control" id="vagas_garagem" name="vagas_garagem" 
                                           min="0" value="<?php echo htmlspecialchars($_POST['vagas_garagem'] ?? ''); ?>">
                                </div>
                            </div>

                            <!-- Endereço -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h6 class="text-primary mb-3">
                                        <i class="fas fa-map-marker-alt me-2"></i>Endereço
                                    </h6>
                                </div>
                                
                                <div class="col-md-8">
                                    <label for="endereco" class="form-label">Endereço Completo</label>
                                    <input type="text" class="form-control" id="endereco" name="endereco" 
                                           value="<?php echo htmlspecialchars($_POST['endereco'] ?? ''); ?>">
                                </div>
                                
                                <div class="col-md-4">
                                    <label for="cep" class="form-label">CEP</label>
                                    <input type="text" class="form-control" id="cep" name="cep" 
                                           value="<?php echo htmlspecialchars($_POST['cep'] ?? ''); ?>">
                                </div>
                            </div>

                            <!-- Características Adicionais -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h6 class="text-primary mb-3">
                                        <i class="fas fa-tags me-2"></i>Características Adicionais
                                    </h6>
                                </div>
                                
                                <div class="col-12">
                                    <div class="row">
                                        <?php foreach ($caracteristicas as $caracteristica): ?>
                                            <div class="col-md-3 mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" 
                                                           name="caracteristicas[]" 
                                                           value="<?php echo $caracteristica['id']; ?>" 
                                                           id="carac_<?php echo $caracteristica['id']; ?>"
                                                           <?php echo (isset($_POST['caracteristicas']) && in_array($caracteristica['id'], $_POST['caracteristicas'])) ? 'checked' : ''; ?>>
                                                    <label class="form-check-label" for="carac_<?php echo $caracteristica['id']; ?>">
                                                        <?php echo htmlspecialchars($caracteristica['nome']); ?>
                                                    </label>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>

                            <!-- Descrição -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h6 class="text-primary mb-3">
                                        <i class="fas fa-align-left me-2"></i>Descrição
                                    </h6>
                                </div>
                                
                                <div class="col-12">
                                    <label for="descricao" class="form-label">Descrição Detalhada *</label>
                                    <textarea class="form-control" id="descricao" name="descricao" rows="6" required><?php echo htmlspecialchars($_POST['descricao'] ?? ''); ?></textarea>
                                    <div class="invalid-feedback">Descrição é obrigatória</div>
                                </div>
                            </div>

                            <!-- Fotos -->
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
                                        Formatos aceitos: JPG, PNG, GIF. Máximo 5MB por foto.
                                    </small>
                                </div>
                            </div>

                            <!-- Botões -->
                            <div class="row">
                                <div class="col-12 text-center">
                                    <button type="submit" class="btn btn-primary btn-lg me-3">
                                        <i class="fas fa-save me-2"></i>Cadastrar Imóvel
                                    </button>
                                    <a href="index.php" class="btn btn-secondary btn-lg">
                                        <i class="fas fa-times me-2"></i>Cancelar
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Admin JS -->
    <script src="../assets/js/admin.js"></script>
    <!-- Dropzone JS -->
    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
    
    <script>
        // Configuração específica para esta página
        document.addEventListener('DOMContentLoaded', function() {
            // Máscara para CEP
            const cepInput = document.getElementById('cep');
            if (cepInput) {
                cepInput.addEventListener('input', function(e) {
                    let value = e.target.value.replace(/\D/g, '');
                    value = value.replace(/^(\d{5})(\d)/, '$1-$2');
                    e.target.value = value;
                });
            }
            
            // Validação de preço
            const precoInput = document.getElementById('preco');
            if (precoInput) {
                precoInput.addEventListener('blur', function() {
                    if (this.value && parseFloat(this.value) <= 0) {
                        this.setCustomValidity('Preço deve ser maior que zero');
                    } else {
                        this.setCustomValidity('');
                    }
                });
            }
        });
    </script>
</body>
</html>
