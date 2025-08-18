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

// Verificar se foi passado um ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$imovel_id = (int)$_GET['id'];

// Buscar dados do imóvel
$imovel = fetch("
    SELECT i.*, t.nome as tipo_nome, l.cidade, l.bairro, u.nome as corretor_nome 
    FROM imoveis i 
    LEFT JOIN tipos_imovel t ON i.tipo_id = t.id 
    LEFT JOIN localizacoes l ON i.localizacao_id = l.id 
    LEFT JOIN usuarios u ON i.usuario_id = u.id 
    WHERE i.id = ?
", [$imovel_id]);

if (!$imovel) {
    header('Location: index.php');
    exit;
}

// Buscar dados para os selects
$tipos_imovel = fetchAll("SELECT * FROM tipos_imovel ORDER BY nome");
$localizacoes = fetchAll("SELECT * FROM localizacoes ORDER BY cidade, bairro");
$usuarios = fetchAll("SELECT * FROM usuarios WHERE ativo = 1 ORDER BY nome");
$caracteristicas = fetchAll("SELECT * FROM caracteristicas ORDER BY nome");

// Buscar características do imóvel
$imovel_caracteristicas = fetchAll("
    SELECT caracteristica_id FROM imovel_caracteristicas WHERE imovel_id = ?
", [$imovel_id]);

$caracteristicas_selecionadas = array_column($imovel_caracteristicas, 'caracteristica_id');

// Buscar fotos do imóvel
$fotos_imovel = fetchAll("
    SELECT * FROM fotos_imovel WHERE imovel_id = ? ORDER BY ordem
", [$imovel_id]);

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
            'status' => cleanInput($_POST['status']),
            'destaque' => isset($_POST['destaque']) ? 1 : 0,
            'area_total' => !empty($_POST['area_total']) ? (float)$_POST['area_total'] : null,
            'area_construida' => !empty($_POST['area_construida']) ? (float)$_POST['area_construida'] : null,
            'quartos' => !empty($_POST['quartos']) ? (int)$_POST['quartos'] : null,
            'banheiros' => !empty($_POST['banheiros']) ? (int)$_POST['banheiros'] : null,
            'vagas_garagem' => !empty($_POST['vagas_garagem']) ? (int)$_POST['vagas_garagem'] : null,
            'endereco' => cleanInput($_POST['endereco']),
            'cep' => cleanInput($_POST['cep']),
            'data_atualizacao' => date('Y-m-d H:i:s')
        ];
        
        // Atualizar imóvel
        $resultado = update("imoveis", $dados_imovel, "id = ?", [$imovel_id]);
        
        if ($resultado) {
            // Atualizar características
            // Primeiro, remover todas as características existentes
            query("DELETE FROM imovel_caracteristicas WHERE imovel_id = ?", [$imovel_id]);
            
            // Inserir características selecionadas
            if (isset($_POST['caracteristicas']) && is_array($_POST['caracteristicas'])) {
                foreach ($_POST['caracteristicas'] as $caracteristica_id) {
                    insert("imovel_caracteristicas", [
                        'imovel_id' => $imovel_id,
                        'caracteristica_id' => (int)$caracteristica_id
                    ]);
                }
            }
            
            // Processar exclusão de fotos
            if (isset($_POST['excluir_fotos']) && is_array($_POST['excluir_fotos'])) {
                foreach ($_POST['excluir_fotos'] as $foto_id) {
                    $foto = fetch("SELECT arquivo FROM fotos_imovel WHERE id = ? AND imovel_id = ?", [$foto_id, $imovel_id]);
                    if ($foto) {
                        // Excluir arquivo físico
                        $arquivo_path = "../../uploads/imoveis/{$imovel_id}/{$foto['arquivo']}";
                        if (file_exists($arquivo_path)) {
                            unlink($arquivo_path);
                        }
                        
                        // Excluir registro do banco
                        query("DELETE FROM fotos_imovel WHERE id = ?", [$foto_id]);
                    }
                }
            }
            
            // Processar upload de novas fotos
            if (isset($_FILES['novas_fotos']) && !empty($_FILES['novas_fotos']['name'][0])) {
                $upload_dir = "../../uploads/imoveis/{$imovel_id}/";
                
                // Criar diretório se não existir
                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0755, true);
                }
                
                // Buscar última ordem
                $ultima_ordem = fetch("SELECT MAX(ordem) as max_ordem FROM fotos_imovel WHERE imovel_id = ?", [$imovel_id]);
                $ordem_atual = ($ultima_ordem['max_ordem'] ?? 0) + 1;
                
                foreach ($_FILES['novas_fotos']['tmp_name'] as $key => $tmp_name) {
                    if ($_FILES['novas_fotos']['error'][$key] === UPLOAD_ERR_OK) {
                        $filename = $_FILES['novas_fotos']['name'][$key];
                        $ext = pathinfo($filename, PATHINFO_EXTENSION);
                        $new_filename = uniqid() . '.' . $ext;
                        
                        if (move_uploaded_file($tmp_name, $upload_dir . $new_filename)) {
                            insert("fotos_imovel", [
                                'imovel_id' => $imovel_id,
                                'arquivo' => $new_filename,
                                'legenda' => cleanInput($_POST['legendas_novas'][$key] ?? ''),
                                'ordem' => $ordem_atual++
                            ]);
                        }
                    }
                }
            }
            
            // Atualizar dados na variável para exibição
            $imovel = array_merge($imovel, $dados_imovel);
            $caracteristicas_selecionadas = isset($_POST['caracteristicas']) ? $_POST['caracteristicas'] : [];
            
            // Buscar fotos atualizadas
            $fotos_imovel = fetchAll("
                SELECT * FROM fotos_imovel WHERE imovel_id = ? ORDER BY ordem
            ", [$imovel_id]);
            
            $success_message = "Imóvel atualizado com sucesso!";
        } else {
            throw new Exception('Erro ao atualizar imóvel no banco de dados.');
        }
        
    } catch (Exception $e) {
        $error_message = "Erro ao atualizar imóvel: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Imóvel - Painel Administrativo JTR Imóveis</title>
    
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
                        <i class="fas fa-edit me-2"></i>Editar Imóvel
                    </h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group me-2">
                            <a href="index.php" class="btn btn-sm btn-secondary">
                                <i class="fas fa-arrow-left me-1"></i>Voltar
                            </a>
                            <a href="../../pages/imovel-detalhes.php?id=<?php echo $imovel_id; ?>" 
                               class="btn btn-sm btn-info" target="_blank">
                                <i class="fas fa-eye me-1"></i>Ver no Site
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Informações do Imóvel -->
                <div class="card shadow mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-info-circle me-2"></i>Informações do Imóvel
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>ID:</strong> <?php echo $imovel['id']; ?></p>
                                <p><strong>Título:</strong> <?php echo htmlspecialchars($imovel['titulo']); ?></p>
                                <p><strong>Tipo:</strong> <?php echo htmlspecialchars($imovel['tipo_nome']); ?></p>
                                <p><strong>Localização:</strong> <?php echo htmlspecialchars($imovel['bairro'] . ', ' . $imovel['cidade']); ?></p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Status:</strong> 
                                    <span class="badge bg-<?php echo $imovel['status'] === 'disponivel' ? 'success' : 
                                        ($imovel['status'] === 'vendido' ? 'danger' : 
                                        ($imovel['status'] === 'alugado' ? 'warning' : 'info')); ?>">
                                        <?php echo ucfirst($imovel['status']); ?>
                                    </span>
                                </p>
                                <p><strong>Destaque:</strong> 
                                    <?php echo $imovel['destaque'] ? '<i class="fas fa-star text-warning"></i> Sim' : '<i class="fas fa-star text-muted"></i> Não'; ?>
                                </p>
                                <p><strong>Corretor:</strong> <?php echo htmlspecialchars($imovel['corretor_nome']); ?></p>
                                <p><strong>Data de Criação:</strong> <?php echo date('d/m/Y H:i', strtotime($imovel['data_criacao'])); ?></p>
                            </div>
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
                            <i class="fas fa-edit me-2"></i>Editar Informações
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
                                           value="<?php echo htmlspecialchars($imovel['titulo']); ?>" required>
                                    <div class="invalid-feedback">Título é obrigatório</div>
                                </div>
                                
                                <div class="col-md-4">
                                    <label for="preco" class="form-label">Preço *</label>
                                    <div class="input-group">
                                        <span class="input-group-text">R$</span>
                                        <input type="number" class="form-control" id="preco" name="preco" 
                                               step="0.01" min="0" 
                                               value="<?php echo htmlspecialchars($imovel['preco']); ?>" required>
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
                                                    <?php echo $imovel['tipo_id'] == $tipo['id'] ? 'selected' : ''; ?>>
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
                                                    <?php echo $imovel['localizacao_id'] == $localizacao['id'] ? 'selected' : ''; ?>>
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
                                        <option value="disponivel" <?php echo $imovel['status'] == 'disponivel' ? 'selected' : ''; ?>>Disponível</option>
                                        <option value="vendido" <?php echo $imovel['status'] == 'vendido' ? 'selected' : ''; ?>>Vendido</option>
                                        <option value="alugado" <?php echo $imovel['status'] == 'alugado' ? 'selected' : ''; ?>>Alugado</option>
                                        <option value="reservado" <?php echo $imovel['status'] == 'reservado' ? 'selected' : ''; ?>>Reservado</option>
                                    </select>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-check mt-4">
                                        <input class="form-check-input" type="checkbox" id="destaque" name="destaque" 
                                               <?php echo $imovel['destaque'] ? 'checked' : ''; ?>>
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
                                           value="<?php echo htmlspecialchars($imovel['area_total'] ?? ''); ?>">
                                </div>
                                
                                <div class="col-md-3">
                                    <label for="area_construida" class="form-label">Área Construída (m²)</label>
                                    <input type="number" class="form-control" id="area_construida" name="area_construida" 
                                           step="0.01" min="0" 
                                           value="<?php echo htmlspecialchars($imovel['area_construida'] ?? ''); ?>">
                                </div>
                                
                                <div class="col-md-2">
                                    <label for="quartos" class="form-label">Quartos</label>
                                    <input type="number" class="form-control" id="quartos" name="quartos" 
                                           min="0" value="<?php echo htmlspecialchars($imovel['quartos'] ?? ''); ?>">
                                </div>
                                
                                <div class="col-md-2">
                                    <label for="banheiros" class="form-label">Banheiros</label>
                                    <input type="number" class="form-control" id="banheiros" name="banheiros" 
                                           min="0" value="<?php echo htmlspecialchars($imovel['banheiros'] ?? ''); ?>">
                                </div>
                                
                                <div class="col-md-2">
                                    <label for="vagas_garagem" class="form-label">Vagas</label>
                                    <input type="number" class="form-control" id="vagas_garagem" name="vagas_garagem" 
                                           min="0" value="<?php echo htmlspecialchars($imovel['vagas_garagem'] ?? ''); ?>">
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
                                           value="<?php echo htmlspecialchars($imovel['endereco'] ?? ''); ?>">
                                </div>
                                
                                <div class="col-md-4">
                                    <label for="cep" class="form-label">CEP</label>
                                    <input type="text" class="form-control" id="cep" name="cep" 
                                           value="<?php echo htmlspecialchars($imovel['cep'] ?? ''); ?>">
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
                                                           <?php echo in_array($caracteristica['id'], $caracteristicas_selecionadas) ? 'checked' : ''; ?>>
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
                                    <textarea class="form-control" id="descricao" name="descricao" rows="6" required><?php echo htmlspecialchars($imovel['descricao']); ?></textarea>
                                    <div class="invalid-feedback">Descrição é obrigatória</div>
                                </div>
                            </div>

                            <!-- Fotos Existentes -->
                            <?php if ($fotos_imovel): ?>
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h6 class="text-primary mb-3">
                                        <i class="fas fa-images me-2"></i>Fotos Existentes
                                    </h6>
                                </div>
                                
                                <div class="col-12">
                                    <div class="row">
                                        <?php foreach ($fotos_imovel as $foto): ?>
                                            <div class="col-md-3 mb-3">
                                                <div class="card">
                                                    <img src="../../uploads/imoveis/<?php echo $imovel_id; ?>/<?php echo $foto['arquivo']; ?>" 
                                                         class="card-img-top" alt="Foto do imóvel" style="height: 150px; object-fit: cover;">
                                                    <div class="card-body">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" 
                                                                   name="excluir_fotos[]" 
                                                                   value="<?php echo $foto['id']; ?>" 
                                                                   id="excluir_<?php echo $foto['id']; ?>">
                                                            <label class="form-check-label text-danger" for="excluir_<?php echo $foto['id']; ?>">
                                                                <i class="fas fa-trash me-1"></i>Excluir
                                                            </label>
                                                        </div>
                                                        <small class="text-muted">Ordem: <?php echo $foto['ordem']; ?></small>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>

                            <!-- Novas Fotos -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h6 class="text-primary mb-3">
                                        <i class="fas fa-plus me-2"></i>Adicionar Novas Fotos
                                    </h6>
                                </div>
                                
                                <div class="col-12">
                                    <div class="drop-zone border-2 border-dashed border-secondary rounded p-4 text-center">
                                        <i class="fas fa-cloud-upload-alt fa-3x text-secondary mb-3"></i>
                                        <h5>Arraste e solte as novas fotos aqui</h5>
                                        <p class="text-muted">ou clique para selecionar</p>
                                        <input type="file" class="file-upload" name="novas_fotos[]" multiple accept="image/*" style="display: none;">
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
                                        <i class="fas fa-save me-2"></i>Salvar Alterações
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
            
            // Confirmação para exclusão de fotos
            const checkboxesExcluir = document.querySelectorAll('input[name="excluir_fotos[]"]');
            checkboxesExcluir.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    if (this.checked) {
                        if (!confirm('Tem certeza que deseja excluir esta foto?')) {
                            this.checked = false;
                        }
                    }
                });
            });
        });
    </script>
</body>
</html>
