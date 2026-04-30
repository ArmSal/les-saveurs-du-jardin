<?php
// tests/Controller/SecurityControllerTest.php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Functional tests for the authentication and security system.
 * Validates that public routes are accessible and protected routes
 * enforce authentication.
 */
class SecurityControllerTest extends WebTestCase
{
    /**
     * Test that the login page (/) is publicly accessible without authentication.
     */
    public function testLoginPageIsPubliclyAccessible(): void
    {
        $client = static::createClient();
        $client->request('GET', '/');

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(200);
    }

    /**
     * Test that the login form is present on the homepage.
     */
    public function testLoginPageContainsForm(): void
    {
        $client = static::createClient();
        $client->request('GET', '/');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('form');
        $this->assertSelectorExists('input[type="password"]');
    }

    /**
     * Test that accessing a protected route without authentication
     * redirects to the login page.
     * This validates the RBAC / firewall configuration is active.
     */
    public function testProtectedDashboardRedirectsToLogin(): void
    {
        $client = static::createClient();
        $client->request('GET', '/dashboard');

        // Must redirect (302) when not authenticated
        $this->assertResponseRedirects();

        // Follow the redirect and verify we land on the login page
        $client->followRedirect();
        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('input[type="password"]');
    }

    /**
     * Test that the HR module is also protected.
     */
    public function testProtectedHRRouteRedirectsToLogin(): void
    {
        $client = static::createClient();
        $client->request('GET', '/rh/agenda');

        $this->assertResponseRedirects();
    }

    /**
     * Test that submitting invalid credentials shows an error.
     */
    public function testInvalidLoginShowsError(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $this->assertResponseIsSuccessful();

        $form = $crawler->selectButton('LOGIN')->form([
            'email' => 'invalid@test.com',
            'password' => 'wrongpassword',
        ]);

        $client->submit($form);

        if ($client->getResponse()->isRedirect()) {
            $client->followRedirect();
        }

        // After failed login, the login page is shown again
        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('input[type="password"]');
    }
}
