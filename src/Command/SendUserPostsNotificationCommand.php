<?php

declare(strict_types=1);

namespace App\Command;

use App\Service\FetchDataService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

#[AsCommand(
    name: 'app:notification:send-user-posts',
    description: 'Send User Posts Notification',
)]
class SendUserPostsNotificationCommand extends Command
{
    public function __construct(private FetchDataService $dataService)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addOption('limit', 'l', InputArgument::OPTIONAL, 'Number of posts to show', 3)
            ->addOption('offset', 'o', InputArgument::OPTIONAL, 'Initial position of posts to show', 0);
    }

    /**
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $limit = $input->getOption('limit');
        $offset = $input->getOption('offset');

        $io->note(\sprintf('Command started with option limit: %d and offset: %d', $limit, $offset));

        $data = $this->dataService->mapPostsToUser($limit, $offset);
        $this->dataService->sendUserPosts($data);

        return Command::SUCCESS;
    }
}
