<?php
// Página Home - JTR Imóveis
?>

<!-- Hero Section -->
<section class="hero-section bg-primary text-white py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold mb-4">Encontre seu Lar dos Sonhos</h1>
                <p class="lead mb-4">Com paixão, dedicação e recursos para ajudar nossos clientes a atingir seus objetivos de compra e venda. Estamos com você em cada passo do caminho.</p>
                <a href="<?php echo getPagePath('imoveis'); ?>" class="btn btn-light btn-lg px-4">Explorar Imóveis</a>
            </div>
            <div class="col-lg-6">
                <div class="hero-image text-center">
                    <i class="fas fa-home fa-10x text-white-50"></i>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Filtros Rápidos em Destaque -->
<section class="quick-filters-section py-5 bg-white">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2 class="text-center mb-4">Busca Rápida</h2>
                <p class="text-center text-muted mb-5">Encontre seu imóvel ideal com nossos filtros inteligentes</p>
            </div>
        </div>
        
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow-lg border-0">
                    <div class="card-body p-4">
                        <form id="quickSearchForm" action="<?php echo getPagePath('imoveis'); ?>" method="GET">
                            <div class="row g-3">
                                <!-- Tipo de Negócio -->
                                <div class="col-md-3">
                                    <label for="tipo_negocio" class="form-label fw-bold">
                                        <i class="fas fa-tag me-2"></i>Tipo de Negócio
                                    </label>
                                    <select class="form-select" id="tipo_negocio" name="tipo_negocio">
                                        <option value="">Todos</option>
                                        <option value="venda">Venda</option>
                                        <option value="aluguel">Aluguel</option>
                                    </select>
                                </div>
                                
                                <!-- Tipo de Imóvel -->
                                <div class="col-md-3">
                                    <label for="tipo_imovel" class="form-label fw-bold">
                                        <i class="fas fa-home me-2"></i>Tipo de Imóvel
                                    </label>
                                    <select class="form-select" id="tipo_imovel" name="tipo_imovel">
                                        <option value="">Todos</option>
                                        <?php
                                        $tipos = fetchAll("SELECT id, nome FROM tipos_imovel ORDER BY nome");
                                        if ($tipos) {
                                            foreach ($tipos as $tipo) {
                                                echo '<option value="' . $tipo['id'] . '">' . htmlspecialchars($tipo['nome']) . '</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                
                                <!-- Cidade -->
                                <div class="col-md-3">
                                    <label for="cidade" class="form-label fw-bold">
                                        <i class="fas fa-map-marker-alt me-2"></i>Cidade
                                    </label>
                                    <select class="form-select" id="cidade" name="cidade">
                                        <option value="">Todas</option>
                                        <?php
                                        $cidades = fetchAll("SELECT DISTINCT cidade FROM localizacoes ORDER BY cidade");
                                        if ($cidades) {
                                            foreach ($cidades as $cidade) {
                                                echo '<option value="' . htmlspecialchars($cidade['cidade']) . '">' . htmlspecialchars($cidade['cidade']) . '</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                
                                <!-- Preço -->
                                <div class="col-md-3">
                                    <label for="preco_max" class="form-label fw-bold">
                                        <i class="fas fa-dollar-sign me-2"></i>Preço Máximo
                                    </label>
                                    <select class="form-select" id="preco_max" name="preco_max">
                                        <option value="">Qualquer</option>
                                        <option value="100000">Até R$ 100.000</option>
                                        <option value="200000">Até R$ 200.000</option>
                                        <option value="300000">Até R$ 300.000</option>
                                        <option value="500000">Até R$ 500.000</option>
                                        <option value="750000">Até R$ 750.000</option>
                                        <option value="1000000">Até R$ 1.000.000</option>
                                        <option value="1500000">Até R$ 1.500.000</option>
                                        <option value="2000000">Até R$ 2.000.000</option>
                                        <option value="5000000">Até R$ 5.000.000</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="row g-3 mt-3">
                                <!-- Quartos -->
                                <div class="col-md-2">
                                    <label for="quartos" class="form-label fw-bold">
                                        <i class="fas fa-bed me-2"></i>Quartos
                                    </label>
                                    <select class="form-select" id="quartos" name="quartos">
                                        <option value="">Qualquer</option>
                                        <option value="1">1+</option>
                                        <option value="2">2+</option>
                                        <option value="3">3+</option>
                                        <option value="4">4+</option>
                                        <option value="5">5+</option>
                                    </select>
                                </div>
                                
                                <!-- Banheiros -->
                                <div class="col-md-2">
                                    <label for="banheiros" class="form-label fw-bold">
                                        <i class="fas fa-bath me-2"></i>Banheiros
                                    </label>
                                    <select class="form-select" id="banheiros" name="banheiros">
                                        <option value="">Qualquer</option>
                                        <option value="1">1+</option>
                                        <option value="2">2+</option>
                                        <option value="3">3+</option>
                                        <option value="4">4+</option>
                                    </select>
                                </div>
                                
                                <!-- Vagas -->
                                <div class="col-md-2">
                                    <label for="vagas" class="form-label fw-bold">
                                        <i class="fas fa-car me-2"></i>Vagas
                                    </label>
                                    <select class="form-select" id="vagas" name="vagas">
                                        <option value="">Qualquer</option>
                                        <option value="1">1+</option>
                                        <option value="2">2+</option>
                                        <option value="3">3+</option>
                                        <option value="4">4+</option>
                                        <option value="5">5+</option>
                                    </select>
                                </div>
                                
                                <!-- Área Mínima -->
                                <div class="col-md-3">
                                    <label for="area_min" class="form-label fw-bold">
                                        <i class="fas fa-ruler-combined me-2"></i>Área Mínima (m²)
                                    </label>
                                    <select class="form-select" id="area_min" name="area_min">
                                        <option value="">Qualquer</option>
                                        <option value="50">50m²+</option>
                                        <option value="80">80m²+</option>
                                        <option value="100">100m²+</option>
                                        <option value="150">150m²+</option>
                                        <option value="200">200m²+</option>
                                        <option value="300">300m²+</option>
                                        <option value="500">500m²+</option>
                                    </select>
                                </div>
                                
                                <!-- Ordenação -->
                                <div class="col-md-3">
                                    <label for="ordenacao" class="form-label fw-bold">
                                        <i class="fas fa-sort me-2"></i>Ordenar por
                                    </label>
                                    <select class="form-select" id="ordenacao" name="ordenacao">
                                        <option value="recentes">Mais Recentes</option>
                                        <option value="preco_menor">Menor Preço</option>
                                        <option value="preco_maior">Maior Preço</option>
                                        <option value="area_maior">Maior Área</option>
                                        <option value="destaque">Em Destaque</option>
                                    </select>
                                </div>
                            </div>
                            
                            <!-- Botões de Ação -->
                            <div class="row mt-4">
                                <div class="col-12 text-center">
                                    <button type="submit" class="btn btn-primary btn-lg px-5 me-3">
                                        <i class="fas fa-search me-2"></i>Buscar Imóveis
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary btn-lg px-4" onclick="limparFiltros()">
                                        <i class="fas fa-times me-2"></i>Limpar Filtros
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Filtros Rápidos -->
                            <div class="row mt-4">
                                <div class="col-12">
                                    <div class="d-flex flex-wrap justify-content-center gap-2">
                                        <button type="button" class="btn btn-outline-primary btn-sm" onclick="aplicarFiltroRapido('destaque', '1')">
                                            <i class="fas fa-star me-1"></i>Em Destaque
                                        </button>
                                        <button type="button" class="btn btn-outline-primary btn-sm" onclick="aplicarFiltroRapido('tipo_negocio', 'venda')">
                                            <i class="fas fa-tag me-1"></i>Para Venda
                                        </button>
                                        <button type="button" class="btn btn-outline-primary btn-sm" onclick="aplicarFiltroRapido('tipo_negocio', 'aluguel')">
                                            <i class="fas fa-key me-1"></i>Para Alugar
                                        </button>
                                        <button type="button" class="btn btn-outline-primary btn-sm" onclick="aplicarFiltroRapido('preco_max', '300000')">
                                            <i class="fas fa-dollar-sign me-1"></i>Até R$ 300k
                                        </button>
                                        <button type="button" class="btn btn-outline-primary btn-sm" onclick="aplicarFiltroRapido('quartos', '3')">
                                            <i class="fas fa-bed me-1"></i>3+ Quartos
                                        </button>
                                        <button type="button" class="btn btn-outline-primary btn-sm" onclick="aplicarFiltroRapido('vagas', '2')">
                                            <i class="fas fa-car me-1"></i>2+ Vagas
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Estatísticas -->
<section class="stats-section py-5 bg-light">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-3 mb-4">
                <div class="stat-item">
                    <i class="fas fa-building fa-3x text-primary mb-3"></i>
                    <h3 class="fw-bold text-primary">850+</h3>
                    <p class="text-muted">APARTAMENTOS</p>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="stat-item">
                    <i class="fas fa-home fa-3x text-primary mb-3"></i>
                    <h3 class="fw-bold text-primary">950+</h3>
                    <p class="text-muted">CHÁCARAS</p>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="stat-item">
                    <i class="fas fa-map fa-3x text-primary mb-3"></i>
                    <h3 class="fw-bold text-primary">120+</h3>
                    <p class="text-muted">TERRENOS</p>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="stat-item">
                    <i class="fas fa-users fa-3x text-primary mb-3"></i>
                    <h3 class="fw-bold text-primary">5K+</h3>
                    <p class="text-muted">CLIENTES SATISFEITOS</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Imóveis em Destaque -->
<section class="featured-properties py-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2 class="text-center mb-5">Imóveis em Destaque</h2>
            </div>
        </div>
        
        <div class="row">
            <?php
            // Buscar imóveis em destaque
            $featured_properties = fetchAll("
                SELECT i.*, t.nome as tipo_nome, l.cidade, l.bairro, f.arquivo as foto_principal
                FROM imoveis i
                LEFT JOIN tipos_imovel t ON i.tipo_id = t.id
                LEFT JOIN localizacoes l ON i.localizacao_id = l.id
                LEFT JOIN fotos_imovel f ON i.id = f.imovel_id AND f.principal = 1
                WHERE i.destaque = 1 AND i.status = 'disponivel'
                ORDER BY i.data_criacao DESC
                LIMIT 6
            ");

            if ($featured_properties) {
                foreach ($featured_properties as $property) {
                    ?>
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="property-card card h-100 shadow-sm">
                            <div class="property-image" style="position: relative;">
                                <?php if ($property['foto_principal']): ?>
                                    <?php 
                                    $image_url = getUploadPath($property['foto_principal']);
                                    if ($image_url): 
                                    ?>
                                        <img src="<?php echo htmlspecialchars($image_url); ?>" 
                                             class="card-img-top" alt="<?php echo htmlspecialchars($property['titulo']); ?>"
                                             style="width: 100%; height: 200px; object-fit: cover; border-radius: 8px 8px 0 0;">
                                        <div class="no-image bg-light d-flex align-items-center justify-content-center" 
                                             style="height: 200px; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 8px 8px 0 0; display: none; position: absolute; top: 0; left: 0; right: 0;">
                                            <div class="text-center">
                                                <i class="fas fa-home fa-3x text-muted mb-2"></i>
                                                <p class="text-muted small mb-0">Foto não disponível</p>
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <div class="no-image bg-light d-flex align-items-center justify-content-center" 
                                             style="height: 200px; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 8px 8px 0 0;">
                                            <div class="text-center">
                                                <i class="fas fa-home fa-3x text-muted mb-2"></i>
                                                <p class="text-muted small mb-0">Foto não disponível</p>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <div class="no-image bg-light d-flex align-items-center justify-content-center" 
                                         style="height: 200px; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 8px 8px 0 0;">
                                        <div class="text-center">
                                            <i class="fas fa-home fa-3x text-muted mb-2"></i>
                                            <p class="text-muted small mb-0">Foto não disponível</p>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <div class="property-price">
                                    <span class="badge bg-primary fs-6"><?php echo formatPrice($property['preco']); ?></span>
                                </div>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $property['titulo']; ?></h5>
                                <p class="card-text text-muted">
                                    <i class="fas fa-map-marker-alt me-2"></i>
                                    <?php echo $property['bairro'] . ', ' . $property['cidade']; ?>
                                </p>
                                <div class="property-features">
                                    <span class="badge bg-light text-dark me-2">
                                        <i class="fas fa-bed me-1"></i><?php echo $property['quartos']; ?> Quartos
                                    </span>
                                    <span class="badge bg-light text-dark me-2">
                                        <i class="fas fa-bath me-1"></i><?php echo $property['banheiros']; ?> Banheiros
                                    </span>
                                    <span class="badge bg-light text-dark me-2">
                                        <i class="fas fa-car me-1"></i><?php echo $property['vagas']; ?> Vagas
                                    </span>
                                </div>
                                <div class="property-area mt-2">
                                    <small class="text-muted">
                                        Área: <?php echo $property['area_total']; ?>m²
                                    </small>
                                </div>
                            </div>
                            <div class="card-footer bg-transparent border-0">
                                <a href="<?php echo getPagePath('imovel', ['id' => $property['id']]); ?>" 
                                   class="btn btn-primary w-100">Ver Imóvel</a>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            } else {
                // Imóveis de exemplo quando não há dados no banco
                $example_properties = [
                    [
                        'titulo' => 'Casa em Condomínio com 3 Suítes',
                        'preco' => 1850000.00,
                        'bairro' => 'Vila Madalena',
                        'cidade' => 'São Paulo',
                        'quartos' => 3,
                        'banheiros' => 4,
                        'vagas' => 4,
                        'area_total' => 200
                    ],
                    [
                        'titulo' => 'Apartamento com Vista para o Parque',
                        'preco' => 850000.00,
                        'bairro' => 'Pinheiros',
                        'cidade' => 'São Paulo',
                        'quartos' => 2,
                        'banheiros' => 2,
                        'vagas' => 2,
                        'area_total' => 85
                    ],
                    [
                        'titulo' => 'Chácara com Área Gourmet',
                        'preco' => 750000.00,
                        'bairro' => 'Atibaia',
                        'cidade' => 'São Paulo',
                        'quartos' => 3,
                        'banheiros' => 3,
                        'vagas' => 5,
                        'area_total' => 235
                    ]
                ];

                foreach ($example_properties as $property) {
                    ?>
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="property-card card h-100 shadow-sm">
                            <div class="property-image">
                                <div class="no-image bg-light d-flex align-items-center justify-content-center" 
                                     style="height: 200px; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 8px 8px 0 0;">
                                    <div class="text-center">
                                        <i class="fas fa-home fa-3x text-muted mb-2"></i>
                                        <p class="text-muted small mb-0">Foto não disponível</p>
                                    </div>
                                </div>
                                <div class="property-price">
                                    <span class="badge bg-primary fs-6"><?php echo formatPrice($property['preco']); ?></span>
                                </div>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $property['titulo']; ?></h5>
                                <p class="card-text text-muted">
                                    <i class="fas fa-map-marker-alt me-2"></i>
                                    <?php echo $property['bairro'] . ', ' . $property['cidade']; ?>
                                </p>
                                <div class="property-features">
                                    <span class="badge bg-light text-dark me-2">
                                        <i class="fas fa-bed me-1"></i><?php echo $property['quartos']; ?> Quartos
                                    </span>
                                    <span class="badge bg-light text-dark me-2">
                                        <i class="fas fa-bath me-1"></i><?php echo $property['banheiros']; ?> Banheiros
                                    </span>
                                    <span class="badge bg-light text-dark me-2">
                                        <i class="fas fa-car me-1"></i><?php echo $property['vagas']; ?> Vagas
                                    </span>
                                </div>
                                <div class="property-area mt-2">
                                    <small class="text-muted">
                                        Área: <?php echo $property['area_total']; ?>m²
                                    </small>
                                </div>
                            </div>
                            <div class="card-footer bg-transparent border-0">
                                <a href="#" class="btn btn-primary w-100">Ver Imóvel</a>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
        
        <div class="row mt-4">
            <div class="col-12 text-center">
                <a href="<?php echo getPagePath('imoveis'); ?>" class="btn btn-outline-primary btn-lg">Ver Todos os Imóveis</a>
            </div>
        </div>
    </div>
</section>

<!-- Seção de Serviços -->
<section class="services-section py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2 class="text-center mb-5">Nossos Serviços</h2>
            </div>
        </div>
        
        <div class="row">
            <div class="col-lg-4 mb-4">
                <div class="service-card text-center p-4">
                    <div class="service-icon mb-3">
                        <i class="fas fa-search fa-3x text-primary"></i>
                    </div>
                    <h5>Busca Personalizada</h5>
                    <p class="text-muted">Encontre o imóvel ideal com nossos filtros avançados e busca inteligente.</p>
                </div>
            </div>
            
            <div class="col-lg-4 mb-4">
                <div class="service-card text-center p-4">
                    <div class="service-icon mb-3">
                        <i class="fas fa-handshake fa-3x text-primary"></i>
                    </div>
                    <h5>Assessoria Completa</h5>
                    <p class="text-muted">Acompanhamento em todo o processo de compra, venda ou aluguel.</p>
                </div>
            </div>
            
            <div class="col-lg-4 mb-4">
                <div class="service-card text-center p-4">
                    <div class="service-icon mb-3">
                        <i class="fas fa-calculator fa-3x text-primary"></i>
                    </div>
                    <h5>Simulação de Financiamento</h5>
                    <p class="text-muted">Simule seu financiamento e encontre as melhores condições.</p>
                </div>
            </div>
        </div>
    </div>
</section>


