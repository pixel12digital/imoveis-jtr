-- Dados de Exemplo para JTR Imóveis
-- Este arquivo deve ser executado APÓS o schema.sql

USE jtr_imoveis;

-- Inserir usuário corretor adicional
INSERT INTO usuarios (nome, email, senha, nivel) VALUES 
('Maria Santos', 'maria@jtrimoveis.com.br', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'corretor'),
('Carlos Oliveira', 'carlos@jtrimoveis.com.br', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'corretor');

-- Inserir mais localizações
INSERT INTO localizacoes (cidade, bairro, estado, cep) VALUES 
('São Paulo', 'Itaim Bibi', 'SP', '01452-000'),
('São Paulo', 'Jardins', 'SP', '01234-000'),
('São Paulo', 'Moema', 'SP', '04040-000'),
('São Paulo', 'Vila Nova Conceição', 'SP', '04501-000'),
('São Paulo', 'Brooklin', 'SP', '04562-000'),
('Campinas', 'Jardim Proença', 'SP', '13088-000'),
('Campinas', 'Nova Veneza', 'SP', '13087-000');

-- Inserir mais características
INSERT INTO caracteristicas (nome, categoria) VALUES 
('Ar condicionado', 'Comodidade'),
('Aquecimento', 'Comodidade'),
('Varanda gourmet', 'Lazer'),
('Sala de jogos', 'Lazer'),
('Spa', 'Lazer'),
('Quadra de tênis', 'Esporte'),
('Pista de caminhada', 'Esporte'),
('Bicicletário', 'Infraestrutura'),
('Lavanderia', 'Infraestrutura'),
('Vista para o parque', 'Localização'),
('Próximo ao metrô', 'Localização'),
('Área pet friendly', 'Lazer');

-- Inserir imóveis de exemplo
INSERT INTO imoveis (titulo, descricao, tipo_id, localizacao_id, preco, area_total, area_construida, quartos, banheiros, vagas, suites, endereco, numero, complemento, latitude, longitude, status, destaque, usuario_id) VALUES 
('Casa em Condomínio com 3 Suítes', 'Linda casa em condomínio fechado com acabamento de luxo, 3 suítes, área gourmet, piscina e churrasqueira. Localização privilegiada no coração de São Paulo.', 1, 1, 1850000.00, 200, 180, 3, 4, 4, 3, 'Rua Harmonia', '123', 'Casa 45', -23.5505, -46.6333, 'disponivel', 1, 1),
('Apartamento com Vista para o Parque', 'Apartamento moderno com vista deslumbrante para o parque, 2 quartos, 2 banheiros, 2 vagas. Prédio com portaria 24h, academia e salão de festas.', 2, 2, 850000.00, 85, 75, 2, 2, 2, 0, 'Rua dos Pinheiros', '456', 'Apto 1201', -23.5686, -46.6934, 'disponivel', 1, 2),
('Chácara com Área Gourmet', 'Chácara espaçosa com 3 quartos, 3 banheiros, 5 vagas. Área gourmet completa, piscina, churrasqueira e muito verde. Ideal para quem busca tranquilidade.', 3, 3, 750000.00, 235, 150, 3, 3, 5, 1, 'Estrada do Campo', '789', 'Chácara 12', -23.5505, -46.6333, 'disponivel', 0, 3),
('Loft Industrial Convertido', 'Loft moderno em prédio industrial convertido, 1 quarto, 1 banheiro, 1 vaga. Design contemporâneo com acabamento de alto padrão.', 2, 4, 650000.00, 65, 65, 1, 1, 1, 0, 'Rua das Indústrias', '321', 'Loft 5', -23.5505, -46.6333, 'disponivel', 0, 1),
('Casa Térrea com Jardim', 'Casa térrea charmosa com 2 quartos, 2 banheiros, 2 vagas. Jardim bem cuidado, garagem coberta e quintal amplo.', 1, 5, 920000.00, 120, 100, 2, 2, 2, 0, 'Rua das Flores', '654', 'Casa 23', -23.5505, -46.6333, 'disponivel', 0, 2),
('Apartamento Studio Mobiliado', 'Studio mobiliado e decorado, 1 banheiro, 1 vaga. Ideal para investimento ou moradia temporária. Prédio com segurança 24h.', 2, 6, 380000.00, 35, 35, 0, 1, 1, 0, 'Rua dos Estudantes', '987', 'Studio 8', -22.9064, -47.0616, 'disponivel', 0, 3),
('Terreno para Construção', 'Terreno plano de 300m² em localização privilegiada. Área residencial com infraestrutura completa. Aprovação para casa de até 2 pavimentos.', 4, 7, 450000.00, 300, 0, 0, 0, 0, 0, 'Rua das Construções', '147', 'Terreno 15', -22.9064, -47.0616, 'disponivel', 0, 1),
('Casa Comercial com Loja', 'Casa comercial com loja no térreo e residência no andar superior. 2 quartos, 2 banheiros, 3 vagas. Localização estratégica para negócios.', 5, 8, 1200000.00, 180, 160, 2, 2, 3, 0, 'Rua Comercial', '258', 'Casa 7', -22.9064, -47.0616, 'disponivel', 0, 2);

-- Inserir fotos para os imóveis (exemplo)
INSERT INTO fotos_imovel (imovel_id, arquivo, legenda, principal, ordem) VALUES 
(1, 'casa-condominio-1.jpg', 'Fachada da casa', 1, 1),
(1, 'casa-condominio-2.jpg', 'Sala de estar', 0, 2),
(1, 'casa-condominio-3.jpg', 'Cozinha gourmet', 0, 3),
(2, 'apartamento-vista-1.jpg', 'Vista para o parque', 1, 1),
(2, 'apartamento-vista-2.jpg', 'Sala de estar', 0, 2),
(2, 'apartamento-vista-3.jpg', 'Quarto principal', 0, 3),
(3, 'chacara-1.jpg', 'Fachada da chácara', 1, 1),
(3, 'chacara-2.jpg', 'Área gourmet', 0, 2),
(3, 'chacara-3.jpg', 'Piscina', 0, 3);

-- Inserir relacionamentos imóveis-características
INSERT INTO imovel_caracteristicas (imovel_id, caracteristica_id) VALUES 
(1, 1), (1, 2), (1, 3), (1, 4), (1, 5), (1, 6), (1, 7), (1, 8), (1, 9), (1, 10),
(2, 1), (2, 2), (2, 4), (2, 5), (2, 6), (2, 7), (2, 8), (2, 9), (2, 11), (2, 12),
(3, 1), (3, 2), (3, 3), (3, 4), (3, 5), (3, 6), (3, 7), (3, 8), (3, 9), (3, 10),
(4, 1), (4, 2), (4, 4), (4, 5), (4, 6), (4, 7), (4, 8), (4, 9), (4, 11), (4, 12),
(5, 1), (5, 2), (5, 3), (5, 4), (5, 5), (5, 6), (5, 7), (5, 8), (5, 9), (5, 10),
(6, 1), (6, 2), (6, 4), (6, 5), (6, 6), (6, 7), (6, 8), (6, 9), (6, 11), (6, 12),
(7, 1), (7, 2), (7, 3), (7, 4), (7, 5), (7, 6), (7, 7), (7, 8), (7, 9), (7, 10),
(8, 1), (8, 2), (8, 3), (8, 4), (8, 5), (8, 6), (8, 7), (8, 8), (8, 9), (8, 11);

-- Inserir clientes de exemplo
INSERT INTO clientes (nome, email, telefone, cpf_cnpj, tipo, observacoes, usuario_id) VALUES 
('Ana Paula Silva', 'ana.silva@email.com', '(11) 99999-1111', '123.456.789-01', 'comprador', 'Interessada em casas de 2-3 quartos na região de Pinheiros', 1),
('Roberto Santos', 'roberto.santos@email.com', '(11) 99999-2222', '987.654.321-09', 'vendedor', 'Vendeu apartamento em 2023, muito satisfeito com o serviço', 2),
('Mariana Costa', 'mariana.costa@email.com', '(11) 99999-3333', '456.789.123-45', 'ambos', 'Comprou casa e alugou apartamento através da empresa', 3),
('João Oliveira', 'joao.oliveira@email.com', '(11) 99999-4444', '789.123.456-78', 'comprador', 'Procurando apartamento de 1-2 quartos para investimento', 1),
('Fernanda Lima', 'fernanda.lima@email.com', '(11) 99999-5555', '321.654.987-32', 'vendedor', 'Vendeu chácara em 2022, processo muito transparente', 2);

-- Inserir interesses dos clientes
INSERT INTO interesses (cliente_id, imovel_id, tipo_interesse, observacoes, status) VALUES 
(1, 1, 'compra', 'Interessada na casa de 3 suítes', 'ativo'),
(1, 2, 'compra', 'Também gostou do apartamento com vista', 'ativo'),
(2, 3, 'compra', 'Interessado na chácara para lazer', 'ativo'),
(3, 4, 'aluguel', 'Quer alugar o loft por 1 ano', 'ativo'),
(4, 5, 'compra', 'Interessado na casa térrea para moradia', 'ativo'),
(5, 6, 'compra', 'Quer o studio para investimento', 'ativo');

-- Inserir contatos de exemplo
INSERT INTO contatos (nome, email, telefone, assunto, mensagem, origem, status) VALUES 
('Pedro Almeida', 'pedro.almeida@email.com', '(11) 99999-6666', 'Compra de Imóvel', 'Gostaria de saber mais sobre a casa em condomínio com 3 suítes. Qual o valor e quando posso agendar uma visita?', 'site', 'novo'),
('Carla Ferreira', 'carla.ferreira@email.com', '(11) 99999-7777', 'Venda de Imóvel', 'Tenho um apartamento para vender na Vila Madalena. Gostaria de saber como funciona o processo de venda com vocês.', 'site', 'em_contato'),
('Lucas Mendes', 'lucas.mendes@email.com', '(11) 99999-8888', 'Financiamento', 'Gostaria de informações sobre financiamento para compra de imóvel. Quais são as melhores opções disponíveis?', 'site', 'novo'),
('Patrícia Rocha', 'patricia.rocha@email.com', '(11) 99999-9999', 'Aluguel', 'Procuro um apartamento para alugar na região de Pinheiros. Preciso de 2 quartos e 2 vagas. Podem me ajudar?', 'site', 'novo'),
('Ricardo Silva', 'ricardo.silva@email.com', '(11) 99999-0000', 'Outros', 'Gostaria de agendar uma reunião para discutir possíveis parcerias comerciais. Vocês atendem outras cidades além de São Paulo?', 'site', 'novo');

-- Inserir histórico de preços de exemplo
INSERT INTO historico_precos (imovel_id, preco_anterior, preco_novo, motivo, usuario_id) VALUES 
(1, 450000.00, 480000.00, 'Ajuste de mercado', 1),
(1, 480000.00, 460000.00, 'Promoção de vendas', 1),
(2, 320000.00, 340000.00, 'Valorização da região', 1),
(3, 280000.00, 290000.00, 'Ajuste de preço', 1),
(4, 520000.00, 500000.00, 'Redução para venda rápida', 1),
(5, 380000.00, 400000.00, 'Valorização do imóvel', 1),
(6, 420000.00, 410000.00, 'Ajuste de mercado', 1);

-- Atualizar estatísticas (opcional - para garantir que os números estejam corretos)
-- Este comando pode ser executado periodicamente para manter as estatísticas atualizadas
-- UPDATE imoveis SET destaque = 1 WHERE id IN (1, 2, 3);
