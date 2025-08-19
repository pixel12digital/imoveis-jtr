<?php
// Configurações do banco de dados - Hostinger
define('DB_HOST', 'auth-db1607.hstgr.io');
define('DB_NAME', 'u342734079_jtrimoveis');
define('DB_USER', 'u342734079_jtrimoveis');
define('DB_PASS', 'Los@ngo#081081');

try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8", DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    die("Erro na conexão: " . $e->getMessage());
}

// Função para executar queries
function query($sql, $params = []) {
    global $pdo;
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt;
}

// Função para buscar uma linha
function fetch($sql, $params = []) {
    $stmt = query($sql, $params);
    return $stmt->fetch();
}

// Função para buscar todas as linhas
function fetchAll($sql, $params = []) {
    $stmt = query($sql, $params);
    return $stmt->fetchAll();
}

// Função para buscar um registro por ID
function fetchById($table, $id) {
    global $pdo;
    $sql = "SELECT * FROM {$table} WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    return $stmt->fetch();
}

// Função para buscar registros por condição
function fetchWhere($table, $where, $params = []) {
    global $pdo;
    $sql = "SELECT * FROM {$table} WHERE {$where}";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetch();
}

// Função para inserir dados
function insert($table, $data) {
    global $pdo;
    
    error_log("DEBUG INSERT: Iniciando inserção na tabela: {$table}");
    error_log("DEBUG INSERT: Dados recebidos: " . print_r($data, true));
    
    try {
        $columns = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));
        
        $sql = "INSERT INTO {$table} ({$columns}) VALUES ({$placeholders})";
        error_log("DEBUG INSERT: SQL gerado: {$sql}");
        
        $stmt = $pdo->prepare($sql);
        error_log("DEBUG INSERT: Statement preparado");
        
        $result = $stmt->execute($data);
        error_log("DEBUG INSERT: Execute retornou: " . ($result ? 'true' : 'false'));
        
        if ($result) {
            $last_id = $pdo->lastInsertId();
            error_log("DEBUG INSERT: SUCESSO - ID inserido: {$last_id}");
            return $last_id;
        } else {
            error_log("DEBUG INSERT: FALHA - Execute retornou false");
            error_log("DEBUG INSERT: Erro PDO: " . print_r($stmt->errorInfo(), true));
            return false;
        }
    } catch (Exception $e) {
        error_log("DEBUG INSERT: EXCEÇÃO CAPTURADA: " . $e->getMessage());
        error_log("DEBUG INSERT: Stack trace: " . $e->getTraceAsString());
        return false;
    } catch (PDOException $e) {
        error_log("DEBUG INSERT: PDO EXCEÇÃO CAPTURADA: " . $e->getMessage());
        error_log("DEBUG INSERT: Código de erro: " . $e->getCode());
        return false;
    }
}

// Função para atualizar dados
function update($table, $data, $where, $params = []) {
    global $pdo;
    
    $set_clause = [];
    $set_params = [];
    $param_count = 0;
    
    foreach (array_keys($data) as $column) {
        $set_clause[] = "{$column} = ?";
        $set_params[] = $data[$column];
    }
    
    $sql = "UPDATE {$table} SET " . implode(', ', $set_clause) . " WHERE {$where}";
    $stmt = $pdo->prepare($sql);
    
    // Combinar parâmetros SET com parâmetros WHERE
    $all_params = array_merge($set_params, $params);
    
    return $stmt->execute($all_params);
}

// Função para deletar dados
function delete($table, $where, $params = []) {
    global $pdo;
    
    try {
        $sql = "DELETE FROM {$table} WHERE {$where}";
        $stmt = $pdo->prepare($sql);
        
        $result = $stmt->execute($params);
        
        // Verificar se alguma linha foi afetada
        if ($result && $stmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    } catch (Exception $e) {
        error_log("Erro na função delete: " . $e->getMessage());
        return false;
    }
}
?>
