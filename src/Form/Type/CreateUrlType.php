<?php


namespace App\Form\Type;


use App\Entity\LifetimeDuration;
use App\Entity\ShortenedUrl;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ShortenUrlType
 * @package App\Form\Type
 */
class CreateUrlType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('url', TextType::class)
            ->add('lifetime', ChoiceType::class, [
                'required' => false,
                'choices' => [
                    new LifetimeDuration('Unlimited', null),
                    new LifetimeDuration('1 hour', 1),
                    new LifetimeDuration('4 hours', 4),
                    new LifetimeDuration('12 hours', 12),
                    new LifetimeDuration('1 day', 24),
                    new LifetimeDuration('1 week', 168),
                ],
                'choice_label' => 'name',
                'choice_value' => 'durationHours'
            ])
            ->add('create', SubmitType::class, ['label' => 'Shorten URL']);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ShortenedUrl::class,
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'csrf_token_id' => 'shortened_url_item',
        ]);
    }
}