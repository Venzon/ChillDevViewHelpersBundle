<?php

/**
 * This file is part of the ChillDev ViewHelpers bundle.
 *
 * @author Rafał Wrzeszcz <rafal.wrzeszcz@wrzasq.pl>
 * @copyright 2013 © by Rafał Wrzeszcz - Wrzasq.pl.
 * @version 0.1.5
 * @since 0.1.2
 * @package ChillDev\Bundle\ViewHelpersBundle
 */

?>
<?php if ($pageCount > 1): ?>
    <div class="pagination">
        <?php if (isset($first) && $current != $first): ?>
            <a href="<?php echo $view->escape($view['router']->generate($route, \array_merge($query, [$pageParameterName => $first]))); ?>">«</a>
        <?php endif; ?>

        <?php if (isset($previous)): ?>
            <a href="<?php echo $view->escape($view['router']->generate($route,\array_merge($query, [$pageParameterName => $previous]))); ?>" rel="prev">‹</a>
        <?php endif; ?>

        <?php foreach ($pagesInRange as $page): ?>
            <?php if ($page != $current): ?>
                <a href="<?php echo $view->escape($view['router']->generate($route, \array_merge($query, [$pageParameterName => $page]))); ?>"><?php echo $page; ?></a>
            <?php else: ?>
                <span class="current"><?php echo $page; ?></span>
            <?php endif; ?>
        <?php endforeach; ?>

        <?php if (isset($next)): ?>
            <a href="<?php echo $view->escape($view['router']->generate($route, \array_merge($query, [$pageParameterName => $next]))); ?>" rel="next">›</a>
        <?php endif; ?>

        <?php if (isset($last) && $current != $last): ?>
            <a href="<?php echo $view->escape($view['router']->generate($route, \array_merge($query, [$pageParameterName => $last]))); ?>">»</a>
        <?php endif; ?>
    </div>
<?php endif; ?>
