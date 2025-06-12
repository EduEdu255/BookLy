# BookNest - Seu Gerenciador de Livros Pessoal

Este é o repositório do BookNest, uma aplicação Laravel que permite gerenciar sua biblioteca de livros. O projeto é conteinerizado usando Docker para facilitar o desenvolvimento e a implantação.

## 🚀 Começando

Siga os passos abaixo para configurar e rodar o projeto BookNest em seu ambiente de desenvolvimento.

### Pré-requisitos

Certifique-se de ter as seguintes ferramentas instaladas em sua máquina:

* **Git**: Para clonar o repositório.
* **Docker Desktop**: Inclui Docker Engine, Docker Compose e Kubernetes (se necessário).

### 📋 Instalação e Execução

1.  **Clone o Repositório:**
    Abra seu terminal (CMD, PowerShell ou Git Bash) e execute:
    ```bash
    git clone [https://github.com/SEU_USUARIO/booknest.git](https://github.com/SEU_USUARIO/booknest.git)
    cd booknest
    ```
    *(Substitua `https://github.com/SEU_USUARIO/booknest.git` pelo link real do seu repositório)*

2.  **Configurar o Ambiente Docker:**
    Certifique-se de que o Docker Desktop esteja em execução. Na pasta raiz do projeto (`booknest`), execute o Docker Compose para construir as imagens e iniciar os contêineres:
    ```bash
    docker-compose up -d --build
    ```
    * `up -d`: Inicia os serviços em segundo plano (detached mode).
    * `--build`: Garante que as imagens Docker sejam construídas (ou reconstruídas) a partir do seu `Dockerfile`.

3.  **Configurar a Aplicação Laravel:**
    Após os contêineres estarem em execução, você precisará configurar o Laravel dentro do contêiner `booknest-app`. Execute os seguintes comandos:

    ```bash
    # Gerar a chave da aplicação Laravel
    docker exec -it booknest-app php artisan key:generate

    # Limpar caches de configuração, rota e visualização
    docker exec -it booknest-app php artisan config:clear
    docker exec -it booknest-app php artisan route:clear
    docker exec -it booknest-app php artisan view:clear

    # Rodar as migrações do banco de dados (cria as tabelas)
    # Se for o primeiro setup ou se quiser resetar o banco de dados:
    docker exec -it booknest-app php artisan migrate:fresh --seed # --seed se tiver seeders
    # Ou, se for apenas para rodar novas migrações sem perder dados existentes:
    # docker exec -it booknest-app php artisan migrate
    ```

4.  **Acessar a Aplicação:**
    Abra seu navegador e acesse:
    ```
    http://localhost:8080/
    ```
    Você deverá ver a página inicial da aplicação BookNest.

## ⚠️ Solução de Problemas Comuns

Caso encontre algum problema durante a execução, verifique as soluções abaixo:

### 1. `ERR_CONNECTION_REFUSED` no Navegador

* **Contêineres não estão rodando:**
    Verifique se todos os contêineres estão em execução. No terminal, execute `docker ps`. Todos os serviços (`booknest-app`, `booknest-frontend`, `booknest-mysql`) devem estar com o status `Up`. Se não estiverem, tente `docker-compose up -d` novamente.
* **Firewall do Windows:**
    Seu firewall pode estar bloqueando a conexão. Crie uma regra de entrada no Firewall do Windows Defender para permitir conexões TCP na porta `8080`.
    * Vá para `Painel de Controle` > `Sistema e Segurança` > `Firewall do Windows Defender` > `Configurações Avançadas`.
    * Em `Regras de Entrada`, clique em `Nova Regra...`.
    * Selecione `Porta`, clique `Avançar`.
    * Selecione `TCP`, `Portas locais específicas: 8080`. Clique `Avançar`.
    * Selecione `Permitir a conexão`. Clique `Avançar`.
    * Marque os perfis de rede (`Domínio`, `Privado`, `Público`). Clique `Avançar`.
    * Dê um nome à regra (ex: "Docker BookNest App 8080"). Clique `Concluir`.
* **Outra aplicação usando a porta 8080:**
    Verifique se a porta 8080 não está sendo usada por outro programa na sua máquina. No CMD (como administrador), execute `netstat -ano | findstr :8080`. Se houver um processo usando a porta, você pode tentar encerrá-lo via Gerenciador de Tarefas ou alterar a porta no `docker-compose.yml` (por exemplo, para `8081:80`) e acessar `http://localhost:8081/`.

### 2. `403 Forbidden` do Nginx

Este erro geralmente indica problemas de permissão para o Nginx acessar os arquivos da aplicação.

* **Permissões incorretas no `Dockerfile`:**
    Certifique-se de que seu `Dockerfile` na raiz do projeto tenha as permissões de arquivo corretas para o `www-data` e que a pasta `public` tenha permissão de leitura para "outros". As permissões no final do `Dockerfile` devem ser como as seguintes:
    ```dockerfile
    # ...
    # Configurar permissões para o Laravel
    RUN chown -R www-data:www-data /var/www \
        && chmod -R 775 /var/www/storage \
        && chmod -R 775 /var/www/bootstrap/cache \
        && find /var/www/public -type d -exec chmod 755 {} \; \
        && find /var/www/public -type f -exec chmod 644 {} \;
    ```
    Após alterar o `Dockerfile`, você precisará reconstruir a imagem do serviço `app`:
    ```bash
    docker-compose down
    docker-compose build --no-cache app
    docker-compose up -d
    ```

### 3. `unknown directive " "` nos logs do Nginx (Nginx não inicia)

Este erro ocorre se houver caracteres invisíveis ou espaços em branco indesejados no início do seu arquivo `nginx/default.conf`.

* **Corrigir `nginx/default.conf`:**
    Abra o arquivo `nginx/default.conf` em um editor de texto (VS Code, Notepad++). Vá para a linha 1 e 2, apague-as completamente e redigite-as (`server {` e `listen 80;`) para garantir que não há caracteres ocultos. Salve o arquivo com codificação UTF-8 (sem BOM).
    Após a correção, reinicie os contêineres:
    ```bash
    docker-compose down
    docker-compose up -d
    ```
    Verifique os logs do Nginx novamente (`docker logs booknest-frontend`) para confirmar que não há mais o erro `unknown directive`.

### 4. `SQLSTATE[HY000] [2002] Connection refused` ou similar do Laravel

Indica que o Laravel não consegue se conectar ao banco de dados.

* **Variáveis de Ambiente (`.env`):**
    Certifique-se de que o arquivo `.env` (crie-o a partir de `.env.example`) tenha as configurações corretas para o banco de dados. O `DB_HOST` deve ser o nome do serviço MySQL no seu `docker-compose.yml`, que é `mysql`.
    ```dotenv
    DB_CONNECTION=mysql
    DB_HOST=mysql # <-- IMPORTANTE: Use o nome do serviço do docker-compose.yml
    DB_PORT=3306
    DB_DATABASE=booknest
    DB_USERNAME=booknest_user
    DB_PASSWORD=secret
    ```
    Após alterar o `.env`, limpe o cache de configuração do Laravel:
    ```bash
    docker exec -it booknest-app php artisan config:clear
    ```

## 🌐 Acessando de Outros Dispositivos na Rede

Para acessar o BookNest de outros dispositivos (celular, tablet, outro PC) na mesma rede local:

1.  **Descubra o IP da sua máquina host:**
    No terminal do seu computador (onde o Docker está rodando), digite `ipconfig` e procure pelo `Endereço IPv4` da sua conexão de rede (ex: `192.168.1.100`).

2.  **Acesse usando o IP:**
    No navegador do outro dispositivo, use o IP da sua máquina seguido da porta:
    ```
    http://[SEU_IP_DA_MAQUINA]:8080/
    ```
    Ex: `http://192.168.1.100:8080/`

3.  **Firewall do Windows (Novamente para Acesso Externo):**
    Mesmo que o acesso local funcione, o Firewall do Windows pode bloquear conexões de entrada de outros dispositivos. Crie uma regra de entrada específica para a porta `8080` (verifique a seção `ERR_CONNECTION_REFUSED` acima para o passo a passo completo).

---

## 🛑 Parando os Contêineres

Para parar e remover os contêineres e redes Docker, execute:
```bash
docker-compose down