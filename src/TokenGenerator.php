<?php

namespace Inventas\AppleMaps;

use DateTimeImmutable;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\JwtFacade;
use Lcobucci\JWT\Signer\Ecdsa\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\UnencryptedToken;

class TokenGenerator
{
    public function issue(
        string $keyIdentifier,
        string $issuer,
        string $privateKey,
        int $lifetime = 30 * 60,
        ?string $origin = null
    ): UnencryptedToken {
        $privateKey = PrivateKeySanitizer::sanitize(privateKey: $privateKey);
        $key = InMemory::plainText($privateKey);

        return (new JwtFacade)->issue(
            new Sha256,
            $key,
            static fn (
                Builder $builder,
                DateTimeImmutable $issuedAt
            ): Builder => $builder
                ->issuedBy($issuer)
                ->withHeader('alg', 'ES256')
                ->withHeader('kid', $keyIdentifier)
                ->withHeader('typ', 'JWT')
                ->expiresAt($issuedAt->modify("+$lifetime seconds"))
        );
    }

    public function token(int $lifetime = 30 * 60): string
    {
        $keyIdentifier = config('apple-maps.key_id');
        $issuerIdentifier = config('apple-maps.team_id');
        $privateKey = config('apple-maps.private_key');
        $tokenGenerator = new TokenGenerator;
        $token = $tokenGenerator->issue(
            keyIdentifier: $keyIdentifier,
            issuer: $issuerIdentifier,
            privateKey: $privateKey,
            lifetime: $lifetime,
        );

        return $token->toString();
    }
}
