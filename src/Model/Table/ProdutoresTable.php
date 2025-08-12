<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Produtores Model
 *
 * @method \App\Model\Entity\Produtore newEmptyEntity()
 * @method \App\Model\Entity\Produtore newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Produtore> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Produtore get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Produtore findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Produtore patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Produtore> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Produtore|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Produtore saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Produtore>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Produtore>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Produtore>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Produtore> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Produtore>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Produtore>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Produtore>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Produtore> deleteManyOrFail(iterable $entities, array $options = [])
 */
class ProdutoresTable extends Table
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

        $this->setTable('produtores');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->hasMany('Propriedades', [
            'foreignKey' => 'id_produtor',
        ]);
        $this->hasMany('ProdutosCultivados', [
            'foreignKey' => 'id_produtor',
        ]);
        $this->hasMany('CriacoesAnimais', [
            'foreignKey' => 'id_produtor',
        ]);
        $this->hasMany('InsumosUtilizados', [
            'foreignKey' => 'id_produtor',
        ]);
        $this->hasOne('FamiliaMaoDeObra', [
            'foreignKey' => 'id_produtor',
        ]);
        $this->hasOne('PerfilGerencial', [
            'foreignKey' => 'id_produtor',
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
            ->scalar('cpf')
            ->maxLength('cpf', 14)
            ->allowEmptyString('cpf');

        $validator
            ->scalar('telefone')
            ->maxLength('telefone', 15)
            ->allowEmptyString('telefone');

        $validator
            ->scalar('cnpj')
            ->maxLength('cnpj', 18)
            ->allowEmptyString('cnpj');

        $validator
            ->scalar('nome')
            ->maxLength('nome', 50)
            ->allowEmptyString('nome');

        return $validator;
    }
}
