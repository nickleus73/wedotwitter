# PREREQUIS

- Install docker (do not use apt-get install docker.io) : https://docs.docker.com/engine/installation/ubuntulinux/
- Install composer by this repository : https://hub.docker.com/r/composer/composer/
- Install docker-compose : https://docs.docker.com/compose/install/
- For Windows, install boot2docker

# Deployment

- Copy and rename the development.yml file to docker-compose.yml file, then complete environments variables for Twitter.
- Execute the command in project root : `docker run -ti -v $(pwd)/www:/app composer/composer install` to install php dependencies
- Execute `docker-compose build` then `docker-compose up -d` to run the project
- Then execute `docker exec -it server php artisan route:scan` to generate routes
- Then execute `docker exec -it server chown -R www-data:www-data storage/` and `docker exec -it server php artisan serve` to change permissions