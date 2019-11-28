<?php

namespace App\Responders;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class RedirectResponder
{
    /** @var UrlGeneratorInterface */
    protected $urlGenerator;

    public function __construct(UrlGeneratorInterface $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }

    public function __invoke(string $routeName, array $paramsRoute = [], int $statusCode = Response::HTTP_FOUND): RedirectResponse
	{
		return new RedirectResponse(
			$this->urlGenerator->generate($routeName, $paramsRoute),
			$statusCode
		);
	}
}
