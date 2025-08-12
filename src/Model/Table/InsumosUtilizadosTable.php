<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * InsumosUtilizados Model
 *
 * @method \App\Model\Entity\InsumosUtilizado newEmptyEntity()
 * @method \App\Model\Entity\InsumosUtilizado newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\InsumosUtilizado> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\InsumosUtilizado get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\InsumosUtilizado findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\InsumosUtilizado patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\InsumosUtilizado> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\InsumosUtilizado|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\InsumosUtilizado saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\InsumosUtilizado>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\InsumosUtilizado>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\InsumosUtilizado>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\InsumosUtilizado> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\InsumosUtilizado>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\InsumosUtilizado>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\InsumosUtilizado>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\InsumosUtilizado> deleteManyOrFail(iterable $entities, array $options = [])
 */
class InsumosUtilizadosTable extends Table
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

        $this->setTable('insumos_utilizados');
        $this->setDisplayField('nome');
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
            ->scalar('local_compra')
            ->maxLength('local_compra', 25)
            ->allowEmptyString('local_compra');

        $validator
            ->scalar('nome')
            ->maxLength('nome', 25)
            ->allowEmptyString('nome');

        $validator
            ->scalar('preco_str')
            ->maxLength('preco_str', 25)
            ->allowEmptyString('preco_str');

        $validator
            ->scalar('quantidade')
            ->maxLength('quantidade', 25)
            ->allowEmptyString('quantidade');

        $validator
            ->scalar('unidade')
            ->maxLength('unidade', 25)
            ->allowEmptyString('unidade');

        return $validator;
    }
}
