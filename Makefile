NAME=myresponder
REPO=hendry/$(NAME)

.PHONY: start stop build sh

all: build

build: check
	docker build -t $(REPO) --build-arg COMMIT=$(shell git describe --always) .

start:
	docker run -d --name $(NAME) --env-file envfile -p 8080:8080 $(REPO)
	#docker run -d --name $(NAME) --env-file envfile -v /home/hendry/tmp/myresponder-data:/srv/data -p 8080:8080 $(REPO)

stop:
	docker stop $(NAME)
	docker rm $(NAME)

sh:
	docker exec -it $(NAME) /bin/sh

check:
	find -name '*.php' | while read phpsource; do php -l $$phpsource; done
