#!/usr/bin/bash

# Function helpers
function create_new_user(){
    groupadd -g "${EASY_START_MAIN_SYSTEM_USER_ID}" "${EASY_START_MAIN_SYSTEM_USER_NAME}"
    useradd -u "${EASY_START_MAIN_SYSTEM_USER_ID}" -g "${EASY_START_MAIN_SYSTEM_USER_ID}" -s /bin/bash -m "${EASY_START_MAIN_SYSTEM_USER_NAME}"
    usermod -aG sudo "${EASY_START_MAIN_SYSTEM_USER_NAME}"
    echo "${EASY_START_MAIN_SYSTEM_USER_NAME}:${MAIN_SYSTEM_USER_PASSWORD}" | chpasswd
}

function unify_access_rights(){
    local USER="${EASY_START_MAIN_SYSTEM_USER_NAME}"
    local GROUP="www-data"

    # Changing the owner, excluding docker
    find /app -path "/app/docker" -prune -o -exec chown "$USER":"$GROUP" {} +

    # Changing access rights, excluding docker
    find /app -path "/app/docker" -prune -o -exec chmod 775 {} +
}
#===========================================================

# Create user and group for unifying file access rights on the host and in the container
if ! getent passwd "$EASY_START_MAIN_SYSTEM_USER_NAME" > /dev/null ; then
    create_new_user
fi
unify_access_rights

until mysql \
    --host="$DB_HOST" \
    --user="$DB_USERNAME" \
    --password="$DB_PASSWORD" \
    --port="$DB_PORT" \
    --execute="SELECT 1;" > /dev/null 2>&1
do
  echo "Waiting for MySQL..."
  sleep 1
done

php artisan migrate

supervisord -c /etc/supervisor/supervisord.conf

# Success message
GREEN="\e[32m"
ENDCOLOR="\e[0m"
echo -e "${GREEN}+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ ${ENDCOLOR}"
echo -e "${GREEN}+                                            INSTALL DONE                                         + ${ENDCOLOR}"
echo -e "${GREEN}+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ ${ENDCOLOR}"

echo -e "${GREEN}+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ ${ENDCOLOR}"
echo -e "${GREEN}+                                          Have a nice job :)                                     + ${ENDCOLOR}"
echo -e "${GREEN}+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ ${ENDCOLOR}"
php-fpm
