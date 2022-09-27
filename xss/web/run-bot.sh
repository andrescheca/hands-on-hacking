#!/bin/sh

export OPENSSL_CONF=/etc/ssl/

/usr/sbin/apachectl start
/usr/local/bin/phantomjs --ignore-ssl-errors=true --local-to-remote-url-access=true --web-security=false --ssl-protocol=any /opt/phantomjs/bot.js