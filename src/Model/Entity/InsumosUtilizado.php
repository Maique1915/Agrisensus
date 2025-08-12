<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * InsumosUtilizado Entity
 *
 * @property int $id
 * @property int $id_produtor
 * @property string|null $local_compra
 * @property string|null $nome
 * @property string|null $preco_str
 * @property string|null $quantidade
 * @property string|null $unidade
 */
class InsumosUtilizado extends Entity
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
        'local_compra' => true,
        'nome' => true,
        'preco_str' => true,
        'quantidade' => true,
        'unidade' => true,
    ];
}
