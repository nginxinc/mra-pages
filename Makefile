tag = ng-ref-arch/ngra-pages
name = ngra-pages
volumes = -v $(CURDIR)/inginious-pages:/inginious-pages

build:
	docker build -t $(tag) .

run:
	docker run --env-file .env_dev --name $(name) -it -p 80:80 $(tag)

run-v:
	docker run --env-file .env_dev --name $(name) -it -p 80:80 $(volumes) $(tag)

shell:
	docker run --env-file .env_dev --name $(name) -it -p 80:80 -p 8888:8888 $(volumes) $(tag) bash

push:
	docker push $(name)