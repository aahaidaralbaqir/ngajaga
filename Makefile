install: node-deps
node-deps:
			docker-compose run --rm npm install
generate-key:
			docker-compose run --rm artisan key:generate
make-config:
			cp ./src/.env.example ./src/.env
laravel-deps:
			docker-compose run --rm php composer install --ignore-platform-reqs
migrate-database:
				docker-compose run --rm artisan migrate
seed-database:
				docker-compose run --rm artisan db:seed
link-storage:
				docker-compose run --rm artisan storage:link