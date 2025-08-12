<?= $this->Html->css(['home']) ?>

<div class="dashboard-page">
    <div class="header">
        <h2>Dashboard de Análises</h2>
        <p>Explore os insights gerados a partir dos dados dos produtores rurais.</p>
    </div>

    <!-- Container das Abas -->
    <div class="tabs-container">
        <!-- Navegação das Abas -->
        <ul class="tabs-nav">
            <li><a href="#tab-perfil" class="active">Perfil e Mão de Obra</a></li>
            <li><a href="#tab-producao">Produção Agrícola</a></li>
            <li><a href="#tab-pecuaria">Pecuária</a></li>
            <li><a href="#tab-mercado">Economia e Mercado</a></li>
            <li><a href="#tab-geo">Geografia e Propriedade</a></li>
            <li><a href="#tab-cruzadas">Análises Cruzadas</a></li>
        </ul>

        <!-- Conteúdo das Abas -->
        <div class="tabs-content">
            <!-- Aba 1: Perfil do Produtor e Mão de Obra -->
            <div id="tab-perfil" class="tab-pane active">
                <h3>Perfil do Produtor, Mão de Obra e Formalização</h3>
                <div class="chart-grid">
                    <div class="chart-container"><canvas id="graficoComposicaoFamiliar"></canvas></div>
                    <div class="chart-container"><canvas id="graficoMaoDeObra"></canvas></div>
                    <div class="chart-container"><canvas id="graficoFormalizacaoPercentuais"></canvas></div>
                    <div class="chart-container"><canvas id="graficoFormalizacaoConhecimento"></canvas></div>
                </div>
            </div>

            <!-- Aba 2: Produção Agrícola -->
            <div id="tab-producao" class="tab-pane">
                <h3>Análise da Produção Agrícola</h3>
                <div class="chart-grid">
                    <div class="chart-container"><canvas id="graficoMaisCultivados"></canvas></div>
                    <div class="chart-container"><canvas id="graficoReceitaProdutos"></canvas></div>
                    <div class="chart-container"><canvas id="graficoPrecoMedio"></canvas></div>
                    <div class="chart-container"><canvas id="graficoPeriodosColheita"></canvas></div>
                </div>
            </div>

            <!-- Aba 3: Pecuária -->
            <div id="tab-pecuaria" class="tab-pane">
                <h3>Análise da Pecuária</h3>
                <div class="chart-grid">
                    <div class="chart-container"><canvas id="chartEspecies"></canvas></div>
                    <div class="chart-container"><canvas id="chartFinalidades"></canvas></div>
                    <div class="chart-container"><canvas id="chartVacinacao"></canvas></div>
                </div>
            </div>

            <!-- Aba 4: Análise Econômica e de Mercado -->
            <div id="tab-mercado" class="tab-pane">
                <h3>Análise Econômica e de Mercado</h3>
                <div class="chart-grid">
                    <div class="chart-container"><canvas id="graficoCredito"></canvas></div>
                    <div class="chart-container"><canvas id="graficoCanaisVenda"></canvas></div>
                    <div class="chart-container"><canvas id="graficoInsumos"></canvas></div>
                    <div class="chart-container"><canvas id="graficoOrigemInsumos"></canvas></div>
                </div>
            </div>

            <!-- Aba 5: Análise Geográfica e de Propriedade -->
            <div id="tab-geo" class="tab-pane">
                <h3>Análise Geográfica e de Propriedade</h3>
                <div class="chart-grid">
                    <div class="chart-container"><canvas id="graficoDistribuicaoGeografica"></canvas></div>
                    <div class="chart-container"><canvas id="graficoPosseTerra"></canvas></div>
                    <div class="chart-container"><canvas id="graficoTamanhoPropriedade"></canvas></div>
                </div>
            </div>

            <!-- Aba 6: Análises Cruzadas -->
            <div id="tab-cruzadas" class="tab-pane">
                <h3>Análises Cruzadas (Insights Avançados)</h3>
                <div class="chart-grid">
                    <div class="chart-container"><canvas id="graficoCreditoDificuldades"></canvas></div>
                    <div class="chart-container"><canvas id="graficoCapacitacaoValorProduto"></canvas></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="/js/home.js"></script>
<script>
    const chartData = {
        composicaoFamiliar: {
            labels: ['Até 7 anos', '8 a 15 anos', '16 a 25 anos', '26 a 65 anos', 'Mais de 65 anos'],
            data: <?= json_encode([
                $distribuicaoIdade['ate_sete'] ?? 0,
                $distribuicaoIdade['oito_quinze'] ?? 0,
                $distribuicaoIdade['dezesseis_vintecinco'] ?? 0,
                $distribuicaoIdade['vintecinco_sessentacinco'] ?? 0,
                $distribuicaoIdade['mais_sessenta_cinco'] ?? 0
            ]) ?>
        },
        maoDeObra: {
            labels: ['Familiar', 'Contratados', 'Familiar Exclusiva', 'Contratada Exclusiva'],
            data: [
                <?= $produtoresFamiliaProducao ?? 0 ?>,
                <?= $produtoresComEmpregados ?? 0 ?>,
                <?= $produtoresFamiliaExclusiva ?? 0 ?>,
                <?= $produtoresMaoDeObraContratadaExclusiva ?? 0 ?>
            ],
            total: <?= $totalProdutores ?? 0 ?>
        },
        formalizacaoPercentuais: {
            labels: ['Emitem Nota Fiscal', 'Inscritos no INSS'],
            data: [
                <?= round(($avgPossuiNota ?? 0) * 100, 2) ?>,
                <?= round(($avgInscritoInss ?? 0) * 100, 2) ?>
            ]
        },
        formalizacaoConhecimento: {
            labels: ['Com nota e conhecem programas', 'Sem nota e conhecem programas'],
            data: [
                <?= $produtoresComNotaEConheceProgramas ?? 0 ?>,
                <?= $produtoresSemNotaEConheceProgramas ?? 0 ?>
            ],
            total: <?= ($produtoresComNotaEConheceProgramas ?? 0) + ($produtoresSemNotaEConheceProgramas ?? 0) ?>
        },
        maisCultivados: {
            labels: <?= json_encode(array_column($mostCultivatedProducts ?? [], 'nome')) ?>,
            data: <?= json_encode(array_column($mostCultivatedProducts ?? [], 'count')) ?>
        },
        receitaProdutos: {
            labels: <?= json_encode(array_column($productsByRevenue ?? [], 'nome')) ?>,
            data: <?= json_encode(array_column($productsByRevenue ?? [], 'total_receita')) ?>
        },
        precoMedio: {
            labels: <?= json_encode(array_column($avgPricePerProduct ?? [], 'nome')) ?>,
            data: <?= json_encode(array_column($avgPricePerProduct ?? [], 'avg_preco')) ?>
        },
        periodosColheita: {
            labels: <?= json_encode(array_column($harvestPeriods ?? [], 'periodo_colheita')) ?>,
            data: <?= json_encode(array_column($harvestPeriods ?? [], 'count')) ?>
        },
        especies: {
            labels: <?= json_encode(array_column($mostCommonSpecies ?? [], 'especie')) ?>,
            data: <?= json_encode(array_column($mostCommonSpecies ?? [], 'total_quantidade')) ?>
        },
        finalidades: {
            labels: <?= json_encode(array_column($mainPurposes ?? [], 'finalidade')) ?>,
            data: <?= json_encode(array_column($mainPurposes ?? [], 'count')) ?>
        },
        vacinacao: {
            labels: <?= json_encode(array_column($vacinacaoBySpecies ?? [], 'especie')) ?>,
            data: <?= json_encode(array_map(fn($v) => round($v->avg_vacinado * 100, 2), $vacinacaoBySpecies ?? [])) ?>
        },
        credito: {
            labels: ['Conhece Crédito', 'Utilizou Crédito'],
            data: [
                <?= number_format(($avgConheceCredito ?? 0) * 100, 2, '.', '') ?>,
                <?= number_format(($avgUtilizouCredito ?? 0) * 100, 2, '.', '') ?>
            ]
        },
        canaisVenda: {
            labels: ['Varejo Petrópolis', 'Varejo Outras Cidades', 'Atacado Petrópolis', 'Atacado Outras Cidades', 'Produtos Processados'],
            data: [
                <?= $canaisDeVenda['varejo_petropolis'] ?? 0 ?>,
                <?= $canaisDeVenda['varejo_cidade'] ?? 0 ?>,
                <?= $canaisDeVenda['atacado_petropolis'] ?? 0 ?>,
                <?= $canaisDeVenda['atacado_cidades'] ?? 0 ?>,
                <?= $canaisDeVenda['comercializar_produtos'] ?? 0 ?>
            ]
        },
        insumos: {
            labels: <?= json_encode(array_column($mostPurchasedInputs ?? [], 'nome')) ?>,
            data: <?= json_encode(array_column($mostPurchasedInputs ?? [], 'count')) ?>
        },
        origemInsumos: {
            labels: <?= json_encode(array_column($inputOrigins ?? [], 'local_compra')) ?>,
            data: <?= json_encode(array_column($inputOrigins ?? [], 'count')) ?>
        },
        distribuicaoGeografica: {
            labels: <?= json_encode(array_map(fn($g) => ($g->comunidade ?? '') . ' / ' . ($g->localidade ?? ''), $distribuicaoGeografica ?? [])) ?>,
            data: <?= json_encode(array_column($distribuicaoGeografica ?? [], 'count')) ?>
        },
        posseTerra: {
            labels: <?= json_encode(array_column($posseTerra ?? [], 'relacao_propriedade')) ?>,
            data: <?= json_encode(array_column($posseTerra ?? [], 'count')) ?>
        },
        tamanhoPropriedade: {
            labels: <?= json_encode(array_column($tamanhoPropriedade ?? [], 'area_total')) ?>,
            data: <?= json_encode(array_column($tamanhoPropriedade ?? [], 'count')) ?>
        },
        formalizacaoMercado: {
            labels: ['Com nota e vende', 'Sem nota e vende'],
            data: [<?= $formalizacaoMercado['com_nota_e_vende'] ?? 0 ?>, <?= $formalizacaoMercado['sem_nota_e_vende'] ?? 0 ?>]
        },
        formalizacaoVendaAtacado: <?php
        if (isset($formalizacaoVendaAtacadoData) && is_array($formalizacaoVendaAtacadoData)) {
            echo json_encode([
                'labels' => ['Emite Nota Fiscal', 'Não Emite Nota Fiscal'],
                'datasets' => [
                    [
                        'label' => 'Vende Atacado Outras Cidades',
                        'data' => [
                            $formalizacaoVendaAtacadoData['com_nota_vende_atacado'] ?? 0,
                            $formalizacaoVendaAtacadoData['sem_nota_vende_atacado'] ?? 0
                        ],
                        'backgroundColor' => '#4e73df'
                    ],
                    [
                        'label' => 'Não Vende Atacado Outras Cidades',
                        'data' => [
                            $formalizacaoVendaAtacadoData['com_nota_nao_vende_atacado'] ?? 0,
                            $formalizacaoVendaAtacadoData['sem_nota_nao_vende_atacado'] ?? 0
                        ],
                        'backgroundColor' => '#f6c23e'
                    ]
                ]
            ]);
        } else {
            echo '{"labels": [], "datasets": []}'; // Provide a default empty structure
        }
        ?>,
        creditoDificuldades: {
            comCredito: {
                producao: <?= $creditoDificuldades['total_com_credito'] > 0 ? number_format(($creditoDificuldades['com_credito_com_dificuldade_prod'] / $creditoDificuldades['total_com_credito']) * 100, 2, '.', '') : 0 ?>,
                comercializacao: <?= $creditoDificuldades['total_com_credito'] > 0 ? number_format(($creditoDificuldades['com_credito_com_dificuldade_com'] / $creditoDificuldades['total_com_credito']) * 100, 2, '.', '') : 0 ?>
            },
            semCredito: {
                producao: <?= $creditoDificuldades['total_sem_credito'] > 0 ? number_format(($creditoDificuldades['sem_credito_com_dificuldade_prod'] / $creditoDificuldades['total_sem_credito']) * 100, 2, '.', '') : 0 ?>,
                comercializacao: <?= $creditoDificuldades['total_sem_credito'] > 0 ? number_format(($creditoDificuldades['sem_credito_com_dificuldade_com'] / $creditoDificuldades['total_sem_credito']) * 100, 2, '.', '') : 0 ?>
            }
        },
        capacitacaoDificuldades: {
            labels: ['Com Dificuldades', 'Sem Dificuldades'],
            datasets: [
                {
                    label: 'Interesse em Cursos',
                    data: [
                        <?= $capacitacaoDificuldadesData['com_interesse_com_dificuldades'] ?? 0 ?>,
                        <?= $capacitacaoDificuldadesData['com_interesse_sem_dificuldades'] ?? 0 ?>
                    ],
                    backgroundColor: '#4e73df'
                },
                {
                    label: 'Sem Interesse',
                    data: [
                        <?= $capacitacaoDificuldadesData['sem_interesse_com_dificuldades'] ?? 0 ?>,
                        <?= $capacitacaoDificuldadesData['sem_interesse_sem_dificuldades'] ?? 0 ?>
                    ],
                    backgroundColor: '#f6c23e'
                }
            ]
        },
        // New missing analyses data
        mediaDependentes: <?= number_format($avgDependentes, 2) ?>,
        tamanhoPropriedadeProduto: <?= json_encode($tamanhoPropriedadeProdutoData ?? []) ?>,
        produtoValorReceita: <?= json_encode($produtoValorReceitaData ?? []) ?>,
        outrasReceitas: {
            labels: ['Com Outras Receitas', 'Sem Outras Receitas'],
            data: [<?= $outrasReceitasData['com_outras_receitas'] ?? 0 ?>, <?= $outrasReceitasData['sem_outras_receitas'] ?? 0 ?>]
        },
        capacitacaoValorProduto: {
            labels: ['Com Interesse em Cursos', 'Sem Interesse em Cursos'],
            data: [<?= $capacitacaoValorProdutoData['avg_valor_com_interesse'] ?? 0 ?>, <?= $capacitacaoValorProdutoData['avg_valor_sem_interesse'] ?? 0 ?>]
        }
    };

    document.addEventListener('DOMContentLoaded', function () {
        const tabs = document.querySelectorAll('.tabs-nav a');
        const panes = document.querySelectorAll('.tab-pane');

        tabs.forEach(tab => {
            tab.addEventListener('click', function (event) {
                event.preventDefault();

                // 1. Remove a classe 'active' de todas as abas e painéis
                tabs.forEach(item => item.classList.remove('active'));
                panes.forEach(pane => pane.classList.remove('active'));

                // 2. Adiciona 'active' à aba clicada e ao painel correspondente
                this.classList.add('active');
                const targetPane = document.querySelector(this.getAttribute('href'));
                if (targetPane) {
                    targetPane.classList.add('active');
                }
            });
        });
    });
</script>