## Gerenciador de Tarefas

Este projeto é um gerenciador de tarefas desenvolvido com Laravel. Ele permite criar, editar, excluir e listar tarefas, além de associar tarefas a categorias e filtrar tarefas por status.

### Requisitos

- **PHP 8.3.7**
- **Composer**
- **Laravel**
- **SQLITE**

## Instalação

    1.	Clone o repositório:

        cd tesk-manager


	2.	Instale as dependências:

        composer install


	3.	Crie um arquivo .env com base no .env.example:

        cp .env.example .env


	4.	Configure o banco de dados para sqlite no arquivo .env.
	5.	Execute as migrations para criar as tabelas no banco de dados:

        php artisan migrate


	6.	Popule o banco de dados com dados iniciais (opcional):

        php artisan db:seed


	7.	Inicie o servidor:

        php artisan serve


## Uso

    Criar Tarefa

        •	Acesse /tasks/create para criar uma nova tarefa.
        •	Preencha o título, descrição e selecione o status da tarefa.

    Editar Tarefa

        •	Acesse /tasks e clique em “Editar” ao lado da tarefa que deseja modificar.
        •	Altere as informações da tarefa e as categorias associadas.

    Deletar Tarefa

        •	Acesse /tasks e clique em “Deletar” ao lado da tarefa que deseja remover.

    Listar Tarefas

        •	Acesse /tasks para ver a lista de todas as tarefas.
        •	Use o filtro para visualizar tarefas por status.

