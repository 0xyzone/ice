<?php

namespace Tests\Feature;

use Tests\TestCase;

class LegalPagesTest extends TestCase
{
    public function test_privacy_policy_page_renders_successfully(): void
    {
        $response = $this->get('/privacy-policy');

        $response->assertStatus(200);
        $response->assertSee('PRIVACY');
        $response->assertSee('Google API Services User Data Policy');
        $response->assertSee('Limited Use');
    }

    public function test_privacy_alias_redirects(): void
    {
        $response = $this->get('/privacy');

        $response->assertRedirect('/privacy-policy');
    }

    public function test_terms_of_service_page_renders_successfully(): void
    {
        $response = $this->get('/terms-of-service');

        $response->assertStatus(200);
        $response->assertSee('TERMS OF');
        $response->assertSee('Acceptance of Terms');
    }

    public function test_terms_alias_redirects(): void
    {
        $response = $this->get('/terms');

        $response->assertRedirect('/terms-of-service');
    }
}
