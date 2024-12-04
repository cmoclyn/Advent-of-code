COMPOSE := docker compose

build:
	$(COMPOSE) build

up:
	$(COMPOSE) up

logs:
	$(COMPOSE) logs -f
