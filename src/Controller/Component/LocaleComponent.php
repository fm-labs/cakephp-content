<?php
namespace Content\Controller\Component;

use Cake\Controller\Component;
use Cake\Event\Event;
use Cake\I18n\I18n;

class LocaleComponent extends Component
{

    public function beforeFilter(Event $event)
    {
        $currentLocale = $requestLocale = I18n::locale();
        if (isset($this->request->params['locale'])) {
            $requestLocale = $this->request->params['locale'];
        } elseif (isset($this->request->query['locale'])) {
            $requestLocale = $this->request->query['locale'];
        }

        if ($currentLocale != $requestLocale) {
            $this->setLocale($requestLocale);
        }

        // set locale in session
        /*
        if (!$this->request->session()->check('Content.locale')) {
            $this->request->session()->write('Content.locale', $locale);
        } else {
            //$this->request->session()->delete('Content.locale');
        }
        debug("Locale: " . I18n::locale());
        */
    }

    public function setLocale($locale)
    {
        I18n::locale($locale);
    }

    public function getLocale()
    {
        return I18n::locale();
    }
}
