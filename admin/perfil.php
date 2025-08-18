<?php
// Iniciar output buffering para evitar problemas com headers
ob_start();

// Carregar configurações ANTES de iniciar a sessão
require_once '../config/paths.php';
require_once '../config/database.php';
require_once '../config/config.php';

// Agora iniciar a sessão
session_start();

// Verificar se o usuário está logado
if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header('Location: login.php');
    exit;
}

$error = '';
$success = '';

// Buscar dados atualizados do usuário
$usuario = fetchById('usuarios', $_SESSION['admin_id']);

if (!$usuario) {
    header('Location: logout.php');
    exit;
}

// Processar formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_profile'])) {
        // Atualizar perfil
        $nome = cleanInput($_POST['nome']);
        $email = cleanInput($_POST['email']);
        
        // Validações
        if (empty($nome) || empty($email)) {
            $error = 'Nome e email são obrigatórios.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = 'Email inválido.';
        } else {
            // Verificar se o email já existe (exceto para o usuário atual)
            $existing_user = fetchWhere('usuarios', 'email = ? AND id != ?', [$email, $_SESSION['admin_id']]);
            if ($existing_user) {
                $error = 'Este email já está cadastrado por outro usuário.';
            } else {
                // Preparar dados para atualização
                $update_data = [
                    'nome' => $nome,
                    'email' => $email
                ];
                
                // Atualizar usuário
                if (update('usuarios', $update_data, 'id = ?', [$_SESSION['admin_id']])) {
                    $success = 'Perfil atualizado com sucesso!';
                    
                    // Atualizar dados da sessão
                    $_SESSION['admin_nome'] = $nome;
                    $_SESSION['admin_email'] = $email;
                    
                    // Recarregar dados do usuário
                    $usuario = fetchById('usuarios', $_SESSION['admin_id']);
                } else {
                    $error = 'Erro ao atualizar perfil. Tente novamente.';
                }
            }
        }
    } elseif (isset($_POST['change_password'])) {
        // Alterar senha
        $senha_atual = $_POST['senha_atual'];
        $nova_senha = $_POST['nova_senha'];
        $confirmar_senha = $_POST['confirmar_senha'];
        
        // Validações
        if (empty($senha_atual) || empty($nova_senha) || empty($confirmar_senha)) {
            $error = 'Todos os campos de senha são obrigatórios.';
        } elseif (!password_verify($senha_atual, $usuario['senha'])) {
            $error = 'Senha atual incorreta.';
        } elseif (strlen($nova_senha) < 6) {
            $error = 'A nova senha deve ter pelo menos 6 caracteres.';
        } elseif ($nova_senha !== $confirmar_senha) {
            $error = 'As senhas não coincidem.';
        } else {
            // Atualizar senha
            $nova_senha_hash = password_hash($nova_senha, PASSWORD_DEFAULT);
            
            if (update('usuarios', ['senha' => $nova_senha_hash], 'id = ?', [$_SESSION['admin_id']])) {
                $success = 'Senha alterada com sucesso!';
                
                // Limpar campos de senha
                $_POST['senha_atual'] = '';
                $_POST['nova_senha'] = '';
                $_POST['confirmar_senha'] = '';
            } else {
                $error = 'Erro ao alterar senha. Tente novamente.';
            }
        }
    }
}

$page_title = 'Perfil';
include 'includes/header.php';
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Meu Perfil</h1>
</div>

<?php if ($error): ?>
    <div class="alert alert-danger" role="alert">
        <i class="fas fa-exclamation-triangle me-2"></i><?php echo htmlspecialchars($error); ?>
    </div>
<?php endif; ?>

<?php if ($success): ?>
    <div class="alert alert-success" role="alert">
        <i class="fas fa-check-circle me-2"></i><?php echo htmlspecialchars($success); ?>
    </div>
<?php endif; ?>

<div class="row">
    <!-- Informações do Perfil -->
    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-user me-2"></i>Informações do Perfil
                </h6>
            </div>
            <div class="card-body">
                <form method="POST" action="">
                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome Completo</label>
                        <input type="text" class="form-control" id="nome" name="nome" 
                               value="<?php echo htmlspecialchars($usuario['nome']); ?>" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" 
                               value="<?php echo htmlspecialchars($usuario['email']); ?>" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="nivel" class="form-label">Nível de Acesso</label>
                        <input type="text" class="form-control" id="nivel" 
                               value="<?php echo ucfirst(htmlspecialchars($usuario['nivel'])); ?>" readonly>
                        <small class="text-muted">O nível de acesso não pode ser alterado.</small>
                    </div>
                    
                    <button type="submit" name="update_profile" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Atualizar Perfil
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Alterar Senha -->
    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-lock me-2"></i>Alterar Senha
                </h6>
            </div>
            <div class="card-body">
                <form method="POST" action="">
                    <div class="mb-3">
                        <label for="senha_atual" class="form-label">Senha Atual</label>
                        <input type="password" class="form-control" id="senha_atual" name="senha_atual" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="nova_senha" class="form-label">Nova Senha</label>
                        <input type="password" class="form-control" id="nova_senha" name="nova_senha" 
                               minlength="6" required>
                        <small class="text-muted">A senha deve ter pelo menos 6 caracteres.</small>
                    </div>
                    
                    <div class="mb-3">
                        <label for="confirmar_senha" class="form-label">Confirmar Nova Senha</label>
                        <input type="password" class="form-control" id="confirmar_senha" name="confirmar_senha" 
                               minlength="6" required>
                    </div>
                    
                    <button type="submit" name="change_password" class="btn btn-warning">
                        <i class="fas fa-key me-2"></i>Alterar Senha
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Informações da Conta -->
<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-info-circle me-2"></i>Informações da Conta
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>ID da Conta:</strong> <?php echo $usuario['id']; ?></p>
                        <p><strong>Data de Criação:</strong> 
                            <?php echo isset($usuario['data_criacao']) ? date('d/m/Y H:i', strtotime($usuario['data_criacao'])) : 'N/A'; ?>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Última Atualização:</strong> 
                            <?php echo isset($usuario['data_atualizacao']) ? date('d/m/Y H:i', strtotime($usuario['data_atualizacao'])) : 'N/A'; ?>
                        </p>
                        <p><strong>Status:</strong> 
                            <span class="badge bg-<?php echo $usuario['ativo'] ? 'success' : 'danger'; ?>">
                                <?php echo $usuario['ativo'] ? 'Ativo' : 'Inativo'; ?>
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
