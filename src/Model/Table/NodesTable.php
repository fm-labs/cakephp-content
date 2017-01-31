<?php
namespace Content\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Routing\Router;
use Cake\Validation\Validator;
use Content\Model\Entity\Node;

/**
 * Nodes Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Menus
 * @property \Cake\ORM\Association\BelongsTo $ParentNodes
 * @property \Cake\ORM\Association\HasMany $ChildNodes
 */
class NodesTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('bc_nodes');
        $this->displayField('title');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('Tree.Tree', [
            'level' => 'level',
        ]);

        $this->belongsTo('Sites', [
            'foreignKey' => 'site_id',
            'joinType' => 'INNER',
            'className' => 'Banana.Sites'
        ]);
        $this->belongsTo('ParentNodes', [
            'className' => 'Content.Nodes',
            'foreignKey' => 'parent_id'
        ]);
        $this->hasMany('ChildNodes', [
            'className' => 'Content.Nodes',
            'foreignKey' => 'parent_id'
        ]);
    }


    public function toJsTree($siteId = null)
    {

        $id = 1;
        $nodeFormatter = function(Node $node) use (&$id) {

            $publishedClass = ($node->isHiddenInNav()) ? 'unpublished' : 'published';
            $class = $node->type;
            $class.= " " . $publishedClass;

            return [
                'id' => $node->id,
                'text' => $node->getLabel(),
                'icon' => $class,
                'state' => [
                    'opened' => false,
                    'disabled' => false,
                    'selected' => false,
                ],
                'children' => [],
                'li_attr' => ['class' => $class],
                'a_attr' => [],
                'data' => [
                    'id' => $node->id,
                    'site_id' => $node->site_id,
                    'type' => $node->type,
                    'typeid' => $node->typeid,
                    'parent_id' => $node->parent_id,
                    'level' => $node->level,
                    'lft' => $node->lft,
                    'url' => Router::url($node->getAdminUrl()),
                ]
            ];
        };

        $nodesFormatter = function($nodes) use ($nodeFormatter, &$nodesFormatter) {
            $formatted = [];
            foreach ($nodes as $node) {
                $_node = $nodeFormatter($node);
                if ($node->getChildren()) {
                    $_node['children'] = $nodesFormatter($node->getChildren()->all()->toArray());
                }
                $formatted[] = $_node;
            }
            return $formatted;
        };

        $nodes = $this->find()
            ->where(['site_id' => $siteId, 'parent_id IS' => null])
            ->order(['Nodes.lft' => 'ASC'])
            ->all();

        return $nodesFormatter($nodes);

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
            ->add('lft', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('lft');

        $validator
            ->add('rght', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('rght');

        $validator
            ->add('level', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('level');

        $validator
            ->add('site_id', 'valid', ['rule' => 'numeric'])
            ->requirePresence('site_id', 'create')
            ->notEmpty('site_id');

        $validator
            ->requirePresence('title', 'create')
            ->notEmpty('title');

        $validator
            ->allowEmpty('type');

        $validator
            ->allowEmpty('typeid');

        $validator
            ->allowEmpty('type_params');

        $validator
            ->allowEmpty('cssid');

        $validator
            ->allowEmpty('cssclass');

        $validator
            ->add('hide_in_nav', 'valid', ['rule' => 'boolean'])
            ->allowEmpty('hide_in_nav');

        $validator
            ->add('hide_in_sitemap', 'valid', ['rule' => 'boolean'])
            ->allowEmpty('hide_in_sitemap');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['site_id'], 'Sites'));
        $rules->add($rules->existsIn(['parent_id'], 'ParentNodes'));
        return $rules;
    }
}
