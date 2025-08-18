<?php
// Página de Contato - JTR Imóveis
?>

<!-- Hero Section -->
<section class="hero-section-small bg-primary text-white py-4">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-12 text-center">
                <h1 class="h2 mb-2">Entre em Contato</h1>
                <p class="mb-0">Estamos aqui para ajudar você a encontrar o imóvel ideal</p>
            </div>
        </div>
    </div>
</section>

<!-- Informações de Contato -->
<section class="contact-info-section py-5">
    <div class="container">
        <div class="row">
            <!-- Informações da Empresa -->
            <div class="col-lg-4 mb-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center">
                        <div class="contact-icon mb-3">
                            <i class="fas fa-building fa-3x text-primary"></i>
                        </div>
                        <h5 class="card-title"><?php echo SITE_NAME; ?></h5>
                        <p class="card-text text-muted">
                            Realizamos sonhos com paixão, dedicação e recursos para ajudar nossos clientes 
                            a atingir seus objetivos de compra e venda.
                        </p>
                        
                        <!-- Estatísticas -->
                        <div class="row text-center mt-4">
                            <div class="col-4">
                                <div class="stat-item">
                                    <h6 class="text-primary mb-1"><?php echo $total_imoveis; ?></h6>
                                    <small class="text-muted">Disponíveis</small>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="stat-item">
                                    <h6 class="text-success mb-1"><?php echo $total_vendidos; ?></h6>
                                    <small class="text-muted">Vendidos</small>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="stat-item">
                                    <h6 class="text-info mb-1"><?php echo $total_alugados; ?></h6>
                                    <small class="text-muted">Alugados</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Informações de Contato -->
            <div class="col-lg-4 mb-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title mb-4">
                            <i class="fas fa-address-book me-2 text-primary"></i>Informações de Contato
                        </h5>
                        
                        <div class="contact-item mb-3">
                            <div class="d-flex align-items-center">
                                <div class="contact-icon-small me-3">
                                    <i class="fas fa-phone fa-lg text-primary"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1">Telefone</h6>
                                    <p class="mb-0">
                                        <a href="tel:<?php echo SITE_PHONE; ?>" class="text-decoration-none">
                                            <?php echo SITE_PHONE; ?>
                                        </a>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="contact-item mb-3">
                            <div class="d-flex align-items-center">
                                <div class="contact-icon-small me-3">
                                    <i class="fas fa-envelope fa-lg text-primary"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1">E-mail</h6>
                                    <p class="mb-0">
                                        <a href="mailto:<?php echo SITE_EMAIL; ?>" class="text-decoration-none">
                                            <?php echo SITE_EMAIL; ?>
                                        </a>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="contact-item mb-3">
                            <div class="d-flex align-items-center">
                                <div class="contact-icon-small me-3">
                                    <i class="fas fa-map-marker-alt fa-lg text-primary"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1">Endereço</h6>
                                    <p class="mb-0">São Paulo - SP, Brasil</p>
                                </div>
                            </div>
                        </div>

                        <div class="contact-item">
                            <div class="d-flex align-items-center">
                                <div class="contact-icon-small me-3">
                                    <i class="fas fa-clock fa-lg text-primary"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1">Horário de Atendimento</h6>
                                    <p class="mb-0">Segunda a Sexta: 8h às 18h<br>Sábado: 8h às 12h</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Redes Sociais e WhatsApp -->
            <div class="col-lg-4 mb-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center">
                        <h5 class="card-title mb-4">
                            <i class="fas fa-share-alt me-2 text-primary"></i>Redes Sociais
                        </h5>
                        
                        <div class="social-links mb-4">
                            <a href="#" class="btn btn-outline-primary btn-lg me-2 mb-2">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="#" class="btn btn-outline-danger btn-lg me-2 mb-2">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a href="#" class="btn btn-outline-success btn-lg me-2 mb-2">
                                <i class="fab fa-whatsapp"></i>
                            </a>
                            <a href="#" class="btn btn-outline-info btn-lg mb-2">
                                <i class="fab fa-linkedin"></i>
                            </a>
                        </div>

                        <div class="whatsapp-cta">
                            <h6 class="mb-3">Atendimento via WhatsApp</h6>
                            <a href="https://wa.me/5511999999999?text=Olá! Gostaria de saber mais sobre imóveis." 
                               target="_blank" class="btn btn-success btn-lg w-100">
                                <i class="fab fa-whatsapp me-2"></i>Falar no WhatsApp
                            </a>
                            <small class="text-muted d-block mt-2">
                                Resposta em até 5 minutos
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Formulário de Contato -->
<section class="contact-form-section py-5 bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card border-0 shadow">
                    <div class="card-header bg-primary text-white text-center">
                        <h4 class="mb-0">
                            <i class="fas fa-paper-plane me-2"></i>Envie sua Mensagem
                        </h4>
                        <p class="mb-0 mt-2">Preencha o formulário abaixo e entraremos em contato</p>
                    </div>
                    <div class="card-body p-4">
                        <?php if ($mensagem_enviada): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fas fa-check-circle me-2"></i>
                                <strong>Mensagem enviada com sucesso!</strong> Entraremos em contato em breve.
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <?php if ($erro): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fas fa-exclamation-circle me-2"></i>
                                <strong>Erro:</strong> <?php echo $erro; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <form id="contact-form" method="POST" action="<?php echo getPagePath('contato'); ?>">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="nome" class="form-label">
                                        <i class="fas fa-user me-2 text-primary"></i>Nome Completo *
                                    </label>
                                    <input type="text" class="form-control" id="nome" name="nome" 
                                           value="<?php echo isset($nome) ? htmlspecialchars($nome) : ''; ?>" 
                                           required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">
                                        <i class="fas fa-envelope me-2 text-primary"></i>E-mail *
                                    </label>
                                    <input type="email" class="form-control" id="email" name="email" 
                                           value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>" 
                                           required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="telefone" class="form-label">
                                        <i class="fas fa-phone me-2 text-primary"></i>Telefone
                                    </label>
                                    <input type="tel" class="form-control" id="telefone" name="telefone" 
                                           value="<?php echo isset($telefone) ? htmlspecialchars($telefone) : ''; ?>"
                                           placeholder="(11) 99999-9999">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="assunto" class="form-label">
                                        <i class="fas fa-tag me-2 text-primary"></i>Assunto
                                    </label>
                                    <select class="form-select" id="assunto" name="assunto">
                                        <option value="">Selecione um assunto</option>
                                        <option value="Compra de Imóvel" <?php echo (isset($assunto) && $assunto == 'Compra de Imóvel') ? 'selected' : ''; ?>>
                                            Compra de Imóvel
                                        </option>
                                        <option value="Venda de Imóvel" <?php echo (isset($assunto) && $assunto == 'Venda de Imóvel') ? 'selected' : ''; ?>>
                                            Venda de Imóvel
                                        </option>
                                        <option value="Aluguel" <?php echo (isset($assunto) && $assunto == 'Aluguel') ? 'selected' : ''; ?>>
                                            Aluguel
                                        </option>
                                        <option value="Financiamento" <?php echo (isset($assunto) && $assunto == 'Financiamento') ? 'selected' : ''; ?>>
                                            Financiamento
                                        </option>
                                        <option value="Outros" <?php echo (isset($assunto) && $assunto == 'Outros') ? 'selected' : ''; ?>>
                                            Outros
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="mensagem" class="form-label">
                                    <i class="fas fa-comment me-2 text-primary"></i>Mensagem *
                                </label>
                                <textarea class="form-control" id="mensagem" name="mensagem" rows="5" 
                                          placeholder="Conte-nos como podemos ajudar você..." required><?php echo isset($mensagem) ? htmlspecialchars($mensagem) : ''; ?></textarea>
                            </div>

                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="concordo" name="concordo" required>
                                    <label class="form-check-label" for="concordo">
                                        Concordo com a <a href="#" class="text-decoration-none">política de privacidade</a> 
                                        e autorizo o contato através dos dados fornecidos.
                                    </label>
                                </div>
                            </div>

                            <div class="d-grid">
                                <button type="submit" name="enviar_contato" class="btn btn-primary btn-lg">
                                    <i class="fas fa-paper-plane me-2"></i>Enviar Mensagem
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Mapa e Localização -->
<section class="map-section py-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h3 class="text-center mb-4">
                    <i class="fas fa-map-marked-alt me-2 text-primary"></i>Nossa Localização
                </h3>
                <div class="map-container">
                    <div class="map-placeholder bg-light d-flex align-items-center justify-content-center" 
                         style="height: 400px; border-radius: 10px;">
                        <div class="text-center">
                            <i class="fas fa-map fa-5x text-muted mb-3"></i>
                            <h5 class="text-muted">Mapa da Localização</h5>
                            <p class="text-muted mb-2">São Paulo - SP, Brasil</p>
                            <small class="text-muted">
                                <i class="fas fa-info-circle me-1"></i>
                                Clique para abrir no Google Maps
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ -->
<section class="faq-section py-5 bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h3 class="text-center mb-5">
                    <i class="fas fa-question-circle me-2 text-primary"></i>Perguntas Frequentes
                </h3>
                
                <div class="accordion" id="faqAccordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="faq1">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1">
                                Como funciona o processo de compra de um imóvel?
                            </button>
                        </h2>
                        <div id="collapse1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                O processo de compra envolve várias etapas: escolha do imóvel, análise de documentação, 
                                negociação, financiamento (se necessário), assinatura do contrato e escritura. 
                                Nossa equipe acompanha você em todo o processo.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="faq2">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2">
                                Quais documentos são necessários para financiamento?
                            </button>
                        </h2>
                        <div id="collapse2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Para financiamento imobiliário são necessários: RG, CPF, comprovante de renda, 
                                comprovante de residência, extrato bancário e outros documentos específicos 
                                solicitados pela instituição financeira.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="faq3">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3">
                                Vocês atendem outras cidades além de São Paulo?
                            </button>
                        </h2>
                        <div id="collapse3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Sim! Atendemos toda a Grande São Paulo e região metropolitana, incluindo Campinas, 
                                Santos e outras cidades próximas. Entre em contato para verificar disponibilidade 
                                na sua região.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="faq4">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4">
                                Qual a taxa de corretagem?
                            </button>
                        </h2>
                        <div id="collapse4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                A taxa de corretagem varia conforme o tipo de imóvel e serviço. Geralmente é de 5% 
                                a 6% sobre o valor da transação. Entre em contato para uma consulta personalizada 
                                e sem compromisso.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Final -->
<section class="cta-section py-5 bg-primary text-white">
    <div class="container text-center">
        <h3 class="mb-3">Pronto para encontrar seu imóvel ideal?</h3>
        <p class="lead mb-4">Nossa equipe está pronta para ajudar você a realizar o sonho da casa própria!</p>
        <div class="d-flex justify-content-center gap-3 flex-wrap">
            <a href="<?php echo getPagePath('imoveis'); ?>" class="btn btn-light btn-lg">
                <i class="fas fa-search me-2"></i>Ver Imóveis
            </a>
            <a href="https://wa.me/5511999999999?text=Olá! Gostaria de agendar uma visita." 
               target="_blank" class="btn btn-success btn-lg">
                <i class="fab fa-whatsapp me-2"></i>Agendar Visita
            </a>
        </div>
    </div>
</section>

<script>
// Validação e funcionalidades do formulário
document.getElementById('contact-form').addEventListener('submit', function(e) {
    const nome = document.getElementById('nome').value.trim();
    const email = document.getElementById('email').value.trim();
    const mensagem = document.getElementById('mensagem').value.trim();
    const concordo = document.getElementById('concordo').checked;
    
    if (!nome || !email || !mensagem) {
        e.preventDefault();
        JTRImoveis.showNotification('Por favor, preencha todos os campos obrigatórios.', 'warning');
        return false;
    }
    
    if (!concordo) {
        e.preventDefault();
        JTRImoveis.showNotification('Você deve concordar com a política de privacidade.', 'warning');
        return false;
    }
    
    // Mostrar loading no botão
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Enviando...';
    submitBtn.disabled = true;
    
    // Restaurar botão após envio
    setTimeout(() => {
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    }, 3000);
});

// Máscara para telefone
document.getElementById('telefone').addEventListener('input', function(e) {
    let value = e.target.value.replace(/\D/g, '');
    if (value.length > 0) {
        value = '(' + value;
        if (value.length > 3) {
            value = value.substring(0, 3) + ') ' + value.substring(3);
        }
        if (value.length > 10) {
            value = value.substring(0, 10) + '-' + value.substring(10);
        }
        if (value.length > 15) {
            value = value.substring(0, 15);
        }
    }
    e.target.value = value;
});

// Abrir mapa no Google Maps
document.querySelector('.map-placeholder').addEventListener('click', function() {
    const address = 'São Paulo, SP, Brasil';
    const googleMapsUrl = `https://www.google.com/maps/search/?api=1&query=${encodeURIComponent(address)}`;
    window.open(googleMapsUrl, '_blank');
});
</script>


