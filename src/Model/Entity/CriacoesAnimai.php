<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CriacoesAnimai Entity
 *
 * @property int $id
 * @property int $id_produtor
 * @property int|null $quantidade
 * @property string|null $especie
 * @property string|null $finalidade
 * @property string|null $raca
 * @property string|null $unidade
 * @property bool|null $realiza_exame
 * @property bool|null $vacinado
 * @property string|null $tipo_exame
 * @property string|null $tipo_vacinacao
 */
class CriacoesAnimai extends Entity
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
        'id_produtor' => true,
        'quantidade' => true,
        'especie' => true,
        'finalidade' => true,
        'raca' => true,
        'unidade' => true,
        'realiza_exame' => true,
        'vacinado' => true,
        'tipo_exame' => true,
        'tipo_vacinacao' => true,
    ];
}
