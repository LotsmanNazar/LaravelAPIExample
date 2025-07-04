<?php

namespace App\Services;

use Lcobucci\JWT\Token\Builder;
use Lcobucci\JWT\Token\Parser;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Encoding\JoseEncoder;
use Lcobucci\JWT\Encoding\ChainedFormatter;
use Lcobucci\JWT\Validation\Validator;
use Lcobucci\JWT\Validation\Constraint\SignedWith;

class ApiKeyService {
	public static function create(): string
	{
		$secretSign = config('app.api_secret_sign');
		$key = InMemory::plainText($secretSign);
		$signer = new Sha256();
		$now = new \DateTimeImmutable();
		$date = $now->modify('+1 month');

		$builder = new Builder(new JoseEncoder(), ChainedFormatter::default());
		$builder->expiresAt($date);
		$token = $builder
			->withClaim('user_id', rand())
			->getToken($signer, $key)
			->toString();

		return $token;
	}

	public static function check(string $tokenString): bool
	{
		try {
			$secretSign = config('app.api_secret_sign');
			$parser = new Parser(new JoseEncoder());
			$validator = new Validator();
			$key = InMemory::plainText($secretSign);
			$signer = new Sha256();
			$signed = new SignedWith($signer, $key);
			$token = $parser->parse($tokenString);

			return $validator->validate($token, $signed);
		} catch ( \Exception $e ){
			return false;
		}
	}
}