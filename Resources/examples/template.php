<?php

/**
 * This file is part of the ChillDev ViewHelpers bundle.
 *
 * @author Rafał Wrzeszcz <rafal.wrzeszcz@wrzasq.pl>
 * @copyright 2012 - 2013 © by Rafał Wrzeszcz - Wrzasq.pl.
 * @version 0.1.3
 * @since 0.0.1
 * @package ChillDev\Bundle\ViewHelpersBundle
 */

?>
<?php $view['title']->append($title); ?>
<?php $view['meta']->setHttpEquiv('Content-Type', 'text/html; charset="utf-8"'); ?>
<?php $view['link']->add('style/print.css', 'stylesheet', 'text/css', 'print'); ?>
<?php $view['script']->add('javascript/prototype.js', 'application/javascript'); ?>
<?php $view['xmlns']['http://ogp.me/ns/fb#'] = 'fb'; ?>
<html<?php echo $view['xmlns']; ?>>
    <head>
        <?php echo $view['title']; ?>
        <?php echo $view['meta']; ?>
        <?php echo $view['link']; ?>
        <?php echo $view['script']; ?>
    </head>
    <body>
        <<?php echo $view['xmlns']->getPrefix('http://ogp.me/ns/fb#'); ?>like send="true" width="450" show_faces="true"/>
    </body>
</html>
