<?php

namespace App\Services;

use Illuminate\Container\Container;
use Lcobucci\JWT\Configuration;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use DateTimeImmutable;
use Lcobucci\JWT\Token\Plain;

class JwtService
{
    private Container $container;

    /**
     * @var mixed|object
     */
    private mixed $config;


    private DateTimeImmutable $now;

    /**
     * Create a new class instance.
     *
     * @param Container $container
     * @param DateTimeImmutable $now
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __construct(Container $container, DateTimeImmutable $now)
    {
        $this->container = $container;
        $this->now = $now;

        $this->config = $this->container->get(Configuration::class);
        assert($this->config instanceof Configuration);
    }

    public function issueToken() : string
    {
        $token = $this->config->builder()
            // Configures the issuer (iss claim)
            ->issuedBy('http://example.com')
            // Configures the audience (aud claim)
            ->permittedFor('http://example.org')
            // Configures the id (jti claim)
            ->identifiedBy('4f1g23a12aa')
            // Configures the time that the token was issue (iat claim)
            ->issuedAt($this->now)
            // Configures the expiration time of the token (exp claim)
            ->expiresAt($this->now->modify('+1 hour'))
            // Configures a new claim, called "uid"
            ->withClaim('uid', 1)
            // Configures a new header, called "foo"
            ->withHeader('foo', 'bar')
            // Builds a new token
            ->getToken($this->config->signer(), $this->config->signingKey());

        return $token->toString();
    }

//    public function verifyToken()
//    {
//    }
//
//    public function deleteToken()
//    {
//    }
//
//    public function refreshToken()
//    {
//    }

}