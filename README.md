Adentrar diretório do projeto e rodar os comandos

Instalação dos pacotes sem necessidade de php e composer instalados localmente:

1. docker run --rm -it -v $(pwd):/app -w /app laravelsail/php83-composer:latest composer i

Utilização do Sail para docker:

1. ./vendor/bin/sail up -d
2. ./vendor/bin/sail artisan migrate
3. ./vendor/bin/sail artisan queue:listen

Em terminal separado para organização:

1. ./vendor/bin/sail npm i
2. ./vendor/bin/sail npm run dev

Detalhes sobre o projeto:

1. Foi utilizando Laravel 12 com InertiaJS + Vue para o frontend por motivos de velocidade de entrega.
2. PrimeVUE como biblioteca de componentes
3. Inertia UI Modal para utilização de modal
