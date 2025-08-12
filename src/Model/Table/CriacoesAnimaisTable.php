<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CriacoesAnimais Model
 *
 * @method \App\Model\Entity\CriacoesAnimai newEmptyEntity()
 * @method \App\Model\Entity\CriacoesAnimai newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\CriacoesAnimai> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CriacoesAnimai get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\CriacoesAnimai findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\CriacoesAnimai patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\CriacoesAnimai> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\CriacoesAnimai|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\CriacoesAnimai saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\CriacoesAnimai>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\CriacoesAnimai>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\CriacoesAnimai>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\CriacoesAnimai> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\CriacoesAnimai>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\CriacoesAnimai>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\CriacoesAnimai>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\CriacoesAnimai> deleteManyOrFail(iterable $entities, array $options = [])
 */
class CriacoesAnimaisTable extends Table
{
    /**
     * Initialize method
     *
     * @param array<string, mixed> $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('criacoes_animais');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Produtores', [
            'foreignKey' => 'id_produtor',
            'joinType' => 'INNER',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('id_produtor')
            ->requirePresence('id_produtor', 'create')
            ->notEmptyString('id_produtor');

        $validator
            ->integer('quantidade')
            ->allowEmptyString('quantidade');

        $validator
            ->scalar('especie')
            ->maxLength('especie', 25)
            ->allowEmptyString('especie');

        $validator
            ->scalar('finalidade')
            ->maxLength('finalidade', 25)
            ->allowEmptyString('finalidade');

        $validator
            ->scalar('raca')
            ->maxLength('raca', 25)
            ->allowEmptyString('raca');

                $validator
            ->scalar('unidade')
            ->maxLength('unidade', 25)
            ->allowEmptyString('unidade');

        $validator
            ->boolean('realiza_exame')
            ->allowEmptyString('realiza_exame');

        $validator
            ->boolean('vacinado')
            ->allowEmptyString('vacinado');

        $validator
            ->scalar('tipo_exame')
            ->maxLength('tipo_exame', 25)
            ->allowEmptyString('tipo_exame');

        $validator
            ->scalar('tipo_vacinacao')
            ->maxLength('tipo_vacinacao', 25)
            ->allowEmptyString('tipo_vacinacao');

        return $validator;

        $validator
            ->boolean('realiza_exame')
            ->allowEmptyString('realiza_exame');

        $validator
            ->boolean('vacinado')
            ->allowEmptyString('vacinado');

        $validator
            ->scalar('tipo_exame')
            ->maxLength('tipo_exame', 25)
            ->allowEmptyString('tipo_exame');

        $validator
            ->scalar('tipo_vacinacao')
            ->maxLength('tipo_vacinacao', 25)
            ->allowEmptyString('tipo_vacinacao');

        return $validator;
    }
}
