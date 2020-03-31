### A2 Helps API

#### Build
```
	docker build -t a2cares-api -f .ci/Dockerfile .
    docker tag a2helps-api:latest a2helps/api:VERSION
    docker push a2helps/api:VERSION
```
