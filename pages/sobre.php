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
                        A <?php echo SITE_NAME; ?> é uma incorporadora e construtora com anos de experiência 
                        no mercado imobiliário, especializada em desenvolver e comercializar imóveis próprios.
                    </p>
                    <p class="mb-4">
                        Com uma trajetória sólida e comprometida com a qualidade, desenvolvemos projetos 
                        residenciais e comerciais que atendem às necessidades de nossos clientes, sempre 
                        priorizando a excelência na construção e o atendimento personalizado.
                    </p>
                    <p class="mb-0">
                        Nossa empresa possui um portfólio diversificado de imóveis próprios para venda e 
                        locação, garantindo aos nossos clientes transparência, seriedade e a segurança 
                        de lidar diretamente com a incorporadora.
                    </p>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="history-image text-center">
                    <div class="image-placeholder bg-light d-flex align-items-center justify-content-center" 
                         style="height: 400px; border-radius: 10px;">
                        <div class="text-center">
                            <i class="fas fa-building fa-5x text-primary mb-3"></i>
                            <h5 class="text-muted">Nossos Projetos</h5>
                            <p class="text-muted">Desenvolvimento e Construção</p>
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
                            Desenvolver e construir imóveis de qualidade superior, oferecendo aos nossos 
                            clientes a oportunidade de adquirir ou locar propriedades próprias com 
                            transparência, seriedade e compromisso com a excelência.
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
                            Ser reconhecida como uma das principais incorporadoras e construtoras da região, 
                            referência em qualidade de construção e desenvolvimento de projetos imobiliários, 
                            expandindo nossa atuação e portfólio de imóveis próprios.
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
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Compromisso com a Qualidade</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Seriedade e Confiança</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Inovação na Construção</li>
                            <li class="mb-0"><i class="fas fa-check text-success me-2"></i>Responsabilidade Social</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>





<!-- CTA -->
<section class="cta-section py-5 bg-primary text-white">
    <div class="container text-center">
        <h3 class="mb-3">Conheça Nossos Imóveis</h3>
        <p class="lead mb-4">
            Agende uma visita e descubra nossos projetos desenvolvidos com qualidade e seriedade!
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



