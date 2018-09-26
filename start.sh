#!/bin/bash

printHelp() {
    cat <<EOF
Usage: start.sh prod|dev
EOF
}

if [ $# -lt 1  ]; then
  printHelp
  exit 2
fi

env_option=$1

if [ "$env_option" != "prod" -a "$env_option" != "dev" ]; then
  printHelp
  exit 2
fi

if [ "$env_option" == "prod" ]; then
  if [ $(ps -aux | grep qconf_agent | wc -l) -le 1 ]; then
    bash /usr/local/qconf/bin/agent-cmd.sh start
  fi
fi

php bin/server start
dioc