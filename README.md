# Àgora - API

## Introdução
Este projeto consiste em uma API, desenvolvida com o framework PHP Laravel, para o sistema Àgora.


## Ferramentas Necessárias:
Para instalar o projeto serão necessários ter instalado em sua máquina, as seguintes ferramentas:
* [Docker](https://www.digitalocean.com/community/tutorials/how-to-install-and-use-docker-on-ubuntu-20-04-pt)
* [Docker-compose](https://www.digitalocean.com/community/tutorials/how-to-install-and-use-docker-on-ubuntu-20-04-pt](https://www.digitalocean.com/community/tutorials/how-to-install-and-use-docker-compose-on-ubuntu-20-04-pt)https://www.digitalocean.com/community/tutorials/how-to-install-and-use-docker-compose-on-ubuntu-20-04-pt)

## Como Instalar o Projeto:
Após a instalação das ferramentas e  ter clonado o projeto, é necessário criar os containers com o Docker para o ambiente de desenvolvimento.
Para  subir o ambiente utilize:
```
docker-compose up -d
```

Então, utilize o script que está na pasta 'environments', que será responsável, por instalar as configurações necessárias para o projeto Laravel:
```
./environment/setup.sh
```

## Outros Comandos:
* Para subir o ambiente de desenvolvimento em um outro momento, primeiro é necessário remover os containers e depois subi-los  novamente, utilizando:
  
```
docker-compose down --remove-orphans
docker-compose up -d
```

* Parar Ambiente de Desenvolvimento
```
docker-compose stop
```

* Verificação de Estilização de Código (Pint)
```
docker-compose exec app composer pint
```

* Verificação de Testes
```
docker-compose exec app php artisan test
```
