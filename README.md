# Installation

To run service execute following command in terminal:

```bash
docker network create admitad-test || true && \
docker-compose up -d && \
docker-compose exec php composer install && \
docker-compose exec php yarn encore production && \
docker-compose exec php php bin/console doctrine:migrations:migrate --no-interaction
```

That's it, now it is accessible at http://localhost:8028