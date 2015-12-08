tag = ng-ref-arch/ngra-pages
name = ngra-pages
volumes = -v $(CURDIR)/inginious-pages:/inginious-pages
ports = -p 80:80

build:
	docker build -t $(tag) .

run:
	docker run --env-file .env -it $(ports) $(tag)

run-v:
	docker run --env-file .env -it $(ports) $(volumes) $(tag)

shell:
	docker run --env-file .env -it $(ports) $(volumes) $(tag) bash

push:
	docker push $(name)