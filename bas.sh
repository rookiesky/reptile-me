#!/bin/bash

php content.php 1 > /dev/null 2>&1 &

sleep 1;

php content.php 2 > /dev/null 2>&1 &

sleep 1;

php content.php 3 > /dev/null 2>&1 &

sleep 1;

php content.php 4 > /dev/null 2>&1 &
