<?php

namespace App\Services;

use Illuminate\Container\Container;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Signer;

class JwtService
{
    private Container $container;

    /**
     * Create a new class instance.
     *
     * @param Container $container
     * @return void
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function execute(): Configuration
    {
        $configuration = Configuration::forAsymmetricSigner(
            new Signer\Rsa\Sha256(),
            InMemory::file(storage_path('jwt/jwtRS256.pem')),
            InMemory::file(storage_path('jwt/jwtRS256.pem.pub'))
        );

        return $configuration;
    }
}