<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\CoreExtension;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* SkeletonView.twig */
class __TwigTemplate_04a10e7b79f8ef5493df33bc002db85c extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
            'content' => [$this, 'block_content'],
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 1
        yield from         $this->loadTemplate("HeaderView.twig", "SkeletonView.twig", 1)->unwrap()->yield($context);
        // line 2
        yield "
<hr>

<main>
    ";
        // line 6
        yield from $this->unwrap()->yieldBlock('content', $context, $blocks);
        // line 7
        yield "</main>

<hr>

";
        // line 11
        yield from         $this->loadTemplate("FooterView.twig", "SkeletonView.twig", 11)->unwrap()->yield($context);
        return; yield '';
    }

    // line 6
    public function block_content($context, array $blocks = [])
    {
        $macros = $this->macros;
        return; yield '';
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "SkeletonView.twig";
    }

    /**
     * @codeCoverageIgnore
     */
    public function isTraitable()
    {
        return false;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getDebugInfo()
    {
        return array (  60 => 6,  55 => 11,  49 => 7,  47 => 6,  41 => 2,  39 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "SkeletonView.twig", "C:\\Users\\loris\\Documents\\GitHub\\SAE_S4\\api\\src\\app\\views\\SkeletonView.twig");
    }
}
