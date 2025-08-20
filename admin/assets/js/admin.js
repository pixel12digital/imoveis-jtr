/**
 * JTR Imóveis - Painel Administrativo
 * JavaScript principal para funcionalidades do admin
 */

document.addEventListener('DOMContentLoaded', function() {
    
    // ===== INICIALIZAÇÃO =====
    initializeAdmin();
    
    // ===== EVENT LISTENERS =====
    setupEventListeners();
    
    // ===== FUNCIONALIDADES RESPONSIVAS =====
    setupResponsiveFeatures();
    
    // ===== CONFIRMAÇÕES E ALERTAS =====
    setupConfirmations();
    
    // ===== TOOLTIPS E POPOVERS =====
    setupTooltips();
    
    // ===== VALIDAÇÕES DE FORMULÁRIO =====
setupFormValidations();

// ===== FORMATAÇÃO DE PREÇOS =====
setupPriceFormatting();
    
    // ===== UPLOAD DE ARQUIVOS =====
    setupFileUploads();
    
    // ===== NOTIFICAÇÕES =====
    setupNotifications();
    
    // ===== DASHBOARD CHARTS =====
    setupDashboardCharts();
});

/**
 * Inicialização principal do painel admin
 */
function initializeAdmin() {
    console.log('JTR Imóveis Admin - Inicializando...');
    
    // Verificar se há mensagens de sucesso/erro para mostrar
    showStoredMessages();
    
    // Inicializar componentes Bootstrap
    initializeBootstrapComponents();
    
    // Configurar tema escuro/claro se disponível
    setupThemeToggle();
    
    // Inicializar sidebar mobile
    initializeMobileSidebar();
}

/**
 * Configurar event listeners
 */
function setupEventListeners() {
    
    // Toggle sidebar mobile
    const sidebarToggle = document.querySelector('.sidebar-toggle');
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', toggleMobileSidebar);
    }
    
    // Fechar sidebar ao clicar fora (mobile)
    document.addEventListener('click', function(e) {
        const sidebar = document.querySelector('.sidebar');
        const sidebarToggle = document.querySelector('.sidebar-toggle');
        
        if (window.innerWidth <= 768 && 
            sidebar && 
            !sidebar.contains(e.target) && 
            !sidebarToggle.contains(e.target)) {
            sidebar.classList.remove('show');
        }
    });
    
    // Filtros de busca em tempo real
    const searchInputs = document.querySelectorAll('.search-input');
    searchInputs.forEach(input => {
        input.addEventListener('input', debounce(handleSearch, 300));
    });
    
    // Filtros de status
    const statusFilters = document.querySelectorAll('.status-filter');
    statusFilters.forEach(filter => {
        filter.addEventListener('change', handleStatusFilter);
    });
    
    // Paginação
    const paginationLinks = document.querySelectorAll('.pagination .page-link');
    paginationLinks.forEach(link => {
        link.addEventListener('click', handlePagination);
    });
    
    // Botões de ação
    const actionButtons = document.querySelectorAll('.action-btn');
    actionButtons.forEach(btn => {
        btn.addEventListener('click', handleActionButton);
    });
}

/**
 * Funcionalidades responsivas
 */
function setupResponsiveFeatures() {
    
    // Ajustar layout baseado no tamanho da tela
    function adjustLayout() {
        const sidebar = document.querySelector('.sidebar');
        const main = document.querySelector('main');
        
        if (window.innerWidth <= 768) {
            if (sidebar) sidebar.classList.remove('show');
            if (main) main.style.marginLeft = '0';
        } else {
            if (sidebar) sidebar.classList.remove('show');
            if (main) main.style.marginLeft = '';
        }
    }
    
    // Executar no carregamento e no redimensionamento
    adjustLayout();
    window.addEventListener('resize', debounce(adjustLayout, 250));
    
    // Sidebar mobile
    initializeMobileSidebar();
}

/**
 * Inicializar sidebar mobile
 */
function initializeMobileSidebar() {
    const sidebar = document.querySelector('.sidebar');
    const sidebarToggle = document.querySelector('.sidebar-toggle');
    
    if (!sidebar || !sidebarToggle) return;
    
    // Criar botão toggle se não existir
    if (!document.querySelector('.sidebar-toggle')) {
        const toggleBtn = document.createElement('button');
        toggleBtn.className = 'btn btn-primary d-md-none sidebar-toggle';
        toggleBtn.innerHTML = '<i class="fas fa-bars"></i>';
        toggleBtn.style.position = 'fixed';
        toggleBtn.style.top = '70px';
        toggleBtn.style.left = '10px';
        toggleBtn.style.zIndex = '1001';
        document.body.appendChild(toggleBtn);
    }
}

/**
 * Toggle sidebar mobile
 */
function toggleMobileSidebar() {
    const sidebar = document.querySelector('.sidebar');
    if (sidebar) {
        sidebar.classList.toggle('show');
    }
}

/**
 * Configurar confirmações
 */
function setupConfirmations() {
    
    // Confirmação para exclusões
    const deleteButtons = document.querySelectorAll('.btn-delete, .btn-excluir');
    deleteButtons.forEach(btn => {
        btn.addEventListener('click', function(e) {
            if (!confirm('Tem certeza que deseja excluir este item? Esta ação não pode ser desfeita.')) {
                e.preventDefault();
                return false;
            }
            
            // Mostrar loading
            showLoading(this);
        });
    });
    
    // Confirmação para alterações de status
    const statusButtons = document.querySelectorAll('.btn-status');
    statusButtons.forEach(btn => {
        btn.addEventListener('click', function(e) {
            const action = this.dataset.action;
            const itemName = this.dataset.itemName || 'item';
            
            if (!confirm(`Tem certeza que deseja ${action} este ${itemName}?`)) {
                e.preventDefault();
                return false;
            }
        });
    });
}

/**
 * Configurar tooltips
 */
function setupTooltips() {
    // Inicializar tooltips Bootstrap
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    // Inicializar popovers Bootstrap
    const popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
    popoverTriggerList.map(function (popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl);
    });
}

/**
 * Configurar validações de formulário
 */
function setupFormValidations() {
    
    const forms = document.querySelectorAll('.needs-validation');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!form.checkValidity()) {
                e.preventDefault();
                e.stopPropagation();
            }
            
            form.classList.add('was-validated');
        });
    });
    
    // Validação de campos específicos
    const requiredFields = document.querySelectorAll('[required]');
    requiredFields.forEach(field => {
        field.addEventListener('blur', validateField);
        field.addEventListener('input', clearFieldError);
    });
}

/**
 * Validar campo individual
 */
function validateField(e) {
    const field = e.target;
    const value = field.value.trim();
    
    if (field.hasAttribute('required') && !value) {
        showFieldError(field, 'Este campo é obrigatório');
    } else if (field.type === 'email' && value && !isValidEmail(value)) {
        showFieldError(field, 'Email inválido');
    } else if (field.type === 'tel' && value && !isValidPhone(value)) {
        showFieldError(field, 'Telefone inválido');
    } else {
        clearFieldError(field);
    }
}

/**
 * Mostrar erro no campo
 */
function showFieldError(field, message) {
    clearFieldError(field);
    
    const errorDiv = document.createElement('div');
    errorDiv.className = 'invalid-feedback';
    errorDiv.textContent = message;
    
    field.classList.add('is-invalid');
    field.parentNode.appendChild(errorDiv);
}

/**
 * Limpar erro do campo
 */
function clearFieldError(field) {
    field.classList.remove('is-invalid');
    const errorDiv = field.parentNode.querySelector('.invalid-feedback');
    if (errorDiv) {
        errorDiv.remove();
    }
}

/**
 * Configurar upload de arquivos
 */
function setupFileUploads() {
    console.log('DEBUG: setupFileUploads chamada');
    
    const fileInputs = document.querySelectorAll('.file-upload');
    console.log('DEBUG: File inputs encontrados:', fileInputs.length);
    
    fileInputs.forEach((input, index) => {
        console.log('DEBUG: Configurando input', index, ':', input);
        input.addEventListener('change', handleFileUpload);
    });
    
    // Drag and drop para upload
    const dropZones = document.querySelectorAll('.drop-zone');
    console.log('DEBUG: Drop zones encontradas:', dropZones.length);
    
    dropZones.forEach((zone, index) => {
        console.log('DEBUG: Configurando drop zone', index, ':', zone);
        zone.addEventListener('dragover', handleDragOver);
        zone.addEventListener('drop', handleDrop);
        zone.addEventListener('dragleave', handleDragLeave);
    });
    
    console.log('DEBUG: setupFileUploads concluído');
}

/**
 * Manipular upload de arquivo
 */
function handleFileUpload(e) {
    console.log('DEBUG: handleFileUpload chamada');
    
    const input = e.target;
    const files = input.files;
    
    console.log('DEBUG: Arquivos selecionados:', files.length);
    console.log('DEBUG: Input:', input);
    console.log('DEBUG: Parent node:', input.parentNode);
    
    // Buscar o preview de forma mais robusta
    let preview = input.parentNode.querySelector('.file-preview');
    
    // Se não encontrar no parent, buscar em todo o documento
    if (!preview) {
        preview = document.querySelector('.file-preview');
        console.log('DEBUG: Preview encontrado no documento:', preview);
    }
    
    // Se ainda não encontrar, criar o preview
    if (!preview) {
        console.log('DEBUG: Criando preview dinamicamente');
        preview = document.createElement('div');
        preview.className = 'file-preview mt-3';
        input.parentNode.appendChild(preview);
    }
    
    console.log('DEBUG: Preview final:', preview);
    
    if (files.length > 0) {
        // Limpar preview anterior
        if (preview) {
            preview.innerHTML = '';
            console.log('DEBUG: Preview limpo');
        }
        
        // Processar cada arquivo
        Array.from(files).forEach((file, index) => {
            console.log('DEBUG: Processando arquivo:', file.name, 'Tipo:', file.type, 'Tamanho:', file.size);
            
            // Validar tipo de arquivo
            if (!isValidFileType(file)) {
                console.log('DEBUG: Arquivo inválido:', file.name);
                showNotification(`Tipo de arquivo não suportado: ${file.name}`, 'error');
                return;
            }
            
            // Validar tamanho
            if (file.size > 5 * 1024 * 1024) { // 5MB
                console.log('DEBUG: Arquivo muito grande:', file.name);
                showNotification(`Arquivo muito grande: ${file.name}. Máximo 5MB`, 'error');
                return;
            }
            
            // Mostrar preview para imagens
            if (preview && file.type.startsWith('image/')) {
                console.log('DEBUG: Criando preview para imagem:', file.name);
                
                const reader = new FileReader();
                reader.onload = function(e) {
                    console.log('DEBUG: FileReader carregado para:', file.name);
                    
                    const previewItem = document.createElement('div');
                    previewItem.className = 'preview-item d-inline-block me-3 mb-3';
                    previewItem.style.cssText = 'position: relative;';
                    
                    previewItem.innerHTML = `
                        <img src="${e.target.result}" class="img-thumbnail" style="max-width: 150px; max-height: 150px; object-fit: cover;">
                        <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0" 
                                style="transform: translate(50%, -50%);" 
                                onclick="removeFile(this, ${index})">
                            <i class="fas fa-times"></i>
                        </button>
                    `;
                    
                    preview.appendChild(previewItem);
                    console.log('DEBUG: Preview item adicionado para:', file.name);
                };
                
                reader.onerror = function() {
                    console.error('DEBUG: Erro no FileReader para:', file.name);
                };
                
                reader.readAsDataURL(file);
            } else {
                console.log('DEBUG: Não é imagem ou preview não encontrado:', file.type, preview);
            }
        });
        
        showNotification(`${files.length} arquivo(s) selecionado(s) com sucesso`, 'success');
    }
}

/**
 * Configurar notificações
 */
function setupNotifications() {
    
    // Criar container de notificações se não existir
    if (!document.querySelector('.notifications-container')) {
        const container = document.createElement('div');
        container.className = 'notifications-container';
        container.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            max-width: 400px;
        `;
        document.body.appendChild(container);
    }
}

/**
 * Mostrar notificação
 */
function showNotification(message, type = 'info', duration = 5000) {
    const container = document.querySelector('.notifications-container');
    if (!container) return;
    
    const notification = document.createElement('div');
    notification.className = `alert alert-${type} alert-dismissible fade show`;
    notification.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    container.appendChild(notification);
    
    // Auto-remover após duração
    setTimeout(() => {
        if (notification.parentNode) {
            notification.remove();
        }
    }, duration);
    
    // Remover ao fechar
    notification.querySelector('.btn-close').addEventListener('click', () => {
        notification.remove();
    });
}

/**
 * Configurar gráficos do dashboard
 */
function setupDashboardCharts() {
    
    // Verificar se Chart.js está disponível
    if (typeof Chart !== 'undefined') {
        setupImoveisChart();
        setupContatosChart();
    }
}

/**
 * Configurar gráfico de imóveis
 */
function setupImoveisChart() {
    const ctx = document.getElementById('imoveisChart');
    if (!ctx) return;
    
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Disponível', 'Vendido', 'Alugado', 'Reservado'],
            datasets: [{
                data: [12, 19, 3, 5],
                backgroundColor: [
                    '#1cc88a',
                    '#e74a3b',
                    '#f6c23e',
                    '#36b9cc'
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
}

/**
 * Configurar gráfico de contatos
 */
function setupContatosChart() {
    const ctx = document.getElementById('contatosChart');
    if (!ctx) return;
    
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun'],
            datasets: [{
                label: 'Contatos',
                data: [65, 59, 80, 81, 56, 55],
                borderColor: '#4e73df',
                backgroundColor: 'rgba(78, 115, 223, 0.1)',
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
}

/**
 * Mostrar mensagens armazenadas
 */
function showStoredMessages() {
    // Verificar mensagens na sessão (PHP)
    const successMessage = document.querySelector('.alert-success');
    const errorMessage = document.querySelector('.alert-danger');
    
    if (successMessage) {
        showNotification(successMessage.textContent, 'success');
        successMessage.remove();
    }
    
    if (errorMessage) {
        showNotification(errorMessage.textContent, 'error');
        errorMessage.remove();
    }
}

/**
 * Inicializar componentes Bootstrap
 */
function initializeBootstrapComponents() {
    // Inicializar dropdowns
    const dropdowns = document.querySelectorAll('.dropdown-toggle');
    dropdowns.forEach(dropdown => {
        new bootstrap.Dropdown(dropdown);
    });
    
    // Inicializar modais
    const modals = document.querySelectorAll('.modal');
    modals.forEach(modal => {
        new bootstrap.Modal(modal);
    });
    
    // Inicializar tabs
    const tabs = document.querySelectorAll('[data-bs-toggle="tab"]');
    tabs.forEach(tab => {
        new bootstrap.Tab(tab);
    });
}

/**
 * Configurar toggle de tema
 */
function setupThemeToggle() {
    const themeToggle = document.querySelector('.theme-toggle');
    if (themeToggle) {
        themeToggle.addEventListener('click', toggleTheme);
        
        // Carregar tema salvo
        const savedTheme = localStorage.getItem('admin-theme');
        if (savedTheme) {
            document.body.setAttribute('data-theme', savedTheme);
        }
    }
}

/**
 * Toggle tema escuro/claro
 */
function toggleTheme() {
    const body = document.body;
    const currentTheme = body.getAttribute('data-theme');
    const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
    
    body.setAttribute('data-theme', newTheme);
    localStorage.setItem('admin-theme', newTheme);
    
    showNotification(`Tema alterado para ${newTheme === 'dark' ? 'escuro' : 'claro'}`, 'info');
}

/**
 * Mostrar loading
 */
function showLoading(element) {
    const originalText = element.innerHTML;
    element.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Carregando...';
    element.disabled = true;
    
    // Restaurar após 3 segundos (ou quando a operação terminar)
    setTimeout(() => {
        element.innerHTML = originalText;
        element.disabled = false;
    }, 3000);
}

/**
 * Debounce function
 */
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

/**
 * Handlers para eventos específicos
 */
function handleSearch(e) {
    const searchTerm = e.target.value;
    const searchResults = document.querySelector('.search-results');
    
    if (searchResults) {
        // Implementar busca em tempo real
        console.log('Buscando por:', searchTerm);
    }
}

function handleStatusFilter(e) {
    const status = e.target.value;
    const form = e.target.closest('form');
    
    if (form) {
        form.submit();
    }
}

function handlePagination(e) {
    e.preventDefault();
    const href = e.target.href;
    
    if (href) {
        window.location.href = href;
    }
}

function handleActionButton(e) {
    const action = e.target.dataset.action;
    const itemId = e.target.dataset.itemId;
    
    console.log('Ação:', action, 'Item:', itemId);
}

/**
 * Funções utilitárias
 */
function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

function isValidPhone(phone) {
    const phoneRegex = /^[\+]?[1-9][\d]{0,15}$/;
    return phoneRegex.test(phone.replace(/\D/g, ''));
}

function isValidFileType(file) {
    // Verificar MIME type
    const allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    if (allowedMimeTypes.includes(file.type)) {
        return true;
    }
    
    // Verificar extensão como fallback
    const allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    const fileName = file.name.toLowerCase();
    const extension = fileName.split('.').pop();
    
    return allowedExtensions.includes(extension);
}

function handleDragOver(e) {
    e.preventDefault();
    e.currentTarget.classList.add('drag-over');
}

function handleDrop(e) {
    e.preventDefault();
    e.currentTarget.classList.remove('drag-over');
    
    const files = e.dataTransfer.files;
    if (files.length > 0) {
        const input = e.currentTarget.querySelector('input[type="file"]');
        if (input) {
            // Atualizar o input com os arquivos
            input.files = files;
            
            // Disparar evento change para processar os arquivos
            const changeEvent = new Event('change', { bubbles: true });
            input.dispatchEvent(changeEvent);
            
            // Adicionar classe visual para feedback
            e.currentTarget.classList.add('drop-success');
            setTimeout(() => {
                e.currentTarget.classList.remove('drop-success');
            }, 1000);
        }
    }
}

function handleDragLeave(e) {
    e.currentTarget.classList.remove('drag-over');
}

/**
 * Remover arquivo do preview
 */
function removeFile(button, index) {
    const previewItem = button.closest('.preview-item');
    if (previewItem) {
        previewItem.remove();
        
        // Atualizar o input de arquivo
        const fileInput = document.querySelector('.file-upload');
        if (fileInput && fileInput.files.length > 0) {
            const dt = new DataTransfer();
            Array.from(fileInput.files).forEach((file, i) => {
                if (i !== index) {
                    dt.items.add(file);
                }
            });
            fileInput.files = dt.files;
        }
        
        showNotification('Arquivo removido', 'info');
    }
}

/**
 * Configurar formatação de preços no padrão brasileiro
 */
function setupPriceFormatting() {
    const priceInputs = document.querySelectorAll('input[name="preco"], input[id="preco"]');
    
    priceInputs.forEach(input => {
        // Formatar valor inicial se existir
        if (input.value) {
            input.value = formatPriceForInput(input.value);
        }
        
        // Formatar ao perder o foco
        input.addEventListener('blur', function() {
            if (this.value) {
                this.value = formatPriceForInput(this.value);
            }
        });
        
        // Formatar ao digitar em tempo real (mais suave)
        input.addEventListener('input', function() {
            // Obter o valor atual e a posição do cursor
            let currentValue = this.value;
            let cursorPosition = this.selectionStart;
            
            // Se o usuário está digitando no meio do campo, não formatar
            if (cursorPosition < currentValue.length) {
                return;
            }
            
            // Remover tudo exceto números
            let cleanValue = currentValue.replace(/[^\d]/g, '');
            
            // Se não há valor, não fazer nada
            if (!cleanValue) {
                return;
            }
            
            // Formatar em tempo real apenas se o usuário está no final
            let formattedValue = formatPriceRealTime(cleanValue);
            
            // Atualizar o campo apenas se o valor mudou e o cursor está no final
            if (formattedValue !== currentValue && cursorPosition === currentValue.length) {
                this.value = formattedValue;
                
                // Manter o cursor no final após formatação
                this.setSelectionRange(formattedValue.length, formattedValue.length);
            }
        });
        
        // Formatar ao ganhar o foco (remover formatação para edição)
        input.addEventListener('focus', function() {
            if (this.value) {
                this.value = this.value.replace(/\./g, '').replace(',', '.');
            }
        });
    });
}

/**
 * Formatar preço em tempo real durante a digitação (versão suave)
 * @param {string} value - Valor numérico limpo
 * @returns {string} - Valor formatado em tempo real
 */
function formatPriceRealTime(value) {
    // Se não há valor, retornar vazio
    if (!value) {
        return '';
    }
    
    // Converter para string e garantir que seja apenas números
    let cleanValue = String(value).replace(/[^\d]/g, '');
    
    // Se não há números, retornar vazio
    if (!cleanValue) {
        return '';
    }
    
    // Formatar em tempo real (versão mais suave)
    let formattedValue = '';
    
    // Para valores pequenos (1-2 dígitos), não adicionar formatação
    if (cleanValue.length <= 2) {
        return cleanValue;
    }
    
    // Para valores médios (3-5 dígitos), adicionar apenas vírgula
    if (cleanValue.length <= 5) {
        formattedValue = cleanValue.slice(0, -2) + ',' + cleanValue.slice(-2);
        return formattedValue;
    }
    
    // Para valores grandes (6+ dígitos), adicionar pontos e vírgula
    let tempValue = cleanValue;
    
    // Adicionar vírgula para decimais
    if (tempValue.length > 2) {
        tempValue = tempValue.slice(0, -2) + ',' + tempValue.slice(-2);
    }
    
    // Adicionar pontos para milhares (apenas se necessário)
    if (tempValue.length > 6) { // Mais de 999,99
        let parts = tempValue.split(',');
        let integerPart = parts[0];
        let decimalPart = parts[1] || '';
        
        // Adicionar pontos para milhares
        let formattedInteger = '';
        for (let i = 0; i < integerPart.length; i++) {
            if (i > 0 && (integerPart.length - i) % 3 === 0) {
                formattedInteger += '.';
            }
            formattedInteger += integerPart[i];
        }
        
        formattedValue = formattedInteger + (decimalPart ? ',' + decimalPart : '');
    } else {
        formattedValue = tempValue;
    }
    
    return formattedValue;
}

/**
 * Formatar preço para exibição no input (padrão brasileiro)
 * @param {string|number} value - Valor a ser formatado
 * @returns {string} - Valor formatado
 */
function formatPriceForInput(value) {
    // Converter para string e remover formatação existente
    let cleanValue = String(value).replace(/[^\d,]/g, '');
    
    // Substituir vírgula por ponto para cálculos
    cleanValue = cleanValue.replace(',', '.');
    
    // Converter para número
    let number = parseFloat(cleanValue);
    
    if (isNaN(number)) {
        return '';
    }
    
    // Formatar para o padrão brasileiro (pontos para milhares, vírgula para decimais)
    return number.toLocaleString('pt-BR', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    });
}

/**
 * Converter preço formatado para número (para envio do formulário)
 * @param {string} formattedPrice - Preço formatado
 * @returns {number} - Número para envio
 */
function convertFormattedPriceToNumber(formattedPrice) {
    // Remover pontos e substituir vírgula por ponto
    const cleanValue = formattedPrice.replace(/\./g, '').replace(',', '.');
    return parseFloat(cleanValue) || 0;
}

// ===== EXPORTAR FUNÇÕES PARA USO GLOBAL =====
window.AdminPanel = {
    showNotification,
    showLoading,
    toggleTheme,
    validateField,
    clearFieldError,
    formatPriceForInput,
    formatPriceRealTime,
    convertFormattedPriceToNumber
};
