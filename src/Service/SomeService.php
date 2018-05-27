<?php
namespace App\Controller;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
// TODO: delete class
class SomeService extends \Controller
{
    private $router;

    public function __construct(UrlGeneratorInterface $router)
    {
        $this->router = $router;
        var_dump($this->router);
    }

    public function someMethod()
    {
        $this->router->generate(
            'createhhhhhhhhhhhhhhhhhhhhhhhhhhhhhh',
            array('slug' => 'my-blog-post')
        );
    }
}
