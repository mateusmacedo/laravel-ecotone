CONTAINER_NAME=laravel-startkit-api-dev
CONTAINER_LOCALSTACK_NAME=localstack
CONTAINER_MYSQL_NAME=mysql
CONTAINER_REDIS_NAME=redis
CONTAINER_RABBITMQ_NAME=rabbitmq
CONTAINER_MONGO_NAME=mongodb

install:
	make build-base
	make build
	make up
	make composer-package-install
	make composer-install
	make localstack-init-default
	make clear

up:
ifdef FILTER
	docker compose up -d laravel-startkit-api-$(FILTER)
else
	docker compose up -d $(CONTAINER_NAME) $(CONTAINER_LOCALSTACK_NAME) $(CONTAINER_MYSQL_NAME) $(CONTAINER_REDIS_NAME) $(CONTAINER_RABBITMQ_NAME) $(CONTAINER_MONGO_NAME)
endif

down:
ifdef FILTER
	docker compose stop laravel-startkit-api-$(FILTER)
else
	docker compose down
endif

bash:
ifdef FILTER
	docker exec -it $(FILTER) sh
else
	docker exec -it $(CONTAINER_NAME) sh
endif

build-base:
	docker build -t macedodosanjosmateus/laravel-startkit:base -f .docker/Dockerfile.base .

build:
	docker compose build

composer-install:
	docker exec -t $(CONTAINER_NAME) composer install --no-interaction --no-scripts

composer-package-install:
	docker exec -t $(CONTAINER_NAME) composer run-script post-root-package-install --no-interaction

test:
ifdef FILTER
	make up
	make clear
	docker exec -t $(CONTAINER_NAME) composer unit-test --filter="$(FILTER)"
else
	make up
	make clear
	docker exec -t $(CONTAINER_NAME) composer unit-test
endif

logs:
ifdef FILTER
	docker compose logs --follow $(FILTER)
else
	docker compose logs --follow
endif

clear:
	docker exec $(CONTAINER_NAME) sh -c "php artisan optimize:clear"

coverage-html:
	make up
	make clear
	docker exec -t $(CONTAINER_NAME) composer test-coverage-html

lint-fix:
	make up
	docker exec -t $(CONTAINER_NAME) composer lint-fix

migrate:
ifdef MPATH
	docker exec $(CONTAINER_NAME) sh -c "php artisan migrate --path=$(MPATH)"
else
	docker exec $(CONTAINER_NAME) sh -c "php artisan migrate"
endif

seed:
	docker exec $(CONTAINER_NAME) sh -c "php artisan db:seed"

run-queue:
ifdef CONNECTION
	docker exec $(CONTAINER_NAME) sh -c "php artisan queue:work $(CONNECTION) --queue=$(QUEUE)"
else
	docker exec $(CONTAINER_NAME) sh -c "php artisan queue:work"
endif

refresh-queue:
	docker exec $(CONTAINER_NAME) sh -c "php artisan queue:restart"

localstack-bash:
	make up
	docker compose exec $(CONTAINER_LOCALSTACK_NAME) bash

localstack-init-default:
	docker compose exec $(CONTAINER_LOCALSTACK_NAME) sh -c "sh /docker-entrypoint-initaws.d/init.sh"

localstack-create-queue:
	docker compose exec $(CONTAINER_LOCALSTACK_NAME) sh -c "awslocal sqs create-queue --queue-name $(QUEUE)"

localstack-delete-queue:
	docker compose exec $(CONTAINER_LOCALSTACK_NAME) sh -c "awslocal sqs delete-queue --queue-url http://localstack:4566/000000000000/$(QUEUE)"

localstack-list-queue:
	docker compose exec $(CONTAINER_LOCALSTACK_NAME) sh -c "awslocal sqs list-queues"

localstack-configure:
	docker compose exec $(CONTAINER_LOCALSTACK_NAME) sh -c "aws configure"

localstack-receive-message:
	docker compose exec $(CONTAINER_LOCALSTACK_NAME) sh -c "awslocal sqs receive-message --queue-url http://localstack:4566/000000000000/$(QUEUE) --max-number-of-messages $(MAX)"

localstack-send-message:
	docker compose exec $(CONTAINER_LOCALSTACK_NAME) sh -c "awslocal sqs send-message --queue-url http://localstack:4566/000000000000/$(QUEUE) --message-body $(MSG)"

localstack-purge-queue:
	docker compose exec $(CONTAINER_LOCALSTACK_NAME) sh -c "awslocal sqs purge-queue --queue-url http://localstack:4566/000000000000/$(QUEUE)"