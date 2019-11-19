# Script to 'refresh' the database
docker-compose exec php bin/console doctrine:database:drop --force
docker-compose exec php bin/console doctrine:database:create

# This can be used to force creation of tables for our entities.
# docker-compose exec php bin/console doctrine:schema:update --force

docker-compose exec php bin/console doctrine:migrations:migrate

# This is our 'seeder' in src/DataFixtures/  (use --append to prevent clearing of all data)
docker-compose exec php bin/console doctrine:fixtures:load --append