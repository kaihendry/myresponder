NAME=myresponder
REPO=hendry/$(NAME)

.PHONY: start stop build sh

all: build

build: check
	docker build -t $(REPO) --build-arg COMMIT=$(shell git describe --always) .

start:
	docker run --rm --name $(NAME) --env-file envfile -p 80:80 -p 443:443 -v $(PWD)/data:/srv/data -v $(HOME)/.caddy:/root/.caddy $(REPO)

stop:
	docker stop $(NAME)

sh:
	docker exec -it $(NAME) /bin/sh

check:
	find -name '*.php' | while read phpsource; do php -l $$phpsource; done
