<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * FamiliaMaoDeObra Model
 *
 * @method \App\Model\Entity\FamiliaMaoDeObra newEmptyEntity()
 * @method \App\Model\Entity\FamiliaMaoDeObra newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\FamiliaMaoDeObra> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\FamiliaMaoDeObra get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\FamiliaMaoDeObra findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\FamiliaMaoDeObra patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\FamiliaMaoDeObra> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\FamiliaMaoDeObra|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\FamiliaMaoDeObra saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\FamiliaMaoDeObra>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\FamiliaMaoDeObra>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\FamiliaMaoDeObra>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\FamiliaMaoDeObra> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\FamiliaMaoDeObra>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\FamiliaMaoDeObra>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\FamiliaMaoDeObra>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\FamiliaMaoDeObra> deleteManyOrFail(iterable $entities, array $options = [])
 */
class FamiliaMaoDeObraTable extends Table
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

        $this->setTable('familia_mao_de_obra');
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
            ->notEmptyString('id_produtor')
            ->add('id_produtor', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->integer('ate_sete')
            ->allowEmptyString('ate_sete');

        $validator
            ->integer('oito_quinze')
            ->allowEmptyString('oito_quinze');

        $validator
            ->integer('dezesseis_vintecinco')
            ->allowEmptyString('dezesseis_vintecinco');

        $validator
            ->integer('vintecinco_sessentacinco')
            ->allowEmptyString('vintecinco_sessentacinco');

        $validator
            ->integer('mais_sessentacinco')
            ->allowEmptyString('mais_sessentacinco');

        $validator
            ->integer('qtd_familia_producao')
            ->allowEmptyString('qtd_familia_producao');

        $validator
            ->integer('qtd_empregados')
            ->allowEmptyString('qtd_empregados');

        $validator
            ->integer('total_dependentes')
            ->allowEmptyString('total_dependentes');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->isUnique(['id_produtor']), ['errorField' => 'id_produtor']);

        return $rules;
    }
}
