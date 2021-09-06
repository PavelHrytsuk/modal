rm -rf pub/static/frontend/*
rm -rf var/view_preprocessed
rm -rf var/cache/*
rm -rf var/page_cache
php bin/magento s:s:d -f
