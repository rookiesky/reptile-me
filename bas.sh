#!/bin/bash


dirpath=`pwd`;

for ((i=0;i<6;i++))
do
    cd $dirpath
    php content.php > /dev/null 2>&1 &
    sleep 9
done


exit
