<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Propriedades Model
 *
 * @method \App\Model\Entity\Propriedade newEmptyEntity()
 * @method \App\Model\Entity\Propriedade newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Propriedade> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Propriedade get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Propriedade findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Propriedade patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Propriedade> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Propriedade|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Propriedade saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Propriedade>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Propriedade>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Propriedade>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Propriedade> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Propriedade>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Propriedade>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Propriedade>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Propriedade> deleteManyOrFail(iterable $entities, array $options = [])
 */
class PropriedadesTable extends Table
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

        $this->setTable('propriedades');
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
            ->scalar('terreno')
            ->allowEmptyString('terreno');

        $validator
            ->scalar('area_total')
            ->maxLength('area_total', 20)
            ->allowEmptyString('area_total');

        $validator
            ->scalar('comunidade')
            ->maxLength('comunidade', 25)
            ->allowEmptyString('comunidade');

        $validator
            ->scalar('localidade')
            ->maxLength('localidade', 25)
            ->allowEmptyString('localidade');

        $validator
            ->scalar('nome_propriedade')
            ->maxLength('nome_propriedade', 25)
            ->allowEmptyString('nome_propriedade');

        $validator
            ->scalar('relacao_propriedade')
            ->maxLength('relacao_propriedade', 25)
            ->allowEmptyString('relacao_propriedade');

        $validator
            ->scalar('bairro')
            ->maxLength('bairro', 25)
            ->allowEmptyString('bairro');

        $validator
            ->scalar('cep')
            ->maxLength('cep', 9)
            ->allowEmptyString('cep');

        $validator
            ->scalar('cidade')
            ->maxLength('cidade', 25)
            ->allowEmptyString('cidade');

        $validator
            ->scalar('complemento')
            ->maxLength('complemento', 25)
            ->allowEmptyString('complemento');

        $validator
            ->scalar('estado')
            ->maxLength('estado', 2)
            ->allowEmptyString('estado');

        $validator
            ->integer('numero')
            ->allowEmptyString('numero');

        return $validator;
    }
}
