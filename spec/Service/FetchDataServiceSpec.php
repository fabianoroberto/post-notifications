<?php

declare(strict_types=1);

namespace spec\App\Service;

use App\Service\FetchDataService;
use PhpSpec\ObjectBehavior;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class FetchDataServiceSpec extends ObjectBehavior
{
    public function let(
        HttpClientInterface $jsonPlaceholderClient,
        MailerInterface $mailer
    ) {
        $this->beConstructedWith($jsonPlaceholderClient, $mailer, 'pippo@pluto.it');
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(FetchDataService::class);
    }
}
