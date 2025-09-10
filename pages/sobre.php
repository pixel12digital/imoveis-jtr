<?php
// Página Sobre - JTR Imóveis

// Buscar estatísticas para mostrar na página
$total_imoveis = fetch("SELECT COUNT(*) as total FROM imoveis")['total'];
$total_vendidos = fetch("SELECT COUNT(*) as total FROM imoveis WHERE status = 'vendido'")['total'];
$total_alugados = fetch("SELECT COUNT(*) as total FROM imoveis WHERE status = 'alugado'")['total'];
$total_clientes = fetch("SELECT COUNT(*) as total FROM clientes")['total'];
?>

<!-- Hero Section -->
<section class="hero-section-small bg-primary text-white py-4">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-12 text-center">
                <h1 class="h2 mb-2">Sobre a <?php echo SITE_NAME; ?></h1>
                <p class="mb-0">Conheça nossa história, missão e valores</p>
            </div>
        </div>
    </div>
</section>

<!-- História da Empresa -->
<section class="company-history py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4">
                <div class="history-content">
                    <h2 class="mb-4">Nossa História</h2>
                    <p class="lead mb-4">
                        A <?php echo SITE_NAME; ?> nasceu da paixão por realizar sonhos e transformar vidas 
                        através da realização do sonho da casa própria.
                    </p>
                    <p class="mb-4">
                        Fundada em 2010, nossa empresa começou como uma pequena imobiliária de bairro e, 
                        através de muito trabalho, dedicação e foco no cliente, cresceu para se tornar 
                        uma das principais referências no mercado imobiliário de São Paulo.
                    </p>
                    <p class="mb-0">
                        Ao longo de mais de uma década, ajudamos milhares de famílias a encontrar seu 
                        lar dos sonhos, sempre com transparência, ética e compromisso com a excelência.
                    </p>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="history-image text-center">
                    <div class="image-placeholder bg-light d-flex align-items-center justify-content-center" 
                         style="height: 400px; border-radius: 10px;">
                        <div class="text-center">
                            <i class="fas fa-building fa-5x text-primary mb-3"></i>
                            <h5 class="text-muted">Nossa Sede</h5>
                            <p class="text-muted">São Paulo - SP</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Missão, Visão e Valores -->
<section class="mission-vision-values py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 mb-4">
                <div class="card h-100 border-0 shadow-sm text-center">
                    <div class="card-body p-4">
                        <div class="icon-wrapper mb-3">
                            <i class="fas fa-bullseye fa-3x text-primary"></i>
                        </div>
                        <h4 class="card-title">Nossa Missão</h4>
                        <p class="card-text">
                            Facilitar o acesso à moradia de qualidade, oferecendo soluções imobiliárias 
                            personalizadas e atendimento diferenciado, contribuindo para a realização 
                            do sonho da casa própria de nossos clientes.
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 mb-4">
                <div class="card h-100 border-0 shadow-sm text-center">
                    <div class="card-body p-4">
                        <div class="icon-wrapper mb-3">
                            <i class="fas fa-eye fa-3x text-primary"></i>
                        </div>
                        <h4 class="card-title">Nossa Visão</h4>
                        <p class="card-text">
                            Ser reconhecida como a imobiliária mais confiável e inovadora da região, 
                            referência em qualidade de atendimento e soluções imobiliárias, expandindo 
                            nossa atuação para outras cidades.
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 mb-4">
                <div class="card h-100 border-0 shadow-sm text-center">
                    <div class="card-body p-4">
                        <div class="icon-wrapper mb-3">
                            <i class="fas fa-heart fa-3x text-primary"></i>
                        </div>
                        <h4 class="card-title">Nossos Valores</h4>
                        <ul class="list-unstyled text-start">
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Ética e Transparência</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Compromisso com o Cliente</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Excelência no Atendimento</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Inovação e Tecnologia</li>
                            <li class="mb-0"><i class="fas fa-check text-success me-2"></i>Responsabilidade Social</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Estatísticas -->
<section class="stats-section py-5">
    <div class="container">
        <div class="row text-center">
            <div class="col-12 mb-4">
                <h2 class="mb-3">Números que Falam por Si</h2>
                <p class="lead text-muted">Resultados que demonstram nossa credibilidade e experiência no mercado</p>
            </div>
        </div>
        
        <div class="row text-center">
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="stat-item">
                    <div class="stat-icon mb-3">
                        <i class="fas fa-home fa-4x text-primary"></i>
                    </div>
                    <h3 class="display-4 fw-bold text-primary mb-2"><?php echo number_format($total_imoveis); ?>+</h3>
                    <p class="text-muted fs-5">Imóveis Cadastrados</p>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="stat-item">
                    <div class="stat-icon mb-3">
                        <i class="fas fa-handshake fa-4x text-success"></i>
                    </div>
                    <h3 class="display-4 fw-bold text-success mb-2"><?php echo number_format($total_vendidos); ?>+</h3>
                    <p class="text-muted fs-5">Imóveis Vendidos</p>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="stat-item">
                    <div class="stat-icon mb-3">
                        <i class="fas fa-key fa-4x text-info"></i>
                    </div>
                    <h3 class="display-4 fw-bold text-info mb-2"><?php echo number_format($total_alugados); ?>+</h3>
                    <p class="text-muted fs-5">Imóveis Alugados</p>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="stat-item">
                    <div class="stat-icon mb-3">
                        <i class="fas fa-users fa-4x text-warning"></i>
                    </div>
                    <h3 class="display-4 fw-bold text-warning mb-2"><?php echo number_format($total_clientes); ?>+</h3>
                    <p class="text-muted fs-5">Clientes Satisfeitos</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Nossa Equipe -->
<section class="team-section py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-5">
                <h2 class="mb-3">Nossa Equipe</h2>
                <p class="lead text-muted">
                    Profissionais experientes e dedicados para atender você com excelência
                </p>
            </div>
        </div>
        
        <div class="row">
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="team-card card border-0 shadow-sm text-center">
                    <div class="card-body p-4">
                        <div class="team-avatar mb-3">
                            <div class="avatar-placeholder bg-primary d-flex align-items-center justify-content-center mx-auto" 
                                 style="width: 120px; height: 120px; border-radius: 50%;">
                                <i class="fas fa-user-tie fa-3x text-white"></i>
                            </div>
                        </div>
                        <h5 class="card-title">João Silva</h5>
                        <p class="text-muted mb-2">Diretor Executivo</p>
                        <p class="card-text small">
                            Mais de 15 anos de experiência no mercado imobiliário, especialista em 
                            gestão de negócios e desenvolvimento de equipes.
                        </p>
                        <div class="team-social">
                            <a href="#" class="text-muted me-2"><i class="fab fa-linkedin"></i></a>
                            <a href="#" class="text-muted me-2"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="text-muted"><i class="fas fa-envelope"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="team-card card border-0 shadow-sm text-center">
                    <div class="card-body p-4">
                        <div class="team-avatar mb-3">
                            <div class="avatar-placeholder bg-success d-flex align-items-center justify-content-center mx-auto" 
                                 style="width: 120px; height: 120px; border-radius: 50%;">
                                <i class="fas fa-user-tie fa-3x text-white"></i>
                            </div>
                        </div>
                        <h5 class="card-title">Maria Santos</h5>
                        <p class="text-muted mb-2">Gerente de Vendas</p>
                        <p class="card-text small">
                            Especialista em vendas imobiliárias com foco em atendimento personalizado 
                            e satisfação total do cliente.
                        </p>
                        <div class="team-social">
                            <a href="#" class="text-muted me-2"><i class="fab fa-linkedin"></i></a>
                            <a href="#" class="text-muted me-2"><i class="fab fa-instagram"></i></a>
                            <a href="#" class="text-muted"><i class="fas fa-envelope"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="team-card card border-0 shadow-sm text-center">
                    <div class="card-body p-4">
                        <div class="team-avatar mb-3">
                            <div class="avatar-placeholder bg-info d-flex align-items-center justify-content-center mx-auto" 
                                 style="width: 120px; height: 120px; border-radius: 50%;">
                                <i class="fas fa-user-tie fa-3x text-white"></i>
                            </div>
                        </div>
                        <h5 class="card-title">Carlos Oliveira</h5>
                        <p class="text-muted mb-2">Especialista Sênior</p>
                        <p class="card-text small">
                            Corretor credenciado com mais de 10 anos de experiência, especialista em 
                            imóveis residenciais e comerciais.
                        </p>
                        <div class="team-social">
                            <a href="#" class="text-muted me-2"><i class="fab fa-linkedin"></i></a>
                            <a href="#" class="text-muted me-2"><i class="fab fa-facebook"></i></a>
                            <a href="#" class="text-muted"><i class="fas fa-envelope"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Diferenciais -->
<section class="differentials-section py-5">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-5">
                <h2 class="mb-3">Por que Escolher a <?php echo SITE_NAME; ?>?</h2>
                <p class="lead text-muted">
                    Conheça os diferenciais que nos tornam únicos no mercado
                </p>
            </div>
        </div>
        
        <div class="row">
            <div class="col-lg-6 mb-4">
                <div class="differential-item d-flex">
                    <div class="differential-icon me-3">
                        <i class="fas fa-shield-alt fa-2x text-primary"></i>
                    </div>
                    <div class="differential-content">
                        <h5>Segurança e Confiança</h5>
                        <p class="text-muted">
                            Todos os nossos imóveis passam por rigorosa verificação de documentação 
                            e legalidade, garantindo transações seguras e transparentes.
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-6 mb-4">
                <div class="differential-item d-flex">
                    <div class="differential-icon me-3">
                        <i class="fas fa-clock fa-2x text-primary"></i>
                    </div>
                    <div class="differential-content">
                        <h5>Atendimento 24/7</h5>
                        <p class="text-muted">
                            Nossa equipe está sempre disponível para atender você, seja por telefone, 
                            WhatsApp ou e-mail, inclusive nos finais de semana.
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-6 mb-4">
                <div class="differential-item d-flex">
                    <div class="differential-icon me-3">
                        <i class="fas fa-tools fa-2x text-primary"></i>
                    </div>
                    <div class="differential-content">
                        <h5>Ferramentas Tecnológicas</h5>
                        <p class="text-muted">
                            Utilizamos as mais modernas tecnologias para facilitar sua busca, 
                            incluindo tours virtuais, fotos em alta resolução e filtros avançados.
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-6 mb-4">
                <div class="differential-item d-flex">
                    <div class="differential-icon me-3">
                        <i class="fas fa-handshake fa-2x text-primary"></i>
                    </div>
                    <div class="differential-content">
                        <h5>Parcerias Estratégicas</h5>
                        <p class="text-muted">
                            Mantemos parcerias com as principais instituições financeiras para 
                            oferecer as melhores condições de financiamento para nossos clientes.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Certificações e Prêmios -->
<section class="certifications-section py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-5">
                <h2 class="mb-3">Certificações e Reconhecimentos</h2>
                <p class="lead text-muted">
                    Nossa qualidade é reconhecida pelo mercado e pelos órgãos reguladores
                </p>
            </div>
        </div>
        
        <div class="row text-center">
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="certification-item">
                    <div class="certification-icon mb-3">
                        <i class="fas fa-certificate fa-4x text-primary"></i>
                    </div>
                    <h5>CRECI Ativo</h5>
                    <p class="text-muted small">
                            Especialista em Imóveis registrado e ativo no Conselho Regional
                    </p>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="certification-item">
                    <div class="certification-icon mb-3">
                        <i class="fas fa-award fa-4x text-success"></i>
                    </div>
                    <h5>Prêmio Excelência</h5>
                    <p class="text-muted small">
                        Reconhecimento por qualidade de atendimento em 2022
                    </p>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="certification-item">
                    <div class="certification-icon mb-3">
                        <i class="fas fa-star fa-4x text-warning"></i>
                    </div>
                    <h5>5 Estrelas</h5>
                    <p class="text-muted small">
                        Avaliação média dos clientes em plataformas online
                    </p>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="certification-item">
                    <div class="certification-icon mb-3">
                        <i class="fas fa-check-circle fa-4x text-info"></i>
                    </div>
                    <h5>ISO 9001</h5>
                    <p class="text-muted small">
                        Certificação de qualidade em gestão empresarial
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="cta-section py-5 bg-primary text-white">
    <div class="container text-center">
        <h3 class="mb-3">Conheça Nossa Equipe Pessoalmente</h3>
        <p class="lead mb-4">
            Agende uma visita e descubra como podemos ajudar você a encontrar o imóvel ideal!
        </p>
        <div class="d-flex justify-content-center gap-3 flex-wrap">
            <a href="<?php echo getPagePath('contato'); ?>" class="btn btn-light btn-lg">
                <i class="fas fa-phone me-2"></i>Fale Conosco
            </a>
            <a href="<?php echo getPagePath('imoveis'); ?>" class="btn btn-outline-light btn-lg">
                <i class="fas fa-search me-2"></i>Ver Imóveis
            </a>
            <a href="https://wa.me/5511999999999?text=Olá! Gostaria de agendar uma visita." 
               target="_blank" class="btn btn-success btn-lg">
                <i class="fab fa-whatsapp me-2"></i>WhatsApp
            </a>
        </div>
    </div>
</section>

<!-- Depoimentos -->
<section class="testimonials-section py-5">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-5">
                <h2 class="mb-3">O que Nossos Clientes Dizem</h2>
                <p class="lead text-muted">
                    Depoimentos de quem já realizou o sonho da casa própria conosco
                </p>
            </div>
        </div>
        
        <div class="row">
            <div class="col-lg-4 mb-4">
                <div class="testimonial-card card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="testimonial-rating mb-3">
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                        </div>
                        <p class="card-text mb-3">
                            "Excelente atendimento! A equipe da <?php echo SITE_NAME; ?> foi fundamental 
                            para encontrarmos nossa casa dos sonhos. Profissionais muito competentes e atenciosos."
                        </p>
                        <div class="testimonial-author">
                            <strong>Ana Paula Silva</strong>
                            <small class="text-muted d-block">Compradora de Casa</small>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 mb-4">
                <div class="testimonial-card card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="testimonial-rating mb-3">
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                        </div>
                        <p class="card-text mb-3">
                            "Vendi meu apartamento em tempo recorde e com um excelente preço. 
                            A equipe é muito profissional e transparente em todo o processo."
                        </p>
                        <div class="testimonial-author">
                            <strong>Roberto Santos</strong>
                            <small class="text-muted d-block">Vendedor de Apartamento</small>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 mb-4">
                <div class="testimonial-card card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="testimonial-rating mb-3">
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                        </div>
                        <p class="card-text mb-3">
                            "Aluguei um apartamento através da <?php echo SITE_NAME; ?> e fui muito bem atendida. 
                            O processo foi rápido e sem complicações. Recomendo!"
                        </p>
                        <div class="testimonial-author">
                            <strong>Mariana Costa</strong>
                            <small class="text-muted d-block">Locatária</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


