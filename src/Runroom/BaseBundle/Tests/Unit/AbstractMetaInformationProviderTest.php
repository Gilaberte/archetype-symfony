<?php

namespace Runroom\BaseBundle\Tests\Unit;

use Prophecy\Argument;
use Runroom\BaseBundle\Service\MetaInformationProvider\AbstractMetaInformationProvider;
use Runroom\BaseBundle\Tests\MotherObject\EntityMetaInformationMotherObject;
use Runroom\BaseBundle\Tests\MotherObject\MetaInformationMotherObject;

class AbstractMetaInformationProviderTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->repository = $this->prophesize('Runroom\BaseBundle\Repository\MetaInformationRepository');

        $this->provider = new TestMetaInformationProvider(
            $this->repository->reveal()
        );

        $this->provider_with_entity = new TestWithEntityMetaInformationProvider(
            $this->repository->reveal()
        );
    }

    /**
     * @test
     */
    public function itDoesNotProvideAnyMetas()
    {
        $meta_routes = ['default', 'home', 'case_study', 'services'];

        foreach ($meta_routes as $meta_route) {
            $this->assertFalse($this->provider->providesMetas($meta_route));
        }
    }

    /**
     * @test
     */
    public function itFindsMetasForRouteAndReplacePlaceholders()
    {
        $meta_route = 'meta_route';
        $model = 'model';

        $expected_title = 'test_title';
        $expected_description = 'test_description';

        $expected_metas = MetaInformationMotherObject::create('placeholder', 'placeholder');

        $this->repository->findOneByRoute($meta_route)
            ->willReturn($expected_metas);

        $metas = $this->provider->findMetasFor($meta_route, $model);

        $title = $metas->getTitle();
        $description = $metas->getDescription();

        $this->assertEquals($expected_title, $title);
        $this->assertEquals($expected_description, $description);
    }

    /**
     * @test
     */
    public function itFindsMetasWithEntityForRouteAndReplacePlaceholders()
    {
        $meta_route = 'meta_route';
        $model = 'model';

        $expected_title = 'meta_title';
        $expected_description = 'meta_description';

        $expected_metas = MetaInformationMotherObject::create('placeholder', 'placeholder');

        $this->repository->findOneByRoute($meta_route)
            ->willReturn($expected_metas);

        $metas = $this->provider_with_entity->findMetasFor($meta_route, $model);

        $title = $metas->getTitle();
        $description = $metas->getDescription();

        $this->assertEquals($expected_title, $title);
        $this->assertEquals($expected_description, $description);
    }
}

class TestMetaInformationProvider extends AbstractMetaInformationProvider
{
    protected function getMetaTitlePlaceholders($model)
    {
        return [
            'placeholder' => 'test_title'
        ];
    }

    protected function getMetaDescriptionPlaceholders($model)
    {
        return [
            'placeholder' => 'test_description'
        ];
    }

    protected function getModelMetaImage($model)
    {
        return null;
    }
}

class TestWithEntityMetaInformationProvider extends AbstractMetaInformationProvider
{
    protected function getMetaTitlePlaceholders($model)
    {
        return [];
    }

    protected function getMetaDescriptionPlaceholders($model)
    {
        return [];
    }

    protected function getModelMetaImage($model)
    {
        return null;
    }

    protected function getEntityMetaInformation($model)
    {
        return EntityMetaInformationMotherObject::createWithMetas();
    }
}
