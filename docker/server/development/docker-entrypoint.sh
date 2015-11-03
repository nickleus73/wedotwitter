#!/bin/bash
set -e

su postgres -c 'pg_ctl start -D /usr/local/pgsql/data -l serverlog'
#sudo service postgresql start

sudo -u postgres psql -U postgres -d postgres -c "CREATE USER dataadmin WITH PASSWORD 'ght2qir2m1'"
