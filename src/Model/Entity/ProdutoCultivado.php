<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ProdutoCultivado Entity
 *
 * @property int $id
 * @property int $id_produtor
 * @property float|null $preco
 * @property float|null $producao_anual
 * @property float|null $receita_total
 * @property string|null $periodo_colheita
 * @property string|null $unidade
 * @property string $nome
 */
class ProdutoCultivado extends Entity
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
        'preco' => true,
        'producao_anual' => true,
        'receita_total' => true,
        'periodo_colheita' => true,
        'unidade' => true,
        'nome' => true,
    ];
}
