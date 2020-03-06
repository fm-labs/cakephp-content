<?php
namespace Content\Routing\Filter;

use Cake\Event\Event;
use Cake\I18n\I18n;
use Cake\Routing\Filter\LocaleSelectorFilter;

/**
 * Class ContentLocaleSelectorFilter
 *
 * Extends CakePHP's built-in LocaleSelectorFilter,
 * by also checking the session for a valid locale setting.
 *
 * @package Content\Routing\Filter
 */
class ContentLocaleSelectorFilter extends LocaleSelectorFilter
{
    public static $sessionKey = 'Content.locale';

    public function beforeDispatch(Event $event)
    {
        parent::beforeDispatch($event);

        $request = $event->getData('request');
        if ($request->getSession()->check(static::$sessionKey)) {
            $locale = $request->getSession()->read(static::$sessionKey);

            if (!$locale || (!empty($this->_locales) && !in_array($locale, $this->_locales))) {
                return;
            }

            I18n::locale($locale);
        }

        /*
        if (!isset($request->getParam('locale'))) {
            debug("add locale to request");
            $request->addParams(['locale' => I18n::getLocale()]);
        }
        */
    }
}
