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
use Twig\TemplateWrapper;

/* security/login.html.twig */
class __TwigTemplate_afddaf113012a7535518ee7eb08cd55e extends Template
{
    private Source $source;
    /**
     * @var array<string, Template>
     */
    private array $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->blocks = [
            'title' => [$this, 'block_title'],
            'body' => [$this, 'block_body'],
        ];
    }

    protected function doGetParent(array $context): bool|string|Template|TemplateWrapper
    {
        // line 1
        return "base.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "security/login.html.twig"));

        $this->parent = $this->load("base.html.twig", 1);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

    }

    // line 3
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_title(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "title"));

        yield "S'identifier | Plateforme LSDJ
";
        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

        yield from [];
    }

    // line 6
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_body(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "body"));

        // line 7
        yield "\t<div class=\"w-full max-w-md mx-auto p-4 sm:p-6 pt-2 sm:pt-4\">
\t\t<style>
\t\t\t@import url('https://fonts.googleapis.com/css2?family=Dancing+Script:wght@600 &display=swap');
\t\t\t/* Prevent scrolling entirely on the login page */
\t\t\thtml,
\t\t\tbody,
\t\t\t.main-content,
\t\t\t.auth-layout {
\t\t\t\theight: 100% !important;
\t\t\t\tmin-height: 100% !important;
\t\t\t\tmax-height: 100% !important;
\t\t\t\toverflow: hidden !important;
\t\t\t\tmargin: 0;
\t\t\t\tpadding: 0;
\t\t\t}

\t\t\t.login-brand-container {
\t\t\t\tposition: relative;
\t\t\t\twidth: 100%;
\t\t\t\theight: 240px;
\t\t\t\tmargin-bottom: -10px; /* Negative margin to pull form up */
\t\t\t\tmargin-top: 25px; /* Increased top margin as requested */
\t\t\t\tpadding: 0;
\t\t\t\tdisplay: flex;
\t\t\t\tflex-direction: column;
\t\t\t\talign-items: center;
\t\t\t\tjustify-content: center;
\t\t\t\toverflow: visible; /* Prevent clipping during pulse */
\t\t\t}
\t\t\t.login-line {
\t\t\t\tposition: absolute;
\t\t\t\twidth: 90%;
\t\t\t\theight: 2px;
\t\t\t\tbackground: #a9df51;
\t\t\t\ttop: 60%; /* Moved down to give more space above */
\t\t\t\tleft: 5%;
\t\t\t\ttransform: scaleX(0);
\t\t\t\ttransform-origin: center;
\t\t\t\tanimation: drawLine 1.2s cubic-bezier(0.65, 0, 0.35, 1) forwards;
\t\t\t}

\t\t\t/* Container for above the line */
\t\t\t.brand-top-content {
\t\t\t\tposition: absolute;
\t\t\t\tbottom: 40%; /* Adjusted to match the line at top: 60% */
\t\t\t\tdisplay: flex;
\t\t\t\talign-items: flex-end;
\t\t\t\tgap: 15px;
\t\t\t}

\t\t\t/* Phase 2: Logo raise (Increased duration) */
\t\t\t.login-logo {
\t\t\t\twidth: 80px;
\t\t\t\theight: auto;
\t\t\t\topacity: 0;
\t\t\t\ttransform: translateY(40px);
\t\t\t\tanimation: logoRaise 0.8s cubic-bezier(0.22, 1, 0.36, 1) 1.2s forwards, pulse 3s ease-in-out 6.5s infinite; /* Keeping the pulse but without shadow */
\t\t\t}

\t\t\t.text-stack {
\t\t\t\tdisplay: flex;
\t\t\t\tflex-direction: column;
\t\t\t\talign-items: flex-start;
\t\t\t\toverflow: visible;
\t\t\t}

\t\t\t/* Phase 3: LES slide out (Increased duration) */
\t\t\t.les-container {
\t\t\t\toverflow: hidden;
\t\t\t}
\t\t\t.stack-les {
\t\t\t\tfont-size: 28px;
\t\t\t\tfont-weight: 800;
\t\t\t\tcolor: #234954;
\t\t\t\ttext-transform: uppercase;
\t\t\t\tline-height: 1;
\t\t\t\tmargin-bottom: 2px;
\t\t\t\topacity: 0;
\t\t\t\ttransform: translateX(-50px);
\t\t\t\tanimation: slideFromLeft 0.8s cubic-bezier(0.22, 1, 0.36, 1) 2s forwards;
\t\t\t}

\t\t\t/* Phase 4: SAVEURS raise (Increased duration) */
\t\t\t.saveurs-container {
\t\t\t\toverflow: hidden;
\t\t\t}
\t\t\t.stack-saveurs {
\t\t\t\tfont-size: 46px;
\t\t\t\tfont-weight: 950;
\t\t\t\tcolor: #234954;
\t\t\t\ttext-transform: uppercase;
\t\t\t\tline-height: 0.85;
\t\t\t\tletter-spacing: -2px;
\t\t\t\topacity: 0;
\t\t\t\ttransform: translateY(50px);
\t\t\t\tanimation: textRaise 0.8s cubic-bezier(0.22, 1, 0.36, 1) 2.6s forwards;
\t\t\t}

\t\t\t/* Phase 5 & 6: DU raise and rotate (Increased duration) */
\t\t\t.du-jardin-wrapper {
\t\t\t\tdisplay: flex;
\t\t\t\talign-items: center;
\t\t\t\tgap: 4px;
\t\t\t\tmargin-top: 5px;
\t\t\t}
\t\t\t.du-container {
\t\t\t\tdisplay: inline-block;
\t\t\t\toverflow: visible;
\t\t\t}
\t\t\t.text-du {
\t\t\t\tdisplay: inline-block;
\t\t\t\tfont-size: 26px;
\t\t\t\tfont-weight: 900;
\t\t\t\tcolor: #234954;
\t\t\t\ttext-transform: uppercase;
\t\t\t\tline-height: 1;
\t\t\t\topacity: 0;
\t\t\t\ttransform-origin: center;
\t\t\t\ttransform: translateY(30px) rotate(-90deg);
\t\t\t\tanimation: duSequence 1.5s cubic-bezier(0.45, 0, 0.55, 1) 3.2s forwards;
\t\t\t}

\t\t\t/* Phase 7: JARDIN slide out (Increased duration) */
\t\t\t.jardin-container {
\t\t\t\toverflow: hidden;
\t\t\t\tpadding-left: 0;
\t\t\t}
\t\t\t.text-jardin {
\t\t\t\tdisplay: inline-block;
\t\t\t\tfont-size: 46px;
\t\t\t\tfont-weight: 950;
\t\t\t\tcolor: #234954;
\t\t\t\ttext-transform: uppercase;
\t\t\t\tline-height: 0.85;
\t\t\t\tletter-spacing: 2px;
\t\t\t\topacity: 0;
\t\t\t\ttransform: translateX(-150px);
\t\t\t\tanimation: slideFromLeft 0.8s cubic-bezier(0.22, 1, 0.36, 1) 4.5s forwards;
\t\t\t}

\t\t\t/* Phase 8: Slogan (Increased duration) */
\t\t\t.slogan-row {
\t\t\t\tposition: absolute;
\t\t\t\ttop: calc(60% + 20px); /* Lower under the line */
\t\t\t\tleft: 0;
\t\t\t\tright: 0;
\t\t\t\ttext-align: center;
\t\t\t\tfont-family: 'Dancing Script', cursive;
\t\t\t\tfont-size: 24px;
\t\t\t\tcolor: #a9df51;
\t\t\t\topacity: 0;
\t\t\t\ttransform: translateY(0);
\t\t\t\twhite-space: nowrap;
\t\t\t\tanimation: fadeIn 1s ease-out 5.2s forwards;
\t\t\t}

\t\t\t/* Keyframes (Refined for fluidity) */
\t\t\t@keyframes drawLine {
\t\t\t\tto {
\t\t\t\t\ttransform: scaleX(1);
\t\t\t\t}
\t\t\t}
\t\t\t@keyframes logoRaise {
\t\t\t\tto {
\t\t\t\t\topacity: 1;
\t\t\t\t\ttransform: translateY(0);
\t\t\t\t}
\t\t\t}
\t\t\t@keyframes slideFromLeft {
\t\t\t\tto {
\t\t\t\t\topacity: 1;
\t\t\t\t\ttransform: translateX(0);
\t\t\t\t}
\t\t\t}
\t\t\t@keyframes textRaise {
\t\t\t\tto {
\t\t\t\t\topacity: 1;
\t\t\t\t\ttransform: translateY(0);
\t\t\t\t}
\t\t\t}
\t\t\t@keyframes duSequence {
\t\t\t\t0% {
\t\t\t\t\topacity: 0;
\t\t\t\t\ttransform: translateY(30px) rotate(0deg);
\t\t\t\t}
\t\t\t\t40% {
\t\t\t\t\topacity: 1;
\t\t\t\t\ttransform: translateY(0) rotate(0deg);
\t\t\t\t}
\t\t\t\t100% {
\t\t\t\t\topacity: 1;
\t\t\t\t\ttransform: translateY(0) rotate(-90deg);
\t\t\t\t}
\t\t\t}
\t\t\t@keyframes fadeIn {
\t\t\t\tto {
\t\t\t\t\topacity: 1;
\t\t\t\t}
\t\t\t}
\t\t\t@keyframes pulse {
\t\t\t\t0% {
\t\t\t\t\ttransform: translateY(0);
\t\t\t\t}
\t\t\t\t50% {
\t\t\t\t\ttransform: translateY(-6px); /* Moves only upward */
\t\t\t\t}
\t\t\t\t100% {
\t\t\t\t\ttransform: translateY(0);
\t\t\t\t}
\t\t\t}
\t\t</style>

\t\t<div class=\"login-brand-container\">
\t\t\t<div class=\"login-line\"></div>

\t\t\t<div class=\"brand-top-content\">
\t\t\t\t<img src=\"";
        // line 223
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("logo.svg"), "html", null, true);
        yield "\" class=\"login-logo\" alt=\"Logo\">
\t\t\t\t<div class=\"text-stack\">
\t\t\t\t\t<div class=\"les-container\">
\t\t\t\t\t\t<div class=\"stack-les\">Les</div>
\t\t\t\t\t</div>
\t\t\t\t\t<div class=\"saveurs-container\">
\t\t\t\t\t\t<div class=\"stack-saveurs\">Saveurs</div>
\t\t\t\t\t</div>
\t\t\t\t\t<div class=\"du-jardin-wrapper\">
\t\t\t\t\t\t<div class=\"du-container\">
\t\t\t\t\t\t\t<span class=\"text-du\">Du</span>
\t\t\t\t\t\t</div>
\t\t\t\t\t\t<div class=\"jardin-container\">
\t\t\t\t\t\t\t<span class=\"text-jardin\">Jardin</span>
\t\t\t\t\t\t</div>
\t\t\t\t\t</div>
\t\t\t\t</div>
\t\t\t</div>

\t\t\t<div class=\"slogan-row\">
\t\t\t\tfruits & légumes en toute saison !
\t\t\t</div>
\t\t</div>

\t\t";
        // line 247
        if ((($tmp = (isset($context["error"]) || array_key_exists("error", $context) ? $context["error"] : (function () { throw new RuntimeError('Variable "error" does not exist.', 247, $this->source); })())) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 248
            yield "\t\t\t<div class=\"flex items-center gap-3 bg-red-50 border border-red-200 text-red-700 rounded-lg px-4 py-3 mb-6 text-sm font-semibold\">
\t\t\t\t<svg width=\"18\" height=\"18\" fill=\"currentColor\" viewbox=\"0 0 20 20\" class=\"shrink-0\">
\t\t\t\t\t<path fill-rule=\"evenodd\" d=\"M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z\" clip-rule=\"evenodd\"></path>
\t\t\t\t</svg>
\t\t\t\t";
            // line 252
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans(CoreExtension::getAttribute($this->env, $this->source, (isset($context["error"]) || array_key_exists("error", $context) ? $context["error"] : (function () { throw new RuntimeError('Variable "error" does not exist.', 252, $this->source); })()), "messageKey", [], "any", false, false, false, 252), CoreExtension::getAttribute($this->env, $this->source, (isset($context["error"]) || array_key_exists("error", $context) ? $context["error"] : (function () { throw new RuntimeError('Variable "error" does not exist.', 252, $this->source); })()), "messageData", [], "any", false, false, false, 252), "security"), "html", null, true);
            yield "
\t\t\t</div>
\t\t";
        }
        // line 255
        yield "
\t\t<form method=\"post\" class=\"space-y-6\">
\t\t\t<div class=\"flex flex-col items-center space-y-4\">
\t\t\t\t<div class=\"w-full max-w-[250px]\">
\t\t\t\t\t<input type=\"email\" value=\"";
        // line 259
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((isset($context["last_username"]) || array_key_exists("last_username", $context) ? $context["last_username"] : (function () { throw new RuntimeError('Variable "last_username" does not exist.', 259, $this->source); })()), "html", null, true);
        yield "\" name=\"email\" id=\"username\" autocomplete=\"email\" required autofocus placeholder=\"EMAIL\" class=\"w-full h-8 border border-slate-300 rounded-lg px-4 text-xs font-bold text-slate-900 text-center outline-none focus:ring-2 focus:ring-[#234954]/10 focus:border-[#234954] transition-all bg-white/80 backdrop-blur-sm shadow-sm leading-none\">
\t\t\t\t</div>

\t\t\t\t<div class=\"w-full max-w-[250px]\">
\t\t\t\t\t<div class=\"relative group\">
\t\t\t\t\t\t<input type=\"password\" name=\"password\" id=\"password\" autocomplete=\"current-password\" required placeholder=\"MOT DE PASSE\" class=\"w-full h-8 border border-slate-300 rounded-lg px-8 text-xs font-bold text-slate-900 text-center outline-none focus:ring-2 focus:ring-[#234954]/10 focus:border-[#234954] transition-all bg-white/80 backdrop-blur-sm shadow-sm leading-none\">
\t\t\t\t\t\t<button type=\"button\" onclick=\"togglePasswordVisibility()\" class=\"absolute right-2 top-1/2 -translate-y-1/2 p-1 text-slate-400 hover:text-[#234954] transition-colors\" aria-label=\"Afficher le mot de passe\">
\t\t\t\t\t\t\t<svg id=\"eye-icon\" width=\"14\" height=\"14\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" viewbox=\"0 0 24 24\">
\t\t\t\t\t\t\t\t<path d=\"M15 12a3 3 0 11-6 0 3 3 0 016 0z\"></path>
\t\t\t\t\t\t\t\t<path d=\"M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z\"></path>
\t\t\t\t\t\t\t</svg>
\t\t\t\t\t\t</button>
\t\t\t\t\t</div>
\t\t\t\t</div>
\t\t\t</div>

\t\t\t<script>
\t\t\t\tfunction togglePasswordVisibility() {
const passwordField = document.getElementById('password');
const eyeIcon = document.getElementById('eye-icon');

if (passwordField.type === 'password') {
passwordField.type = 'text';
eyeIcon.innerHTML = `
\t\t\t\t\t\t\t<path d=\"M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88L4.34 4.34m11.18 11.18l5.14 5.14\"></path>
\t\t\t\t\t\t\t<path d=\"M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z\"></path>
\t\t\t\t\t\t`;
} else {
passwordField.type = 'password';
eyeIcon.innerHTML = `
\t\t\t\t\t\t\t<path d=\"M15 12a3 3 0 11-6 0 3 3 0 016 0z\"></path>
\t\t\t\t\t\t\t<path d=\"M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z\"></path>
\t\t\t\t\t\t`;
}
}
\t\t\t</script>

\t\t\t<input type=\"hidden\" name=\"_csrf_token\" value=\"";
        // line 296
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getRuntime('Symfony\Component\Form\FormRenderer')->renderCsrfToken("authenticate"), "html", null, true);
        yield "\">

\t\t\t<button class=\"w-full bg-transparent hover:opacity-80 text-[#234954] font-black text-xl tracking-[0.2em] transition-all mt-4\" type=\"submit\">
\t\t\t\tLOGIN
\t\t\t</button>
\t\t</form>
\t</div>
";
        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "security/login.html.twig";
    }

    /**
     * @codeCoverageIgnore
     */
    public function isTraitable(): bool
    {
        return false;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getDebugInfo(): array
    {
        return array (  391 => 296,  351 => 259,  345 => 255,  339 => 252,  333 => 248,  331 => 247,  304 => 223,  86 => 7,  76 => 6,  58 => 3,  41 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends 'base.html.twig' %}

{% block title %}S'identifier | Plateforme LSDJ
{% endblock %}

{% block body %}
\t<div class=\"w-full max-w-md mx-auto p-4 sm:p-6 pt-2 sm:pt-4\">
\t\t<style>
\t\t\t@import url('https://fonts.googleapis.com/css2?family=Dancing+Script:wght@600 &display=swap');
\t\t\t/* Prevent scrolling entirely on the login page */
\t\t\thtml,
\t\t\tbody,
\t\t\t.main-content,
\t\t\t.auth-layout {
\t\t\t\theight: 100% !important;
\t\t\t\tmin-height: 100% !important;
\t\t\t\tmax-height: 100% !important;
\t\t\t\toverflow: hidden !important;
\t\t\t\tmargin: 0;
\t\t\t\tpadding: 0;
\t\t\t}

\t\t\t.login-brand-container {
\t\t\t\tposition: relative;
\t\t\t\twidth: 100%;
\t\t\t\theight: 240px;
\t\t\t\tmargin-bottom: -10px; /* Negative margin to pull form up */
\t\t\t\tmargin-top: 25px; /* Increased top margin as requested */
\t\t\t\tpadding: 0;
\t\t\t\tdisplay: flex;
\t\t\t\tflex-direction: column;
\t\t\t\talign-items: center;
\t\t\t\tjustify-content: center;
\t\t\t\toverflow: visible; /* Prevent clipping during pulse */
\t\t\t}
\t\t\t.login-line {
\t\t\t\tposition: absolute;
\t\t\t\twidth: 90%;
\t\t\t\theight: 2px;
\t\t\t\tbackground: #a9df51;
\t\t\t\ttop: 60%; /* Moved down to give more space above */
\t\t\t\tleft: 5%;
\t\t\t\ttransform: scaleX(0);
\t\t\t\ttransform-origin: center;
\t\t\t\tanimation: drawLine 1.2s cubic-bezier(0.65, 0, 0.35, 1) forwards;
\t\t\t}

\t\t\t/* Container for above the line */
\t\t\t.brand-top-content {
\t\t\t\tposition: absolute;
\t\t\t\tbottom: 40%; /* Adjusted to match the line at top: 60% */
\t\t\t\tdisplay: flex;
\t\t\t\talign-items: flex-end;
\t\t\t\tgap: 15px;
\t\t\t}

\t\t\t/* Phase 2: Logo raise (Increased duration) */
\t\t\t.login-logo {
\t\t\t\twidth: 80px;
\t\t\t\theight: auto;
\t\t\t\topacity: 0;
\t\t\t\ttransform: translateY(40px);
\t\t\t\tanimation: logoRaise 0.8s cubic-bezier(0.22, 1, 0.36, 1) 1.2s forwards, pulse 3s ease-in-out 6.5s infinite; /* Keeping the pulse but without shadow */
\t\t\t}

\t\t\t.text-stack {
\t\t\t\tdisplay: flex;
\t\t\t\tflex-direction: column;
\t\t\t\talign-items: flex-start;
\t\t\t\toverflow: visible;
\t\t\t}

\t\t\t/* Phase 3: LES slide out (Increased duration) */
\t\t\t.les-container {
\t\t\t\toverflow: hidden;
\t\t\t}
\t\t\t.stack-les {
\t\t\t\tfont-size: 28px;
\t\t\t\tfont-weight: 800;
\t\t\t\tcolor: #234954;
\t\t\t\ttext-transform: uppercase;
\t\t\t\tline-height: 1;
\t\t\t\tmargin-bottom: 2px;
\t\t\t\topacity: 0;
\t\t\t\ttransform: translateX(-50px);
\t\t\t\tanimation: slideFromLeft 0.8s cubic-bezier(0.22, 1, 0.36, 1) 2s forwards;
\t\t\t}

\t\t\t/* Phase 4: SAVEURS raise (Increased duration) */
\t\t\t.saveurs-container {
\t\t\t\toverflow: hidden;
\t\t\t}
\t\t\t.stack-saveurs {
\t\t\t\tfont-size: 46px;
\t\t\t\tfont-weight: 950;
\t\t\t\tcolor: #234954;
\t\t\t\ttext-transform: uppercase;
\t\t\t\tline-height: 0.85;
\t\t\t\tletter-spacing: -2px;
\t\t\t\topacity: 0;
\t\t\t\ttransform: translateY(50px);
\t\t\t\tanimation: textRaise 0.8s cubic-bezier(0.22, 1, 0.36, 1) 2.6s forwards;
\t\t\t}

\t\t\t/* Phase 5 & 6: DU raise and rotate (Increased duration) */
\t\t\t.du-jardin-wrapper {
\t\t\t\tdisplay: flex;
\t\t\t\talign-items: center;
\t\t\t\tgap: 4px;
\t\t\t\tmargin-top: 5px;
\t\t\t}
\t\t\t.du-container {
\t\t\t\tdisplay: inline-block;
\t\t\t\toverflow: visible;
\t\t\t}
\t\t\t.text-du {
\t\t\t\tdisplay: inline-block;
\t\t\t\tfont-size: 26px;
\t\t\t\tfont-weight: 900;
\t\t\t\tcolor: #234954;
\t\t\t\ttext-transform: uppercase;
\t\t\t\tline-height: 1;
\t\t\t\topacity: 0;
\t\t\t\ttransform-origin: center;
\t\t\t\ttransform: translateY(30px) rotate(-90deg);
\t\t\t\tanimation: duSequence 1.5s cubic-bezier(0.45, 0, 0.55, 1) 3.2s forwards;
\t\t\t}

\t\t\t/* Phase 7: JARDIN slide out (Increased duration) */
\t\t\t.jardin-container {
\t\t\t\toverflow: hidden;
\t\t\t\tpadding-left: 0;
\t\t\t}
\t\t\t.text-jardin {
\t\t\t\tdisplay: inline-block;
\t\t\t\tfont-size: 46px;
\t\t\t\tfont-weight: 950;
\t\t\t\tcolor: #234954;
\t\t\t\ttext-transform: uppercase;
\t\t\t\tline-height: 0.85;
\t\t\t\tletter-spacing: 2px;
\t\t\t\topacity: 0;
\t\t\t\ttransform: translateX(-150px);
\t\t\t\tanimation: slideFromLeft 0.8s cubic-bezier(0.22, 1, 0.36, 1) 4.5s forwards;
\t\t\t}

\t\t\t/* Phase 8: Slogan (Increased duration) */
\t\t\t.slogan-row {
\t\t\t\tposition: absolute;
\t\t\t\ttop: calc(60% + 20px); /* Lower under the line */
\t\t\t\tleft: 0;
\t\t\t\tright: 0;
\t\t\t\ttext-align: center;
\t\t\t\tfont-family: 'Dancing Script', cursive;
\t\t\t\tfont-size: 24px;
\t\t\t\tcolor: #a9df51;
\t\t\t\topacity: 0;
\t\t\t\ttransform: translateY(0);
\t\t\t\twhite-space: nowrap;
\t\t\t\tanimation: fadeIn 1s ease-out 5.2s forwards;
\t\t\t}

\t\t\t/* Keyframes (Refined for fluidity) */
\t\t\t@keyframes drawLine {
\t\t\t\tto {
\t\t\t\t\ttransform: scaleX(1);
\t\t\t\t}
\t\t\t}
\t\t\t@keyframes logoRaise {
\t\t\t\tto {
\t\t\t\t\topacity: 1;
\t\t\t\t\ttransform: translateY(0);
\t\t\t\t}
\t\t\t}
\t\t\t@keyframes slideFromLeft {
\t\t\t\tto {
\t\t\t\t\topacity: 1;
\t\t\t\t\ttransform: translateX(0);
\t\t\t\t}
\t\t\t}
\t\t\t@keyframes textRaise {
\t\t\t\tto {
\t\t\t\t\topacity: 1;
\t\t\t\t\ttransform: translateY(0);
\t\t\t\t}
\t\t\t}
\t\t\t@keyframes duSequence {
\t\t\t\t0% {
\t\t\t\t\topacity: 0;
\t\t\t\t\ttransform: translateY(30px) rotate(0deg);
\t\t\t\t}
\t\t\t\t40% {
\t\t\t\t\topacity: 1;
\t\t\t\t\ttransform: translateY(0) rotate(0deg);
\t\t\t\t}
\t\t\t\t100% {
\t\t\t\t\topacity: 1;
\t\t\t\t\ttransform: translateY(0) rotate(-90deg);
\t\t\t\t}
\t\t\t}
\t\t\t@keyframes fadeIn {
\t\t\t\tto {
\t\t\t\t\topacity: 1;
\t\t\t\t}
\t\t\t}
\t\t\t@keyframes pulse {
\t\t\t\t0% {
\t\t\t\t\ttransform: translateY(0);
\t\t\t\t}
\t\t\t\t50% {
\t\t\t\t\ttransform: translateY(-6px); /* Moves only upward */
\t\t\t\t}
\t\t\t\t100% {
\t\t\t\t\ttransform: translateY(0);
\t\t\t\t}
\t\t\t}
\t\t</style>

\t\t<div class=\"login-brand-container\">
\t\t\t<div class=\"login-line\"></div>

\t\t\t<div class=\"brand-top-content\">
\t\t\t\t<img src=\"{{ asset('logo.svg') }}\" class=\"login-logo\" alt=\"Logo\">
\t\t\t\t<div class=\"text-stack\">
\t\t\t\t\t<div class=\"les-container\">
\t\t\t\t\t\t<div class=\"stack-les\">Les</div>
\t\t\t\t\t</div>
\t\t\t\t\t<div class=\"saveurs-container\">
\t\t\t\t\t\t<div class=\"stack-saveurs\">Saveurs</div>
\t\t\t\t\t</div>
\t\t\t\t\t<div class=\"du-jardin-wrapper\">
\t\t\t\t\t\t<div class=\"du-container\">
\t\t\t\t\t\t\t<span class=\"text-du\">Du</span>
\t\t\t\t\t\t</div>
\t\t\t\t\t\t<div class=\"jardin-container\">
\t\t\t\t\t\t\t<span class=\"text-jardin\">Jardin</span>
\t\t\t\t\t\t</div>
\t\t\t\t\t</div>
\t\t\t\t</div>
\t\t\t</div>

\t\t\t<div class=\"slogan-row\">
\t\t\t\tfruits & légumes en toute saison !
\t\t\t</div>
\t\t</div>

\t\t{% if error %}
\t\t\t<div class=\"flex items-center gap-3 bg-red-50 border border-red-200 text-red-700 rounded-lg px-4 py-3 mb-6 text-sm font-semibold\">
\t\t\t\t<svg width=\"18\" height=\"18\" fill=\"currentColor\" viewbox=\"0 0 20 20\" class=\"shrink-0\">
\t\t\t\t\t<path fill-rule=\"evenodd\" d=\"M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z\" clip-rule=\"evenodd\"></path>
\t\t\t\t</svg>
\t\t\t\t{{ error.messageKey|trans(error.messageData, 'security') }}
\t\t\t</div>
\t\t{% endif %}

\t\t<form method=\"post\" class=\"space-y-6\">
\t\t\t<div class=\"flex flex-col items-center space-y-4\">
\t\t\t\t<div class=\"w-full max-w-[250px]\">
\t\t\t\t\t<input type=\"email\" value=\"{{ last_username }}\" name=\"email\" id=\"username\" autocomplete=\"email\" required autofocus placeholder=\"EMAIL\" class=\"w-full h-8 border border-slate-300 rounded-lg px-4 text-xs font-bold text-slate-900 text-center outline-none focus:ring-2 focus:ring-[#234954]/10 focus:border-[#234954] transition-all bg-white/80 backdrop-blur-sm shadow-sm leading-none\">
\t\t\t\t</div>

\t\t\t\t<div class=\"w-full max-w-[250px]\">
\t\t\t\t\t<div class=\"relative group\">
\t\t\t\t\t\t<input type=\"password\" name=\"password\" id=\"password\" autocomplete=\"current-password\" required placeholder=\"MOT DE PASSE\" class=\"w-full h-8 border border-slate-300 rounded-lg px-8 text-xs font-bold text-slate-900 text-center outline-none focus:ring-2 focus:ring-[#234954]/10 focus:border-[#234954] transition-all bg-white/80 backdrop-blur-sm shadow-sm leading-none\">
\t\t\t\t\t\t<button type=\"button\" onclick=\"togglePasswordVisibility()\" class=\"absolute right-2 top-1/2 -translate-y-1/2 p-1 text-slate-400 hover:text-[#234954] transition-colors\" aria-label=\"Afficher le mot de passe\">
\t\t\t\t\t\t\t<svg id=\"eye-icon\" width=\"14\" height=\"14\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" viewbox=\"0 0 24 24\">
\t\t\t\t\t\t\t\t<path d=\"M15 12a3 3 0 11-6 0 3 3 0 016 0z\"></path>
\t\t\t\t\t\t\t\t<path d=\"M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z\"></path>
\t\t\t\t\t\t\t</svg>
\t\t\t\t\t\t</button>
\t\t\t\t\t</div>
\t\t\t\t</div>
\t\t\t</div>

\t\t\t<script>
\t\t\t\tfunction togglePasswordVisibility() {
const passwordField = document.getElementById('password');
const eyeIcon = document.getElementById('eye-icon');

if (passwordField.type === 'password') {
passwordField.type = 'text';
eyeIcon.innerHTML = `
\t\t\t\t\t\t\t<path d=\"M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88L4.34 4.34m11.18 11.18l5.14 5.14\"></path>
\t\t\t\t\t\t\t<path d=\"M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z\"></path>
\t\t\t\t\t\t`;
} else {
passwordField.type = 'password';
eyeIcon.innerHTML = `
\t\t\t\t\t\t\t<path d=\"M15 12a3 3 0 11-6 0 3 3 0 016 0z\"></path>
\t\t\t\t\t\t\t<path d=\"M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z\"></path>
\t\t\t\t\t\t`;
}
}
\t\t\t</script>

\t\t\t<input type=\"hidden\" name=\"_csrf_token\" value=\"{{ csrf_token('authenticate') }}\">

\t\t\t<button class=\"w-full bg-transparent hover:opacity-80 text-[#234954] font-black text-xl tracking-[0.2em] transition-all mt-4\" type=\"submit\">
\t\t\t\tLOGIN
\t\t\t</button>
\t\t</form>
\t</div>
{% endblock %}

", "security/login.html.twig", "/var/www/html/templates/security/login.html.twig");
    }
}
