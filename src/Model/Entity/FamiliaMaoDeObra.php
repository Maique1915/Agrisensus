<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * FamiliaMaoDeObra Entity
 *
 * @property int $id
 * @property int $id_produtor
 * @property int|null $ate_sete
 * @property int|null $oito_quinze
 * @property int|null $dezesseis_vintecinco
 * @property int|null $vintecinco_sessentacinco
 * @property int|null $mais_sessentacinco
 * @property int|null $qtd_familia_producao
 * @property int|null $qtd_empregados
 * @property int|null $total_dependentes
 */
class FamiliaMaoDeObra extends Entity
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
        'ate_sete' => true,
        'oito_quinze' => true,
        'dezesseis_vintecinco' => true,
        'vintecinco_sessentacinco' => true,
        'mais_sessentacinco' => true,
        'qtd_familia_producao' => true,
        'qtd_empregados' => true,
        'total_dependentes' => true,
    ];
}
