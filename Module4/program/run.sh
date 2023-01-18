#! /bin/bash

year_lst=( '1930' '1940' '1941' '1942' '1943' '1944' )
fileroot="/home/jesse/module4/cardinals-"
for i in ${year_lst[@]}
do
    filename=$fileroot$i".txt"
    python3 baseball.py $filename >> output.txt 2>&1
done