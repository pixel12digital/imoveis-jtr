<?php
// Teste de redirecionamento após cadastro
echo "<h1>🧪 Teste de Redirecionamento</h1>";

// Simular sucesso no cadastro
$success_message = "Imóvel cadastrado com sucesso! ID: 123 - Redirecionando para o dashboard em 2 segundos...";

echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>";
echo "<i class='fas fa-check-circle me-2'></i>" . htmlspecialchars($success_message);
echo "<div class='mt-2'>";
echo "<a href='admin/index.php' class='btn btn-success btn-sm me-2'>";
echo "<i class='fas fa-tachometer-alt me-1'></i>Ir para Dashboard";
echo "</a>";
echo "<a href='admin/imoveis/index.php' class='btn btn-primary btn-sm me-2'>";
echo "<i class='fas fa-home me-1'></i>Ver Imóveis";
echo "</a>";
echo "<a href='admin/imoveis/adicionar.php' class='btn btn-info btn-sm'>";
echo "<i class='fas fa-plus me-1'></i>Adicionar Outro";
echo "</a>";
echo "</div>";
echo "<button type='button' class='btn-close' data-bs-dismiss='alert'></button>";
echo "</div>";

// Script de redirecionamento
echo "<script>
    // Aguardar 2 segundos e redirecionar para o dashboard
    setTimeout(function() {
        window.location.href = 'admin/index.php';
    }, 2000);
    
    // Mostrar contador regressivo
    let countdown = 2;
    const countdownElement = document.createElement('div');
    countdownElement.innerHTML = '<small class=\"text-muted\">Redirecionando em <span id=\"countdown\">' + countdown + '</span> segundos...</small>';
    document.querySelector('.alert-success').appendChild(countdownElement);
    
    const countdownInterval = setInterval(function() {
        countdown--;
        document.getElementById('countdown').textContent = countdown;
        if (countdown <= 0) {
            clearInterval(countdownInterval);
        }
    }, 1000);
</script>";

echo "<p><strong>Teste:</strong> Esta página simula o comportamento após cadastro bem-sucedido.</p>";
echo "<p><strong>Funcionalidades:</strong></p>";
echo "<ul>";
echo "<li>✅ Mensagem de sucesso com ID do imóvel</li>";
echo "<li>✅ Botões de ação (Dashboard, Ver Imóveis, Adicionar Outro)</li>";
echo "<li>✅ Contador regressivo de 2 segundos</li>";
echo "<li>✅ Redirecionamento automático para o dashboard</li>";
echo "</ul>";

echo "<p><strong>Como testar:</strong></p>";
echo "<ol>";
echo "<li>Observe a mensagem de sucesso</li>";
echo "<li>Veja o contador regressivo</li>";
echo "<li>Aguarde 2 segundos para redirecionamento automático</li>";
echo "<li>Ou clique em um dos botões para navegação manual</li>";
echo "</ol>";
?>
