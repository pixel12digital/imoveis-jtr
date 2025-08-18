-- Arquivo para atualizar senha do administrador para testes
-- ATENÇÃO: Use apenas em ambiente de desenvolvimento!

USE jtr_imoveis;

-- Atualizar senha do administrador para "123456" (sem criptografia)
UPDATE usuarios 
SET senha = '123456' 
WHERE email = 'admin@jtrimoveis.com.br' AND nivel = 'admin';

-- Verificar se foi atualizado
SELECT id, nome, email, senha, nivel FROM usuarios WHERE email = 'admin@jtrimoveis.com.br';

-- Comentário: Esta senha é apenas para testes. Em produção, sempre use password_hash()
