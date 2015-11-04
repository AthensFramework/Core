#!/bin/bash

while getopts d: option
  do case "${option}" in
  d) DEST=${OPTARG}/;;
  esac
done

: ${DEST:=./};

if [ ! -d "$DEST" ]; then
  echo "Directory $DEST does not exist";
  exit -1;
fi

DBNAME=`cat localSettings.php | grep MYSQL_DB_NAME | cut -d \' -f 4`;
DBUSER=`cat localSettings.php | grep MYSQL_USER | cut -d \' -f 4`;
DBPASS=`cat localSettings.php | grep MYSQL_PASSWORD | cut -d \' -f 4`;

APPNAME=`cat settings.php | grep APPLICATION_NAME | cut -d \' -f 4`;

DIRNAME=$APPNAME-$(date +%Y-%m-%d-%H-%M-%S);
FULLPATHDIRNAME=$DEST$DIRNAME;

mkdir $FULLPATHDIRNAME;

echo `git rev-parse --abbrev-ref HEAD` > $FULLPATHDIRNAME/branch.txt;
echo `git rev-parse HEAD` > $FULLPATHDIRNAME/rev.txt;
mysqldump -u $DBUSER -p$DBPASS $DBNAME > $FULLPATHDIRNAME/database.sql;

tar -C $DEST -cvf ${FULLPATHDIRNAME}.tar $DIRNAME;

rm -rf $FULLPATHDIRNAME;
