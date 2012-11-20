<?php

/**
 * This file is part of the ChillDev ViewHelpers bundle.
 *
 * @author Rafał Wrzeszcz <rafal.wrzeszcz@wrzasq.pl>
 * @copyright 2012 © by Rafał Wrzeszcz - Wrzasq.pl.
 * @version 0.0.2
 * @since 0.0.1
 * @package ChillDev\Bundle\ViewHelpersBundle
 */

?>
<?php $view['title']->append($title); ?>
<?php $view['meta']->setHttpEquiv('Content-Type', 'text/html; charset="utf-8"'); ?>
<?php $view['link']->add('style/print.css', 'stylesheet', 'text/css', 'print'); ?>
<?php $view['script']->add('javascript/prototype.js', 'application/javascript'); ?>
<html>
    <head>
        <?php echo $view['title']; ?>
        <?php echo $view['meta']; ?>
        <?php echo $view['link']; ?>
        <?php echo $view['script']; ?>
    </head>
    <body>
        <pre><?php echo $view['serializer']->serialize(['Hello', 'World']); ?></pre>
    </body>
</html>
