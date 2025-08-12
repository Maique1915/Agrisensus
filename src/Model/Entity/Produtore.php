<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Produtore Entity
 *
 * @property int $id
 * @property string|null $cpf
 * @property string|null $telefone
 * @property string|null $cnpj
 * @property string|null $nome
 */
class Produtore extends Entity
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
        'cpf' => true,
        'telefone' => true,
        'cnpj' => true,
        'nome' => true,
    ];
}
