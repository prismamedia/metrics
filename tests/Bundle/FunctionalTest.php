<?php

namespace PrismaMedia\Metrics\Tests\Bundle;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FunctionalTest extends WebTestCase
{
    /**
     * Requires Symfony 5.4+
     */
    public function testEndpointMetrics(): void
    {
        $client = static::createClient();
        $client->catchExceptions(false);

        ob_start();
        $client->request('GET', '/metrics');
        $content = ob_get_contents();
        ob_end_clean();

        $this->assertResponseIsSuccessful();

        $expected =
            "article_total{brand=\"Capital\"} 42\r\n".
            "article_total{brand=\"Femme Actuelle\"} 876\r\n".
            "article_total{brand=\"Télé-Loisirs\"} 381\r\n";
        $this->assertSame($expected, $content);

        $this->assertSame(200, $client->getResponse()->getStatusCode());
        $this->assertFalse($client->getResponse()->isCacheable());
    }
}
