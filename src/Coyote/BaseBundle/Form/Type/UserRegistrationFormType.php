<?php

namespace Coyote\BaseBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Symfony\Component\Validator\Constraints as Assert;

class UserRegistrationFormType extends AbstractType {
	
	public function buildForm(FormBuilderInterface $builder, array $options){
		
		
		$builder
			->add('username', null, array(
					'label' => 'Username'
			))
			->add('plainPassword', 'repeated', array(
					'type' => 'password',
					'first_options' => array('label' => 'Password'),
					'second_options' => array('label' => 'Verify Password'),
					'invalid_message' => 'Passwords do not match!',
				)
			)
			->add('accountnumber', 'text', array(
				'mapped' => false,
				'constraints' => array(
					new Assert\NotBlank(array(
							'message' => 'Account number is required!',
						)
					),
					new Assert\Regex(array(
							'pattern' => '/^[a-zA-Z]\d{5}$/',
							'message' => '{{ value }} is not a valid account number!',
						)
					),
				),
				'label' => 'Account Number',
				)
			)
			;
	}
	
	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
		$resolver->setDefaults(array(
				'data_class' => 'Coyote\BaseBundle\Entity\User',
				'attr' => array(
					'novalidate' => true,
				),
				'error_mapping' => array(
				    'usernameCanonical' => 'username',
					'emailCanonical' => 'email',
				),
				'validation_groups' => array('register', 'Default'),
		));
	}
	
	public function getName(){
		return 'coyote_user_register';
	}
}