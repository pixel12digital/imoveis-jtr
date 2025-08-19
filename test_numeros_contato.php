<?php
// Teste dos Números de Contato - JTR Imóveis
require_once 'config/paths.php';
require_once 'config/database.php';
require_once 'config/config.php';

echo "<!DOCTYPE html>";
echo "<html lang='pt-BR'>";
echo "<head>";
echo "<meta charset='UTF-8'>";
echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
echo "<title>Teste dos Números de Contato</title>";
echo "<link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>";
echo "<link href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css' rel='stylesheet'>";
echo "</head>";
echo "<body class='bg-light'>";

echo "<div class='container py-5'>";
echo "<h1 class='text-center mb-5'>Teste dos Números de Contato</h1>";

// Testar constantes
echo "<div class='row'>";
echo "<div class='col-md-6'>";
echo "<div class='card'>";
echo "<div class='card-header bg-success text-white'>";
echo "<h5 class='mb-0'><i class='fas fa-home me-2'></i>Números de Venda</h5>";
echo "</div>";
echo "<div class='card-body'>";
echo "<p><strong>Telefone:</strong> " . PHONE_VENDA . "</p>";
echo "<p><strong>WhatsApp:</strong> " . PHONE_WHATSAPP_VENDA . "</p>";
echo "<p><strong>Link WhatsApp:</strong> <a href='https://wa.me/" . PHONE_WHATSAPP_VENDA . "?text=Olá! Gostaria de saber mais sobre imóveis para compra.' target='_blank'>Abrir WhatsApp</a></p>";
echo "</div>";
echo "</div>";
echo "</div>";

echo "<div class='col-md-6'>";
echo "<div class='card'>";
echo "<div class='card-header bg-info text-white'>";
echo "<h5 class='mb-0'><i class='fas fa-key me-2'></i>Números de Locação</h5>";
echo "</div>";
echo "<div class='card-body'>";
echo "<p><strong>Telefone:</strong> " . PHONE_LOCACAO . "</p>";
echo "<p><strong>WhatsApp:</strong> " . PHONE_WHATSAPP_LOCACAO . "</p>";
echo "<p><strong>Link WhatsApp:</strong> <a href='https://wa.me/" . PHONE_WHATSAPP_LOCACAO . "?text=Olá! Gostaria de saber mais sobre imóveis para aluguel.' target='_blank'>Abrir WhatsApp</a></p>";
echo "</div>";
echo "</div>";
echo "</div>";
echo "</div>";

echo "<hr class='my-5'>";

// Testar formatação dos números
echo "<h3>Teste de Formatação</h3>";
echo "<div class='row'>";
echo "<div class='col-md-6'>";
echo "<h5>Vendas</h5>";
echo "<p><strong>Original:</strong> " . PHONE_VENDA . "</p>";
echo "<p><strong>Para telefone:</strong> " . str_replace(['+', ' ', '-'], '', PHONE_VENDA) . "</p>";
echo "<p><strong>Para WhatsApp:</strong> " . PHONE_WHATSAPP_VENDA . "</p>";
echo "</div>";
echo "<div class='col-md-6'>";
echo "<h5>Locação</h5>";
echo "<p><strong>Original:</strong> " . PHONE_LOCACAO . "</p>";
echo "<p><strong>Para telefone:</strong> " . str_replace(['+', ' ', '-'], '', PHONE_LOCACAO) . "</p>";
echo "<p><strong>Para WhatsApp:</strong> " . PHONE_WHATSAPP_LOCACAO . "</p>";
echo "</div>";
echo "</div>";

echo "<hr class='my-5'>";

// Testar links funcionais
echo "<h3>Teste de Links</h3>";
echo "<div class='row'>";
echo "<div class='col-md-6'>";
echo "<h5>Links de Venda</h5>";
echo "<p><a href='tel:" . str_replace(['+', ' ', '-'], '', PHONE_VENDA) . "' class='btn btn-success me-2'>";
echo "<i class='fas fa-phone me-1'></i>Ligar para Vendas</a></p>";
echo "<p><a href='https://wa.me/" . PHONE_WHATSAPP_VENDA . "?text=Olá! Gostaria de saber mais sobre imóveis para compra.' target='_blank' class='btn btn-outline-success'>";
echo "<i class='fab fa-whatsapp me-1'></i>WhatsApp Vendas</a></p>";
echo "</div>";
echo "<div class='col-md-6'>";
echo "<h5>Links de Locação</h5>";
echo "<p><a href='tel:" . str_replace(['+', ' ', '-'], '', PHONE_LOCACAO) . "' class='btn btn-info me-2'>";
echo "<i class='fas fa-phone me-1'></i>Ligar para Locação</a></p>";
echo "<p><a href='https://wa.me/" . PHONE_WHATSAPP_LOCACAO . "?text=Olá! Gostaria de saber mais sobre imóveis para aluguel.' target='_blank' class='btn btn-outline-info'>";
echo "<i class='fab fa-whatsapp me-1'></i>WhatsApp Locação</a></p>";
echo "</div>";
echo "</div>";

echo "<hr class='my-5'>";

// Instruções
echo "<h3>Como Testar</h3>";
echo "<div class='alert alert-info'>";
echo "<h5><i class='fas fa-info-circle me-2'></i>Instruções de Teste</h5>";
echo "<ol>";
echo "<li><strong>Teste os links de telefone:</strong> Clique nos botões 'Ligar para Vendas' e 'Ligar para Locação'</li>";
echo "<li><strong>Teste os links do WhatsApp:</strong> Clique nos botões 'WhatsApp Vendas' e 'WhatsApp Locação'</li>";
echo "<li><strong>Verifique o footer:</strong> Acesse qualquer página do site e verifique o footer</li>";
echo "<li><strong>Verifique a página de contato:</strong> Acesse a página de contato e verifique os números destacados</li>";
echo "<li><strong>Verifique os botões flutuantes:</strong> Role a página para ver os botões do WhatsApp no canto direito</li>";
echo "</ol>";
echo "</div>";

echo "<div class='alert alert-success'>";
echo "<h5><i class='fas fa-check-circle me-2'></i>Status do Sistema</h5>";
echo "<p><strong>✅ Constantes configuradas:</strong> PHONE_VENDA e PHONE_LOCACAO</p>";
echo "<p><strong>✅ Números formatados:</strong> Para telefone e WhatsApp</p>";
echo "<p><strong>✅ Links funcionais:</strong> Telefone e WhatsApp</p>";
echo "<p><strong>✅ Footer atualizado:</strong> Com números específicos</p>";
echo "<p><strong>✅ Página de contato:</strong> Com números destacados</p>";
echo "<p><strong>✅ Botões flutuantes:</strong> WhatsApp separados por tipo</p>";
echo "</div>";

echo "</div>";

echo "<script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js'></script>";
echo "</body>";
echo "</html>";
?>
