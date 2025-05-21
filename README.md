Adentrar diretório do projeto e rodar os comandos

Instalação dos pacotes sem necessidade de php e composer instalados localmente:
docker run --rm -it -v $(pwd):/app -w /app laravelsail/php83-composer:latest composer i

Utilização do Sail para docker:
./vendor/bin/sail up -d
./vendor/bin/sail artisan migrate
./vendor/bin/sail artisan queue:listen

Em terminal separado para organização:
./vendor/bin/sail npm i
./vendor/bin/sail npm run dev
