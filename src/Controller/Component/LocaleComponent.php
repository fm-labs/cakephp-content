<?php
declare(strict_types=1);

namespace Content\Controller\Component;

use Cake\Controller\Component;
use Cake\I18n\I18n;

/**
 * Class LocaleComponent
 *
 * @package Content\Controller\Component
 */
class LocaleComponent extends Component
{
    /**
     * @param \Cake\Event\Event $event
     */
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        $currentLocale = $requestLocale = I18n::getLocale();
        $request = $this->getController()->getRequest();
        if ($request->getParam('locale')) {
            $requestLocale = $request->getParam('locale');
        } elseif ($request->getQuery('locale')) {
            $requestLocale = $request->getQuery('locale');
        }

        if ($currentLocale != $requestLocale) {
            $this->setLocale($requestLocale);
        }

        // set locale in session
        /*
        if (!$request->getSession()->check('Content.locale')) {
            $request->getSession()->write('Content.locale', $locale);
        } else {
            //$request->getSession()->delete('Content.locale');
        }
        debug("Locale: " . I18n::getLocale());
        */
    }

    /**
     * @param $locale
     */
    public function setLocale($locale)
    {
        debug("LocaleComponent::setLocale " . $locale);
        I18n::setLocale($locale);
    }

    /**
     * @return null|string
     */
    public function getLocale()
    {
        return I18n::getLocale();
    }
}
