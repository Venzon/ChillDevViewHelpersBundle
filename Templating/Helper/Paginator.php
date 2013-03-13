<?php

/**
 * This file is part of the ChillDev ViewHelpers bundle.
 *
 * @author Rafał Wrzeszcz <rafal.wrzeszcz@wrzasq.pl>
 * @copyright 2013 © by Rafał Wrzeszcz - Wrzasq.pl.
 * @version 0.1.3
 * @since 0.1.3
 * @package ChillDev\Bundle\ViewHelpersBundle
 */

namespace ChillDev\Bundle\ViewHelpersBundle\Templating\Helper;

use Knp\Component\Pager\Pagination\PaginationInterface;

use Symfony\Bundle\FrameworkBundle\Templating\Helper\RouterHelper;
use Symfony\Component\Templating\PhpEngine;
use Symfony\Component\Templating\Helper\Helper;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * Paginator helper.
 *
 * This is PHP helper, since KnpPaginatorBundle provides only one for Twig.
 *
 * @author Rafał Wrzeszcz <rafal.wrzeszcz@wrzasq.pl>
 * @copyright 2013 © by Rafał Wrzeszcz - Wrzasq.pl.
 * @version 0.1.3
 * @since 0.1.3
 * @package ChillDev\Bundle\ViewHelpersBundle
 */
class Paginator extends Helper
{
    /**
     * Router generator.
     *
     * @var RouterHelper
     * @version 0.1.3
     * @since 0.1.3
     */
    protected $routerHelper;

    /**
     * Translator.
     *
     * @var TranslatorInterface
     * @version 0.1.3
     * @since 0.1.3
     */
    protected $translator;

    /**
     * Templating engine.
     *
     * @var PhpEngine
     * @version 0.1.3
     * @since 0.1.3
     */
    protected $templating;

    /**
     * Initializes helper.
     *
     * @param RouterHelper $routerHelper Router generator.
     * @param TranslatorInterface $translator Messages translator.
     * @param PhpEngine $templating Templating engine.
     * @version 0.1.3
     * @since 0.1.3
     */
    public function __construct(RouterHelper $routerHelper, TranslatorInterface $translator, PhpEngine $templating)
    {
        $this->routerHelper = $routerHelper;
        $this->translator = $translator;
        $this->templating = $templating;
    }

    /**
     * Renders the pagination template.
     *
     * @param PaginationInterface $pagination Pagination data.
     * @param string $template Template to use.
     * @param array $queryParams URL parameters.
     * @param array $viewParams View parameters.
     * @return string
     * @version 0.1.3
     * @since 0.1.3
     */
    public function render(
        PaginationInterface $pagination,
        $template = null,
        array $queryParams = [],
        array $viewParams = []
    ) {
        $data = $pagination->getPaginationData();

        $data['route'] = $pagination->getRoute();
        $data['query'] = \array_merge($pagination->getParams(), $queryParams);

        $data = \array_merge(
            // options given to paginator when paginated
            $pagination->getPaginatorOptions(),
            // all custom parameters for view
            $pagination->getCustomParameters(),
            // additional custom parameters for view
            $viewParams,
            // merging base route parameters last, to avoid broke of integrity
            $data
        );

        return $this->templating->render($template ?: $pagination->getTemplate(), $data);
    }

    /**
     * Create a sort url for given field.
     *
     * @param PaginationInterface $pagination Pagination data.
     * @param string $title Field title.
     * @param string $key Sorting key.
     * @param array $options Link element attributes.
     * @param array $params Additional parameters.
     * @param string $template Template to use.
     * @return string
     * @version 0.1.3
     * @since 0.1.3
     */
    public function sortable(
        PaginationInterface $pagination,
        $title,
        $key,
        $options = [],
        $params = [],
        $template = null
    ) {
        $options = \array_merge(
            [
                'absolute' => false,
                'translationParameters' => [],
                'translationDomain' => null,
                'translationCount' => null,
            ],
            $options
        );

        $params = \array_merge($pagination->getParams(), $params);

        $direction = isset($options[$pagination->getPaginatorOption('sortDirectionParameterName')])
            ? $options[$pagination->getPaginatorOption('sortDirectionParameterName')]
            : (isset($options['defaultDirection']) ? $options['defaultDirection'] : 'asc')
        ;

        $sorted = $pagination->isSorted($key, $params);

        if ($sorted) {
            $direction = $params[$pagination->getPaginatorOption('sortDirectionParameterName')];
            $direction = \strtolower($direction) == 'asc' ? 'desc' : 'asc';
            $class = $direction == 'asc' ? 'desc' : 'asc';

            if (isset($options['class'])) {
                $options['class'] .= ' ' . $class;
            } else {
                $options['class'] = $class;
            }
        } else {
            $options['class'] = 'sortable';
        }

        if (\is_array($title) && \array_key_exists($direction, $title)) {
            $title = $title[$direction];
        }

        $params = \array_merge(
            $params,
            [
                $pagination->getPaginatorOption('sortFieldParameterName') => $key,
                $pagination->getPaginatorOption('sortDirectionParameterName') => $direction,
                // reset to 1 on sort
                $pagination->getPaginatorOption('pageParameterName') => 1
            ]
        );

        $options['href'] = $this->routerHelper->generate($pagination->getRoute(), $params, $options['absolute']);

        if (null !== $options['translationDomain']) {
            if (null !== $options['translationCount']) {
                $title = $this->translator->transChoice(
                    $title,
                    $options['translationCount'],
                    $options['translationParameters'],
                    $options['translationDomain']
                );
            } else {
                $title = $this->translator->trans(
                    $title,
                    $options['translationParameters'],
                    $options['translationDomain']
                );
            }
        }

        if (!isset($options['title'])) {
            $options['title'] = $title;
        }

        unset($options['absolute'], $options['translationDomain'], $options['translationParameters']);

        $data = \array_merge(
            $pagination->getPaginatorOptions(),
            $pagination->getCustomParameters(),
            compact('options', 'title', 'direction', 'sorted', 'key')
        );

        return $this->templating->render($template ?: $pagination->getSortableTemplate(), $data);
    }

    /**
     * Create a filter url for given field.
     *
     * @param PaginationInterface $pagination Pagination data.
     * @param string $title Field title.
     * @param string $key Filter key.
     * @param array $options Link element attributes.
     * @param array $params Additional parameters.
     * @param string $template Template to use.
     * @return string
     * @version 0.1.3
     * @since 0.1.3
     */
    public function filter(
        PaginationInterface $pagination,
        array $fields,
        $options = [],
        $params = [],
        $template = null
    ) {
        $options = \array_merge(
            [
                'absolute' => false,
                'translationParameters' => [],
                'translationDomain' => null,
                'button' => 'Filter',
            ],
            $options
        );

        $params = \array_merge($pagination->getParams(), $params);
        // reset to 1 on filter
        $params[$pagination->getPaginatorOption('pageParameterName')] = 1;

        $filterFieldName = $pagination->getPaginatorOption('filterFieldParameterName');
        $filterValueName = $pagination->getPaginatorOption('filterValueParameterName');

        $selectedField = isset($params[$filterFieldName]) ? $params[$filterFieldName] : null;
        $selectedValue = isset($params[$filterValueName]) ? $params[$filterValueName] : null;

        $action = $this->routerHelper->generate($pagination->getRoute(), $params, $options['absolute']);

        foreach ($fields as $field => $title) {
            $fields[$field] = $this->translator->trans(
                $title,
                $options['translationParameters'],
                $options['translationDomain']
            );
        }
        $options['button'] = $this->translator->trans(
            $options['button'],
            $options['translationParameters'],
            $options['translationDomain']
        );

        unset($options['absolute'], $options['translationDomain'], $options['translationParameters']);

        $data = \array_merge(
            $pagination->getPaginatorOptions(),
            $pagination->getCustomParameters(),
            compact(
                'fields',
                'action',
                'filterFieldName',
                'filterValueName',
                'selectedField',
                'selectedValue',
                'options'
            )
        );

        return $this->templating->render($template ?: $pagination->getFiltrationTemplate(), $data);
    }

    /**
     * Returns helpers alias.
     *
     * @return string Helper name.
     * @version 0.1.3
     * @since 0.1.3
     */
    public function getName()
    {
        return 'paginator';
    }
}
