<?php

namespace App\Responders;

use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

/**
 * Class ViewResponder
 *
 * @package App\Responders
 */
final class ViewResponder
{

    /** @var Environment  */
    protected $templating;

    /**
     * ViewResponder constructor.
     *
     * @param Environment $templating
     */
    public function __construct(Environment $templating)
    {
        $this->templating = $templating;
    }

    public function __invoke(string $template, array $paramsTemplate = [])
    {
        return new Response($this->templating->render($template, $paramsTemplate));
    }
}
