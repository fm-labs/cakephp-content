<?php
namespace Content\Controller\Component;

use Cake\Controller\Component;
use Cake\Event\Event;
use Cake\I18n\I18n;

/**
 * Class LocaleComponent
 *
 * @package Content\Controller\Component
 */
class LocaleComponent extends Component
{
    /**
     * @param Event $event
     */
    public function beforeFilter(Event $event)
    {
        $currentLocale = $requestLocale = I18n::getLocale();
        if ($this->request->getParam('locale')) {
            $requestLocale = $this->request->getParam('locale');
        } elseif (isset($this->request->query['locale'])) {
            $requestLocale = $this->request->query['locale'];
        }

        if ($currentLocale != $requestLocale) {
            $this->setLocale($requestLocale);
        }

        // set locale in session
        /*
        if (!$this->request->getSession()->check('Content.locale')) {
            $this->request->getSession()->write('Content.locale', $locale);
        } else {
            //$this->request->getSession()->delete('Content.locale');
        }
        debug("Locale: " . I18n::getLocale());
        */
    }

    /**
     * @param $locale
     */
    public function setLocale($locale)
    {
        I18n::locale($locale);
    }

    /**
     * @return null|string
     */
    public function getLocale()
    {
        return I18n::getLocale();
    }
}
