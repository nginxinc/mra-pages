<?php

/* base.html.twig */
class __TwigTemplate_bfab4ee857586ba9295d66651afbdd1ccf6808a5ddb150c678080277ae624143 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'stylesheets' => array($this, 'block_stylesheets'),
            'body' => array($this, 'block_body'),
            'javascripts' => array($this, 'block_javascripts'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_957bd732ba5da9607b3851eccc6ae1e7e7f2b88fc6b8eba2dccecbb293cbd0ca = $this->env->getExtension("native_profiler");
        $__internal_957bd732ba5da9607b3851eccc6ae1e7e7f2b88fc6b8eba2dccecbb293cbd0ca->enter($__internal_957bd732ba5da9607b3851eccc6ae1e7e7f2b88fc6b8eba2dccecbb293cbd0ca_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "base.html.twig"));

        // line 1
        echo "<!DOCTYPE html>
<html>
    <head>
        <meta charset=\"UTF-8\" />
        <title>";
        // line 5
        $this->displayBlock('title', $context, $blocks);
        echo "</title>
        ";
        // line 6
        $this->displayBlock('stylesheets', $context, $blocks);
        // line 7
        echo "        <link rel=\"icon\" type=\"image/x-icon\" href=\"";
        echo twig_escape_filter($this->env, $this->env->getExtension('asset')->getAssetUrl("favicon.ico"), "html", null, true);
        echo "\" />
    </head>
    <body>
        ";
        // line 10
        $this->displayBlock('body', $context, $blocks);
        // line 11
        echo "        ";
        $this->displayBlock('javascripts', $context, $blocks);
        // line 12
        echo "    </body>
</html>
";
        
        $__internal_957bd732ba5da9607b3851eccc6ae1e7e7f2b88fc6b8eba2dccecbb293cbd0ca->leave($__internal_957bd732ba5da9607b3851eccc6ae1e7e7f2b88fc6b8eba2dccecbb293cbd0ca_prof);

    }

    // line 5
    public function block_title($context, array $blocks = array())
    {
        $__internal_b6027ad647aa5f410cc97df7f897239fb72bd6c0221c50f9bfdfc9a1e22bd553 = $this->env->getExtension("native_profiler");
        $__internal_b6027ad647aa5f410cc97df7f897239fb72bd6c0221c50f9bfdfc9a1e22bd553->enter($__internal_b6027ad647aa5f410cc97df7f897239fb72bd6c0221c50f9bfdfc9a1e22bd553_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "title"));

        echo "Welcome!";
        
        $__internal_b6027ad647aa5f410cc97df7f897239fb72bd6c0221c50f9bfdfc9a1e22bd553->leave($__internal_b6027ad647aa5f410cc97df7f897239fb72bd6c0221c50f9bfdfc9a1e22bd553_prof);

    }

    // line 6
    public function block_stylesheets($context, array $blocks = array())
    {
        $__internal_62d4ba1de0e2410dad062d177a76704db90a3e865989f2c6f15f0971ac47379e = $this->env->getExtension("native_profiler");
        $__internal_62d4ba1de0e2410dad062d177a76704db90a3e865989f2c6f15f0971ac47379e->enter($__internal_62d4ba1de0e2410dad062d177a76704db90a3e865989f2c6f15f0971ac47379e_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "stylesheets"));

        
        $__internal_62d4ba1de0e2410dad062d177a76704db90a3e865989f2c6f15f0971ac47379e->leave($__internal_62d4ba1de0e2410dad062d177a76704db90a3e865989f2c6f15f0971ac47379e_prof);

    }

    // line 10
    public function block_body($context, array $blocks = array())
    {
        $__internal_1c48671622d39a0a9c68341b105946d80dfc86138f25cf853572bc6bc9a57ade = $this->env->getExtension("native_profiler");
        $__internal_1c48671622d39a0a9c68341b105946d80dfc86138f25cf853572bc6bc9a57ade->enter($__internal_1c48671622d39a0a9c68341b105946d80dfc86138f25cf853572bc6bc9a57ade_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "body"));

        
        $__internal_1c48671622d39a0a9c68341b105946d80dfc86138f25cf853572bc6bc9a57ade->leave($__internal_1c48671622d39a0a9c68341b105946d80dfc86138f25cf853572bc6bc9a57ade_prof);

    }

    // line 11
    public function block_javascripts($context, array $blocks = array())
    {
        $__internal_46b01828690fd1ed630ecc81a2f8ce435476babb59012ccad5423da4bbfe78f3 = $this->env->getExtension("native_profiler");
        $__internal_46b01828690fd1ed630ecc81a2f8ce435476babb59012ccad5423da4bbfe78f3->enter($__internal_46b01828690fd1ed630ecc81a2f8ce435476babb59012ccad5423da4bbfe78f3_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "javascripts"));

        
        $__internal_46b01828690fd1ed630ecc81a2f8ce435476babb59012ccad5423da4bbfe78f3->leave($__internal_46b01828690fd1ed630ecc81a2f8ce435476babb59012ccad5423da4bbfe78f3_prof);

    }

    public function getTemplateName()
    {
        return "base.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  93 => 11,  82 => 10,  71 => 6,  59 => 5,  50 => 12,  47 => 11,  45 => 10,  38 => 7,  36 => 6,  32 => 5,  26 => 1,);
    }
}
/* <!DOCTYPE html>*/
/* <html>*/
/*     <head>*/
/*         <meta charset="UTF-8" />*/
/*         <title>{% block title %}Welcome!{% endblock %}</title>*/
/*         {% block stylesheets %}{% endblock %}*/
/*         <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}" />*/
/*     </head>*/
/*     <body>*/
/*         {% block body %}{% endblock %}*/
/*         {% block javascripts %}{% endblock %}*/
/*     </body>*/
/* </html>*/
/* */
