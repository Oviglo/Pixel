<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;

class WysiwygType extends AbstractType
{
    public function getParent(): string
    {
        // Ce champ hérite de textarea
        return TextareaType::class;
    }

    public function buildView(FormView $view, FormInterface $form, array $options): void
    {
        // Ajoute la classe html 'wysiwyg' au champ
        $view->vars['attr']['class'] = ($view->vars['attr']['class'] ?? ''). ' wysiwyg';
    }
}