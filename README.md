# Auryn Challenge

### Etapas
- [x] Selecionar uma imagem no navegador e fazer o upload pro servidor
- [x] Enviar junto à imagem um tamanho (10x15, 12x15, 13x18) e a quantidade de cópias
- [x] Salvar as informações no banco de dados
- [x] Atribuir um valor a cada tamanho (10x15: R$ 0,10/cópia, 12x15: R$ 0.15/cópia e 13x18: R$ 0.20/cópia)
- [ ] Possibilitar a aplicação de filtros na imagem enviada (grayscale ou sepia)
- [x] Exibir todas as imagens enviadas com todos os detalhes de cada uma

### Diferenciais Opcionais
- [x] Escrever pelo menos um teste
- [x] Fazer o upload do arquivo para algum serviço de storage
- [x] Utilizar bibliotecas ou frameworks JavaScript (Vue.js, React, Angular e etc)
- [x] Utilizar um framework css (Bootstrap, Foundation, Bulda e etc)
- [ ] Rodar a aplicação em servidor Apache, que não é a tribo, nem o helicóptero
___
## Como funciona ?
O backend é baseado na framework Symfony, utilizando frameworks do composer, como Annotations para rotas, s3 para a conexão com o s3 da Amazon AWS e Doctrine para comunicação com o banco de dados MariaDB/MySQL. Ao acessar a home localhost:8000, é mostrado a lista das fotos cadastradas no banco de dados.

### Sevidor Banco de Dados
O servidor é um droplet da DigitalOcean, ambiente em Docker no Ubuntu. O serviço do banco de dados é rodado através de um container em Docker com a última versão da MariaDB, a conexão é feita através do endereço do servidor, no usuário cadastrado no banco.

### Esquema Banco de Dados
O banco de dados recebe os valores na tabela photos, os valores [URL da foto: **url**, tamanhos da foto: **sizes**, e a quantidade de cópia das fotos: **copies**]. 

### Framework Backend
É utilizado o symfony como backend, configurando as rotas para requisições de API como:

Retorna a quantidade de fotos em JSON
> localhost:8000/api/photo/

Retorna os dados da foto em JSON passando o id que quer buscar
> localhost:8000/api/photo/{id}

Fazer Upload de um arquivo
> localhost:8000/upload/?url='URL-DA-IMAGEM'&sizes='SIZES'&copies='COPIES'/{id}

Também é utilizado para retornar a homepage.

### Framework's Frontend
Foi utilizado Vue.js, Bootstrap e o Axios para requisição das API's
___
### Como rodar
Clone o repositório
```cmd
git clone git@github.com:MisterDaniels/ayrun-challenge.git
```

Adicione o arquivo .env na raiz do projeto e então adicione o seguintes dados
```env
DATABASE_URL=mysql://usuario-do-banco:senha-do-banco@host-do-banco:3306/nome-do-banco

S3_KEY=chave-amazon-s3
S3_SECRET=chave-secreta-amazon-s3
S3_REGION=região-amazon-s3
S3_VERSION=versão-amazon-s3
S3_BUCKET=bucket-amazon-s3
```

Rode o seguinte comando para baixar as dependências
```cmd
composer install
```

Rode o servidor do Symfony
```cmd
symfony server:start
```

**Clique no botão Carregar Tamanho**

**Pronto, agora é só clicar no botão Carregar**

## Observações

- O bucket do S3 está colocando as imagens como acesso privado, portanto, imagens feitas uploads não serão acessíveis, a não ser que seja feito manualmente. Faltou uma política para tornar elas públicas.
- As requisições estão em tese, lentas, muito por conta do banco de dados ser dos eua.
- É necessário esperar um tempo de execução ao clicar no botão **"Carregar Tamanho"**, verificar console que retorna o response em json, o botão **"Caregar"** é fundamental ser clicado depois de um tempo clicado no "Carregar Tamanho", vai carregar gradativamente graças ao Vue.js.
- Não houve tempo hábil para o estudo dos filtros.
- A ideia era colocar em um ambiente Nginx, porém, não houve tempo hábil para.

