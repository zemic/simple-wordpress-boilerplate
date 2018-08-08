#!/bin/bash
DOMAIN_NAME="domain.com"
REGION="ap-southeast-2"
ELB_TYPE="alb" # alb, classic, none
AWS_CONFIG_BUCKET=""

###########################################
DEPLOY_ID=${DEPLOYMENT_ID:2:9}
DEPLOY_DIRECTORY=$(cd `dirname $0` && pwd)

if [ ! -z "$DOMAIN_NAME" ]; then

    # IN-PLACE/ROLLING UPDATE USING APPLICATION LOAD BALANCER
    if [ ${ELB_TYPE} == "alb" ]; then

        # UPDATE ALB COMMON_FUNCTIONS.SH
        rm -rf ${DEPLOY_DIRECTORY}/alb/common_functions.sh
        /usr/bin/aws s3 cp s3://${AWS_CONFIG_BUCKET}/_deploy/scripts/alb/common_functions.sh ${DEPLOY_DIRECTORY}/alb/common_functions.sh --quiet --region ${REGION}
        chmod 644 ${DEPLOY_DIRECTORY}/alb/common_functions.sh

        # DREGISTER EC2 INSTANCE FROM ELB target groups
        . ${DEPLOY_DIRECTORY}/alb/common_functions.sh
        . ${DEPLOY_DIRECTORY}/alb/deregister_from_elb.sh
    fi

    # IN-PLACE/ROLLING UPDATE USING CLASSIC LOAD BALANCER
    if [ ${ELB_TYPE} == "classic" ]; then

        # UPDATE CLASSIC LOAD BALANCER COMMON_FUNCTIONS.SH
        rm -rf ${DEPLOY_DIRECTORY}/elb-classic/common_functions.sh
        /usr/bin/aws s3 cp s3://${AWS_CONFIG_BUCKET}/_deploy/scripts/elb-classic/common_functions.sh ${DEPLOY_DIRECTORY}/elb-classic/common_functions.sh --quiet --region ${REGION}
        chmod 644 ${DEPLOY_DIRECTORY}/elb-classic/common_functions.sh

        # DREGISTER EC2 INSTANCE FROM ELB
        . ${DEPLOY_DIRECTORY}/elb-classic/common_functions.sh
        . ${DEPLOY_DIRECTORY}/elb-classic/deregister_from_elb.sh
    fi

    # STOP APACHE
    systemctl stop httpd.service

    # GRAB THE OLD CDN KEY FROM WP-CONFIG.PHP AND DELETE OLD FILES
    if [ -f /var/www/vhosts/${DOMAIN_NAME}/public_html/wp-config.php ]; then
        OLD_CDN_VERSION_KEY=`cat /var/www/vhosts/${DOMAIN_NAME}/public_html/wp-config.php | grep CDN_VERSION_KEY | cut -d \' -f 4`

        if [ ! -z "$OLD_CDN_VERSION_KEY" ]; then
            /usr/bin/aws s3 rm s3://${DOMAIN_NAME}-assets/build/${OLD_CDN_VERSION_KEY}/ --quiet --recursive --region ${REGION}
        fi
    fi

    # REMOVE OUR WEBSITE FILES IF THEY ALREADY EXIST
    if [ -d "/var/www/vhosts/${DOMAIN_NAME}" ]; then
        rm -rf /var/www/vhosts/${DOMAIN_NAME}/*
    fi

fi
