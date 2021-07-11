<?php

declare(strict_types=1);

namespace spec\App\Command;

use App\Command\SendUserPostsNotificationCommand;
use App\Service\FetchDataService;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;

class SendUserPostsNotificationCommandSpec extends ObjectBehavior
{
    public function let(
        FetchDataService $dataService
    ) {
        $this->beConstructedWith($dataService);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(SendUserPostsNotificationCommand::class);
    }

    public function it_has_a_name(): void
    {
        $this->getName()->shouldBe('app:notification:send-user-posts');
    }

    public function it_has_a_description(): void
    {
        $this->getDescription()->shouldBe(
            'Send User Posts Notification'
        );
    }

    /**
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
//    public function it_send_user_post_notification(
//        InputInterface $input,
//        OutputInterface $output,
//        FetchDataService $dataService
//    ) {
//        $input->getOption('limit')->willReturn(3);
//        $input->getOption('offset')->willReturn(0);
//
//        $dataService->getUsers()->willReturn([
//            ['id' => 1, 'name' => 'Pippo'],
//        ]);
//
//        $dataService->getPosts()->willReturn([
//            ['userId' => 1, 'title' => 'Pluto'],
//            ['userId' => 1, 'title' => 'Topolino'],
//        ]);
//
//        $dataService->mapPostsToUser()->shouldBeCalled()->willReturn([
//            'user' => ['name' => 'Pippo'],
//            'posts' => [
//                ['title' => 'Pluto'],
//                ['title' => 'Topolino'],
//            ],
//        ]);
//
//        $dataService->sendUserPosts(Argument::any())->shouldBeCalled();
//
//        $this->run($input, $output);
//    }
}
