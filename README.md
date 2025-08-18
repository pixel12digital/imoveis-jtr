# 🏠 JTR Imóveis - Sistema de Gestão Imobiliária

Sistema completo de gestão imobiliária desenvolvido em PHP, inspirado no design e funcionalidades do NLS Imóveis. Sistema moderno, responsivo e totalmente funcional para imobiliárias.

## ✨ Características Principais

- **Sistema Completo**: Frontend, backend e painel administrativo
- **Design Responsivo**: Funciona perfeitamente em todos os dispositivos
- **Filtros Avançados**: Sistema de busca com múltiplos critérios
- **Gestão de Imóveis**: CRUD completo com galeria de fotos
- **Painel Administrativo**: Dashboard para gestão da imobiliária
- **Sistema de Contatos**: Gestão de leads e clientes
- **Integração WhatsApp**: Botão flutuante para contato direto
- **SEO Otimizado**: Meta tags e estrutura semântica

## 🚀 Tecnologias Utilizadas

- **Backend**: PHP 7.4+ (compatível com GoDaddy)
- **Banco de Dados**: MySQL 5.7+ / MariaDB 10.2+
- **Frontend**: HTML5, CSS3, JavaScript (ES6+)
- **Framework CSS**: Bootstrap 5.3
- **Ícones**: Font Awesome 6.4
- **Servidor**: Apache (mod_rewrite habilitado)

## 📋 Requisitos do Sistema

### Servidor
- PHP 7.4 ou superior
- MySQL 5.7 ou superior / MariaDB 10.2+
- Apache com mod_rewrite habilitado
- Extensões PHP: PDO, PDO_MySQL, GD (para imagens)

### Cliente
- Navegador moderno (Chrome, Firefox, Safari, Edge)
- JavaScript habilitado
- Conexão com internet para CDNs

## 🛠️ Instalação

### 1. Preparar o Ambiente
```bash
# Clonar o repositório
git clone https://github.com/seu-usuario/jtr-imoveis.git
cd jtr-imoveis

# Configurar permissões
chmod 755 uploads/
chmod 644 config/*.php
chmod 644 .htaccess
```

### 2. Configurar Banco de Dados
```sql
-- Importar o arquivo database/schema.sql
mysql -u root -p < database/schema.sql
```

### 3. Configurar Conexão
Editar `config/database.php`:
```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'jtr_imoveis');
define('DB_USER', 'seu_usuario');
define('DB_PASS', 'sua_senha');
```

**⚠️ IMPORTANTE**: O sistema está configurado para usar banco remoto da Hostinger por padrão.
Para usar banco local, altere as configurações em `config/database.php`.

### 4. Configurar Site
Editar `config/config.php`:
```php
define('SITE_NAME', 'Sua Imobiliária');
define('SITE_EMAIL', 'contato@seusite.com');
define('SITE_PHONE', '(11) 99999-9999');
```
**Nota**: A URL do site é detectada automaticamente, não precisa configurar.

### 5. Acessar o Sistema
- **Frontend**: `http://seusite.com/`
- **Admin**: `http://seusite.com/admin/`
- **Login padrão**: admin@jtrimoveis.com.br / admin123

## 🏗️ Estrutura do Projeto

```
jtr-imoveis/
├── admin/                 # Painel administrativo
├── assets/               # Arquivos estáticos
│   ├── css/             # Estilos CSS
│   ├── js/              # JavaScript
│   └── images/          # Imagens
├── config/               # Configurações
├── database/             # Scripts do banco
├── includes/             # Arquivos incluídos
├── pages/                # Páginas do sistema
├── uploads/              # Uploads de imagens
├── index.php             # Arquivo principal
└── README.md             # Documentação
```

## 📱 Funcionalidades

### Frontend
- **Página Inicial**: Hero section, estatísticas, imóveis em destaque
- **Listagem de Imóveis**: Grid responsivo com filtros
- **Detalhes do Imóvel**: Galeria de fotos, características, contato
- **Sistema de Busca**: Filtros por tipo, preço, localização
- **Formulário de Contato**: Captura de leads
- **Páginas Institucionais**: Sobre, contato

### Backend
- **Gestão de Usuários**: Administradores e corretores
- **CRUD de Imóveis**: Cadastro, edição, exclusão
- **Upload de Imagens**: Galeria com múltiplas fotos
- **Gestão de Clientes**: Cadastro e histórico
- **Sistema de Contatos**: Gestão de leads
- **Relatórios**: Estatísticas e métricas

## 🔧 Configurações

### Personalização de Cores
Editar `assets/css/style.css`:
```css
:root {
    --primary-color: #0d6efd;    /* Cor principal */
    --secondary-color: #6c757d;  /* Cor secundária */
    /* ... outras cores ... */
}
```

### Caminhos Automáticos
O sistema detecta automaticamente todos os caminhos:
- **Desenvolvimento**: `http://localhost/jtr-imoveis/`
- **Produção**: `https://seusite.com/`
- **Subdiretórios**: Funciona em qualquer pasta

### Configuração de WhatsApp
Editar `includes/footer.php`:
```php
<a href="https://wa.me/5511999999999?text=Olá! Gostaria de saber mais sobre imóveis.">
```

### Configuração de Redes Sociais
Editar `includes/header.php` e `includes/footer.php`:
```php
<a href="https://facebook.com/sua-imobiliaria">
<a href="https://instagram.com/sua-imobiliaria">
```

## 📊 Banco de Dados

### Configuração Atual
- **✅ BANCO REMOTO**: Sistema configurado para usar banco da Hostinger
- **Host**: auth-db1607.hstgr.io
- **Database**: u342734079_jtrimoveis
- **Usuário**: u342734079_jtrimoveis
- **Status**: Operacional e testado

### Tabelas Principais
- **usuarios**: Administradores e corretores
- **imoveis**: Cadastro de imóveis
- **fotos_imovel**: Galeria de fotos
- **clientes**: Cadastro de clientes
- **contatos**: Formulários de contato
- **tipos_imovel**: Tipos de imóveis
- **localizacoes**: Cidades e bairros

### Relacionamentos
- Imóveis → Tipos, Localizações, Usuários
- Fotos → Imóveis
- Clientes → Usuários
- Contatos → Independente

### Dados Iniciais
- **1 usuário administrador** (admin@jtrimoveis.com.br / admin123)
- **6 tipos de imóvel** configurados
- **5 localizações** (São Paulo e Campinas)
- **9 características** de imóveis
- **2 imóveis de exemplo** para demonstração

## 🚀 Deploy na GoDaddy

### 1. Upload dos Arquivos
- Fazer upload via FTP ou cPanel File Manager
- Manter a estrutura de pastas

### 2. Configurar Banco de Dados
- Criar banco MySQL no cPanel
- Importar `database/schema.sql`
- Atualizar `config/database.php`

### 3. Configurar Domínio
- A URL é detectada automaticamente
- Configurar SSL (recomendado)

### 4. Testar Funcionalidades
- Verificar uploads de imagens
- Testar formulários
- Validar responsividade

## 🌐 Deploy na Hostinger

### 1. Upload dos Arquivos
- Fazer upload via File Manager da Hostinger
- Manter a estrutura de pastas

### 2. Banco de Dados Remoto
- **✅ JÁ CONFIGURADO**: Sistema usa banco remoto da Hostinger
- **Host**: auth-db1607.hstgr.io
- **Database**: u342734079_jtrimoveis
- **Usuário**: u342734079_jtrimoveis

### 3. Configurar Domínio
- A URL é detectada automaticamente
- Configurar SSL (recomendado)

### 4. Testar Funcionalidades
- **✅ SISTEMA TESTADO**: Todas as funcionalidades validadas
- Uploads de imagens funcionando
- Formulários operacionais
- Responsividade validada
- Painel administrativo funcional

## 🔒 Segurança

- **Validação de Inputs**: Função `cleanInput()` para sanitização
- **Prepared Statements**: Prevenção de SQL Injection
- **Sessões Seguras**: Configurações de segurança
- **Upload Seguro**: Validação de tipos e tamanhos de arquivo
- **Controle de Acesso**: Sistema de níveis de usuário

## 📱 Responsividade

- **Mobile First**: Design otimizado para dispositivos móveis
- **Bootstrap 5**: Framework responsivo
- **CSS Grid/Flexbox**: Layouts modernos
- **Touch Friendly**: Botões e interações otimizadas

## 🔍 SEO

- **Meta Tags**: Title, description, keywords
- **Open Graph**: Compartilhamento em redes sociais
- **URLs Amigáveis**: Estrutura semântica
- **Schema.org**: Marcação estruturada
- **Sitemap**: Mapa do site para indexação

## 🧪 Testes

### Funcionalidades a Testar
- [x] Cadastro de imóveis
- [x] Upload de imagens
- [x] Sistema de filtros
- [x] Formulário de contato
- [x] Painel administrativo
- [x] Responsividade mobile
- [x] Integração WhatsApp

**✅ SISTEMA TOTALMENTE TESTADO**: Todas as funcionalidades foram validadas e estão funcionando perfeitamente com o banco remoto da Hostinger.

### Navegadores Suportados
- Chrome 90+
- Firefox 88+
- Safari 14+
- Edge 90+

## 📈 Próximas Funcionalidades

- [ ] Sistema de agendamento de visitas
- [ ] Integração com APIs de corretores
- [ ] Sistema de newsletter
- [ ] Blog integrado
- [ ] Área do cliente
- [ ] Sistema de avaliações
- [ ] Integração com Google Maps
- [ ] Sistema de notificações push

## 🎯 Status Atual do Projeto

### ✅ **SISTEMA COMPLETAMENTE FUNCIONAL**
- **Banco de dados**: Configurado e testado na Hostinger
- **Todas as funcionalidades**: Validadas e operacionais
- **Ambiente de produção**: Pronto para uso
- **Documentação**: Atualizada e completa

### 🚀 **PRONTO PARA PRODUÇÃO**
O sistema está 100% funcional e pode ser usado imediatamente em produção.
Todas as funcionalidades foram testadas e validadas com o banco remoto.

## 🤝 Contribuição

1. Fork o projeto
2. Crie uma branch para sua feature (`git checkout -b feature/AmazingFeature`)
3. Commit suas mudanças (`git commit -m 'Add some AmazingFeature'`)
4. Push para a branch (`git push origin feature/AmazingFeature`)
5. Abra um Pull Request

## 📄 Licença

Este projeto está sob a licença MIT. Veja o arquivo `LICENSE` para mais detalhes.

## 📞 Suporte

- **Email**: suporte@jtrimoveis.com.br
- **Documentação**: [Wiki do Projeto](link-para-wiki)
- **Issues**: [GitHub Issues](link-para-issues)

## 🙏 Agradecimentos

- Inspirado no design do [NLS Imóveis](https://nlsimoveis.com.br/)
- Comunidade PHP e Bootstrap
- Contribuidores e testadores

---

**Desenvolvido com ❤️ para sua imobiliária**

*JTR Imóveis - Realizando Sonhos*
