<?php
namespace Qaraqter\QuestionnaireBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Pcs\AdminBundle\Entity\Question;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\Common\Proxy\Exception\InvalidArgumentException;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class GroupType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'form';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'group';
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'class' => 'PcsAdminBundle:Response',
                'description' => null,
                'attr' => array(
                    'class' => 'table',
                    'data-type' => 'scale',
                ),
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $response = $options['data'];
        $templateQuestion = $response->getTemplateQuestion();

        foreach ($templateQuestion->getQuestion()->getChildren() as $i => $child) {
            $childQuestion = $child->getQuestion();
            $childResponse = $response->getChildByQuestion($childQuestion);
            $builder->add(
                "question_{$i}",
                'multiple_choice',
                array(
                    'class' => 'PcsAdminBundle:Answer',
                    'data' => $childQuestion->getAllowedAnswers() == 1
                        ? $childResponse->getAnswers()->first()
                        : $childResponse->getAnswers(),
                    'label' => $childQuestion->getText(),
                    'description' => $childQuestion->getDescription(),
                    'choices' => $childQuestion->getAnswers(),
                )
            );
        }
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        parent::buildView($view, $form, $options);
        $view->vars['description'] = $options['description'];
    }
}
