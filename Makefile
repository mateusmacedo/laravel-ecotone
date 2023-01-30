CONTAINER_NAME=laravel-startkit-api
CONTAINER_LOCALSTACK_NAME=localstack

install:
	make build
	make up
	make composer-package-install
	make composer-install
	make localstack-init-default
	make clear

up:
	docker-compose up -d

down:
	docker-compose down

bash:
	make up
	docker exec -it $(CONTAINER_NAME) sh

build:
	docker-compose build

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
	docker-compose logs --follow

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
	docker exec $(CONTAINER_NAME) sh -c "php artisan queue:work $(CONNECTION) --queue=$(QUEUE_NAME)"
else
	docker exec $(CONTAINER_NAME) sh -c "php artisan queue:work"
endif

refresh-queue:
	docker exec $(CONTAINER_NAME) sh -c "php artisan queue:restart"

localstack-bash:
	make up
	docker-compose exec $(CONTAINER_LOCALSTACK_NAME) bash

localstack-init-default:
	docker-compose exec $(CONTAINER_LOCALSTACK_NAME) sh -c "sh /docker-entrypoint-initaws.d/init.sh"

localstack-create-queue:
	docker-compose exec $(CONTAINER_LOCALSTACK_NAME) sh -c "awslocal sqs create-queue --queue-name $(QUEUE_NAME)"

localstack-delete-queue:
	docker-compose exec $(CONTAINER_LOCALSTACK_NAME) sh -c "awslocal sqs delete-queue --queue-url $(QUEUE_URL)"

localstack-list-queue:
	docker-compose exec $(CONTAINER_LOCALSTACK_NAME) sh -c "awslocal sqs list-queues"

localstack-configure:
	docker-compose exec $(CONTAINER_LOCALSTACK_NAME) sh -c "aws configure"

localstack-receive-message:
	docker-compose exec $(CONTAINER_LOCALSTACK_NAME) sh -c "awslocal sqs receive-message --queue-url $(QUEUE_URL) --max-number-of-messages $(QUEUE_MAX_MSG)"
