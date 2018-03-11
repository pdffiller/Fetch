#!/usr/bin/env bash

# trace ERR through pipes
set -o pipefail

# trace ERR through 'time command' and other functions
set -o errtrace

# set -u : exit the script if you try to use an uninitialised variable
set -o nounset

# set -e : exit the script if any statement returns a non-true return value
set -o errexit

FQDN=tedivm.com
TEST_USER=testuser
TEST_PASSWD=applesauce

echo $(grep $(hostname) /etc/hosts | cut -f1) "${FQDN}" >> /etc/hosts


if ! id -u ${TEST_USER} > /dev/null 2>&1; then
	adduser -D -s /bin/bash \
			-h /home/"${TEST_USER}" \
			-G users -g users \
			"${TEST_USER}"
fi

echo "${TEST_USER}:${TEST_PASSWD}" | chpasswd
mkdir -p /home/"${TEST_USER}"

if [ -f /data/Attachments.tar ] && [ ! -d /resources/Attachments ]; then
	rm -rf /resources/Attachments && mkdir /resources
	tar -xf /data/Attachments.tar -C /resources
fi

if [ -f /data/Maildir.tar ] && [ ! -d /home/"${TEST_USER}"/Maildir ]; then
	rm -rf /home/"${TEST_USER}"/Maildir
	tar -xf /data/Maildir.tar -C /home/"${TEST_USER}"
fi

chown -R "${TEST_USER}":users /home/"${TEST_USER}"
