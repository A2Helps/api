default: all

VERSION := $(shell git describe --tags)

build:
	@docker build -t a2helps-api -f .ci/Dockerfile .

tag:
	@docker tag a2helps-api:latest a2helps/api:$(VERSION)

push:
	@docker push a2helps/api:$(VERSION)

all: build tag push
