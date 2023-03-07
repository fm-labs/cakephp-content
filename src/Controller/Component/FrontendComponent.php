<?php
declare(strict_types=1);

namespace Content\Controller\Component;

use Cake\Controller\Component;

/**
 * Class FrontendComponent
 *
 * @package Content\Controller\Component
 * @property \Cake\Controller\Component\FlashComponent $Flash
 */
class FrontendComponent extends Component
{
    /**
     * @var array
     */
    protected $_defaultConfig = [
        'viewClass' => 'Content.Content',
        'refscope' => null,
    ];

    /**
     * @inheritDoc
     */
    public function initialize(array $config): void
    {
        $viewClass = $this->_config['viewClass'];
        $this->getController()->viewBuilder()->setClassName($viewClass);

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
     * Checks if the request has a valid preview key
     *
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
