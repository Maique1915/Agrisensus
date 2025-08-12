<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PerfilGerencial Model
 *
 * @method \App\Model\Entity\PerfilGerencial newEmptyEntity()
 * @method \App\Model\Entity\PerfilGerencial newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\PerfilGerencial> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PerfilGerencial get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\PerfilGerencial findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\PerfilGerencial patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\PerfilGerencial> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\PerfilGerencial|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\PerfilGerencial saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\PerfilGerencial>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\PerfilGerencial>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\PerfilGerencial>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\PerfilGerencial> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\PerfilGerencial>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\PerfilGerencial>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\PerfilGerencial>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\PerfilGerencial> deleteManyOrFail(iterable $entities, array $options = [])
 */
class PerfilGerencialTable extends Table
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

        $this->setTable('perfil_gerencial');
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
            ->boolean('possui_nota')
            ->allowEmptyString('possui_nota');

        $validator
            ->boolean('faz_declan')
            ->allowEmptyString('faz_declan');

        $validator
            ->boolean('inscrito_inss')
            ->allowEmptyString('inscrito_inss');

        $validator
            ->boolean('faria_curso')
            ->allowEmptyString('faria_curso');

        $validator
            ->scalar('curso_interesse')
            ->maxLength('curso_interesse', 4294967295)
            ->allowEmptyString('curso_interesse');

        $validator
            ->boolean('conhece_credito')
            ->allowEmptyString('conhece_credito');

        $validator
            ->boolean('utilizou_credito')
            ->allowEmptyString('utilizou_credito');

        $validator
            ->scalar('credito')
            ->maxLength('credito', 25)
            ->allowEmptyString('credito');

        $validator
            ->boolean('varejo_petropolis')
            ->allowEmptyString('varejo_petropolis');

        $validator
            ->boolean('varejo_cidade')
            ->allowEmptyString('varejo_cidade');

        $validator
            ->boolean('atacado_petropolis')
            ->allowEmptyString('atacado_petropolis');

        $validator
            ->boolean('atacado_cidades')
            ->allowEmptyString('atacado_cidades');

        $validator
            ->boolean('comercializar_produtos')
            ->allowEmptyString('comercializar_produtos');

        $validator
            ->scalar('outras_receitas')
            ->maxLength('outras_receitas', 4294967295)
            ->allowEmptyString('outras_receitas');

        $validator
            ->boolean('conhece_programas')
            ->allowEmptyString('conhece_programas');

        $validator
            ->scalar('programas')
            ->maxLength('programas', 4294967295)
            ->allowEmptyString('programas');

        $validator
            ->scalar('dificuldade_producao')
            ->maxLength('dificuldade_producao', 4294967295)
            ->allowEmptyString('dificuldade_producao');

        $validator
            ->scalar('dificuldade_infraestrutura')
            ->maxLength('dificuldade_infraestrutura', 4294967295)
            ->allowEmptyString('dificuldade_infraestrutura');

        $validator
            ->scalar('dificuldade_comercializacao')
            ->maxLength('dificuldade_comercializacao', 4294967295)
            ->allowEmptyString('dificuldade_comercializacao');

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
