# Sistema de Gestão Integrada

Este é um sistema de gestão integrado desenvolvido em HTML, CSS, JavaScript e PHP puro, com o suporte do framework Bootstrap para a interface visual. O sistema foi projetado para otimizar a administração de processos em diferentes áreas, incluindo balcão, técnicos, analista contábil fiscal e almoxarifado.

## Funcionalidades Principais

### Tela de Login
- **Campos:** Nome de usuário, Senha
- **Botões:** Entrar, Esqueci minha senha
- **Ações:** Autenticação de usuário, Redirecionamento para o dashboard

### Tela de Dashboard
- **Componentes:** Menu de navegação, Painel de resumo com KPIs e notificações
- **Ações:** Redirecionamento para seções específicas

### Tela de Cadastro de Usuários
- **Campos:** Nome, E-mail, Senha, Cargo
- **Botões:** Salvar, Cancelar
- **Ações:** Armazenamento de dados de usuário, Validação de campos

### Tela do Balcão
- **Componentes:** Lista de produtos, Formulários de checklist, avaliação de garantia e orçamento
- **Ações:** Registro de produtos, Atualização de checklists, Avaliação de garantias, Criação de orçamentos

### Tela dos Técnicos (Externo e Laboratório)
- **Componentes:** Lista de chamados, Formulários de criação de orçamento e baixa de peças
- **Ações:** Gerenciamento de chamados, Registro de peças, Criação de orçamentos, Solicitação de materiais ao almoxarifado

### Tela do Analista Contábil Fiscal
- **Componentes:** Lista de NF-e, Formulários de controle de orçamento, folha de pagamento, pagamentos e contratos
- **Ações:** Emissão de NF-e, Controle de orçamento, Registro de folha de pagamento, Registro de pagamentos, Criação de contratos

### Tela do Almoxarifado
- **Componentes:** Lista de peças e equipamentos, Formulários de recebimento de peças, contagem de estoque, pedidos de reposição
- **Ações:** Registro de recebimento de peças, Atualização de contagem de estoque, Criação de pedidos de reposição

## Banco de Dados

O sistema utiliza um banco de dados relacional para registro dos chamados, usuários e ações.

## Como Rodar o Projeto

1. **Instalação do Banco de Dados:**
    - Importe o arquivo `banco.sql` fornecido no projeto para o seu servidor MySQL.

2. **Configuração do Banco de Dados:**
    - Edite o arquivo `db.php` e configure as credenciais de conexão com o banco de dados.

3. **Registro de Usuário:**
    - Acesse a aplicação e registre um usuário através da tela de cadastro.

4. **Acesso ao Sistema:**
    - Utilize as credenciais cadastradas para acessar o sistema e explorar suas funcionalidades.


## Tecnologias Utilizadas

- **HTML/CSS/JS:** Para estrutura e interatividade.
- **PHP:** Para a lógica do servidor.
- **Bootstrap:** Para estilização e responsividade.
- **MySQL:** Para o banco de dados.

---

Este projeto foi desenvolvido para fornecer uma solução robusta e eficiente para a gestão integrada de diferentes áreas funcionais. Sinta-se à vontade para explorar e adaptar conforme necessário.
