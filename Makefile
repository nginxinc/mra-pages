name = ngrefarch/pages
volumes = -v $(CURDIR)/inginious-pages:/inginious-pages
ports = -p 80:80 -p 443:443

build:
	docker build --build-arg VAULT_TOKEN=$(VAULT_TOKEN) -t $(name) .

run:
	docker run --env-file .env -it $(ports) $(name)

run-v:
	docker run --env-file .env -it $(ports) $(volumes) $(name)

shell:
	docker run --env-file .env -it $(ports) $(volumes) $(name) bash

push:
	docker push $(name)
