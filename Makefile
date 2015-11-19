tag = ng-ref-arch/ngra-pages
name = ngra-pages
volumes = -v $(CURDIR)/inginious-pages:/inginious-pages

build:
	docker build -t $(tag) .

run:
	docker run --name $(name) -it -p 80:80 $(tag)

run-v:
	docker run --name $(name) -it -p 80:80 $(volumes) $(tag)

shell:
	docker run --name $(name) -it -p 80:80 -p 8888:8888 $(volumes) $(tag) bash

push:
	docker push $(name)