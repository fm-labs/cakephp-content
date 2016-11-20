<?php
namespace Content\Model\Table;

use Content\Model\Entity\Post;
use Cake\Core\Plugin;
use Cake\Form\Schema;
use Cake\Log\Log;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Posts Model
 *
 */
class PostsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('bc_posts');
        $this->displayField('title');
        $this->primaryKey('id');
        $this->addBehavior('Timestamp');

        $this->addBehavior('Translate', [
            'fields' => ['title', 'slug', 'teaser_html', 'teaser_link_caption', 'body_html'],
            'translationTable' => 'bc_i18n'
        ]);

        $this->addBehavior('Content.ContentModule', [
            'alias' => 'ContentModules',
            'scope' => 'Content.Posts',
            'concat' => 'body_html'
        ]);

        $this->addBehavior('Banana.Sortable', [
            'field' => 'pos',
            'scope' => ['refscope', 'refid']
        ]);

        $this->addBehavior('Banana.Copyable', [
            'excludeFields' => ['is_published']
        ]);

        $this->addBehavior('Banana.Sluggable');
        $this->addBehavior('Banana.Publishable', []);

        //@TODO Refactor with initalization hook
        if (Plugin::loaded('Media')) {
            $this->addBehavior('Media.Media', [
                'fields' => [
                    'teaser_image_file' => [
                        'config' => 'images'
                    ],
                    'image_file' => [
                        'config' => 'images'
                    ],
                    'image_files' => [
                        'config' => 'images',
                        'multiple' => true
                    ]
                ]
            ]);
        } else {
            Log::warning('Media plugin is not loaded');
        }



        /*
        if (Plugin::loaded('Attachment')) {
            $this->addBehavior('Attachment.Attachment', [
                'dataDir' => WWW_ROOT . 'attachments' . DS . 'posts' . DS,
                'dataUrl' => '/attachments/posts/',
                'fields' => [
                    'image_file' => ['uploadConfig' => 'posts_images']
                ]
            ]);
        } else {
            Log::warning('Attachment plugin is not loaded');
        }
        */
    }

    protected function _initializeSchema(\Cake\Database\Schema\Table $schema)
    {
        $schema->columnType('image_files', 'media_file');
        return $schema;
    }

    public function setAsHome($postId, $siteId)
    {
        $updated = 0;
        $updated += $this->updateAll(['is_home' => true], ['id' => $postId, 'site_id' => $siteId]);
        $updated += $this->updateAll(['is_home' => false], ['id !=' => $postId, 'site_id' => $siteId]);
        return $updated;
    }

    public function findHome($siteId = null, $fallback = true)
    {
        $post = $this
            ->find()
            //->find('published')
            ->where([
                'site_id' => $siteId,
                'is_home' => true,
                'parent_id IS NULL'
            ])
            ->first();

        if (!$post && $fallback && $siteId !== null) {
            return $this->findHome(null, false);
        }

        return $post;
    }
    /**
     * @param null $slug
     * @return mixed Model Id or null
     */
    public function findIdBySlug($slug = null)
    {
        $post = $this
            ->find()
            ->where([
                'slug' => $slug
            ])
            ->select('id')
            ->contain([])
            ->hydrate(false)
            ->first();

        return $post['id'];
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->add('id', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('id', 'create');
            
        $validator
            ->requirePresence('title', 'create')
            ->notEmpty('title');
            
        $validator
            ->allowEmpty('slug');
            
        $validator
            ->allowEmpty('subheading');
            
        $validator
            ->allowEmpty('teaser');
            
        $validator
            ->allowEmpty('body_html');
            
        $validator
            ->allowEmpty('image_file');
            
        $validator
            ->add('is_published', 'valid', ['rule' => 'boolean'])
            ->requirePresence('is_published', 'create')
            ->notEmpty('is_published');
            
        $validator
            ->add('publish_start_datetime', 'valid', ['rule' => 'datetime'])
            ->allowEmpty('publish_start_datetime');
            
        $validator
            ->add('publish_end_datetime', 'valid', ['rule' => 'datetime'])
            ->allowEmpty('publish_end_datetime');

        return $validator;
    }
}
