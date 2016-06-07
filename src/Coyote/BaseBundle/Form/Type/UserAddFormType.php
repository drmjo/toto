<?php

namespace Coyote\BaseBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Coyote\BaseBundle\Entity\User;

class UserAddFormType extends AbstractType {

    private $roles;

    public function __construct($roles_array){
        $this->roles = $roles_array;
    }

	public function buildForm(FormBuilderInterface $builder, array $options){
		
		
		$builder
			->add('username', null, array(
					'label' => 'Username'
			))
			->add('email', 'email', array('label' => 'Email'))
			//->add('roles', 'choice')
			->add('plainPassword', 'repeated', array(
					'type' => 'password',
					'options' => array('translation_domain' => 'FOSUserBundle'),
					'first_options' => array('label' => 'form.password'),
					'second_options' => array('label' => 'form.password_confirmation'),
					'invalid_message' => 'fos_user.password.mismatch',
				)
			)
			->add('roles', 'choice', array(
					'choices' => $this->fixRolesArray(),
					'multiple' => true,
					'expanded' => true,
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
		));
	}

    protected function fixRolesArray(){

        $return_array =  array();
        foreach($this->roles as $role)
        {
            $return_array[$role['name']] = $role['label'];
        }

        return $return_array;
    }
	
	public function getName(){
		return 'coyote_base_user_add';
	}
}