#!/bin/bash
DOMAIN_NAME="domain.com"
REGION="ap-southeast-2"
ELB_TYPE="alb" # alb, classic, none

###########################################
DEPLOY_ID=${DEPLOYMENT_ID:2:9}
DEPLOY_DIRECTORY=$(cd `dirname $0` && pwd)

if [ ! -z "$DOMAIN_NAME" ]; then

    # CREATE WORDPRESS UPLOADS FOLDER IF IT DOESNT EXIST
    if [ ! -d "/var/www/vhosts/${DOMAIN_NAME}/public_html/content/uploads" ]; then
        mkdir -p /var/www/vhosts/${DOMAIN_NAME}/public_html/content/uploads
    fi

    # FIX UPLOADS FOLDER PERMISSIONS
    if [ -d "/var/www/vhosts/${DOMAIN_NAME}/public_html/content/uploads" ]; then
        chown -R apache:apache /var/www/vhosts/${DOMAIN_NAME}/public_html/content/uploads
        find /var/www/vhosts/${DOMAIN_NAME}/public_html/content/uploads -type d -exec chmod 755 {} \;
        find /var/www/vhosts/${DOMAIN_NAME}/public_html/content/uploads -type f -exec chmod 644 {} \;
    fi

    # COPY WORDPRESS CONFIGURATION FILES FROM S3 BUCKET
    /usr/bin/aws s3 sync s3://${DOMAIN_NAME}-assets/ /var/www/vhosts/${DOMAIN_NAME}/public_html/ --quiet --region ap-southeast-2 --exclude '*' --include 'wp-config.php'
    chmod 644 /var/www/vhosts/${DOMAIN_NAME}/public_html/wp-config.php

    # COPY UPDATED VIRTUAL HOST FILE TO APACHE CONF FOLDER
    if [ -f /var/www/vhosts/${DOMAIN_NAME}/_deploy/${DOMAIN_NAME}.conf ]; then
        cp /var/www/vhosts/${DOMAIN_NAME}/_deploy/${DOMAIN_NAME}.conf /etc/httpd/vhosts/${DOMAIN_NAME}.conf
    fi

    # RECURSIVELY COPY ALL STATIS FILES TO S3 BUCKET
    /usr/bin/aws s3 sync /var/www/vhosts/${DOMAIN_NAME}/public_html/ s3://${DOMAIN_NAME}-assets/build/${DEPLOY_ID}/ --quiet --region ${REGION} --acl public-read --cache-control max-age=31536000,public --exclude '*' --include '*.css' --include '*.js' --include '*.svg' --include '*.jpg' --include '*.png'  --include '*.eot' --include '*.ttf' --include '*.woff' --include '*.woff2'

    # INSERT CDN VERSION KEY INTO WP-CONFIG.PHP
    NEW_CDN_VERSION_KEY="%%CDN_VERSION_KEY%%"
    sed -i "s/${NEW_CDN_VERSION_KEY}/${DEPLOY_ID}/g" /var/www/vhosts/${DOMAIN_NAME}/public_html/wp-config.php

    # SECURE WORDPRESS CONFIGURATION
    chmod 444 /var/www/vhosts/${DOMAIN_NAME}/public_html/wp-config.php

    # START APACHE
    systemctl start httpd.service

    # IN-PLACE/ROLLING UPDATE USING APPLICATION LOAD BALANCER
    if [ ${ELB_TYPE} == "alb" ]; then

        # REGISTER EC2 INSTANCES WITH ELB TARGET GROUPS
        . ${DEPLOY_DIRECTORY}/alb/common_functions.sh
        . ${DEPLOY_DIRECTORY}/alb/register_with_elb.sh
    fi

    # IN-PLACE/ROLLING UPDATE USING ELB CLASSIC
    if [ ${ELB_TYPE} == "classic" ]; then

        # REGISTER EC2 INSTANCES WITH ELB TARGET GROUPS
        . ${DEPLOY_DIRECTORY}/elb-classic/common_functions.sh
        . ${DEPLOY_DIRECTORY}/elb-classic/register_with_elb.sh
    fi
fi
