<?php
declare(strict_types=1);

namespace Content\Controller\Component;

use Cake\Controller\Component;
use Cake\Core\Configure;
use Cake\Core\Plugin;

/**
 * Class FrontendComponent
 *
 * @package Content\Controller\Component
 */
class FrontendComponent extends Component
{
    /**
     * @var array
     */
    protected $_defaultConfig = [
        'viewClass' => 'Content.Content',
        'refscope' => null,
        'theme' => null,
        'layout' => null,
    ];

    /**
     * {@inheritDoc}
     */
    public function initialize(array $config): void
    {
        $layout = $this->_config['layout'] ?: Configure::read('Site.layout');
        $theme = $this->_config['theme'] ?: Configure::read('Site.theme');
        $viewClass = $this->_config['viewClass'];

        // check if theme plugin is loaded
        if ($theme && !Plugin::isLoaded($theme)) {
            triggerWarning("Warning: Configured site theme '$theme' is not loaded. Is the plugin loaded?");
            //$theme = null;
        }

        $this->getController()->viewBuilder()->setClassName($viewClass);
        $this->getController()->viewBuilder()->setLayout($layout);
        $this->getController()->viewBuilder()->setTheme($theme);

        $this->setRefScope($this->_config['refscope']);
        $this->setRefId(null);
    }

    /**
     * @param string $scope Ref Scope
     * @return $this
     */
    public function setRefScope($scope)
    {
        $this->getController()->set('refscope', $scope);

        return $this;
    }

    /**
     * @param int $id Ref ID
     * @return $this
     */
    public function setRefId($id)
    {
        $this->getController()->set('refid', $id);

        return $this;
    }

    /**
     * @return string
     */
    public function getTheme(): string
    {
        return $this->_config['theme'];
    }

    /**
     * Checks if the request has a valid preview key
     * @todo Move PreviewMode to separate Component
     * @return bool
     */
    public function isPreviewMode(): bool
    {
        $previewKeyInSession = $this->getController()->getRequest()->getSession()->read('Content.previewKey');
        $previewKeyInRequest = $this->getController()->getRequest()->getQuery('preview');

        if (!$previewKeyInRequest || !$previewKeyInSession) {
            return false;
        }

        return $previewKeyInRequest === $previewKeyInSession;
    }
}
