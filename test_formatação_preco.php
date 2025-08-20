<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teste Formatação de Preços - JTR Imóveis</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .test-section {
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
        .price-input {
            font-family: monospace;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-5">
            <i class="fas fa-dollar-sign text-success"></i>
            Teste de Formatação de Preços em Tempo Real - Padrão Brasileiro
        </h1>

        <div class="row">
            <div class="col-md-6">
                <div class="test-section">
                                         <h4>Campo de Preço com Formatação em Tempo Real</h4>
                     <p class="text-muted">Digite valores para ver a formatação automática em tempo real</p>
                    
                    <div class="input-group mb-3">
                        <span class="input-group-text">R$</span>
                        <input type="text" class="form-control price-input" id="preco1" 
                               placeholder="0,00" value="5900000">
                    </div>
                    
                    <div class="alert alert-info">
                        <strong>Valor digitado:</strong> <span id="valor1">R$ 59.000,00</span>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="test-section">
                                         <h4>Campo de Preço com Validação e Formatação em Tempo Real</h4>
                     <p class="text-muted">Teste a formatação em tempo real e validação</p>
                    
                    <div class="input-group mb-3">
                        <span class="input-group-text">R$</span>
                        <input type="text" class="form-control price-input" id="preco2" 
                               placeholder="0,00" value="1500000">
                    </div>
                    
                    <div class="alert alert-info">
                        <strong>Valor digitado:</strong> <span id="valor2">R$ 15.000,00</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12">
                <div class="test-section">
                    <h4>Teste de Conversão</h4>
                    <p class="text-muted">Teste a conversão de valores formatados para números</p>
                    
                    <div class="row">
                        <div class="col-md-4">
                            <label class="form-label">Valor Formatado:</label>
                            <input type="text" class="form-control" id="valorFormatado" 
                                   value="1.250.000,50" readonly>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Valor Numérico:</label>
                            <input type="text" class="form-control" id="valorNumerico" readonly>
                        </div>
                        <div class="col-md-4">
                            <button class="btn btn-primary mt-4" onclick="testarConversao()">
                                Testar Conversão
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12">
                <div class="test-section">
                    <h4>Instruções de Uso</h4>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <strong>Formatação inteligente:</strong> Formatação suave que não interfere na digitação
                        </li>
                        <li class="list-group-item">
                            <strong>Formato:</strong> Pontos para milhares (1.000.000) e vírgula para decimais (1.000,50)
                        </li>
                        <li class="list-group-item">
                            <strong>Foco:</strong> Ao clicar no campo, a formatação é removida para facilitar a edição
                        </li>
                        <li class="list-group-item">
                            <strong>Envio:</strong> O valor é automaticamente convertido para número antes do envio
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Função para formatar preço em tempo real durante a digitação (versão suave)
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

        // Função para formatar preço no padrão brasileiro
        function formatPriceForInput(value) {
            let cleanValue = String(value).replace(/[^\d,]/g, '');
            cleanValue = cleanValue.replace(',', '.');
            let number = parseFloat(cleanValue);
            
            if (isNaN(number)) {
                return '';
            }
            
            return number.toLocaleString('pt-BR', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        }

        // Função para converter preço formatado para número
        function convertFormattedPriceToNumber(formattedPrice) {
            const cleanValue = formattedPrice.replace(/\./g, '').replace(',', '.');
            return parseFloat(cleanValue) || 0;
        }

        // Configurar formatação para os campos de preço
        function setupPriceFormatting() {
            const priceInputs = document.querySelectorAll('#preco1, #preco2');
            
            priceInputs.forEach((input, index) => {
                // Formatar valor inicial
                if (input.value) {
                    input.value = formatPriceForInput(input.value);
                    updateDisplay(index + 1, input.value);
                }
                
                // Formatar ao perder o foco
                input.addEventListener('blur', function() {
                    if (this.value) {
                        this.value = formatPriceForInput(this.value);
                        updateDisplay(index + 1, this.value);
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
                
                // Remover formatação ao ganhar foco
                input.addEventListener('focus', function() {
                    if (this.value) {
                        this.value = this.value.replace(/\./g, '').replace(',', '.');
                    }
                });
            });
        }

        // Atualizar display dos valores
        function updateDisplay(index, value) {
            const display = document.getElementById(`valor${index}`);
            if (display) {
                display.textContent = `R$ ${value}`;
            }
        }

        // Testar conversão
        function testarConversao() {
            const valorFormatado = document.getElementById('valorFormatado').value;
            const valorNumerico = convertFormattedPriceToNumber(valorFormatado);
            document.getElementById('valorNumerico').value = valorNumerico;
        }

        // Inicializar quando a página carregar
        document.addEventListener('DOMContentLoaded', function() {
            setupPriceFormatting();
            
            // Formatar valores iniciais
            const preco1 = document.getElementById('preco1');
            const preco2 = document.getElementById('preco2');
            
            if (preco1.value) {
                preco1.value = formatPriceForInput(preco1.value);
                updateDisplay(1, preco1.value);
            }
            
            if (preco2.value) {
                preco2.value = formatPriceForInput(preco2.value);
                updateDisplay(2, preco2.value);
            }
        });
    </script>
</body>
</html>
