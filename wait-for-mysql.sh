#!/bin/sh

CONTAINER="db_mysql"
USERNAME="tutorial"
PASSWORD="secret"
while ! docker exec $CONTAINER mysql --user=$USERNAME --password=$PASSWORD -e "SELECT 1" >/dev/null 2>&1; do
    sleep 1
done