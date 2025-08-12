<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ProdutosCultivados Model
 *
 * @method \App\Model\Entity\ProdutosCultivado newEmptyEntity()
 * @method \App\Model\Entity\ProdutosCultivado newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\ProdutosCultivado> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ProdutosCultivado get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\ProdutosCultivado findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\ProdutosCultivado patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\ProdutosCultivado> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\ProdutosCultivado|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\ProdutosCultivado saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\ProdutosCultivado>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ProdutosCultivado>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ProdutosCultivado>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ProdutosCultivado> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ProdutosCultivado>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ProdutosCultivado>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ProdutosCultivado>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ProdutosCultivado> deleteManyOrFail(iterable $entities, array $options = [])
 */
class ProdutosCultivadosTable extends Table
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

        $this->setTable('produtos_cultivados');
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
            ->decimal('preco')
            ->allowEmptyString('preco');

        $validator
            ->decimal('producao_anual')
            ->allowEmptyString('producao_anual');

        $validator
            ->decimal('receita_total')
            ->allowEmptyString('receita_total');

        $validator
            ->scalar('periodo_colheita')
            ->maxLength('periodo_colheita', 20)
            ->allowEmptyString('periodo_colheita');

        $validator
            ->scalar('unidade')
            ->maxLength('unidade', 10)
            ->allowEmptyString('unidade');

        $validator
            ->scalar('nome')
            ->maxLength('nome', 25)
            ->requirePresence('nome', 'create')
            ->notEmptyString('nome');

        return $validator;
    }
}
