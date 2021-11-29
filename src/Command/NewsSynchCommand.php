<?php

namespace App\Command;

use App\Entity\NewsApi;
use App\Services\NewsService;
use Doctrine\ORM\EntityManagerInterface;
use GuzzleHttp\Exception\GuzzleException;
use PHPUnit\Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;


class NewsSynchCommand extends Command
{
    /**
     * @var NewsService
     */
    private NewsService $newsService;


    /**
     * @var string
     */
    protected static $defaultName = 'app:news-sync';

    /**
     * @var string
     */
    protected static $defaultDescription = 'To synchronise news';

    /**
     * @param NewsService $newsService
     * @param string|null $name
     */
    public function __construct(
        NewsService $newsService,
        string      $name = null
    )
    {
        $this->newsService = $newsService;
        parent::__construct($name);
    }

    protected function configure(): void
    {
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     * @throws GuzzleException
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln([
            '<info>News detected</info>',
            'Fetch News details from API in progress'
        ]);

        try {
            $this->newsService->processNews($output);
        } catch (\Exception $exception) {
            $output->writeln([
                "<comment>{$exception->getMessage()}</comment>",
            ]);
        }

        return true;
    }

}
