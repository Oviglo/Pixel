<?php

namespace App\Menu;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Symfony\Component\Security\Core\Security;

class MenuBuilder
{
    private $factory;

    private $security; // php 7

    /**
     * Add any other dependency you need...
     */
    public function __construct(FactoryInterface $factory, Security $security /* private Security $security*/)
    {
        $this->factory = $factory;
        $this->security = $security; // php 7
    }

    public function createMainMenu(array $options): ItemInterface
    {
        $menu = $this->factory->createItem('root');

        $menu->addChild('Home', ['route' => 'app_app_home']);
        $menu->addChild('game.menu', ['route' => 'app_game_list']);

        if ($this->security->isGranted('ROLE_ADMIN')) {
            $menu->addChild('support.menu', ['route' => 'support_index']);
            $menu->addChild('category.menu', ['route' => 'category_index']);
        }

        return $menu;
    }

    public function createUserMenu(array $options): ItemInterface
    {
        $menu = $this->factory->createItem('root');

        // Si l'utilisateur à le ROLE_USER, il est donc connecté
        if ($this->security->isGranted('ROLE_USER')) {
            $user = $this->security->getUser();

            $child = $menu->addChild($user->getEmail(), ['uri' => '#'])
                ->setExtra('translation_domain', false) // Désactive la traduction
            ;
            $child->addChild('security.logout', ['route' => 'app_logout']);
        } else {
            $menu->addChild('security.register', [
                'route' => 'app_register', 
                'attributes' => [
                    'class' => 'menu-register',
                ]
            ]);
            $menu->addChild('security.login', ['route' => 'app_login']);
        }

        return $menu;
    }
}