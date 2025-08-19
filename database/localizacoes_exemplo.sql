-- Arquivo de localizações de exemplo para o sistema JTR Imóveis
-- Execute este arquivo para inserir localizações pré-cadastradas

USE jtr_imoveis;

-- Limpar localizações existentes (opcional - comente se quiser manter)
-- DELETE FROM localizacoes;

-- Inserir localizações de São Paulo
INSERT INTO localizacoes (cidade, bairro, estado, cep) VALUES 
('São Paulo', 'Itaim Bibi', 'SP', '01452-000'),
('São Paulo', 'Jardins', 'SP', '01234-000'),
('São Paulo', 'Moema', 'SP', '04040-000'),
('São Paulo', 'Vila Nova Conceição', 'SP', '04501-000'),
('São Paulo', 'Brooklin', 'SP', '04562-000'),
('São Paulo', 'Pinheiros', 'SP', '05422-000'),
('São Paulo', 'Vila Madalena', 'SP', '05433-000'),
('São Paulo', 'Vila Olímpia', 'SP', '04547-000'),
('São Paulo', 'Centro', 'SP', '01001-000'),
('São Paulo', 'Bela Vista', 'SP', '01315-000'),
('São Paulo', 'Consolação', 'SP', '01302-000'),
('São Paulo', 'Higienópolis', 'SP', '01238-000'),
('São Paulo', 'Perdizes', 'SP', '05016-000'),
('São Paulo', 'Vila Prudente', 'SP', '03135-000'),
('São Paulo', 'Tatuapé', 'SP', '03064-000');

-- Inserir localizações de Campinas
INSERT INTO localizacoes (cidade, bairro, estado, cep) VALUES 
('Campinas', 'Jardim Proença', 'SP', '13088-000'),
('Campinas', 'Nova Veneza', 'SP', '13087-000'),
('Campinas', 'Centro', 'SP', '13010-000'),
('Campinas', 'Nova Campinas', 'SP', '13012-000'),
('Campinas', 'Jardim Chapadão', 'SP', '13070-000'),
('Campinas', 'Taquaral', 'SP', '13076-000'),
('Campinas', 'Cambuí', 'SP', '13024-000'),
('Campinas', 'Botafogo', 'SP', '13020-000'),
('Campinas', 'Guanabara', 'SP', '13073-000'),
('Campinas', 'Jardim das Paineiras', 'SP', '13092-000');

-- Inserir localizações do Rio de Janeiro
INSERT INTO localizacoes (cidade, bairro, estado, cep) VALUES 
('Rio de Janeiro', 'Copacabana', 'RJ', '22070-000'),
('Rio de Janeiro', 'Ipanema', 'RJ', '22080-000'),
('Rio de Janeiro', 'Leblon', 'RJ', '22440-000'),
('Rio de Janeiro', 'Botafogo', 'RJ', '22250-000'),
('Rio de Janeiro', 'Flamengo', 'RJ', '22220-000'),
('Rio de Janeiro', 'Laranjeiras', 'RJ', '22240-000'),
('Rio de Janeiro', 'Catete', 'RJ', '22220-000'),
('Rio de Janeiro', 'Gloria', 'RJ', '20241-000'),
('Rio de Janeiro', 'Centro', 'RJ', '20010-000'),
('Rio de Janeiro', 'Santa Teresa', 'RJ', '20240-000');

-- Inserir localizações de Belo Horizonte
INSERT INTO localizacoes (cidade, bairro, estado, cep) VALUES 
('Belo Horizonte', 'Savassi', 'MG', '30112-000'),
('Belo Horizonte', 'Funcionários', 'MG', '30140-000'),
('Belo Horizonte', 'Lourdes', 'MG', '30180-000'),
('Belo Horizonte', 'Centro', 'MG', '30110-000'),
('Belo Horizonte', 'Pampulha', 'MG', '31365-000'),
('Belo Horizonte', 'Santa Tereza', 'MG', '31010-000'),
('Belo Horizonte', 'Floresta', 'MG', '30150-000'),
('Belo Horizonte', 'Cidade Nova', 'MG', '31170-000'),
('Belo Horizonte', 'Nova Suíça', 'MG', '30421-000'),
('Belo Horizonte', 'Gutierrez', 'MG', '30430-000');

-- Inserir localizações de Curitiba
INSERT INTO localizacoes (cidade, bairro, estado, cep) VALUES 
('Curitiba', 'Centro', 'PR', '80010-000'),
('Curitiba', 'Batel', 'PR', '80420-000'),
('Curitiba', 'Água Verde', 'PR', '80620-000'),
('Curitiba', 'Bacacheri', 'PR', '82515-000'),
('Curitiba', 'Bigorrilho', 'PR', '80730-000'),
('Curitiba', 'Boa Vista', 'PR', '82540-000'),
('Curitiba', 'Cabral', 'PR', '80035-000'),
('Curitiba', 'Cristo Rei', 'PR', '80050-000'),
('Curitiba', 'Hugo Lange', 'PR', '80040-000'),
('Curitiba', 'Jardim Botânico', 'PR', '80210-000');

-- Inserir localizações de Porto Alegre
INSERT INTO localizacoes (cidade, bairro, estado, cep) VALUES 
('Porto Alegre', 'Centro', 'RS', '90010-000'),
('Porto Alegre', 'Moinhos de Vento', 'RS', '90430-000'),
('Porto Alegre', 'Petrópolis', 'RS', '90460-000'),
('Porto Alegre', 'Boa Vista', 'RS', '91340-000'),
('Porto Alegre', 'Cidade Baixa', 'RS', '90040-000'),
('Porto Alegre', 'Floresta', 'RS', '90050-000'),
('Porto Alegre', 'Santana', 'RS', '90040-000'),
('Porto Alegre', 'Teresópolis', 'RS', '90850-000'),
('Porto Alegre', 'Vila Assunção', 'RS', '91900-000'),
('Porto Alegre', 'Vila Conceição', 'RS', '91900-000');

-- Inserir localizações de Brasília
INSERT INTO localizacoes (cidade, bairro, estado, cep) VALUES 
('Brasília', 'Asa Sul', 'DF', '70200-000'),
('Brasília', 'Asa Norte', 'DF', '70800-000'),
('Brasília', 'Lago Sul', 'DF', '71680-000'),
('Brasília', 'Lago Norte', 'DF', '71500-000'),
('Brasília', 'Sudoeste', 'DF', '70670-000'),
('Brasília', 'Noroeste', 'DF', '70690-000'),
('Brasília', 'Guará', 'DF', '71000-000'),
('Brasília', 'Taguatinga', 'DF', '72000-000'),
('Brasília', 'Ceilândia', 'DF', '72200-000'),
('Brasília', 'Samambaia', 'DF', '72300-000');

-- Inserir localizações de Salvador
INSERT INTO localizacoes (cidade, bairro, estado, cep) VALUES 
('Salvador', 'Barra', 'BA', '40140-000'),
('Salvador', 'Ondina', 'BA', '40170-000'),
('Salvador', 'Rio Vermelho', 'BA', '41950-000'),
('Salvador', 'Pituba', 'BA', '41810-000'),
('Salvador', 'Costa Azul', 'BA', '41760-000'),
('Salvador', 'Centro', 'BA', '40020-000'),
('Salvador', 'Pelourinho', 'BA', '40026-000'),
('Salvador', 'São Lázaro', 'BA', '40040-000'),
('Salvador', 'Nazaré', 'BA', '40040-000'),
('Salvador', 'Graça', 'BA', '40150-000');

-- Inserir localizações de Recife
INSERT INTO localizacoes (cidade, bairro, estado, cep) VALUES 
('Recife', 'Boa Viagem', 'PE', '51020-000'),
('Recife', 'Pina', 'PE', '51110-000'),
('Recife', 'Centro', 'PE', '50020-000'),
('Recife', 'Santo Antônio', 'PE', '50010-000'),
('Recife', 'São José', 'PE', '50020-000'),
('Recife', 'Casa Forte', 'PE', '52061-000'),
('Recife', 'Espinheiro', 'PE', '52020-000'),
('Recife', 'Graças', 'PE', '52011-000'),
('Recife', 'Parnamirim', 'PE', '52060-000'),
('Recife', 'Rosarinho', 'PE', '52020-000');

-- Inserir localizações de Fortaleza
INSERT INTO localizacoes (cidade, bairro, estado, cep) VALUES 
('Fortaleza', 'Meireles', 'CE', '60160-000'),
('Fortaleza', 'Aldeota', 'CE', '60115-000'),
('Fortaleza', 'Dionísio Torres', 'CE', '60125-000'),
('Fortaleza', 'Centro', 'CE', '60010-000'),
('Fortaleza', 'Praia de Iracema', 'CE', '60060-000'),
('Fortaleza', 'Varjota', 'CE', '60175-000'),
('Fortaleza', 'Cocó', 'CE', '60190-000'),
('Fortaleza', 'Papicu', 'CE', '60175-000'),
('Fortaleza', 'Engenheiro Luciano Cavalcante', 'CE', '60811-000'),
('Fortaleza', 'Cidade 2000', 'CE', '60190-000');

-- Verificar total de localizações inseridas
SELECT 
    COUNT(*) as total_localizacoes,
    COUNT(DISTINCT cidade) as total_cidades,
    COUNT(DISTINCT estado) as total_estados
FROM localizacoes;

-- Listar localizações por estado
SELECT 
    estado,
    COUNT(*) as total_localizacoes,
    GROUP_CONCAT(DISTINCT cidade ORDER BY cidade SEPARATOR ', ') as cidades
FROM localizacoes 
GROUP BY estado 
ORDER BY estado;
