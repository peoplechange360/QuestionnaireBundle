<?php
namespace Qaraqter\QuestionnaireBundle\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Qaraqter\QuestionnaireBundle\Form\Type\HeaderType;

class FormTypeExtension extends AbstractTypeExtension
{
    /**
     * Returns the name of the type being extended.
     *
     * @return string The name of the type being extended
     */
    public function getExtendedType()
    {
        return 'form';
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        if (!array_key_exists('container', $view->vars)) {
            if ($form->getParent()) {
                $view->vars['container'] = true;
            } else {
                $view->vars['container'] = false;
            }
        }
    }
}