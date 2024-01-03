# Hands on hacking labs
Labs used in the Hands-on-hacking web apps book. This project is meant to be run in a cloud based linux container but it can be installed on a local machine as well. It is recommended not to leave the project running for a long time since it contains vulnerable code.

## Requirements
NodeJS, Docker and docker compose plugin

NodeJS version should be at most 18.18.0

## Install dependencies
Install project dependencies:

```bash
cd main
npm install
npx prisma generate
```

## Create the containers
Run the `create-containers.sh` script so it creates the containers first to improve speed when starting them from the main project.

```bash
./create-containers.sh
```

## Start the labs
```bash
npm run start
```

It will listen on the port 3000 by default:

```bash
http://localhost:3000
```

To close the labs press `Ctrl+c`.
