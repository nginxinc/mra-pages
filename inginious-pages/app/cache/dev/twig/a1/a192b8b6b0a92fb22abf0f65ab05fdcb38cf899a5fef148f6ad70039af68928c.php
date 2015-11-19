<?php

/* TwigBundle:Exception:exception_full.html.twig */
class __TwigTemplate_d6dc9995711abd91494be65b9748efac098c9158b19feefa80b5b05283cef65f extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("TwigBundle::layout.html.twig", "TwigBundle:Exception:exception_full.html.twig", 1);
        $this->blocks = array(
            'head' => array($this, 'block_head'),
            'title' => array($this, 'block_title'),
            'body' => array($this, 'block_body'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "TwigBundle::layout.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_29a43f5adb099918717d6dfd6fed35cf7469e0f952ab2034fbc44bc558cded1c = $this->env->getExtension("native_profiler");
        $__internal_29a43f5adb099918717d6dfd6fed35cf7469e0f952ab2034fbc44bc558cded1c->enter($__internal_29a43f5adb099918717d6dfd6fed35cf7469e0f952ab2034fbc44bc558cded1c_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "TwigBundle:Exception:exception_full.html.twig"));

        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_29a43f5adb099918717d6dfd6fed35cf7469e0f952ab2034fbc44bc558cded1c->leave($__internal_29a43f5adb099918717d6dfd6fed35cf7469e0f952ab2034fbc44bc558cded1c_prof);

    }

    // line 3
    public function block_head($context, array $blocks = array())
    {
        $__internal_79073e53711bd48ff150802cd0af64a524d196361592aa541d6100f4081609e2 = $this->env->getExtension("native_profiler");
        $__internal_79073e53711bd48ff150802cd0af64a524d196361592aa541d6100f4081609e2->enter($__internal_79073e53711bd48ff150802cd0af64a524d196361592aa541d6100f4081609e2_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "head"));

        // line 4
        echo "    <link href=\"";
        echo twig_escape_filter($this->env, $this->env->getExtension('request')->generateAbsoluteUrl($this->env->getExtension('asset')->getAssetUrl("bundles/framework/css/exception.css")), "html", null, true);
        echo "\" rel=\"stylesheet\" type=\"text/css\" media=\"all\" />
";
        
        $__internal_79073e53711bd48ff150802cd0af64a524d196361592aa541d6100f4081609e2->leave($__internal_79073e53711bd48ff150802cd0af64a524d196361592aa541d6100f4081609e2_prof);

    }

    // line 7
    public function block_title($context, array $blocks = array())
    {
        $__internal_58c763a1ee944972dbe02d4769e5c306c159b22581889798636261009310e5c3 = $this->env->getExtension("native_profiler");
        $__internal_58c763a1ee944972dbe02d4769e5c306c159b22581889798636261009310e5c3->enter($__internal_58c763a1ee944972dbe02d4769e5c306c159b22581889798636261009310e5c3_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "title"));

        // line 8
        echo "    ";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["exception"]) ? $context["exception"] : $this->getContext($context, "exception")), "message", array()), "html", null, true);
        echo " (";
        echo twig_escape_filter($this->env, (isset($context["status_code"]) ? $context["status_code"] : $this->getContext($context, "status_code")), "html", null, true);
        echo " ";
        echo twig_escape_filter($this->env, (isset($context["status_text"]) ? $context["status_text"] : $this->getContext($context, "status_text")), "html", null, true);
        echo ")
";
        
        $__internal_58c763a1ee944972dbe02d4769e5c306c159b22581889798636261009310e5c3->leave($__internal_58c763a1ee944972dbe02d4769e5c306c159b22581889798636261009310e5c3_prof);

    }

    // line 11
    public function block_body($context, array $blocks = array())
    {
        $__internal_35a1d01a56396467f498cb0588d078088dbce93590c76ee4e7f5ae6445e7e549 = $this->env->getExtension("native_profiler");
        $__internal_35a1d01a56396467f498cb0588d078088dbce93590c76ee4e7f5ae6445e7e549->enter($__internal_35a1d01a56396467f498cb0588d078088dbce93590c76ee4e7f5ae6445e7e549_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "body"));

        // line 12
        echo "    ";
        $this->loadTemplate("TwigBundle:Exception:exception.html.twig", "TwigBundle:Exception:exception_full.html.twig", 12)->display($context);
        
        $__internal_35a1d01a56396467f498cb0588d078088dbce93590c76ee4e7f5ae6445e7e549->leave($__internal_35a1d01a56396467f498cb0588d078088dbce93590c76ee4e7f5ae6445e7e549_prof);

    }

    public function getTemplateName()
    {
        return "TwigBundle:Exception:exception_full.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  78 => 12,  72 => 11,  58 => 8,  52 => 7,  42 => 4,  36 => 3,  11 => 1,);
    }
}
/* {% extends 'TwigBundle::layout.html.twig' %}*/
/* */
/* {% block head %}*/
/*     <link href="{{ absolute_url(asset('bundles/framework/css/exception.css')) }}" rel="stylesheet" type="text/css" media="all" />*/
/* {% endblock %}*/
/* */
/* {% block title %}*/
/*     {{ exception.message }} ({{ status_code }} {{ status_text }})*/
/* {% endblock %}*/
/* */
/* {% block body %}*/
/*     {% include 'TwigBundle:Exception:exception.html.twig' %}*/
/* {% endblock %}*/
/* */
