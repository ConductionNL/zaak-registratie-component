#!/bin/bash
if [ "$1" == "" ]; then
    echo "You must pass a command to dartisan."
elif [ "$2" != "" ]; then
    docker-compose exec php bin/console $1 $2
else
    docker-compose exec php bin/console $1
fi
