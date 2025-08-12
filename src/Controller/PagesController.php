<?php
declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Core\Configure;
use Cake\Http\Exception\ForbiddenException;
use Cake\Http\Exception\NotFoundException;
use Cake\Http\Response;
use Cake\View\Exception\MissingTemplateException;
use Cake\ORM\TableRegistry;

/**
 * Static content controller
 *
 * This controller will render views from templates/Pages/
 *
 * @link https://book.cakephp.org/5/en/controllers/pages-controller.html
 */
class PagesController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->Produtores = TableRegistry::getTableLocator()->get('Produtores');
        $this->FamiliaMaoDeObra = TableRegistry::getTableLocator()->get('FamiliaMaoDeObra');
        $this->PerfilGerencial = TableRegistry::getTableLocator()->get('PerfilGerencial');
        $this->ProdutosCultivados = TableRegistry::getTableLocator()->get('ProdutosCultivados');
        $this->CriacoesAnimais = TableRegistry::getTableLocator()->get('CriacoesAnimais');
        $this->InsumosUtilizados = TableRegistry::getTableLocator()->get('InsumosUtilizados');
        $this->Propriedades = TableRegistry::getTableLocator()->get('Propriedades');
    }
    /**
     * Displays a view
     *
     * @param string ...$path Path segments.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Http\Exception\ForbiddenException When a directory traversal attempt.
     * @throws \Cake\View\Exception\MissingTemplateException When the view file could not
     *   be found and in debug mode.
     * @throws \Cake\Http\Exception\NotFoundException When the view file could not
     *   be found and not in debug mode.
     * @throws \Cake\View\Exception\MissingTemplateException In debug mode.
     */
    public function display(string ...$path): ?Response
    {
        if (!$path) {
            return $this->redirect('/');
        }
        if (in_array('..', $path, true) || in_array('.', $path, true)) {
            throw new ForbiddenException();
        }
        $page = $subpage = null;

        if (!empty($path[0])) {
            $page = $path[0];
        }
        if (!empty($path[1])) {
            $subpage = $path[1];
        }

        // --- Composição Familiar ---
        $avgDependentes = $this->FamiliaMaoDeObra->find()
            ->select(['avg_dependentes' => 'AVG(total_dependentes)'])
            ->first()
            ->avg_dependentes;

        $totalAteSete = $this->FamiliaMaoDeObra->find()->select(['total' => 'SUM(ate_sete)'])->first()->total;
        $totalOitoQuinze = $this->FamiliaMaoDeObra->find()->select(['total' => 'SUM(oito_quinze)'])->first()->total;
        $totalDezesseisVinteCinco = $this->FamiliaMaoDeObra->find()->select(['total' => 'SUM(dezesseis_vintecinco)'])->first()->total;
        $totalVinteCincoSessentaCinco = $this->FamiliaMaoDeObra->find()->select(['total' => 'SUM(vintecinco_sessentacinco)'])->first()->total;
        $totalMaisSessentaCinco = $this->FamiliaMaoDeObra->find()->select(['total' => 'SUM(mais_sessentacinco)'])->first()->total;

        $distribuicaoIdade = [
            'ate_sete' => $totalAteSete,
            'oito_quinze' => $totalOitoQuinze,
            'dezesseis_vintecinco' => $totalDezesseisVinteCinco,
            'vintecinco_sessentacinco' => $totalVinteCincoSessentaCinco,
            'mais_sessenta_cinco' => $totalMaisSessentaCinco,
        ];

        // --- Mão de Obra ---
        $totalProdutores = $this->Produtores->find()->count();
        
        $produtoresFamiliaProducao = $this->FamiliaMaoDeObra->find()
            ->where(['qtd_familia_producao >' => 0])
            ->count();

        $produtoresComEmpregados = $this->FamiliaMaoDeObra->find()
            ->where(['qtd_empregados >' => 0])
            ->count();
        
        $produtoresFamiliaExclusiva = $this->FamiliaMaoDeObra->find()
            ->where(['qtd_familia_producao >' => 0, 'qtd_empregados' => 0])
            ->count();

        $produtoresMaoDeObraContratadaExclusiva = $this->FamiliaMaoDeObra->find()
            ->where(['qtd_empregados >' => 0, 'qtd_familia_producao' => 0])
            ->count();

        // --- Nível de Formalização ---
        $avgPossuiNota = $this->PerfilGerencial->find()
            ->select(['avg_possui_nota' => 'AVG(possui_nota)'])
            ->first()
            ->avg_possui_nota;

        $avgInscritoInss = $this->PerfilGerencial->find()
            ->select(['avg_inscrito_inss' => 'AVG(inscrito_inss)'])
            ->first()
            ->avg_inscrito_inss;

        $produtoresComNotaEConheceProgramas = $this->PerfilGerencial->find()
            ->where(['possui_nota' => true, 'conhece_programas' => true])
            ->count();
        
        $produtoresSemNotaEConheceProgramas = $this->PerfilGerencial->find()
            ->where(['possui_nota' => false, 'conhece_programas' => true])
            ->count();

        // --- Análise da Produção Agrícola ---
        // Produtos Mais Relevantes: Quais são os produtos mais cultivados?
        $mostCultivatedProducts = $this->ProdutosCultivados->find()
            ->select(['nome', 'count' => 'COUNT(*)'])
            ->group('nome')
            ->order(['count' => 'DESC'])
            ->limit(5)
            ->toArray();

        // Quais produtos geram a maior receita total?
        $productsByRevenue = $this->ProdutosCultivados->find()
            ->select(['nome', 'total_receita' => 'SUM(receita_total)'])
            ->group('nome')
            ->order(['total_receita' => 'DESC'])
            ->limit(5)
            ->toArray();

        // Qual o preço médio por unidade de cada produto?
        $avgPricePerProduct = $this->ProdutosCultivados->find()
            ->select(['nome', 'avg_preco' => 'AVG(preco)'])
            ->group('nome')
            ->order(['avg_preco' => 'DESC'])
            ->limit(5)
            ->toArray();

        // Análise de Sazonalidade: Quais são os principais períodos de colheita?
        $harvestPeriods = $this->ProdutosCultivados->find()
            ->select(['periodo_colheita', 'count' => 'COUNT(*)'])
            ->group('periodo_colheita')
            ->order(['count' => 'DESC'])
            ->toArray();

        // --- Análise da Pecuária ---
        // Principais Espécies: Quais são as espécies de animais mais comuns na região?
        $mostCommonSpecies = $this->CriacoesAnimais->find()
            ->select(['especie', 'total_quantidade' => 'SUM(quantidade)'])
            ->group('especie')
            ->order(['total_quantidade' => 'DESC'])
            ->limit(5)
            ->toArray();

        // Qual a finalidade principal da criação (corte, leite, caseira, comercial)?
        $mainPurposes = $this->CriacoesAnimais->find()
            ->select(['finalidade', 'count' => 'COUNT(*)'])
            ->group('finalidade')
            ->order(['count' => 'DESC'])
            ->toArray();

        // Saúde Animal: Qual o percentual de rebanhos que são vacinados?
        // Assuming ManejoSanitario is associated with CriacoesAnimais
        $avgVacinado = $this->CriacoesAnimais->find()
            ->select(['avg_vacinado' => 'AVG(CriacoesAnimais.vacinado)'])
            ->first()
            ->avg_vacinado;

        // Existe diferença nas práticas de vacinação entre diferentes espécies?
        $vacinacaoBySpecies = $this->CriacoesAnimais->find()
            ->select(['especie', 'avg_vacinado' => 'AVG(CriacoesAnimais.vacinado)'])
            ->group('especie')
            ->order(['avg_vacinado' => 'DESC'])
            ->toArray();

        // --- Análise Econômica e de Mercado ---
        // Acesso a Crédito
        $avgConheceCredito = $this->PerfilGerencial->find()
            ->select(['avg_conhece_credito' => 'AVG(conhece_credito)'])
            ->first()
            ->avg_conhece_credito;

        $avgUtilizouCredito = $this->PerfilGerencial->find()
            ->select(['avg_utilizou_credito' => 'AVG(utilizou_credito)'])
            ->first()
            ->avg_utilizou_credito;

        // Canais de Venda
        $canaisDeVenda = [
            'varejo_petropolis' => $this->PerfilGerencial->find()->where(['varejo_petropolis' => true])->count(),
            'varejo_cidade' => $this->PerfilGerencial->find()->where(['varejo_cidade' => true])->count(),
            'atacado_petropolis' => $this->PerfilGerencial->find()->where(['atacado_petropolis' => true])->count(),
            'atacado_cidades' => $this->PerfilGerencial->find()->where(['atacado_cidades' => true])->count(),
            'comercializar_produtos' => $this->PerfilGerencial->find()->where(['comercializar_produtos' => true])->count(),
        ];

        // Diversificação de Renda
        $produtoresComOutrasReceitas = $this->PerfilGerencial->find()
            ->where(function ($exp, $q) {
                return $exp->isNotNull('outras_receitas');
            })
            ->andWhere(['outras_receitas !=' => ''])
            ->count();

        // Análise de Custos (Insumos)
        // Insumos Mais Comprados
        $mostPurchasedInputs = $this->InsumosUtilizados->find()
            ->select(['nome', 'count' => 'COUNT(*)'])
            ->group('nome')
            ->order(['count' => 'DESC'])
            ->limit(5)
            ->toArray();

        // Origem dos Insumos
        $inputOrigins = $this->InsumosUtilizados->find()
            ->select(['local_compra', 'count' => 'COUNT(*)'])
            ->group('local_compra')
            ->order(['count' => 'DESC'])
            ->toArray();

        // --- Análise Geográfica e de Propriedade ---
        $distribuicaoGeografica = $this->Propriedades->find()
            ->select(['comunidade', 'localidade', 'count' => 'COUNT(*)'])
            ->group(['comunidade', 'localidade'])
            ->order(['count' => 'DESC'])
            ->toArray();

        $posseTerra = $this->Propriedades->find()
            ->select(['relacao_propriedade', 'count' => 'COUNT(*)'])
            ->group('relacao_propriedade')
            ->order(['count' => 'DESC'])
            ->toArray();

        $tamanhoPropriedade = $this->Propriedades->find()
            ->select(['area_total', 'count' => 'COUNT(*)'])
            ->group('area_total')
            ->order(['count' => 'DESC'])
            ->toArray();

        // --- Análises Cruzadas ---
        // Formalização vs. Mercado
        $formalizacaoMercado = [
            'com_nota_e_vende' => $this->PerfilGerencial->find()
                ->where(['possui_nota' => true, 'atacado_cidades' => true])
                ->count(),
            'sem_nota_e_vende' => $this->PerfilGerencial->find()
                ->where(['possui_nota' => false, 'atacado_cidades' => true])
                ->count(),
            'total_com_nota' => $this->PerfilGerencial->find()
                ->where(['possui_nota' => true])
                ->count(),
            'total_vende_atacado_cidades' => $this->PerfilGerencial->find()
                ->where(['atacado_cidades' => true])
                ->count(),
        ];

        // Mão de Obra vs. Área
        $maoDeObraAreaRaw = $this->Propriedades->find()
            ->select([
                'area_total' => 'Propriedades.area_total',
                'qtd_empregados' => 'FamiliaMaoDeObra.qtd_empregados'
            ])
            ->join([
                'table' => 'familia_mao_de_obra',
                'alias' => 'FamiliaMaoDeObra',
                'type' => 'INNER',
                'conditions' => 'FamiliaMaoDeObra.id_produtor = Propriedades.id_produtor',
            ])
            ->where(['FamiliaMaoDeObra.qtd_empregados >' => 0])
            ->toArray();

        $areaMapping = [
            'zero_dez' => 5,
            'dez_cinquenta' => 30,
            'cinquenta_cem' => 75,
            'cem_quinhentos' => 300,
            'mais_quinhentos' => 600
        ];

        $maoDeObraAreaData = array_map(function ($row) use ($areaMapping) {
            if (!isset($row->area_total) || !isset($areaMapping[$row->area_total])) {
                return null;
            }
            return [
                'x' => $areaMapping[$row->area_total],
                'y' => $row->qtd_empregados
            ];
        }, $maoDeObraAreaRaw);
        $maoDeObraAreaData = array_filter($maoDeObraAreaData);


        // Crédito vs. Dificuldades
        $creditoDificuldades = [
            'com_credito_com_dificuldade_prod' => $this->PerfilGerencial->find()
                ->where([
                    'utilizou_credito' => true,
                    'dificuldade_producao IS NOT NULL',
                    'dificuldade_producao !=' => ''
                 ])->count(),
            'sem_credito_com_dificuldade_prod' => $this->PerfilGerencial->find()
                ->where([
                    'utilizou_credito' => false,
                    'dificuldade_producao IS NOT NULL',
                    'dificuldade_producao !=' => ''
                ])->count(),
            'com_credito_com_dificuldade_com' => $this->PerfilGerencial->find()
                ->where([
                    'utilizou_credito' => true,
                    'dificuldade_comercializacao IS NOT NULL',
                    'dificuldade_comercializacao !=' => ''
                ])->count(),
            'sem_credito_com_dificuldade_com' => $this->PerfilGerencial->find()
                ->where([
                    'utilizou_credito' => false,
                    'dificuldade_comercializacao IS NOT NULL',
                    'dificuldade_comercializacao !=' => ''
                ])->count(),
            'total_com_credito' => $this->PerfilGerencial->find()->where(['utilizou_credito' => true])->count(),
            'total_sem_credito' => $this->PerfilGerencial->find()->where(['utilizou_credito' => false])->count(),
        ];

        // Insumos vs. Produtividade
        $produtoresComInsumosEspecificos = $this->InsumosUtilizados->find()
            ->select(['id_produtor'])
            ->where($this->InsumosUtilizados->query()->newExpr()->in('nome', ['ADUBO QUIMICO', 'AGROTOXICO']))
            ->distinct(['id_produtor']);

        $avgReceitaComInsumos = $this->ProdutosCultivados->find()
            ->where(['id_produtor IN' => $produtoresComInsumosEspecificos])
            ->select(['avg_receita' => 'AVG(receita_total)'])
            ->first()
            ->avg_receita;

        $avgReceitaSemInsumos = $this->ProdutosCultivados->find()
            ->where(['id_produtor NOT IN' => $produtoresComInsumosEspecificos])
            ->select(['avg_receita' => 'AVG(receita_total)'])
            ->first()
            ->avg_receita;

        $insumosReceitaData = [
            'labels' => ['Usa Insumos Específicos', 'Não Usa Insumos Específicos'],
            'data' => [
                round((float)($avgReceitaComInsumos ?? 0), 2),
                round((float)($avgReceitaSemInsumos ?? 0), 2)
            ]
        ];

        $this->set(compact(
            'page',
            'subpage',
            'avgDependentes',
            'distribuicaoIdade',
            'totalProdutores',
            'produtoresFamiliaProducao',
            'produtoresComEmpregados',
            'produtoresFamiliaExclusiva',
            'produtoresMaoDeObraContratadaExclusiva',
            'avgPossuiNota',
            'avgInscritoInss',
            'produtoresComNotaEConheceProgramas',
            'produtoresSemNotaEConheceProgramas',
            'mostCultivatedProducts',
            'productsByRevenue',
            'avgPricePerProduct',
            'harvestPeriods',
            'mostCommonSpecies',
            'mainPurposes',
            'avgVacinado',
            'vacinacaoBySpecies',
            'avgConheceCredito',
            'avgUtilizouCredito',
            'canaisDeVenda',
            'produtoresComOutrasReceitas',
            'mostPurchasedInputs',
            'inputOrigins',
            'distribuicaoGeografica',
            'posseTerra',
            'tamanhoPropriedade',
            'formalizacaoMercado',
            'maoDeObraAreaData',
            'creditoDificuldades',
            'insumosReceitaData'
        ));

        try {
            return $this->render(implode('/', $path));
        } catch (MissingTemplateException $exception) {
            if (Configure::read('debug')) {
                throw $exception;
            }
            throw new NotFoundException();
        }
    }
}