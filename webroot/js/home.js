class ChartFactory {
    constructor(chartData) {
        this.chartData = chartData;

        this.defaultColors = ['#4e73df',
            '#1cc88a',
            '#36b9cc',
            '#f6c23e',
            '#e74a3b',
            '#858796',
            '#4caf50',
            '#ff9800',
            '#2196f3',
            '#e91e63',
            '#9c27b0'];
    }

    _createChart(elementId, config) {
        const ctx = document.getElementById(elementId);
        if (ctx && config) {
            new Chart(ctx, config);
        }
    }

    _getBasicConfig(type,
        data, label, customOptions = {}) {
        if (!data || !data.labels || !data.data) return null;
        return {
            type: type,
            data: {
                labels: data.labels,
                datasets: [{
                    label: label,
                    data: data.data,
                    backgroundColor: this.defaultColors,
                }]
            },
            options: {
                responsive: true,
                ...customOptions
            }
        };
    }

    _getStackedConfig(type,
        data, customOptions = {}) {
        if (!data || !data.labels || !data.datasets) return null;
        return {
            type: type,
            data: {
                labels: data.labels,
                datasets: data.datasets
            },
            options: {
                responsive: true,
                scales: {
                    x: { stacked: true },
                    y: { stacked: true, beginAtZero: true }
                },
                ...customOptions
            }
        };
    }

    _getScatterConfig(elementId,
        data, xAxisLabel, yAxisLabel) {
        if (!data || !data.data) return null;
        return {
            type: 'scatter',
            data: {
                datasets: [{
                    label: 'Produtores',
                    data: data.data,
                    backgroundColor: 'rgba(75, 192, 192, 0.6)'
                }]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        type: 'linear',
                        position: 'bottom',
                        title: {
                            display: true,
                            text: xAxisLabel
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: yAxisLabel
                        }
                    }
                }
            }
        };
    }

    buildAll() {
        // --- Perfil do Produtor ---
        this._createChart(
            'graficoComposicaoFamiliar',
            this._getBasicConfig('bar',
                this.chartData.composicaoFamiliar,
                'Qtd. de Pessoas', {
                plugins: { legend: { display: false } }, scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { precision: 0 }
                    }
                }
            }));

        this._createChart('graficoMediaDependentes',
            this._getBasicConfig('bar', {
                labels: ['Média de Dependentes'],
                data: [this.chartData.mediaDependentes]
            },
                'Número de Dependentes', {
                plugins: { legend: { display: false } }, scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { precision: 2 }
                    }
                }
            }));

        this._createChart('graficoMaoDeObra', {
            type: 'pie',
            data: {
                labels: this.chartData.maoDeObra.labels,
                datasets: [{ data: this.chartData.maoDeObra.data, backgroundColor: this.defaultColors }]
            }, options: { responsive: true, plugins: { tooltip: { callbacks: { label: (c) => `${c.label}: ${c.raw} (${((c.raw / this.chartData.maoDeObra.total) * 100).toFixed(1)}%)` } } } }
        });

        this._createChart('graficoFormalizacaoPercentuais',
            this._getBasicConfig('bar',
                this.chartData.formalizacaoPercentuais,
                '% de Produtores', {
                scales: {
                    y: {
                        beginAtZero: true, max: 100,
                        ticks: { callback: (v) => v + '%' }
                    }
                }
            }));

        this._createChart('graficoFormalizacaoConhecimento', {
            type: 'pie',
            data: {
                labels: this.chartData.formalizacaoConhecimento.labels,
                datasets: [{ data: this.chartData.formalizacaoConhecimento.data, backgroundColor: this.defaultColors }]
            }, options: { responsive: true, plugins: { tooltip: { callbacks: { label: (c) => `${c.label}: ${c.raw} (${((c.raw / this.chartData.formalizacaoConhecimento.total) * 100).toFixed(1)}%)` } } } }
        });

        // --- Produção Agrícola ---
        this._createChart('graficoMaisCultivados',
            this._getBasicConfig('bar',
                this.chartData.maisCultivados,
                'Quantidade cultivada', { indexAxis: 'y' }));

        this._createChart('graficoReceitaProdutos',
            this._getBasicConfig('bar',
                this.chartData.receitaProdutos,
                'Receita total (R$)', { scales: { y: { ticks: { callback: (v) => 'R$ ' + v.toLocaleString('pt-BR') } } } }));

        this._createChart('graficoPrecoMedio',
            this._getBasicConfig('bar',
                this.chartData.precoMedio,
                'Preço médio (R$/unid)', { scales: { y: { ticks: { callback: (v) => 'R$ ' + v.toLocaleString('pt-BR') } } } }));

        this._createChart('graficoPeriodosColheita',
            this._getBasicConfig('pie',
                this.chartData.periodosColheita,
                'Períodos'));

        this._createChart('graficoTamanhoPropriedadeProduto',
            this._getStackedConfig('bar',
                this.chartData.tamanhoPropriedadeProduto));

        this._createChart('graficoProdutoValorReceita',
            this._getScatterConfig('graficoProdutoValorReceita',
                this.chartData.produtoValorReceita,
                'Preço Médio (R$/unid)',
                'Receita Total (R$)'));

        // --- Pecuária ---
        this._createChart('chartEspecies',
            this._getBasicConfig('doughnut',
                this.chartData.especies,
                'Quantidade'));

        this._createChart('chartFinalidades',
            this._getBasicConfig('bar',
                this.chartData.finalidades,
                'Quantidade', { scales: { y: { beginAtZero: true } } }));

        this._createChart('chartVacinacao',
            this._getBasicConfig('bar',
                this.chartData.vacinacao,
                'Percentual Vacinado (%)', { indexAxis: 'y', scales: { x: { beginAtZero: true, max: 100 } } }));

        // --- Econômica e de Mercado ---
        this._createChart('graficoCredito',
            this._getBasicConfig('pie',
                this.chartData.credito,
                'Crédito'));

        this._createChart('graficoCanaisVenda',
            this._getBasicConfig('bar',
                this.chartData.canaisVenda,
                'Quantidade'));

        this._createChart('graficoInsumos',
            this._getBasicConfig('bar',
                this.chartData.insumos,
                'Quantidade'));

        this._createChart('graficoOrigemInsumos',
            this._getBasicConfig('bar',
                this.chartData.origemInsumos,
                'Quantidade', { indexAxis: 'y' }));

        this._createChart('graficoOutrasReceitas',
            this._getBasicConfig('pie',
                this.chartData.outrasReceitas,
                'Outras Receitas'));

        // --- Geográfica e de Propriedade ---
        this._createChart('graficoDistribuicaoGeografica',
            this._getBasicConfig('bar',
                this.chartData.distribuicaoGeografica,
                'Quantidade', { indexAxis: 'y' }));

        this._createChart('graficoPosseTerra',
            this._getBasicConfig('pie',
                this.chartData.posseTerra,
                'Posse'));

        this._createChart('graficoTamanhoPropriedade',
            this._getBasicConfig('bar',
                this.chartData.tamanhoPropriedade,
                'Quantidade'));

        // --- Análises Cruzadas ---
        this._createChart('graficoCreditoDificuldades', {
            type: 'bar',
            data: {
                labels: ['Dificuldade de Produção',
                    'Dificuldade de Comercialização'],
                datasets: [{
                    label: 'Produtores COM Crédito',
                    data: [this.chartData.creditoDificuldades.comCredito.producao,
                    this.chartData.creditoDificuldades.comCredito.comercializacao], backgroundColor: '#4e73df'
                }, {
                    label: 'Produtores SEM Crédito',
                    data: [this.chartData.creditoDificuldades.semCredito.producao,
                    this.chartData.creditoDificuldades.semCredito.comercializacao], backgroundColor: '#e74a3b'
                }]
            }, options: {
                responsive: true, plugins: {
                    title: {
                        display: true,
                        text: 'Percentual de Produtores com Dificuldades (com vs. sem crédito)'
                    },
                    tooltip: { callbacks: { label: (c) => `${c.dataset.label}: ${c.parsed.y.toFixed(2)}%` } }
                }, scales: {
                    y: {
                        beginAtZero: true, max: 100,
                        ticks: { callback: (v) => v + '%' }
                    }
                }
            }
        });

        this._createChart('graficoCapacitacaoValorProduto',
            this._getBasicConfig('bar',
                this.chartData.capacitacaoValorProduto,
                'Valor Médio do Produto (R$)', {
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { callback: (v) => 'R$ ' + v.toLocaleString('pt-BR') }
                    }
                }
            }));

        this._createChart('graficoCapacitacaoDificuldades',
            this._getStackedConfig('bar',
                this.chartData.capacitacaoDificuldades));

        this._createChart('graficoFormalizacaoVendaAtacado',
            this._getStackedConfig('bar',
                this.chartData.formalizacaoVendaAtacado));

        this._createChart('graficoMaoDeObraArea',
            this._getScatterConfig('graficoMaoDeObraArea',
                this.chartData.maoDeObraArea,
                'Área Total da Propriedade (hectares)',
                'Número de Empregados Contratados'));

        this._createChart('graficoInsumosReceita',
            this._getBasicConfig('bar',
                this.chartData.insumosReceita,
                'Receita Média (R$)', {
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { callback: (v) => 'R$ ' + v.toLocaleString('pt-BR') }
                    }
                }
            }));
    }
}

// Main execution
document.addEventListener('DOMContentLoaded', function () {
    // The chartData object is passed from home.php
    if (typeof chartData !== 'undefined') {
        const chartFactory = new ChartFactory(chartData);
        chartFactory.buildAll();
    }
});

