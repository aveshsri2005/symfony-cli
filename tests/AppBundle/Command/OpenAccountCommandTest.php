<?php
// tests/AppBundle/Command/OpenAccountCommandTest.php


namespace Tests\AppBundle\Command;
use AppBundle\Command;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\Console\Output\OutputInterface;

class PrintLastFortuneCommandTest extends \PHPUnit_Framework_TestCase
{
    private $app;

    protected function setUp()
    {
        $kernel = new \AppKernel('test', false);
        $application = new Application($kernel);
        $application->setAutoExit(false);
        $this->app = new ApplicationTester($application);
    }

    /**
     * @test
     */
    public function it_opens_account()
    {
        $input = array(
            'account:open',
        );

        $exitCode = $this->app->run($input);

        self::assertSame(0, $exitCode, $this->app->getDisplay());
    }
}

