# CRUD de Produtos com PHP, MySQL e Docker Compose

## 1. Descrição do projeto

Aplicação web simples de CRUD (Create, Read, Update, Delete) desenvolvida em **PHP puro** (sem framework), utilizando **MySQL** como banco de dados relacional. Todo o ambiente é orquestrado com **Docker Compose**, containerizando tanto a aplicação quanto o banco de dados.

A entidade escolhida foi **Produto**, com os seguintes campos:

- `id` — chave primária, auto incremento
- `nome` — nome do produto (varchar)
- `descricao` — descrição do produto (texto)
- `preco` — preço do produto (decimal)
- `data_cadastro` — data/hora de cadastro (datetime, preenchida automaticamente)

## 2. Pré-requisitos

- [Docker](https://www.docker.com/) instalado
- [Docker Compose](https://docs.docker.com/compose/) instalado (já vem incluso no Docker Desktop)

Não é necessário ter PHP ou MySQL instalados na máquina — tudo roda dentro dos containers.

## 3. Passo a passo para executar o projeto

1. **Clonar o repositório:**
   ```bash
   git clone <URL_DO_REPOSITORIO>
   cd <nome-da-pasta>
   ```

2. **Subir os containers:**
   ```bash
   docker-compose up -d
   ```

3. **Criação da tabela no banco:** a tabela `produtos` é criada **automaticamente pelo código PHP**. O arquivo `app/db.php` executa um comando `CREATE TABLE IF NOT EXISTS` toda vez que a aplicação se conecta ao banco — ou seja, na primeira requisição feita ao subir os containers, a tabela já é criada sozinha, sem necessidade de rodar nenhum script SQL manualmente.

4. **Acessar a aplicação:** abra o navegador em [http://localhost:8080](http://localhost:8080)

5. **Para parar os containers:**
   ```bash
   docker-compose down
   ```
   (os dados do banco continuam salvos no volume `db_data`, mesmo depois de parar os containers)

## 4. Explicação detalhada do `docker-compose.yml`

O arquivo declara dois serviços:

- **`app`**: container que roda a aplicação PHP, usando a imagem oficial `php:8.2-apache` (PHP já integrado ao servidor Apache). A pasta local `./app` é montada dentro do container em `/var/www/html`, que é o diretório servido pelo Apache. A porta `8080` da máquina host é mapeada para a porta `80` do container, permitindo o acesso via navegador.

- **`db`**: container do banco de dados, usando a imagem oficial `mysql:8.0`. Um volume nomeado (`db_data`) é associado ao diretório interno `/var/lib/mysql`, garantindo que os dados não sejam perdidos quando o container é recriado.

**Variáveis de ambiente utilizadas** (definidas diretamente no `docker-compose.yml`, sem uso de `.env`):

| Variável | Serviço | Função |
|---|---|---|
| `DB_HOST` | app | Nome do serviço do banco (`db`), usado pelo PHP para se conectar |
| `DB_USER` | app | Usuário do banco de dados |
| `DB_PASSWORD` | app | Senha do usuário do banco |
| `DB_NAME` | app | Nome do banco de dados usado pela aplicação |
| `MYSQL_ROOT_PASSWORD` | db | Senha do usuário root do MySQL |
| `MYSQL_DATABASE` | db | Nome do banco criado automaticamente na inicialização do MySQL |

**Rede criada:** foi definida uma rede personalizada do tipo `bridge` chamada `minha-rede`. Ambos os serviços (`app` e `db`) estão conectados a ela, o que permite que o container `app` se comunique com o container `db` simplesmente usando o nome do serviço (`db`) como se fosse um hostname — sem precisar descobrir ou fixar um endereço IP.

## 5. Pontos interessantes observados pela dupla

- Utilizar variáveis de ambiente diretamente no `docker-compose.yml` facilita a mudança de configuração (usuário, senha, nome do banco) sem precisar alterar nenhuma linha do código PHP.
- O volume nomeado (`db_data`) garante que os dados do banco persistam mesmo que os containers sejam removidos e recriados com `docker-compose down` e `docker-compose up` novamente.
- Criar uma rede `bridge` isolada (`minha-rede`) permite que os containers se comuniquem entre si pelo nome do serviço, em vez de depender de endereços IP fixos, o que deixa a configuração mais simples e portátil.
- Usar `CREATE TABLE IF NOT EXISTS` no próprio código PHP elimina a necessidade de rodar scripts SQL manuais: o banco fica pronto para uso assim que a aplicação recebe a primeira requisição.

## 6. Autores

- Bruno Peclat Barbosa - 250291
- Nome completo 2

---

**Estrutura do projeto:**

```
.
├── docker-compose.yml
├── README.md
└── app/
    ├── db.php       # Conexão com o banco e criação automática da tabela
    ├── index.php    # Listagem (Read)
    ├── create.php   # Cadastro (Create)
    ├── edit.php     # Edição (Update)
    └── delete.php   # Exclusão (Delete)
```
