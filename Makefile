APP := @docker compose run --rm app

.PHONY:
ci: analyse test

.PHONY:
install:
	$(APP) composer install

.PHONY:
update:
	$(APP) composer update

.PHONY:
analyse:
	$(APP) composer analyse

.PHONY:
test:
	$(APP) composer test

.PHONY:
coverage:
	$(APP) composer coverage

.PHONY:
ssh:
	$(APP) sh
