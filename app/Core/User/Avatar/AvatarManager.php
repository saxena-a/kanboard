<?php

namespace Kanboard\Core\User\Avatar;

/**
 * Avatar Manager
 *
 * @package  avatar
 * @author   Frederic Guillot
 */
class AvatarManager
{
    /**
     * Providers
     *
     * @access private
     * @var AvatarProviderInterface[]
     */
    private $providers = array();

    /**
     * Register a new Avatar provider
     *
     * @access public
     * @param  AvatarProviderInterface $provider
     * @return $this
     */
    public function register(AvatarProviderInterface $provider)
    {
        $this->providers[] = $provider;
        return $this;
    }

    /**
     * Render avatar html element
     *
     * @access public
     * @param  string   $user_id
     * @param  string   $username
     * @param  string   $name
     * @param  string   $email
     * @param  int      $size
     * @return string
     */
    public function render($user_id, $username, $name, $email, $size)
    {
        $user = array(
            'id' => $user_id,
            'username' => $username,
            'name' => $name,
            'email' => $email,
        );

        krsort($this->providers);

        foreach ($this->providers as $provider) {
            if ($provider->isActive($user)) {
                return $provider->render($user, $size);
            }
        }

        return '';
    }
}
