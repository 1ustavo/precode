Mini E-commerce com Integração API

Sistema de loja online desenvolvido com PHP, PostgreSQL e JavaScript, com foco em integração com APIs externas.

Funcionalidades

- Cadastro de produtos
- Listagem de produtos
- Criação de pedidos
- Aprovação e cancelamento de pedidos
- Integração com API externa (e-commerce)
- Autenticação de usuário (login)
- Proteção contra SQL Injection (Prepared Statements)

Tecnologias

- PHP
- PostgreSQL
- JavaScript
- HTML/CSS

Segurança

- Uso de Prepared Statements (PDO)
- Validação e sanitização de entrada de dados
- Autenticação de usuários

Integração API

- O sistema realiza integração com API externa para sincronização de pedidos e produtos.

Exemplo de integração

- Envio de pedidos para API externa
- Consumo de dados via cURL
- Tratamento de respostas e erros

Diferenciais do projeto

- Implementação de integração com API externa
- Boas práticas de segurança (PDO + validação)
- Estrutura modularizada para fácil manutenção

## Estrutura (organizada)

Este projeto roda direto no XAMPP (document root no próprio repositório), então os arquivos PHP na raiz continuam existindo como **entrypoints**.
O código “de verdade” está sendo migrado para `app/` (orientado a objetos), mantendo compatibilidade com os scripts antigos.

- `app/`
  - `bootstrap.php`: autoloader simples (sem Composer)
  - `Support/Config.php`: loader de configs (`config/*.php`)
  - `Services/`: classes de integração (ex.: `ReplicaDeApi`)
- `config/`
  - `api.php`: URLs + header de autenticação (centralizado)
  - `app.php`: configs gerais do app
- `services/`
  - wrappers compatíveis com o legado (ex.: `ApiService.php` expõe `enviarProdutoParaApi()`)
- `helpers/`
  - utilitários (ex.: gerador de SKU/EAN)
- `styles.css`
  - design system (cores, botões, forms, tabelas, header/nav)
