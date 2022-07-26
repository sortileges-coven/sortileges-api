<?php

namespace App\Tests\Controller;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use App\Repository\UserRepository;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;

class RegistrationControllerTest extends ApiTestCase
{
    use RefreshDatabaseTrait;

    public function testRegistrationMissingData(): void
    {
        static::createClient()->request('POST', '/register', ['json' => []]);
        $this->assertResponseStatusCodeSame(400);
        $this->assertJsonContains(['message' => 'Registration failed', 'errors' => [
            ['field' => 'email', 'message' => 'This value should not be blank.'],
            ['field' => 'password', 'message' => 'This value should not be blank.'],
            ['field' => 'pseudo', 'message' => 'This value should not be blank.'],
        ]]);
    }

    public function testRegistrationInvalidEmail(): void
    {
        static::createClient()->request('POST', '/register', ['json' => [
            'email' => 'invalid email',
            'password' => 'randomValidPassword',
            'pseudo' => 'randomValidPseudo',
        ]]);
        $this->assertResponseStatusCodeSame(400);
        $this->assertJsonContains(['message' => 'Registration failed', 'errors' => [
            ['field' => 'email', 'message' => 'This value is not a valid email address.'],
        ]]);
    }

    public function testRegistrationPasswordTooShort(): void
    {
        static::createClient()->request('POST', '/register', ['json' => [
            'email' => 'random@email.com',
            'password' => 'short',
            'pseudo' => 'randomValidPseudo',
        ]]);
        $this->assertResponseStatusCodeSame(400);
        $this->assertJsonContains(['message' => 'Registration failed', 'errors' => [
            ['field' => 'password', 'message' => 'This value is too short. It should have 8 characters or more.'],
        ]]);
    }

    public function testRegistrationPseudoTooShort(): void
    {
        static::createClient()->request('POST', '/register', ['json' => [
            'email' => 'random@email.com',
            'password' => 'randomValidPassword',
            'pseudo' => 'sh',
        ]]);
        $this->assertResponseStatusCodeSame(400);
        $this->assertJsonContains(['message' => 'Registration failed', 'errors' => [
            ['field' => 'pseudo', 'message' => 'This value is too short. It should have 3 characters or more.'],
        ]]);
    }

    public function testRegistrationOk(): void
    {
        $email = 'random@email.com';
        $pseudo = 'randomValidPseudo';
        static::createClient()->request('POST', '/register', ['json' => [
            'email' => $email,
            'password' => 'randomValidPassword',
            'pseudo' => $pseudo,
        ]]);

        $this->assertResponseStatusCodeSame(204);
        $user = static::getContainer()->get(UserRepository::class)->findOneBy(['email' => $email]);
        $this->assertNotNull($user);
        $this->assertSame($email, $user->getEmail());
        $this->assertSame($pseudo, $user->getPseudo());
    }
}
