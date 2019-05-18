#!/bin/bash

for ((i=0;i<6;i++))
do
    php content.php > /dev/null 2>&1 &
    sleep 9
done


exit
