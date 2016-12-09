<?php

namespace Content\Controller;

use Cake\Event\Event;

/**
 * Class SeoController
 * @package Content\Controller
 *
 */
class SeoController extends AppController
{
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);

        $this->Auth->allow();
    }

    /**
     * Generates robots.txt in webroot
     */
    public function robots()
    {
        $robots = [
            'User-agent: *',
            'Disallow: /tmp/',
            'Disallow: /wp-admin/',
            'Disallow: /admin/',
            'Disallow: /adm/',
            'Disallow: /backend/',
            'Disallow: /private/',
            'Disallow: /login/',
            'Disallow: /user/',
            'Disallow: /usr/',
            'Disallow: /hate/',
            'Disallow: /racism/',
        ];
        $this->response->type('text/plain');
        $this->response->body(join("\n", $robots));
        return $this->response;
    }
}
