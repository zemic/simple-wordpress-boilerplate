<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
        <title><?php wp_title( ',', true, 'right' ); ?></title>

        <!-- // Add addresses for prefetching
        <link rel="dns-prefetch" href="//s3.amazonaws.com">
        -->

        <!-- // Favicons
        <link rel="apple-touch-icon" sizes="57x57" href="/favicons/favicons/favicon-57x57.png">
        <link rel="apple-touch-icon" sizes="60x60" href="/favicons/favicon-60x60.png">
        <link rel="apple-touch-icon" sizes="72x72" href="/favicons/favicon-72x72.png">
        <link rel="apple-touch-icon" sizes="76x76" href="/favicons/favicon-76x76.png">
        <link rel="apple-touch-icon" sizes="114x114" href="/favicons/favicon-114x114.png">
        <link rel="apple-touch-icon" sizes="120x120" href="/favicons/favicon-120x120.png">
        <link rel="apple-touch-icon" sizes="144x144" href="/favicons/favicon-144x144.png">
        <link rel="apple-touch-icon" sizes="152x152" href="/favicons/favicon-152x152.png">
        <link rel="apple-touch-icon" sizes="180x180" href="/favicons/favicon-180x180.png">
        <link rel="icon" type="image/png" href="/favicons/favicon-32x32.png" sizes="32x32">
        <link rel="icon" type="image/png" href="/favicons/favicon-192x192.png" sizes="192x192">
        <link rel="icon" type="image/png" href="/favicons/favicon-96x96.png" sizes="96x96">
        <link rel="icon" type="image/png" href="/favicons/favicon-16x16.png" sizes="16x16">
        <link rel="manifest" href="/manifest.json">
        <link rel="mask-icon" href="/favicons/safari-pinned-tab.svg" color="#ffffff">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="/favicons/favicon-144x144.png">
        <meta name="theme-color" content="#ffffff">
        -->

        <?php wp_head(); ?>

        <?php if ( preg_match('/^www\./i', $_SERVER[ 'SERVER_NAME' ] ) && !preg_match('/.internal$/i', $_SERVER[ 'SERVER_NAME' ] )) : ?>
            <?php // Inline JS that should only run in production i.e. Analytics ?>
        <?php endif; ?>

    </head>

    <body <?php body_class(); ?>>
