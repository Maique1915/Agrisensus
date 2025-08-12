<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PerfilGerencial Entity
 *
 * @property int $id
 * @property int $id_produtor
 * @property bool|null $possui_nota
 * @property bool|null $faz_declan
 * @property bool|null $inscrito_inss
 * @property bool|null $faria_curso
 * @property string|null $curso_interesse
 * @property bool|null $conhece_credito
 * @property bool|null $utilizou_credito
 * @property string|null $credito
 * @property bool|null $varejo_petropolis
 * @property bool|null $varejo_cidade
 * @property bool|null $atacado_petropolis
 * @property bool|null $atacado_cidades
 * @property bool|null $comercializar_produtos
 * @property string|null $outras_receitas
 * @property bool|null $conhece_programas
 * @property string|null $programas
 * @property string|null $dificuldade_producao
 * @property string|null $dificuldade_infraestrutura
 * @property string|null $dificuldade_comercializacao
 */
class PerfilGerencial extends Entity
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
        'possui_nota' => true,
        'faz_declan' => true,
        'inscrito_inss' => true,
        'faria_curso' => true,
        'curso_interesse' => true,
        'conhece_credito' => true,
        'utilizou_credito' => true,
        'credito' => true,
        'varejo_petropolis' => true,
        'varejo_cidade' => true,
        'atacado_petropolis' => true,
        'atacado_cidades' => true,
        'comercializar_produtos' => true,
        'outras_receitas' => true,
        'conhece_programas' => true,
        'programas' => true,
        'dificuldade_producao' => true,
        'dificuldade_infraestrutura' => true,
        'dificuldade_comercializacao' => true,
    ];
}
