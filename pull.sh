rsync -av --progress --rsh='ssh -p 987' \
    --exclude='error_log' \
    --exclude='version2018/' \
    --exclude='.git' \
    --exclude='assets/datas/' \
    municipa@municipedia.com:/home/municipa/public_html/ \
    ./