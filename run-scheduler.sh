#!/bin/bash
while true; do
    echo "=> Running scheduler"
    php artisan schedule:run || true;
    echo "=> Sleeping for 60 seconds"
    sleep 60;
done