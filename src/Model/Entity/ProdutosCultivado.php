<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ProdutosCultivado Entity
 *
 * @property int $id
 * @property int $id_produtor
 * @property string|null $preco_produto
 * @property string|null $producao_anual
 * @property string|null $receita_total
 * @property string|null $periodo_colheita
 * @property string|null $unidade_producao
 * @property string $nome_produto
 */
class ProdutosCultivado extends Entity
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
        'preco_produto' => true,
        'producao_anual' => true,
        'receita_total' => true,
        'periodo_colheita' => true,
        'unidade_producao' => true,
        'nome_produto' => true,
    ];
}
