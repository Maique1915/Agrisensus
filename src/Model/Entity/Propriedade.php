<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Propriedade Entity
 *
 * @property int $id
 * @property int $id_produtor
 * @property string|null $terreno
 * @property string|null $area_total
 * @property string|null $comunidade
 * @property string|null $localidade
 * @property string|null $nome_propriedade
 * @property string|null $relacao_propriedade
 * @property string|null $bairro
 * @property string|null $cep
 * @property string|null $cidade
 * @property string|null $complemento
 * @property string|null $estado
 * @property int|null $numero
 */
class Propriedade extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected array $_accessible = [
        'id' => true,
        'id_produtor' => true,
        'terreno' => true,
        'area_total' => true,
        'comunidade' => true,
        'localidade' => true,
        'nome_propriedade' => true,
        'relacao_propriedade' => true,
        'bairro' => true,
        'cep' => true,
        'cidade' => true,
        'complemento' => true,
        'estado' => true,
        'numero' => true,
    ];
}
