# Installation

**Prerequisite**: Docker installed & running 

### Step 1

Clone repository and select dir:
```
git clone git@github.com:gta4kv/tz.git && cd tz
```

### Step 2
Run service with command:
```bash
mkdir docker/data/pgdata || true && \
docker network create admitad-test || true && \
docker-compose up -d && \
docker-compose exec php composer install && \
docker-compose exec php yarn install && \
docker-compose exec php yarn encore production && \
docker-compose exec php php bin/console doctrine:migrations:migrate --no-interaction
```

That's it, now it is accessible at http://localhost:8028