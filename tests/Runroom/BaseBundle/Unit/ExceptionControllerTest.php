<?php

namespace Tests\Runroom\BaseBundle\Unit;

use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Runroom\BaseBundle\Controller\ExceptionController;
use Runroom\BaseBundle\Service\PageRendererService;
use Symfony\Component\HttpFoundation\Response;

class ExceptionControllerTest extends TestCase
{
    const NOT_FOUND = 'pages/404.html.twig';

    protected function setUp()
    {
        $this->renderer = $this->prophesize(PageRendererService::class);

        $this->controller = new ExceptionController($this->renderer->reveal());
    }

    /**
     * @test
     */
    public function itRenders404()
    {
        $expectedResponse = $this->prophesize(Response::class);

        $this->renderer->renderResponse(
            self::NOT_FOUND,
            null,
            Argument::type(Response::class)
        )->willReturn($expectedResponse->reveal());

        $response = $this->controller->notFound();

        $this->assertSame($expectedResponse->reveal(), $response);
    }
}
