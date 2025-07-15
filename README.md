# CRMX

O CRMX é um projeto de estudo voltado para o desenvolvimento de habilidades e compreensão de conceitos fundamentais em desenvolvimento web, utilizando frameworks e bibliotecas o mínimo possível. Trata-se de uma aplicação web para gestão simplificada de cadastros, com foco inicial no backend, organização do código, implementação de APIs e testes unitários. Futuras melhorias incluem aprimoramentos no frontend e na experiência do usuário (UX) para tornar a interface mais agradável, leve, intuitiva e fluida.

## Índice

- [Sobre o Projeto](#sobre-o-projeto)
- [Funcionalidades](#funcionalidades)
- [Tecnologias Utilizadas](#tecnologias-utilizadas)
- [Instalação](#instalação)
- [Uso](#uso)
- [Licença](#licença)
- [Contato](#contato)

## Sobre o Projeto

O CRMX é uma aplicação web desenvolvida com o objetivo de praticar conceitos fundamentais de programação e arquitetura de software. A aplicação permite gerenciar cadastros de empresas, leads, clientes, pedidos, produtos, pacotes, contratos e modelos de contratos, utilizando uma API própria. O projeto prioriza a construção de um backend robusto e organizado, com planos para melhorias futuras no frontend e UX.

## Funcionalidades

- Cadastro e gerenciamento de empresas
- Gestão de leads e clientes
- Administração de pedidos e produtos
- Gerenciamento de pacotes e contratos
- Criação e edição de modelos de contratos
- API própria para integração e manipulação de dados

## Tecnologias Utilizadas

- **PHP**: Backend e lógica da aplicação
- **JavaScript**: Interatividade no frontend
- **HTML**: Estrutura das páginas
- **CSS**: Estilização
- **MySQL**: Banco de dados relacional

## Instalação

Siga os passos abaixo para configurar o projeto localmente:

### Pré-requisitos
- PHP 7.4 ou superior
- MySQL 5.7 ou superior
- Servidor web (ex.: Apache ou Nginx)
- Git

### Passos
```bash
# Clone o repositório
git clone https://github.com/rogeriobarboza/crmx.git

# Entre no diretório do projeto
cd crmx

# Configure o banco de dados
# 1. Crie um banco de dados MySQL
# 2. Importe o arquivo de schema (disponível em /database/schema.sql, se aplicável)
mysql -u seu_usuario -p nome_do_banco < database/schema.sql

# Configure as variáveis de ambiente
# Crie um arquivo .env baseado no .env.example e ajuste as credenciais do banco
cp .env.example .env

# Instale dependências (se houver, ex.: via Composer)
composer install