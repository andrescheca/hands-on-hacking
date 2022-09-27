#!/bin/sh

docker compose -p hands_on_hacking_web_apps_csrf -f ../csrf/docker-compose.yml up -d
docker compose -p hands_on_hacking_web_apps_csrf -f ../csrf/docker-compose.yml down

docker compose -p hands_on_hacking_web_apps_fileinclusion -f ../file-inclusion/docker-compose.yml up -d
docker compose -p hands_on_hacking_web_apps_fileinclusion -f ../file-inclusion/docker-compose.yml down

docker compose -p hands_on_hacking_web_apps_fileupload -f ../file-upload/docker-compose.yml up -d
docker compose -p hands_on_hacking_web_apps_fileupload -f ../file-upload/docker-compose.yml down

docker compose -p hands_on_hacking_web_apps_insecuredeserialization -f ../insecure-deserialization/docker-compose.yml up -d
docker compose -p hands_on_hacking_web_apps_insecuredeserialization -f ../insecure-deserialization/docker-compose.yml down

docker compose -p hands_on_hacking_web_apps_openredirect -f ../open-redirect/docker-compose.yml up -d
docker compose -p hands_on_hacking_web_apps_openredirect -f ../open-redirect/docker-compose.yml down

docker compose -p hands_on_hacking_web_apps_sqli -f ../sqli/docker-compose.yml up -d
docker compose -p hands_on_hacking_web_apps_sqli -f ../sqli/docker-compose.yml down

docker compose -p hands_on_hacking_web_apps_ssrf -f ../ssrf/docker-compose.yml up -d
docker compose -p hands_on_hacking_web_apps_ssrf -f ../ssrf/docker-compose.yml down

docker compose -p hands_on_hacking_web_apps_xss -f ../xss/docker-compose.yml up -d
docker compose -p hands_on_hacking_web_apps_xss -f ../xss/docker-compose.yml down
