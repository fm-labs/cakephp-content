<?php
namespace Content\Page;

use Cake\Controller\Controller;
use Cake\Network\Response;

/**
 * Interface PageInterface
 *
 * @package Content\Page
 */
interface PageInterface
{
    /**
     * @return int
     */
    public function getPageId();

    /**
     * @return string
     */
    public function getPageType();

    /**
     * @return string
     */
    public function getPageTitle();

    /**
     * @return string|array
     */
    public function getPageUrl();

    /**
     * @return string|array
     */
    public function getPageAdminUrl();

    /**
     * @return array
     */
    public function getPageChildren();

    /**
     * @return bool
     */
    public function isPagePublished();

    /**
     * @return bool
     */
    public function isPageHiddenInNav();

    /**
     * @return null|Response
     */
    public function execute(Controller &$controller);
}