<?php

namespace Tests\AppLayout;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class SpaTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_should_load_the_spa_app()
    {
        $this->get('/')
            ->assertStatus(200)
            ->assertViewIs('spa');
    }
}
