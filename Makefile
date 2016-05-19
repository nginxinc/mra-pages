name = trainees/pages
volumes = -v $(CURDIR)/inginious-pages:/inginious-pages -v $(CURDIR)/php-start.sh:/php-start.sh

ports = -p 80:80

build:
	docker build -t $(name) .

run:
	docker run --env-file .env -it $(ports) $(name)

run-v:
	docker run --env-file .env -it $(ports) $(volumes) $(name)

shell:
	docker run --env-file .env -it $(ports) $(volumes) $(name) bash

push:
	docker push $(name)
