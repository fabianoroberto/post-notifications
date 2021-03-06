<?php

declare(strict_types=1);

namespace App\Service;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface as MailerTransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class FetchDataService
{
    private HttpClientInterface $client;

    public function __construct(
        HttpClientInterface $jsonPlaceholderClient,
        private MailerInterface $mailer,
        private string $adminEmail
    ) {
        $this->client = $jsonPlaceholderClient;
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     */
    public function getUsers(): array
    {
        $response = $this->client->request('GET', '/users');

        return $response->toArray();
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     */
    public function getPosts(): array
    {
        $response = $this->client->request('GET', '/posts');

        return $response->toArray();
    }

    /**
     * @param mixed $offset
     *
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     */
    public function mapPostsToUser(int $limit = 3, int $offset = 0): array
    {
        $toReturn = [];
        $users = [];

        foreach ($this->getUsers() as $user) {
            $users[$user['id']] = $user;
        }

        $index = 0;

        foreach ($this->getPosts() as $post) {
            $userId = $post['userId'];

            if (!\array_key_exists($userId, $toReturn)) {
                $index = 0;
                $toReturn[$userId] = [
                    'user' => $users[$userId],
                ];
            }

            $postId = $post['id'];

            if (!\array_key_exists('posts', $toReturn[$userId])) {
                $toReturn[$userId]['posts'] = [];
            }

            if ($index < $offset) {
                continue;
            }

            if ($index >= $limit + $offset) {
                continue;
            }

            $index++;

            $toReturn[$userId]['posts'][$postId] = $post;
        }

        return $toReturn;
    }

    /**
     * @throws MailerTransportExceptionInterface
     */
    public function sendUserPosts(array $data)
    {
        $email = (new TemplatedEmail())
            ->to($this->adminEmail)
            ->subject('PostNotifications | Riassunto ultimi post')
            ->htmlTemplate('emails/summary-posts.html.twig')
            ->context([
                'data' => $data,
                'name' => $this->adminEmail,
            ]);

        $this->mailer->send($email);
    }
}
