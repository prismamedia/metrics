<?php

declare(strict_types=1);

namespace PrismaMedia\Metrics\Tests\Bundle;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FunctionalTest extends WebTestCase
{
    /**
     * Requires Symfony 5.4+.
     */
    public function testEndpointMetrics(): void
    {
        $client = static::createClient();
        $client->catchExceptions(false);

        $client->request('GET', '/metrics');
        $content = $client->getResponse()->getContent();

        $this->assertResponseIsSuccessful();

        $expected =
            "article_total{brand=\"Capital\"} 42\n".
            "article_total{brand=\"Femme Actuelle\"} 876\n".
            "article_total{brand=\"Télé-Loisirs\"} 381\n";
        $this->assertSame($expected, $content);

        $this->assertSame(200, $client->getResponse()->getStatusCode());
        $this->assertFalse($client->getResponse()->isCacheable());
    }
}
