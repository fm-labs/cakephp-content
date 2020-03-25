<?php
declare(strict_types=1);

namespace Content\Model\Table;

use Cake\Core\Plugin;
use Cake\Database\Schema\TableSchema;
use Cake\Database\Schema\TableSchemaInterface;
use Cake\Datasource\ResultSetDecorator;
use Cake\Log\Log;
use Cake\ORM\Entity;
use Cake\ORM\Query;
use Cake\Validation\Validator;

/**
 * Articles Model
 *
 */
class ArticlesTable extends BaseTable
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        $this->setTable('articles');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->belongsTo('Parent', [
            'className' => 'Content.Articles',
            'foreignKey' => 'parent_id',
        ]);

        $this->addBehavior('Timestamp');

        $this->addBehavior('Banana.Attributes', [
            //'attributesTableClass' => 'Content.Options',
            'attributesTableName' => 'content_options',
            'attributesField' => 'options',
        ]);

        $this->addBehavior('Translate', [
            'fields' => ['title', 'slug', 'teaser_html', 'body_html'],
            'translationTable' => 'content_i18n',
        ]);

        /*
        $this->addBehavior('Content.ContentModule', [
            'alias' => 'ContentModules',
            'scope' => 'Content.Articles',
            'concat' => 'body_html',
        ]);
        */

        /*
        $this->addBehavior('Tree.SimpleTree', [
            'field' => 'pos',
            'scope' => ['refscope', 'refid'],
        ]);
        */

        $this->addBehavior('Banana.Copyable', [
            'excludeFields' => ['is_published'],
        ]);

        $this->addBehavior('Banana.Sluggable');
        $this->addBehavior('Banana.Publishable', []);

        //$this->addBehavior('Eav.Attributes');

        //@TODO Refactor with initalization hook
        if (Plugin::isLoaded('Media')) {
            $this->addBehavior('Media.Media', [
                'fields' => [
                    'image_file' => [
                        'config' => 'images',
                    ],
                ],
            ]);
        } else {
            Log::warning('Media plugin is not loaded');
        }

        if (Plugin::isLoaded('Search')) {
            $this->addBehavior('Search.Search');
            $this->searchManager()
                ->add('q', 'Search.Like', [
                    'before' => true,
                    'after' => true,
                    'fieldMode' => 'OR',
                    'comparison' => 'LIKE',
                    'wildcardAny' => '*',
                    'wildcardOne' => '?',
                    'field' => ['title'],
                ])
                ->add('title', 'Search.Like', [
                    'before' => true,
                    'after' => true,
                    'fieldMode' => 'OR',
                    'comparison' => 'LIKE',
                    'wildcardAny' => '*',
                    'wildcardOne' => '?',
                    'field' => ['title'],
                ])
                ->value('is_published', [
                    'filterEmpty' => true,
                ]);
        }
    }

    public function buildAttributes(array $attributes)
    {
        $attributes['meta_lang'] = [];
        $attributes['meta_title'] = [];
        $attributes['meta_desc'] = [];
        $attributes['meta_keywords'] = [];

        return $attributes;
    }

    /**
     * @param \Cake\Database\Schema\TableSchema $schema
     * @return \Cake\Database\Schema\TableSchema
     */
    protected function _initializeSchema(TableSchemaInterface $schema): TableSchemaInterface
    {
        //$schema->setColumnType('image_files', 'media_file');
        return $schema;
    }

    public function buildInputs(\Banana\Model\TableInputSchema $inputs)
    {
        //$inputs->addField('teaser_html', ['type' => 'Html']);
        return $inputs;
    }

    public function findWithUri(Query $query)
    {
        $query->formatResults(function (ResultSetDecorator $results) {
            $results = $results->map(function (Entity $row) {

                $row->my_fancy_view_url = "blub";
                /*
                if (isset($row->attributes)) {
                    $attrs = collection($row->attributes);
                    $row->attributes = $attrs->combine('name', 'value')->toArray();
                    $row->clean();
                }
                */
                $row->clean();

                return $row;
            });

            return $results;
        });

        return $query;
    }

    /**
     * @param null $slug
     * @return mixed Model Id or null
     */
    public function findIdBySlug($slug = null)
    {
        $article = $this
            ->find()
            ->where([
                'slug' => $slug,
            ])
            ->select('id')
            ->contain([])
            ->enableHydration(false)
            ->first();

        return $article['id'];
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): \Cake\Validation\Validator
    {
        $validator
            ->add('id', 'valid', ['rule' => 'numeric'])
            ->allowEmptyString('id', 'create');

        $validator
            ->requirePresence('title', 'create')
            ->notEmptyString('title');

        $validator
            ->allowEmptyString('slug');

        $validator
            ->allowEmptyString('subheading');

        $validator
            ->allowEmptyString('teaser');

        $validator
            ->allowEmptyString('body_html');

        $validator
            ->allowEmptyString('image_file');

        $validator
            ->add('is_published', 'valid', ['rule' => 'boolean'])
            ->requirePresence('is_published', 'create')
            ->notEmptyString('is_published');

        $validator
            ->add('publish_start_datetime', 'valid', ['rule' => 'datetime'])
            ->allowEmptyDateTime('publish_start_datetime');

        $validator
            ->add('publish_end_datetime', 'valid', ['rule' => 'datetime'])
            ->allowEmptyDateTime('publish_end_datetime');

        return $validator;
    }

    /*
    public function getTypeHandler()
    {
        $types = TableRegistry::getTableLocator()->get('Content.Menus')->getTypes();

        $handlerBuilder = function (EntityInterface $entity) use ($types) {
            $type = $entity->get('type');
            $params = (array)$entity->get('type_params');

            if (!isset($types[$type])) {
                throw new \Exception('Unknown page type: ' . $type);
            }

            $className = $types[$type]['className'];
            if (!class_exists($className)) {
                throw new \Exception('Class not found: ' . $className);
            }

            //$params += $entity->extract(['type', 'title', 'hide_in_nav', 'hide_in_sitemap', 'cssid', 'cssclass']);
            $handler = new $className($params);

            return $handler;
        };
    }
    */
}
