<?php

/**
 * This file is part of the ChillDev ViewHelpers bundle.
 *
 * @author Rafał Wrzeszcz <rafal.wrzeszcz@wrzasq.pl>
 * @copyright 2012 - 2013 © by Rafał Wrzeszcz - Wrzasq.pl.
 * @version 0.1.2
 * @since 0.0.1
 * @package ChillDev\Bundle\ViewHelpersBundle
 */

namespace ChillDev\Bundle\ViewHelpersBundle\Tests\Templating\Helper;

use ChillDev\Bundle\ViewHelpersBundle\Templating\Helper\Meta;
use ChillDev\Bundle\ViewHelpersBundle\Templating\Container\Meta as Container;
use ChillDev\Bundle\ViewHelpersBundle\Tests\BaseTemplatingTest;

/**
 * @author Rafał Wrzeszcz <rafal.wrzeszcz@wrzasq.pl>
 * @copyright 2012 - 2013 © by Rafał Wrzeszcz - Wrzasq.pl.
 * @version 0.1.2
 * @since 0.0.1
 * @package ChillDev\Bundle\ViewHelpersBundle
 */
class MetaTest extends BaseTemplatingTest
{
    /**
     * @test
     * @version 0.1.0
     * @since 0.0.1
     */
    public function getHelperName()
    {
        $this->assertEquals('meta', (new Meta($this->templating, $this->checker, $this->markup))->getName(), 'Meta::getName() should return helper alias.');
    }

    /**
     * Check operations on meta-name values.
     *
     * @test
     * @version 0.1.0
     * @since 0.0.1
     */
    public function metaNameCrud()
    {
        $key = 'foo';
        $value = 'bar';

        $meta = new Meta($this->templating, $this->checker, $this->markup);

        $this->assertEquals('', $meta->getMetaName($key), 'Meta::getMetaName() should return empty string for undefined meta names.');

        $meta->setMetaName($key, $value);

        $this->assertEquals($value, $meta->getMetaName($key), 'Meta::setMetaName() should set meta name value and Meta::getMetaName() should return that value.');

        $meta->unsetMetaName($key);

        $this->assertEquals('', $meta->getMetaName($key), 'Meta::unsetMetaName() should delete value for specified meta name.');
    }

    /**
     * Check operations on meta-properties values.
     *
     * @test
     * @version 0.1.0
     * @since 0.0.1
     */
    public function metaPropertyCrud()
    {
        $key = 'foo';
        $value = 'bar';

        $meta = new Meta($this->templating, $this->checker, $this->markup);

        $this->assertEquals('', $meta->getProperty($key), 'Meta::getProperty() should return empty string for undefined meta properties.');

        $meta->setProperty($key, $value);

        $this->assertEquals($value, $meta->getProperty($key), 'Meta::setProperty() should set meta property value and Meta::getProperty() should return that value.');

        $meta->unsetProperty($key);

        $this->assertEquals('', $meta->getProperty($key), 'Meta::unsetProperty() should delete value for specified meta property.');
    }

    /**
     * Check operations on meta-http-equiv values.
     *
     * @test
     * @version 0.1.0
     * @since 0.0.1
     */
    public function metaHttpEquivCrud()
    {
        $key = 'foo';
        $value = 'bar';

        $meta = new Meta($this->templating, $this->checker, $this->markup);

        $this->assertEquals('', $meta->getHttpEquiv($key), 'Meta::getHttpEquiv() should return empty string for undefined meta HTTP-equivs.');

        $meta->setHttpEquiv($key, $value);

        $this->assertEquals($value, $meta->getHttpEquiv($key), 'Meta::setHttpEquiv() should set meta HTTP-equiv value and Meta::getHttpEquiv() should return that value.');

        $meta->unsetHttpEquiv($key);

        $this->assertEquals('', $meta->getHttpEquiv($key), 'Meta::unsetHttpEquiv() should delete value for specified meta HTTP-equiv.');
    }

    /**
     * Check to-string conversion.
     *
     * @test
     * @version 0.1.0
     * @since 0.0.1
     */
    public function toStringConversion()
    {
        $key1 = 'foo';
        $value1 = 'bar';
        $key2 = 'baz';
        $value2 = 'qux';
        $key3 = 'quux';
        $value3 = 'corge';

        $container1 = new Container($this->templating, $this->checker, $this->markup, 'name');
        $container1[$key1] = $value1;
        $container1[$key2] = $value2;

        $container2 = new Container($this->templating, $this->checker, $this->markup, 'property');
        $container2[$key3] = $value3;

        $meta = new Meta($this->templating, $this->checker, $this->markup);
        $meta->setMetaName($key1, $value1)
            ->setMetaName($key2, $value2)
            ->setProperty($key3, $value3);

        $this->assertEquals(((string) $container1) . ((string) $container2), $meta->__toString(), 'Meta::__toString() should generate all contained <meta> tags.');
    }

    /**
     * Check to-string casting.
     *
     * @test
     * @version 0.1.0
     * @since 0.0.1
     */
    public function toStringCasting()
    {
        $key = 'foo';
        $value = 'bar';

        $container = new Container($this->templating, $this->checker, $this->markup, 'name');
        $container[$key] = $value;

        $meta = new Meta($this->templating, $this->checker, $this->markup);
        $meta->setMetaName($key, $value);

        $this->assertEquals((string) $container, (string) $meta, 'Meta::__toString() should handle conversion to string.');
    }
}
