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
        // Hérite du champ textarea
        return TextareaType::class;
    }

    public function buildView(FormView $view, FormInterface $form, array $options): void
    {
        // Ajoute la classe 'wysiwyg' au champ html
        $view->vars['attr']['class'] = ($view->vars['attr']['class'] ?? '') . ' wysiwyg';
    }
}