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

# Запуск Nginx
nginx -g "daemon off;"