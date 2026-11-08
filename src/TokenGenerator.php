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
        ?string $origin = null,
        ?string $scope = null,
    ): UnencryptedToken {
        $privateKey = PrivateKeySanitizer::sanitize(privateKey: $privateKey);
        $key = InMemory::plainText($privateKey);

        return (new JwtFacade)->issue(
            new Sha256,
            $key,
            static function (
                Builder $builder,
                DateTimeImmutable $issuedAt,
            ) use ($issuer, $keyIdentifier, $lifetime, $origin, $scope): Builder {
                $builder = $builder
                    ->issuedBy($issuer)
                    ->withHeader('alg', 'ES256')
                    ->withHeader('kid', $keyIdentifier)
                    ->withHeader('typ', 'JWT')
                    ->expiresAt($issuedAt->modify("+$lifetime seconds"));

                if ($origin !== null) {
                    $builder = $builder->withClaim('origin', $origin);
                }

                return $scope === null ? $builder : $builder->withClaim('scope', $scope);
            },
        );
    }

    public function token(int $lifetime = 30 * 60, ?string $scope = null, ?string $origin = null): string
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
            origin: $origin,
            scope: $scope,
        );

        return $token->toString();
    }
}
