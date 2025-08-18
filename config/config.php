<?php
// Configurações de sessão (DEVEM vir ANTES de session_start())
if (session_status() === PHP_SESSION_NONE) {
    ini_set('session.cookie_lifetime', 86400); // 24 horas
    ini_set('session.gc_maxlifetime', 86400);
    ini_set('session.cookie_httponly', 1);
    ini_set('session.cookie_secure', 0); // 0 para desenvolvimento local, 1 para produção
    ini_set('session.use_strict_mode', 1);
}

// Configurações gerais do sistema
define('SITE_NAME', 'JTR Imóveis');
define('SITE_URL', ''); // Será detectado automaticamente
define('SITE_EMAIL', 'contato@jtrimoveis.com.br');
define('SITE_PHONE', '(11) 99999-9999');

// Configurações de upload
define('UPLOAD_DIR', dirname(__DIR__) . '/uploads/');
define('MAX_FILE_SIZE', 5 * 1024 * 1024); // 5MB
define('ALLOWED_EXTENSIONS', ['jpg', 'jpeg', 'png', 'gif']);

// Configurações de paginação
define('ITEMS_PER_PAGE', 12);

// Função para limpar input
function cleanInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Função para formatar preço
function formatPrice($price) {
    return 'R$ ' . number_format($price, 2, ',', '.');
}

// Função para formatar data
function formatDate($date) {
    return date('d/m/Y', strtotime($date));
}

// Função para gerar slug
function generateSlug($string) {
    $string = strtolower($string);
    $string = preg_replace('/[^a-z0-9\s-]/', '', $string);
    $string = preg_replace('/[\s-]+/', '-', $string);
    return trim($string, '-');
}
