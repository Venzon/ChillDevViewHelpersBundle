<?php

/**
 * This file is part of the ChillDev ViewHelpers bundle.
 *
 * @author Rafał Wrzeszcz <rafal.wrzeszcz@wrzasq.pl>
 * @copyright 2012 © by Rafał Wrzeszcz - Wrzasq.pl.
 * @version 0.0.1
 * @since 0.0.1
 * @package ChillDevViewHelpersBundle
 */

?>
<?php $view['title']->append($title); ?>
<html>
    <head>
        <title><?php echo $view['title']; ?></title>
    </head>
    <body>
    </body>
</html>
