<?php


/*
 * This file is part of the Sonata package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\BlockBundle\Tests\Page;

use Sonata\BlockBundle\Block\BlockServiceManager;
use Symfony\Component\DependencyInjection\ContainerInterface;

class BlockServiceManagerTest extends \PHPUnit_Framework_TestCase
{
    public function testGetBlockService()
    {
        $service = $this->getMock('Sonata\BlockBundle\Block\BlockServiceInterface');

        $container = $this->getMock('Symfony\Component\DependencyInjection\ContainerInterface');
        $container->expects($this->once())->method('get')->will($this->returnValue($service));

        $manager = new BlockServiceManager($container, true);

        $manager->addBlockService('test', 'test');

        $block = $this->getMock('Sonata\BlockBundle\Model\BlockInterface');
        $block->expects($this->any())->method('getType')->will($this->returnValue('test'));

        $this->assertInstanceOf(get_class($service), $manager->getBlockService($block));
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testInvalidServiceType()
    {
        $service = $this->getMock('stdClass');

        $container = $this->getMock('Symfony\Component\DependencyInjection\ContainerInterface');
        $container->expects($this->once())->method('get')->will($this->returnValue($service));

        $manager = new BlockServiceManager($container, true);

        $manager->addBlockService('test', 'test');

        $block = $this->getMock('Sonata\BlockBundle\Model\BlockInterface');
        $block->expects($this->any())->method('getType')->will($this->returnValue('test'));

        $this->assertInstanceOf(get_class($service), $manager->getBlockService($block));
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testGetBlockServiceException()
    {
        $container = $this->getMock('Symfony\Component\DependencyInjection\ContainerInterface');

        $manager = new BlockServiceManager($container, true);

        $block = $this->getMock('Sonata\BlockBundle\Model\BlockInterface');
        $block->expects($this->any())->method('getType')->will($this->returnValue('fakse'));

        $manager->getBlockService($block);
    }
}